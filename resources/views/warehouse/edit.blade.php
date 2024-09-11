<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Warehouse Entry') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm rounded">
                        <div class="card-body">
                            <form action="{{ route('warehouse.update', $warehouseEntry->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group mb-3">
                                    <x-input-label for="purchase_order_id" :value="__('Purchase Order')" />
                                    <select name="purchase_order_id" id="purchase_order_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        <option value="">-- Select Purchase Order --</option>
                                        @foreach($purchaseOrders as $purchaseOrder)
                                            <option value="{{ $purchaseOrder->id }}" {{ $purchaseOrder->id == $warehouseEntry->purchase_order_id ? 'selected' : '' }}>
                                                {{ $purchaseOrder->id }} - {{ $purchaseOrder->supplier->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <x-input-label for="arrival_date" :value="__('Tanggal Kedatangan')" />
                                    <x-text-input id="arrival_date" type="date" name="arrival_date" class="block mt-1 w-full" value="{{ $warehouseEntry->arrival_date }}" required />
                                </div>

                                <div id="material-section">
                                    <h3 class="font-semibold text-lg">{{ __('Materials') }}</h3>
                                    <div id="material-container"></div>
                                </div>

                                <div class="flex items-center justify-end gap-2 mt-4">
                                    <x-reset-button class="mb-3">
                                        {{ __('Reset') }}
                                    </x-reset-button>
                                    <x-primary-button class="mb-3">
                                        {{ __('Update') }}
                                    </x-primary-button>
                                </div>
                            </form> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const purchaseOrderSelect = document.getElementById('purchase_order_id');
            const materialSection = document.getElementById('material-section');
            const materialContainer = document.getElementById('material-container');
            const warehouseEntryId = "{{ $warehouseEntry->id }}";

            function loadMaterials(purchaseOrderId) {
                if (purchaseOrderId) {
                    fetch(`/warehouse/get-materials/${purchaseOrderId}?entry_id=${warehouseEntryId}`)
                        .then(response => response.json())
                        .then(data => {
                            materialSection.style.display = 'block';
                            materialContainer.innerHTML = '';

                            data.materials.forEach((material, index) => {
                                materialContainer.innerHTML += `
                                    <div class="material-item flex gap-4 mb-3">
                                        <div class="w-full">
                                            <x-input-label :value="'Material'" />
                                            <input type="hidden" name="materials[${index}][material_id]" value="${material.id}" />
                                            <x-text-input type="text" class="block mt-1 w-full" value="${material.name}" readonly />
                                        </div>
                                        <div class="w-1/4">
                                            <x-input-label :value="'Quantity'" />
                                            <x-text-input name="materials[${index}][quantity]" type="number" min="1" class="block mt-1 w-full" value="${material.quantity}" required />
                                        </div>
                                        <div class="w-1/4">
                                            <x-input-label :value="'Condition'" />
                                            <select name="materials[${index}][condition]" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                <option value="good" ${material.condition == 'good' ? 'selected' : ''}>Good</option>
                                                <option value="bad" ${material.condition == 'bad' ? 'selected' : ''}>Bad</option>
                                            </select>
                                        </div>
                                    </div>
                                `;
                            });
                        })
                        .catch(error => {
                            console.error('Error fetching materials:', error);
                            materialSection.style.display = 'none';
                        });
                } else {
                    materialSection.style.display = 'none';
                }
            }

            // Initial load of materials based on selected purchase order
            loadMaterials(purchaseOrderSelect.value);

            // Reload materials when purchase order selection changes
            purchaseOrderSelect.addEventListener('change', function () {
                loadMaterials(this.value);
            });
        });
    </script>
</x-app-layout>
