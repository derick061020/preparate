<?php

use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;
use App\Models\Transaccion;

name('transactions');
middleware(['auth', 'verified']);

new class extends Component
{
    public $transactions = [];

    public function mount()
    {
        $this->transactions = Transaccion::latest()->get()->where('user_id', auth()->user()->id);
    }
};
?>

<x-layouts.app>
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <x-slot name="header">
        <h2 class="text-lg font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Transacciones') }}
        </h2>
    </x-slot>

    @volt('transactions')
        <div class="flex flex-col flex-1 items-stretch h-full">
            <div class="flex flex-col items-stretch flex-1 pb-5 mx-auto h-full min-h-[500px] w-full">
                <div class="relative flex-1 w-full h-full">
                    <div class="flex justify-between items-center w-full h-full  bg-pink- overflow-hidden border border-dashed bg-gradient-to-br from-white to-zinc-50 rounded-lg border-zinc-200 dark:border-gray-700 dark:from-gray-950 dark:via-gray-900 dark:to-gray-800">
                        <div class="h-full w-full flex relative flex-col p-10">
                            <div class="flex items-center pb-5 mb-5 space-x-1.5 text-lg font-bold text-gray-800 uppercase border-b border-dotted border-zinc-200 dark:border-gray-800 dark:text-gray-200">
                                <x-ui.logo class="block w-auto h-7 text-gray-800 fill-current dark:text-gray-200" />
                                <span>{{ __('Tus Transacciones') }}</span>
                            </div>

                                <div class="w-full mt-6">
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full bg-white dark:bg-gray-800 border-separate border-spacing-y-px">
                                            <thead>
                                                <tr class="bg-gray-50 dark:bg-gray-700">
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                                @foreach($transactions as $transaction)
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $transaction->id }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $transaction->monto }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $transaction->descripcion }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ 
                                                                match($transaction->estado) {
                                                                    'pendiente' => 'bg-yellow-100 text-yellow-800',
                                                                    'completado' => 'bg-green-100 text-green-800',
                                                                    'fallido' => 'bg-blue-100 text-blue-800',
                                                                    'cancelado' => 'bg-red-100 text-red-800'
                                                                } 
                                                            }}">
                                                                {{ $transaction->estado }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endvolt
</x-layouts.app>