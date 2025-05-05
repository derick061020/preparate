<?php

use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;

name('home');


new class extends Component
{
    public $selectedState = '';

    public function startProcess()
    {
        if (empty($this->selectedState)) {
            $this->dispatch('toast', message: 'Por favor selecciona un estado');
            return;
        }

        return redirect()->to('/register/' . $this->selectedState);
    }
};

?>

<x-layouts.marketing>

    @volt('home')
    <div class="relative flex flex-col items-center justify-center w-full h-auto overflow-hidden" x-cloak>

        <svg class="absolute top-0 left-0 w-7/12 -ml-40 -translate-x-1/2 fill-current opacity-10 dark:opacity-5 text-slate-400" viewBox="0 0 978 615" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M978 216.141C656.885 277.452 321.116 341.682 0 402.993c39.425-4.071 128.449-11.563 167.843-15.912l6.661 22.46c59.138 174.752 275.144 254.906 438.792 172.235 48.902-72.088 119.911-180.018 171.073-255.946L978 216.141ZM611.485 405.155c-19.059 27.934-46.278 66.955-65.782 94.576-98.453 40.793-230.472-11.793-268.175-111.202-1.096-2.89-1.702-5.965-3.379-11.972l382.99-38.6c-16.875 24.845-31.224 46.049-45.654 67.198Z" />
            <path d="m262.704 306.481 1.336-28.817c.25-1.784.572-3.562.951-5.323 17.455-81.121 65.161-136.563 144.708-159.63 81.813-23.725 157.283-5.079 211.302 61.02 6.466 7.912 23.695 33.305 23.695 33.305s107.788-20.295 102.487-22.242C710.939 81.362 569.507-31.34 398.149 8.04 221.871 48.55 144.282 217.1 160.797 331.317c23.221-5.568 78.863-19.192 101.907-24.836Z" />
            <path d="M890.991 458.296c-57.168 2.205-69.605 14.641-71.809 71.809-2.205-57.168-14.641-69.604-71.809-71.809 57.168-2.204 69.604-14.641 71.809-71.809 2.204 57.169 14.641 69.605 71.809 71.809Z" />
            <path d="M890.991 458.296c-57.168 2.205-69.605 14.641-71.809 71.809-2.205-57.168-14.641-69.604-71.809-71.809 57.168-2.204 69.604-14.641 71.809-71.809 2.204 57.169 14.641 69.605 71.809 71.809Z" />
            <path d="M952.832 409.766c-21.048.812-25.626 5.39-26.438 26.438-.811-21.048-5.39-25.626-26.437-26.438 21.047-.811 25.626-5.39 26.437-26.437.812 21.047 5.39 25.626 26.438 26.437Z" />
        </svg>
        <svg class="absolute top-0 right-0 w-7/12 -mr-40 translate-x-1/2 fill-current opacity-10 dark:opacity-5 text-slate-400" viewBox="0 0 978 615" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M978 216.141C656.885 277.452 321.116 341.682 0 402.993c39.425-4.071 128.449-11.563 167.843-15.912l6.661 22.46c59.138 174.752 275.144 254.906 438.792 172.235 48.902-72.088 119.911-180.018 171.073-255.946L978 216.141ZM611.485 405.155c-19.059 27.934-46.278 66.955-65.782 94.576-98.453 40.793-230.472-11.793-268.175-111.202-1.096-2.89-1.702-5.965-3.379-11.972l382.99-38.6c-16.875 24.845-31.224 46.049-45.654 67.198Z" />
            <path d="m262.704 306.481 1.336-28.817c.25-1.784.572-3.562.951-5.323 17.455-81.121 65.161-136.563 144.708-159.63 81.813-23.725 157.283-5.079 211.302 61.02 6.466 7.912 23.695 33.305 23.695 33.305s107.788-20.295 102.487-22.242C710.939 81.362 569.507-31.34 398.149 8.04 221.871 48.55 144.282 217.1 160.797 331.317c23.221-5.568 78.863-19.192 101.907-24.836Z" />
            <path d="M890.991 458.296c-57.168 2.205-69.605 14.641-71.809 71.809-2.205-57.168-14.641-69.604-71.809-71.809 57.168-2.204 69.604-14.641 71.809-71.809 2.204 57.169 14.641 69.605 71.809 71.809Z" />
            <path d="M890.991 458.296c-57.168 2.205-69.605 14.641-71.809 71.809-2.205-57.168-14.641-69.604-71.809-71.809 57.168-2.204 69.604-14.641 71.809-71.809 2.204 57.169 14.641 69.605 71.809 71.809Z" />
            <path d="M952.832 409.766c-21.048.812-25.626 5.39-26.438 26.438-.811-21.048-5.39-25.626-26.437-26.438 21.047-.811 25.626-5.39 26.437-26.437.812 21.047 5.39 25.626 26.438 26.437Z" />
        </svg>

        <div class="container mx-auto px-4 mt-30 min-h-screen">
            <form wire:submit="startProcess">
            <div class="flex flex-col md:flex-row justify-center items-center gap-8">
                <!-- Left column with text and select -->
                <div class="w-full md:w-3/5 space-y-6">
                    <h1 class="text-4xl lg:text-5xl font-bold text-slate-800 dark:text-white">
                        La forma segura y fácil de obtener tu LLC
                    </h1>
                    <h2 class="text-xl text-slate-600 dark:text-slate-300">
                        Establece tu LLC sin complicaciones. Te guiaremos en cada paso para que puedas comenzar tu negocio sin problemas.
                    </h2>
                    
                    <div class="relative max-w-sm">
                        <select required wire:model="selectedState"
                                class="w-full px-3 py-2 text-base rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-800 dark:text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none">
                            <option value="">Selecciona un estado</option>
                            <option value="AL">Alabama</option>
                            <option value="AK">Alaska</option>
                            <option value="AZ">Arizona</option>
                            <option value="AR">Arkansas</option>
                            <option value="CA">California</option>
                            <option value="CO">Colorado</option>
                            <option value="CT">Connecticut</option>
                            <option value="DE">Delaware</option>
                            <option value="FL">Florida</option>
                            <option value="GA">Georgia</option>
                            <option value="HI">Hawaii</option>
                            <option value="ID">Idaho</option>
                            <option value="IL">Illinois</option>
                            <option value="IN">Indiana</option>
                            <option value="IA">Iowa</option>
                            <option value="KS">Kansas</option>
                            <option value="KY">Kentucky</option>
                            <option value="LA">Louisiana</option>
                            <option value="ME">Maine</option>
                            <option value="MD">Maryland</option>
                            <option value="MA">Massachusetts</option>
                            <option value="MI">Michigan</option>
                            <option value="MN">Minnesota</option>
                            <option value="MS">Mississippi</option>
                            <option value="MO">Missouri</option>
                            <option value="MT">Montana</option>
                            <option value="NE">Nebraska</option>
                            <option value="NV">Nevada</option>
                            <option value="NH">New Hampshire</option>
                            <option value="NJ">New Jersey</option>
                            <option value="NM">New Mexico</option>
                            <option value="NY">New York</option>
                            <option value="NC">North Carolina</option>
                            <option value="ND">North Dakota</option>
                            <option value="OH">Ohio</option>
                            <option value="OK">Oklahoma</option>
                            <option value="OR">Oregon</option>
                            <option value="PA">Pennsylvania</option>
                            <option value="RI">Rhode Island</option>
                            <option value="SC">South Carolina</option>
                            <option value="SD">South Dakota</option>
                            <option value="TN">Tennessee</option>
                            <option value="TX">Texas</option>
                            <option value="UT">Utah</option>
                            <option value="VT">Vermont</option>
                            <option value="VA">Virginia</option>
                            <option value="WA">Washington</option>
                            <option value="WV">West Virginia</option>
                            <option value="WI">Wisconsin</option>
                            <option value="WY">Wyoming</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-700 dark:text-slate-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>

                    <div class="w-48">
                        <x-ui.button type="primary" tag="button" submit="true">
                            Empezar
                        </x-ui.button>
                    </div>
                </div>
            </form>
                
                <!-- Right column with image -->
                <div class="w-full md:w-1/5 flex justify-center items-center">
                    <img src="https://www.tailorbrands.com/wp-content/uploads/2022/09/30-Million-spanish.png" 
                         alt="LLC Image" 
                         class="w-full">
                </div>
            </div>
            <div class="container mx-auto px-4 mt-12">
                <div class="flex justify-center">
                    <img src="https://www.tailorbrands.com/wp-content/uploads/2022/08/spanish-trust-badge.png" 
                        alt="Trust Badge" 
                        class="w-96">
                </div>
            </div>
            <div class="container mx-auto px-20 mt-12">
                <div class="flex justify-start">
                    <div class="">
                        <h1 class="text-3xl font-bold text-slate-800 dark:text-white mb-8">
                            Cómo iniciar tu LLC en 7 pasos sencillos
                        </h1>

                        <p class="text-slate-600 dark:text-slate-300 mb-4">
                            El término "entidad legal" puede asustar a futuros empresarios. Incluso autónomos con experiencia a veces se sienten intimidados. Muchos nuevos propietarios no saben qué es una LLC o cómo empezar, pero sí saben que es importante.
                        </p>

                        <p class="text-slate-600 dark:text-slate-300 mb-4">
                            Si es tu caso, no te preocupes: aunque al principio parezca complicado, formar una LLC es un proceso simple si sigues estos pasos.
                        </p>

                        <section>
                            <h2 class="text-2xl font-semibold text-slate-800 dark:text-white mb-4">
                                1. Nombra tu LLC
                            </h2>

                            <p class="text-slate-600 dark:text-slate-300 mb-4">
                                Debes elegir un nombre único para evitar confusiones con otras empresas. El nombre debe incluir "LLC" o "compañía de responsabilidad limitada" y no puede contener términos financieros como "banco" o "seguro".
                            </p>

                            <p class="text-slate-600 dark:text-slate-300 mb-4">
                                Cada estado tiene reglas específicas que puedes consultar en su sitio web.
                            </p>

                            <h3 class="text-xl font-semibold text-slate-800 dark:text-white mb-4">
                                Nombre de LLC vs. nombre comercial
                            </h3>

                            <p class="text-slate-600 dark:text-slate-300 mb-4">
                                Tu LLC puede usar el mismo nombre para operar o un nombre diferente para fines de marketing (solicitando un DBA). Tener "LLC" en tu nombre puede transmitir más confianza.
                            </p>

                            <h3 class="text-xl font-semibold text-slate-800 dark:text-white mb-4">
                                Reserva del nombre
                            </h3>

                            <p class="text-slate-600 dark:text-slate-300 mb-4">
                                Si aún no vas a formar tu LLC, puedes reservar el nombre por 30 a 120 días, según el estado.
                            </p>
                        </section>

                        <section>
                            <h2 class="text-2xl font-semibold text-slate-800 dark:text-white mb-4">
                                2. Selecciona tu estado
                            </h2>

                            <p class="text-slate-600 dark:text-slate-300 mb-4">
                                Puedes registrar tu LLC en cualquier estado, pero en general conviene hacerlo en tu estado de residencia, donde las oficinas y leyes locales te resultarán más accesibles.
                            </p>

                            <p class="text-slate-600 dark:text-slate-300 mb-4">
                                Algunos empresarios eligen estados como Delaware por sus bajas tasas fiscales y costos reducidos.
                            </p>

                            <p class="text-slate-600 dark:text-slate-300 mb-4">
                                Importante: Registrar tu empresa en un estado no protege el nombre en otros. Si planeas expandirte, podrías considerar registrar tu marca a nivel nacional.
                            </p>
                        </section>

                        <section>
                            <h2 class="text-2xl font-semibold text-slate-800 dark:text-white mb-4">
                                3. Presenta el acta constitutiva
                            </h2>

                            <p class="text-slate-600 dark:text-slate-300 mb-4">
                                Debes presentar el acta constitutiva (o certificado de formación) en el sitio web de tu estado. La tarifa varía entre $50 y $800.
                            </p>

                            <p class="text-slate-600 dark:text-slate-300 mb-4">
                                Una vez aprobado, recibirás un certificado de organización. Además, tendrás que pagar tarifas anuales para mantener la LLC en cumplimiento.
                            </p>
                        </section>

                        <section>
                            <h2 class="text-2xl font-semibold text-slate-800 dark:text-white mb-4">
                                4. Elige un agente registrado
                            </h2>

                            <p class="text-slate-600 dark:text-slate-300 mb-4">
                                Necesitas un agente registrado que reciba documentos legales y fiscales en nombre de tu empresa. Puedes ser tú mismo o contratar uno.
                            </p>

                            <p class="text-slate-600 dark:text-slate-300 mb-4">
                                El agente debe tener una dirección física y disponibilidad durante el horario laboral.
                            </p>
                        </section>

                        <section>
                            <h2 class="text-2xl font-semibold text-slate-800 dark:text-white mb-4">
                                5. Crea un acuerdo operativo
                            </h2>

                            <p class="text-slate-600 dark:text-slate-300 mb-4">
                                Aunque muchos estados no lo exigen, es recomendable crear un acuerdo operativo que detalle la estructura de tu LLC, responsabilidades de los miembros y reglas internas. Es útil para inversores y en casos de conflictos legales.
                            </p>
                        </section>

                        <section>
                            <h2 class="text-2xl font-semibold text-slate-800 dark:text-white mb-4">
                                6. Solicita un EIN
                            </h2>

                            <p class="text-slate-600 dark:text-slate-300 mb-4">
                                El EIN (Número de Identificación del Empleador) es un número de 9 dígitos que identifica tu empresa ante el IRS.
                            </p>

                            <p class="text-slate-600 dark:text-slate-300 mb-4">
                                Puedes solicitarlo:
                            </p>

                            <ul class="list-disc pl-8 mb-6 text-slate-600 dark:text-slate-300">
                                <li>En línea (proceso inmediato).</li>
                                <li>Por correo (tarda unas 4 semanas).</li>
                                <li>Por fax.</li>
                            </ul>
                        </section>

                        <section>
                            <h2 class="text-2xl font-semibold text-slate-800 dark:text-white mb-4">
                                7. Cumple con los requisitos fiscales
                            </h2>

                            <p class="text-slate-600 dark:text-slate-300 mb-4">
                                Para operar legalmente, debes obtener licencias y permisos estatales y locales, además de pagar tus impuestos.
                            </p>

                            <p class="text-slate-600 dark:text-slate-300 mb-4">
                                Cada estado tiene requisitos distintos para reportes anuales y pagos de impuestos. No cumplir puede generar fuertes sanciones, por lo que se recomienda investigar bien o contratar un contador.
                            </p>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endvolt
</x-layouts.marketing>