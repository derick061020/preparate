<?php

use App\Models\Llc;

$states = [
    'AL' => 'Alabama',
    'AK' => 'Alaska',
    'AZ' => 'Arizona',
    'AR' => 'Arkansas',
    'CA' => 'California',
    'CO' => 'Colorado',
    'CT' => 'Connecticut',
    'DE' => 'Delaware',
    'FL' => 'Florida',
    'GA' => 'Georgia',
    'HI' => 'Hawaii',
    'ID' => 'Idaho',
    'IL' => 'Illinois',
    'IN' => 'Indiana',
    'IA' => 'Iowa',
    'KS' => 'Kansas',
    'KY' => 'Kentucky',
    'LA' => 'Louisiana',
    'ME' => 'Maine',
    'MD' => 'Maryland',
    'MA' => 'Massachusetts',
    'MI' => 'Michigan',
    'MN' => 'Minnesota',
    'MS' => 'Mississippi',
    'MO' => 'Missouri',
    'MT' => 'Montana',
    'NE' => 'Nebraska',
    'NV' => 'Nevada',
    'NH' => 'New Hampshire',
    'NJ' => 'New Jersey',
    'NM' => 'New Mexico',
    'NY' => 'New York',
    'NC' => 'North Carolina',
    'ND' => 'North Dakota',
    'OH' => 'Ohio',
    'OK' => 'Oklahoma',
    'OR' => 'Oregon',
    'PA' => 'Pennsylvania',
    'RI' => 'Rhode Island',
    'SC' => 'South Carolina',
    'SD' => 'South Dakota',
    'TN' => 'Tennessee',
    'TX' => 'Texas',
    'UT' => 'Utah',
    'VT' => 'Vermont',
    'VA' => 'Virginia',
    'WA' => 'Washington',
    'WV' => 'West Virginia',
    'WI' => 'Wisconsin',
    'WY' => 'Wyoming'
];
$state = $states[request()->state] ?? 'tu estado';

if (isset($_POST['businessName'])) {
    $llc = Llc::create([
        'business_name' => $_POST['businessName'],
        'state' => $_POST['state'],
        'business_type' => $_POST['businessType'],
        'business_description' => $_POST['businessDescription'],
        'street_address' => $_POST['businessAddress'],
        'city' => $state,
        'email' => $_POST['businessEmail'],
        'phone' => $_POST['businessPhone'],
    ]);
    $llcId = $llc->id;
    header('location: /auth/register?id=' . $llcId);
    exit();
}

