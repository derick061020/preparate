<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <div class="space-y-4">
        <div>
            <label for="business_name" class="block text-sm font-medium text-gray-700">Nombre del Negocio</label>
            <input type="text" id="business_name" name="business_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" wire:model="business_name">
        </div>
        
        <div>
            <label for="city" class="block text-sm font-medium text-gray-700">Ciudad</label>
            <input type="text" id="city" name="city" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" wire:model="city">
        </div>
        
        <div>
            <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
            <select id="estado" name="estado" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" wire:model="estado">
                <option value="pendiente">Pendiente</option>
                <option value="completado">Completado</option>
                <option value="en_proceso">En Proceso</option>
                <option value="cancelado">Cancelado</option>
            </select>
        </div>
    </div>
    <div class="mt-4 flex justify-end space-x-4">
        <button wire:click="$closeModal" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Cancelar
        </button>
        <button wire:click="save" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Guardar
        </button>
    </div>
</div>
