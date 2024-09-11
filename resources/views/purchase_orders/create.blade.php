<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Purchase Order') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('purchase_orders.store') }}" method="POST" id="purchase-order-form">
                        @csrf

                        <div class="form-group mb-3">
                            <x-input-label for="supplier_id" :value="__('Supplier')" />
                            <x-input-select id="supplier_id" name="supplier_id" :options="$suppliers->map(fn($supplier) => ['value' => $supplier->id, 'label' => $supplier->name])" required />
                            @error('supplier_id')
                                <x-input-error :messages="$message" class="mt-2" />
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <h3 class="font-semibold text-lg">{{ __('Materials') }}</h3>
                            <div id="materials-container">
                                <div class="material-item flex gap-4 mb-3">
                                    <div class="w-full">
                                        <x-input-label for="materials[0][material_id]" :value="__('Material')" />
                                        <select name="materials[0][material_id]" class="material-select block mt-1 w-full" required>
                                            <option value="">Pilih</option>
                                            @foreach($materials as $material)
                                                <option value="{{ $material->id }}" data-price="{{ $material->price }}">{{ $material->name }} (Price: {{ number_format($material->price, 2) }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="w-1/4">
                                        <x-input-label for="materials[0][quantity]" :value="__('Kuantitas')" />
                                        <x-text-input name="materials[0][quantity]" type="number" min="1" class="quantity-input block mt-1 w-full" value="1" required />
                                    </div>
                                    <div>
                                        <div class="mt-4" />
                                        <button type="button" class="btn-remove">Hapus</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="add-material" class="btn-add">Tambah</button>
                        </div>

                        <div class="form-group mb-3 mt-2">
                            <h3 class="font-semibold text-lg">{{ __('Ringkasan') }}</h3>
                            <p>{{ __('Total Kuantitas:') }} <span id="total-quantity">0</span></p>
                            <p>{{ __('Total Harga:') }} <span id="total-price">0.00</span></p>
                        </div>

                        <div class="form-group flex items-center justify-end gap-2">
                            <x-reset-button class="mb-3">
                                {{ __('Atur Ulang') }}
                            </x-reset-button>
                            <x-primary-button class="mb-3">
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .btn-add {
            background-color: #3498db;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-add:hover {
            background-color: #2980b9;
        }

        .btn-remove {
            background-color: #e74c3c;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-remove:hover {
            background-color: #c0392b;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addMaterialButton = document.getElementById('add-material');
            const materialsContainer = document.getElementById('materials-container');
            const totalQuantityElement = document.getElementById('total-quantity');
            const totalPriceElement = document.getElementById('total-price');
            let materialIndex = 1;

            function calculateTotals() {
                let totalQuantity = 0;
                let totalPrice = 0;

                const materialItems = document.querySelectorAll('.material-item');
                materialItems.forEach(item => {
                    const quantity = parseInt(item.querySelector('.quantity-input').value) || 0;
                    const pricePerUnit = parseFloat(item.querySelector('.material-select').selectedOptions[0].dataset.price) || 0;

                    totalQuantity += quantity;
                    totalPrice += quantity * pricePerUnit;
                });

                totalQuantityElement.textContent = totalQuantity;
                totalPriceElement.textContent = totalPrice.toFixed(2);
            }

            addMaterialButton.addEventListener('click', function () {
                const newMaterial = document.createElement('div');
                newMaterial.classList.add('material-item', 'flex', 'gap-4', 'mb-3');
                newMaterial.innerHTML = `
                    <div class="w-full">
                        <label for="materials[${materialIndex}][material_id]" class="block font-medium text-sm text-gray-700">Material</label>
                        <select name="materials[${materialIndex}][material_id]" class="material-select block mt-1 w-full" required>
                            <option value="">-- Select Material --</option>
                            @foreach($materials as $material)
                                <option value="{{ $material->id }}" data-price="{{ $material->price }}">{{ $material->name }} (Price: ${{ number_format($material->price, 2) }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-1/4">
                        <label for="materials[${materialIndex}][quantity]" class="block font-medium text-sm text-gray-700">Quantity</label>
                        <input type="number" name="materials[${materialIndex}][quantity]" class="quantity-input block mt-1 w-full" min="1" value="1" required />
                    </div>
                    <button type="button" class="btn-remove">Remove</button>
                `;
                materialsContainer.appendChild(newMaterial);
                materialIndex++;
            });

            materialsContainer.addEventListener('change', function (e) {
                if (e.target.classList.contains('material-select') || e.target.classList.contains('quantity-input')) {
                    calculateTotals();
                }
            });

            materialsContainer.addEventListener('click', function (e) {
                if (e.target.classList.contains('btn-remove')) {
                    e.target.closest('.material-item').remove();
                    calculateTotals();
                }
            });

            calculateTotals();
        });
    </script>
</x-app-layout>
