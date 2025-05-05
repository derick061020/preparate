<?php

namespace App\Http\Controllers;

use App\Models\Llc;
use App\Models\Plan;
use App\Models\DocumentoRequerido;
use App\Models\Transaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;

class PlanController extends Controller
{
    public function select(Request $request)
    {
        $llcId = $request->query('llc_id');
        
        if (!$llcId) {
            return redirect()->route('dashboard');
        }

        $plans = Plan::all();

        return view('pages.plan.select', [
            'plans' => $plans,
            'llcId' => $llcId,
        ]);
    }

    public function assign(string $llc_id, Request $request)
    {
        $llcId = $llc_id;
        $planId = $request->query('plan_id');

        if (!$llcId || !$planId) {
            return redirect()->route('dashboard');
        }

        $llc = Llc::find($llcId);
        if (!$llc) {
            return redirect()->route('dashboard');
        }

        $plan = Plan::find($planId);
        if (!$plan) {
            return redirect()->route('dashboard');
        }

        try {
            // Crear transacción pendiente
            $transaccion = Transaccion::create([
                'llc_id' => $llcId,
                'user_id' => $llc->user_id,
                'plan_id' => $planId,
                'monto' => $plan->precio,
                'estado' => 'pendiente',
                'descripcion' => 'Pago por plan ' . $plan->nombre
            ]);

            // Inicializar Stripe con las claves del archivo .env
            Stripe::setApiKey(env('STRIPE_KEY'));

            // Crear sesión de pago
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $plan->nombre,
                            'description' => 'Plan de LLC',
                        ],
                        'unit_amount' => $plan->precio * 100, // Stripe usa centavos
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('plan.success', ['llc_id' => $llcId, 'plan_id' => $planId, 'transaccion_id' => $transaccion->id]),
                'cancel_url' => route('plan.cancel', ['llc_id' => $llcId, 'plan_id' => $planId, 'transaccion_id' => $transaccion->id]),
                'customer_email' => $llc->usuario->email,
                'metadata' => [
                    'llc_id' => $llcId,
                    'plan_id' => $planId,
                    'transaccion_id' => $transaccion->id
                ]
            ]);

            // Actualizar la transacción con el ID de la sesión
            $transaccion->stripe_session_id = $session->id;
            $transaccion->save();

            // Redirigir a Stripe para completar el pago
            return redirect($session->url);

        } catch (ApiErrorException $e) {
            Log::error("Error Stripe API: " . $e->getMessage());
            die($e->getMessage());
            return redirect()->route('dashboard')->with('error', 'Error al procesar el pago. Por favor, inténtalo de nuevo.');
        }
    }

    public function success(string $llc_id, string $plan_id, string $transaccion_id)
    {
        $llcId = $llc_id;
        $planId = $plan_id;
        $transaccionId = $transaccion_id;

        if (!$llcId || !$planId || !$transaccionId) {
            return redirect()->route('dashboard')->with('error', 'Información de pago inválida');
        }

        try {
            $llc = Llc::find($llcId);
            $plan = Plan::find($planId);
            $transaccion = Transaccion::find($transaccionId);

            if (!$llc || !$plan || !$transaccion) {
                return redirect()->route('dashboard')->with('error', 'Información de plan inválida');
            }

            // Actualizar el estado del LLC
            $llc->plan_id = $planId;
            $llc->save();

            // Actualizar el estado de la transacción
            $transaccion->estado = 'completado';
            $transaccion->save();

            // Crear documentos requeridos
            $documentos = $plan->documentos;
            foreach ($documentos as $documento) {
                DocumentoRequerido::create([
                    'nombre' => $documento['nombre'],
                    'descripcion' => $documento['descripcion'],
                    'llc_id' => $llcId,
                    'estado' => 'pendiente'
                ]);
            }

            return redirect()->route('dashboard')->with('success', 'Pago completado exitosamente');

        } catch (\Exception $e) {
            Log::error("Error al procesar el éxito del pago: " . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'Error al procesar el éxito del pago');
        }
    }

    public function cancel(string $llc_id, string $plan_id, string $transaccion_id)
    {
        $llcId = $llc_id;
        $planId = $plan_id;
        $transaccionId = $transaccion_id;

        if (!$llcId || !$planId || !$transaccionId) {
            return redirect()->route('dashboard')->with('error', 'Información de pago inválida');
        }

        try {
            $transaccion = Transaccion::find($transaccionId);
            if ($transaccion) {
                $transaccion->estado = 'fallido';
                $transaccion->save();
            }
        } catch (\Exception $e) {
            Log::error("Error al cancelar la transacción: " . $e->getMessage());
        }

        return redirect()->route('dashboard')->with('info', 'Pago cancelado');
    }
}
