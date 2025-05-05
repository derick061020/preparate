<x-layouts.app>
    <div class="min-h-screen dark:bg-gray-900 bg-white py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold dark:text-white text-gray-900 mb-2">
                    Selecciona un Plan
                </h2>
                <p class="text-lg dark:text-gray-400 text-gray-600 max-w-2xl mx-auto">
                    Elige el plan que mejor se adapte a tus necesidades y comienza a gestionar tu LLC de manera eficiente
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($plans as $plan)
                    <div class="group relative dark:bg-gray-800 bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 cursor-pointer"
                         onclick="selectPlan({{ $plan->id }})">
                        <div class="p-8">
                            <div class="space-y-6">
                                <h3 class="text-2xl font-bold dark:text-white text-gray-900 group-hover:dark:text-indigo-400 group-hover:text-indigo-600 transition-colors duration-300">
                                    {{ $plan->nombre }}
                                </h3>
                                <div class="flex items-center dark:text-indigo-400 text-indigo-600">
                                    <span class="text-4xl font-bold">{{ number_format($plan->precio, 2) }}</span>
                                    <span class="ml-1 text-base">USD</span>
                                </div>
                            </div>
                            
                            <div class="mt-8 space-y-4">
                                @foreach($plan->descripcion as $item)
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <svg class="w-5 h-5 dark:text-green-400 text-green-500 group-hover:dark:text-green-500 group-hover:text-green-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <p class="dark:text-gray-400 text-gray-600 text-sm group-hover:dark:text-gray-300 group-hover:text-gray-700 transition-colors duration-300">
                                            {{ $item['contenido'] }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="absolute inset-0 dark:bg-gradient-to-b dark:from-transparent dark:via-transparent dark:to-gray-700 bg-gradient-to-b from-transparent via-transparent to-gray-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.app>

<script>
    function selectPlan(planId) {
        const llcId = new URLSearchParams(window.location.search).get('llc_id');
        window.location.href = '/llc/plan/' + llcId + '?plan_id=' + planId;
    }
</script>
