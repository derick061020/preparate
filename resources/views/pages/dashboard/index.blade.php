<?php

use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;
use App\Models\Llc;

name('dashboard');
middleware(['auth', 'verified']);

new class extends Component
{
    public $llcs = [];

    public function mount()
    {
        $this->llcs = Llc::with(['usuario', 'plan'])->latest()->get()->where('user_id', auth()->user()->id);
    }
};
?>

<x-layouts.app>
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <x-slot name="header">
        <h2 class="text-lg font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @volt('dashboard')
        <div class="flex flex-col flex-1 items-stretch h-full">
            <div class="flex flex-col items-stretch flex-1 pb-5 mx-auto h-full min-h-[500px] w-full">
                <div class="relative flex-1 w-full h-full">
                    <div class="flex justify-between items-center w-full h-full  bg-pink- overflow-hidden border border-dashed bg-gradient-to-br from-white to-zinc-50 rounded-lg border-zinc-200 dark:border-gray-700 dark:from-gray-950 dark:via-gray-900 dark:to-gray-800">
                        <div class="h-full w-full flex relative flex-col p-10">
                            <div class="flex items-center pb-5 mb-5 space-x-1.5 text-lg font-bold text-gray-800 uppercase border-b border-dotted border-zinc-200 dark:border-gray-800 dark:text-gray-200">
                                <x-ui.logo class="block w-auto h-7 text-gray-800 fill-current dark:text-gray-200" />
                                <span>{{ __('Tus llcs') }}</span>
                            </div>

                                <div class="w-full mt-6">
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full bg-white dark:bg-gray-800 border-separate border-spacing-y-px">
                                            <thead>
                                                <tr class="bg-gray-50 dark:bg-gray-700">
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ciudad</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plan</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Documentos</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                                @foreach($llcs as $llc)
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $llc->id }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $llc->business_name }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $llc->city }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ 
                                                                match($llc->estado) {
                                                                    'pendiente' => 'bg-yellow-100 text-yellow-800',
                                                                    'completado' => 'bg-green-100 text-green-800',
                                                                    'en_proceso' => 'bg-blue-100 text-blue-800',
                                                                    'cancelado' => 'bg-red-100 text-red-800'
                                                                } 
                                                            }}">
                                                                {{ $llc->estado }}
                                                            </span>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                            @if($llc->plan_id)
                                                                {{ $llc->plan->nombre }}
                                                            @else
                                                                <button 
                                                                    onclick="window.location.href='/plan/select/{{ $llc->id }}'"
                                                                    class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                                >
                                                                    Seleccionar Plan
                                                                </button>
                                                            @endif
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                            <button 
                                                                onclick="toggleDocuments({{ $llc->id }})"
                                                                class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                            >
                                                                Ver Documentos
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $pendientes = \App\Models\DocumentoRequerido::where('llc_id', $llc->id)
                                                            ->get();
                                                    @endphp
                                                    <tr>
                                                        <td colspan="6" class="px-6 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                            <div class="mt-2 space-y-2">
                                                                <div id="documents-{{ $llc->id }}" class="hidden">
                                                                    @if($pendientes->count() > 0)
                                                                        <div class="mt-4">
                                                                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                                                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                                                                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                                                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    @foreach($pendientes as $doc)
                                                                                        <tr>
                                                                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $doc->nombre }}</td>
                                                                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $doc->descripcion }}</td>
                                                                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ 
                                                                                                    match($doc->estado) {
                                                                                                        'pendiente' => 'bg-yellow-100 text-yellow-800',
                                                                                                        'subido' => 'bg-green-100 text-green-800',
                                                                                                        default => 'bg-gray-100 text-gray-800'
                                                                                                    } 
                                                                                                }}">
                                                                                                    {{ ucfirst($doc->estado) }}
                                                                                                </span>
                                                                                            </td>
                                                                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                                                                @if($doc->estado === 'pendiente')
                                                                                                    <div class="relative">
                                                                                                        <input 
                                                                                                            type="file" 
                                                                                                            class="hidden" 
                                                                                                            id="file-{{ $doc->id }}"
                                                                                                            data-document-id="{{ $doc->id }}"
                                                                                                            data-llc-id="{{ $llc->id }}"
                                                                                                            onchange="handleFileUpload(this)"
                                                                                                        >
                                                                                                        <div id="upload-container-{{ $doc->id }}" class="flex items-center space-x-2">
                                                                                                            <label 
                                                                                                                for="file-{{ $doc->id }}" 
                                                                                                                class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 cursor-pointer"
                                                                                                            >
                                                                                                                Subir Archivo
                                                                                                            </label>
                                                                                                            <div id="upload-status-{{ $doc->id }}" class="hidden text-xs text-gray-600">
                                                                                                                <span class="loading-status">Cargando...</span>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                @elseif($doc->estado === 'subido')
                                                                                                    <div class="flex items-center space-x-2">
                                                                                                        <a href="storage/{{ $doc->archivo }}" target="_blank" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                                                                            Ver Archivo
                                                                                                        </a>
                                                                                                        <button 
                                                                                                            onclick="handleRevertir({{ $doc->id }})" 
                                                                                                            class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                                                                                        >
                                                                                                            Revertir
                                                                                                        </button>
                                                                                                    </div>
                                                                                                @endif
                                                                                            </td>
                                                                                        </tr>
                                                                                    @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    @else
                                                                        <div class="mt-4 text-sm text-gray-500">No hay documentos pendientes</div>
                                                                    @endif
                                                                </div>
                                                            </div>
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

    <script>
        function handleFileUpload(input) {
            const file = input.files[0];
            if (!file) return;

            const documentId = input.dataset.documentId;
            const llcId = input.dataset.llcId;
            console.log('Subiendo archivo:', file.name, 'para documento:', documentId);

            // Obtener los elementos
            const container = document.getElementById(`upload-container-${documentId}`);
            const label = container.querySelector('label');
            const statusDiv = document.getElementById(`upload-status-${documentId}`);
            const statusText = statusDiv.querySelector('.loading-status');

            // Ocultar el botón y mostrar el estado
            label.classList.add('hidden');
            statusDiv.classList.remove('hidden');
            statusText.textContent = 'Iniciando subida...';

            // Crear el formulario de datos
            const formData = new FormData();
            formData.append('archivo', file);
            formData.append('document_id', documentId);
            formData.append('llc_id', llcId);

            // Crear la solicitud
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '/documentos/upload', true);
            console.log('URL de subida:', xhr.url);

            // Agregar el token CSRF
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            if (!csrfToken) {
                console.error('Token CSRF no encontrado');
                return;
            }
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

            // Manejar el progreso
            xhr.upload.onprogress = function(e) {
                if (e.lengthComputable) {
                    const percent = (e.loaded / e.total) * 100;
                    statusText.textContent = `Subiendo... ${Math.round(percent)}%`;
                }
            };

            // Manejar el éxito
            xhr.onload = function() {
                console.log('Respuesta del servidor:', xhr.responseText);
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        console.log('Respuesta parseada:', response);
                        if (response.success) {
                            // Actualizar el estado del documento
                            container.innerHTML = `
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Archivo Subido
                                </span>
                            `;
                            
                            // Emitir evento para refrescar la tabla
                            window.dispatchEvent(new Event('llcUpdated'));
                        } else {
                            statusText.textContent = 'Error: Respuesta inválida del servidor';
                        }
                    } catch (e) {
                        console.error('Error parsing JSON:', e);
                        statusText.textContent = 'Error: Respuesta inválida del servidor';
                    }
                } else {
                    statusText.textContent = `Error: ${xhr.status}`;
                }
            };

            // Manejar el error
            xhr.onerror = function() {
                console.error('Error en la solicitud:', xhr.statusText);
                statusText.textContent = 'Error: Fallo en la conexión';
            };

            // Enviar la solicitud
            try {
                xhr.send(formData);
                console.log('Solicitud enviada');
            } catch (e) {
                console.error('Error al enviar:', e);
                statusText.textContent = 'Error: No se pudo enviar el archivo';
            }
        }

        function handleRevertir(documentId) {
            if (!confirm('¿Estás seguro de que deseas revertir la subida de este documento?')) {
                return;
            }

            // Crear la solicitud
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '/documentos/revertir', true);
            
            // Agregar el token CSRF
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            if (!csrfToken) {
                console.error('Token CSRF no encontrado');
                return;
            }
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            xhr.setRequestHeader('Content-Type', 'application/json');

            // Manejar el éxito
            xhr.onload = function() {
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            // Recargar la página
                            location.reload();
                        }
                    } catch (e) {
                        console.error('Error parsing JSON:', e);
                    }
                }
            };

            // Manejar el error
            xhr.onerror = function() {
                console.error('Error en la solicitud:', xhr.statusText);
            };

            // Enviar la solicitud
            try {
                xhr.send(JSON.stringify({ document_id: documentId }));
            } catch (e) {
                console.error('Error al enviar:', e);
            }
        }

        function toggleDocuments(llcId) {
            const documentsDiv = document.getElementById(`documents-${llcId}`);
            documentsDiv.classList.toggle('hidden');
        }
    </script>
    
    <!-- Listener para refrescar la tabla después de guardar -->
    @push('scripts')
    <script>
        window.addEventListener('llcUpdated', event => {
            location.reload();
        });
    </script>
    @endpush
    
</x-layouts.app>