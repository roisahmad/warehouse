<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Receive Material from Purchase Order') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm rounded">
                        <div class="card-body">
                            <form action="{{ route('warehouse.store') }}" method="POST">
                                @csrf
                                
                                <div class="form-group mb-3">
                                    <x-input-label for="purchase_order_id" :value="__('Select Purchase Order')" />
                                    <select id="purchase_order_id" name="purchase_order_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        <option value="">-- Pilih --</option>
                                        @foreach($purchaseOrders as $purchaseOrder)
                                            <option value="{{ $purchaseOrder->id }}">{{ $purchaseOrder->id }} - {{ $purchaseOrder->supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div id="materials-section" style="display:none;">
                                    <h3 class="font-semibold text-lg">{{ __('Materials') }}</h3>
                                    <div id="materials-container">
                                        <!-- Material fields will be dynamically loaded here -->
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <x-input-label for="arrival_date" :value="__('Tanggal Kedatangan')" />
                                    <x-text-input id="arrival_date" type="date" name="arrival_date" class="block mt-1 w-full" required />
                                </div>

                                <div class="flex items-center justify-end gap-2">
                                    <x-reset-button class="mb-3">
                                        {{ __('Reset') }}
                                    </x-reset-button>
                                    <x-primary-button class="mb-3">
                                        {{ __('Submit') }}
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
        document.getElementById('purchase_order_id').addEventListener('change', function () {
            let purchaseOrderId = this.value;
            let materialsSection = document.getElementById('materials-section');
            let materialsContainer = document.getElementById('materials-container');

            if (purchaseOrderId) {
                fetch(`/get-materials/${purchaseOrderId}`)
                    .then(response => response.json())
                    .then(data => {
                        materialsSection.style.display = 'block';
                        materialsContainer.innerHTML = '';

                        data.materials.forEach((material, index) => {
                            let materialHTML = `
                                <div class="material-item flex gap-4 mb-3">
                                    <div class="w-full">
                                        <x-input-label :value="'Material'" />
                                        <input type="hidden" name="materials[${index}][material_id]" value="${material.id}">
                                        <x-text-input type="text" class="block mt-1 w-full" value="${material.name}" readonly />
                                    </div>
                                    <div class="w-1/4">
                                        <x-input-label :value="'Quantity'" />
                                        <x-text-input name="materials[${index}][quantity]" type="number" min="1" class="block mt-1 w-full" value="${material.quantity}" required />
                                    </div>
                                    <div class="w-1/4">
                                        <x-input-label :value="'Condition'" />
                                        <select name="materials[${index}][condition]" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                            <option value="good">Good</option>
                                            <option value="bad">Bad</option>
                                        </select>
                                    </div>
                                </div>`;
                            materialsContainer.innerHTML += materialHTML;
                        });
                    });
            } else {
                materialsSection.style.display = 'none';
                materialsContainer.innerHTML = '';
            }
        });
    </script>
</x-app-layout>