?>
<x-layouts.marketing>
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-4xl mx-auto bg-white dark:bg-slate-800 rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold text-slate-800 dark:text-white mb-8 text-center">
                Registra tu LLC
            </h1>

            <form method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="state" value="{{ request()->state }}">

                <!-- Paso 1: Nombre de la empresa -->
                <div id="step1" class="step active">
                    <div class="mb-6 text-center">
                        <h2 class="text-xl font-semibold text-slate-800 dark:text-white mb-4">
                            Registremos tu empresa como una LLC en @php
                            $states = [
                                'AL' => 'Alabama',
                                'AK' => 'Alaska',
                                'AZ' => 'Arizona',
                                'AR' => 'Arkansas',
                                'CA' => 'California',
                                'CO' => 'Colorado',
                                'CT' => 'Connecticut',
                                'DE' => 'Delaware',
                                'FL' => 'Florida',
                                'GA' => 'Georgia',
                                'HI' => 'Hawaii',
                                'ID' => 'Idaho',
                                'IL' => 'Illinois',
                                'IN' => 'Indiana',
                                'IA' => 'Iowa',
                                'KS' => 'Kansas',
                                'KY' => 'Kentucky',
                                'LA' => 'Louisiana',
                                'ME' => 'Maine',
                                'MD' => 'Maryland',
                                'MA' => 'Massachusetts',
                                'MI' => 'Michigan',
                                'MN' => 'Minnesota',
                                'MS' => 'Mississippi',
                                'MO' => 'Missouri',
                                'MT' => 'Montana',
                                'NE' => 'Nebraska',
                                'NV' => 'Nevada',
                                'NH' => 'New Hampshire',
                                'NJ' => 'New Jersey',
                                'NM' => 'New Mexico',
                                'NY' => 'New York',
                                'NC' => 'North Carolina',
                                'ND' => 'North Dakota',
                                'OH' => 'Ohio',
                                'OK' => 'Oklahoma',
                                'OR' => 'Oregon',
                                'PA' => 'Pennsylvania',
                                'RI' => 'Rhode Island',
                                'SC' => 'South Carolina',
                                'SD' => 'South Dakota',
                                'TN' => 'Tennessee',
                                'TX' => 'Texas',
                                'UT' => 'Utah',
                                'VT' => 'Vermont',
                                'VA' => 'Virginia',
                                'WA' => 'Washington',
                                'WV' => 'West Virginia',
                                'WI' => 'Wisconsin',
                                'WY' => 'Wyoming'
                            ];
                            echo $states[request()->state] ?? 'tu estado';
                            @endphp
                        </h2>
                        <p class="text-slate-600 dark:text-slate-300">
                            La creación de una LLC es un paso importante para los aspirantes a empresarios, y nos encantaría hacerla realidad para ti. Siempre puedes cambiar el nombre de tu negocio antes de comprar.
                        </p>
                    </div>

                    <div class="text-center">
                        <label for="businessName" class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-2">
                            
                        </label>
                        <input type="text" 
                               id="businessName" 
                               name="businessName"
                               required
                               style="--livewire-progress-bar-color : none;"
                               class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-md text-slate-800 dark:text-white bg-white dark:bg-slate-800"
                               placeholder="Nombre de tu empresa">
                    </div>

                    <div class="flex justify-center mt-6">
                        <button type="button" 
                                onclick="showStep(2)" 
                                class="px-4 py-2 text-sm font-medium rounded-full bg-gray-800 dark:bg-gray-100 text-white dark:text-gray-700 hover:bg-gray-900 dark:focus:ring-offset-gray-900 dark:focus:ring-gray-100 dark:hover:bg-white dark:hover:text-gray-800 focus:ring-2 focus:ring-gray-900 focus:ring-offset-2 cursor-pointer inline-flex items-center w-full justify-center disabled:opacity-50 font-semibold focus:outline-none"
                                :disabled="!document.getElementById('businessName').value">
                            Siguiente
                        </button>
                    </div>
                </div>

                <!-- Paso 2: Tipo de negocio -->
                <div id="step2" class="step hidden">
                    <h2 class="text-xl font-semibold text-slate-800 dark:text-white mb-4 text-center">
                        ¿Qué tipo de negocio es?
                    </h2>
                    <p class="text-slate-600 dark:text-slate-300 mb-6 text-center">
                        Selecciona el tipo de negocio que mejor se ajuste a tu empresa.
                    </p>

                    <div class="text-center">
                        <label for="businessType" class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-2">
                            Tipo de negocio
                        </label>
                        <select id="businessType" 
                               name="businessType"
                               required
                               class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-md text-slate-800 dark:text-white bg-white dark:bg-slate-800">
                            <option value="">Selecciona un tipo...</option>
                            <option value="retail">Minorista</option>
                            <option value="service">Servicios</option>
                            <option value="consulting">Consultoría</option>
                            <option value="technology">Tecnología</option>
                            <option value="manufacturing">Manufactura</option>
                            <option value="other">Otro</option>
                        </select>
                    </div>

                    <div class="flex justify-center mt-6">
                    <button type="button" 
                                onclick="showStep(1)" 
                                class="mx-4 px-4 py-2 text-sm font-medium rounded-full bg-white border text-gray-500 hover:text-gray-700 border-gray-200/70 dark:focus:ring-offset-gray-900 dark:border-gray-400/10 hover:bg-gray-50 active:bg-white dark:focus:ring-gray-700 focus:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200/60 dark:bg-gray-800/50 dark:hover:bg-gray-800/70 dark:text-gray-400 focus:shadow-outline cursor-pointer inline-flex items-center w-full justify-center disabled:opacity-50 font-semibold focus:outline-none">
                            Atrás
                        </button>
                        <button type="button" 
                                onclick="showStep(3)" 
                                class="mx-4 px-4 py-2 text-sm font-medium rounded-full bg-gray-800 dark:bg-gray-100 text-white dark:text-gray-700 hover:bg-gray-900 dark:focus:ring-offset-gray-900 dark:focus:ring-gray-100 dark:hover:bg-white dark:hover:text-gray-800 focus:ring-2 focus:ring-gray-900 focus:ring-offset-2 cursor-pointer inline-flex items-center w-full justify-center disabled:opacity-50 font-semibold focus:outline-none"
                                :disabled="!document.getElementById('businessType').value">
                            Siguiente
                        </button>
                    </div>
                </div>

                <!-- Paso 3: Descripción -->
                <div id="step3" class="step hidden">
                    <h2 class="text-xl font-semibold text-slate-800 dark:text-white mb-4 text-center">
                        Describe tu negocio
                    </h2>
                    <p class="text-slate-600 dark:text-slate-300 mb-6 text-center">
                        Cuéntanos más sobre tu negocio y sus servicios.
                    </p>

                    <div class="text-center">
                        <label for="businessDescription" class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-2">
                            Descripción del negocio
                        </label>
                        <textarea id="businessDescription" 
                                  name="businessDescription"
                                  required
                                  rows="4"
                                  class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-md text-slate-800 dark:text-white bg-white dark:bg-slate-800"
                                  placeholder="Describe tu negocio y sus servicios"></textarea>
                    </div>

                    <div class="flex justify-center mt-6">
                        <button type="button" 
                                onclick="showStep(2)" 
                                class="mx-4 px-4 py-2 text-sm font-medium rounded-full bg-white border text-gray-500 hover:text-gray-700 border-gray-200/70 dark:focus:ring-offset-gray-900 dark:border-gray-400/10 hover:bg-gray-50 active:bg-white dark:focus:ring-gray-700 focus:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200/60 dark:bg-gray-800/50 dark:hover:bg-gray-800/70 dark:text-gray-400 focus:shadow-outline cursor-pointer inline-flex items-center w-full justify-center disabled:opacity-50 font-semibold focus:outline-none">
                            Atrás
                        </button>
                        <button type="button" 
                                onclick="showStep(4)" 
                                class="mx-4 px-4 py-2 text-sm font-medium rounded-full bg-gray-800 dark:bg-gray-100 text-white dark:text-gray-700 hover:bg-gray-900 dark:focus:ring-offset-gray-900 dark:focus:ring-gray-100 dark:hover:bg-white dark:hover:text-gray-800 focus:ring-2 focus:ring-gray-900 focus:ring-offset-2 cursor-pointer inline-flex items-center w-full justify-center disabled:opacity-50 font-semibold focus:outline-none"
                                :disabled="!document.getElementById('businessDescription').value">
                            Siguiente
                        </button>
                    </div>
                </div>

                <!-- Paso 4: Dirección -->
                <div id="step4" class="step hidden">
                    <h2 class="text-xl font-semibold text-slate-800 dark:text-white mb-4 text-center">
                        Dirección de tu empresa
                    </h2>
                    <p class="text-slate-600 dark:text-slate-300 mb-6 text-center">
                        Proporciona la dirección completa de tu empresa.
                    </p>

                    <div class="text-center">
                        <label for="businessAddress" class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-2">
                            Dirección de la empresa
                        </label>
                        <input type="text" 
                               id="businessAddress" 
                               name="businessAddress"
                               required
                               class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-md text-slate-800 dark:text-white bg-white dark:bg-slate-800"
                               placeholder="Dirección completa">
                    </div>

                    <div class="flex justify-center mt-6">
                        <button type="button" 
                                onclick="showStep(3)" 
                                class="mx-4 px-4 py-2 text-sm font-medium rounded-full bg-white border text-gray-500 hover:text-gray-700 border-gray-200/70 dark:focus:ring-offset-gray-900 dark:border-gray-400/10 hover:bg-gray-50 active:bg-white dark:focus:ring-gray-700 focus:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200/60 dark:bg-gray-800/50 dark:hover:bg-gray-800/70 dark:text-gray-400 focus:shadow-outline cursor-pointer inline-flex items-center w-full justify-center disabled:opacity-50 font-semibold focus:outline-none">
                            Atrás
                        </button>
                        <button type="button" 
                                onclick="showStep(5)" 
                                class="mx-4 px-4 py-2 text-sm font-medium rounded-full bg-gray-800 dark:bg-gray-100 text-white dark:text-gray-700 hover:bg-gray-900 dark:focus:ring-offset-gray-900 dark:focus:ring-gray-100 dark:hover:bg-white dark:hover:text-gray-800 focus:ring-2 focus:ring-gray-900 focus:ring-offset-2 cursor-pointer inline-flex items-center w-full justify-center disabled:opacity-50 font-semibold focus:outline-none"
                                :disabled="!document.getElementById('businessAddress').value">
                            Siguiente
                        </button>
                    </div>
                </div>

                <!-- Paso 5: Contacto -->
                <div id="step5" class="step hidden">
                    <h2 class="text-xl font-semibold text-slate-800 dark:text-white mb-4 text-center">
                        Información de contacto
                    </h2>
                    <p class="text-slate-600 dark:text-slate-300 mb-6 text-center">
                        Proporciona los datos de contacto de tu empresa.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="text-center">
                            <label for="businessPhone" class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-2">
                                Teléfono de la empresa
                            </label>
                            <input type="tel" 
                                   id="businessPhone" 
                                   name="businessPhone"
                                   required
                                   class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-md text-slate-800 dark:text-white bg-white dark:bg-slate-800"
                                   placeholder="Teléfono de contacto">
                        </div>
                        <div class="text-center">
                            <label for="businessEmail" class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-2">
                                Correo electrónico de la empresa
                            </label>
                            <input type="email" 
                                   id="businessEmail" 
                                   name="businessEmail"
                                   required
                                   class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-md text-slate-800 dark:text-white bg-white dark:bg-slate-800"
                                   placeholder="Correo electrónico">
                        </div>
                    </div>

                    <div class="flex justify-center mt-6">
                        <button  type="button" 
                                onclick="showStep(4)" 
                                class="mx-4 px-4 py-2 text-sm font-medium rounded-full bg-white border text-gray-500 hover:text-gray-700 border-gray-200/70 dark:focus:ring-offset-gray-900 dark:border-gray-400/10 hover:bg-gray-50 active:bg-white dark:focus:ring-gray-700 focus:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200/60 dark:bg-gray-800/50 dark:hover:bg-gray-800/70 dark:text-gray-400 focus:shadow-outline cursor-pointer inline-flex items-center w-full justify-center disabled:opacity-50 font-semibold focus:outline-none">
                            Atrás
                        </button>
                        <button type="submit" 
                        class="mx-4 px-4 py-2 text-sm font-medium rounded-full bg-gray-800 dark:bg-gray-100 text-white dark:text-gray-700 hover:bg-gray-900 dark:focus:ring-offset-gray-900 dark:focus:ring-gray-100 dark:hover:bg-white dark:hover:text-gray-800 focus:ring-2 focus:ring-gray-900 focus:ring-offset-2 cursor-pointer inline-flex items-center w-full justify-center disabled:opacity-50 font-semibold focus:outline-none"
                        :disabled="!document.getElementById('businessPhone').value || !document.getElementById('businessEmail').value">
                            Completar registro
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showStep(stepNumber) {
            // Ocultar todos los pasos
            document.querySelectorAll('.step').forEach(step => {
                step.classList.add('hidden');
                step.classList.remove('active');
            });

            // Mostrar el paso seleccionado
            const step = document.getElementById('step' + stepNumber);
            if (step) {
                step.classList.remove('hidden');
                step.classList.add('active');
            }
        }
    </script>
</x-layouts.marketing>
