<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Materials') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm rounded">
                        <div class="card-body">
                            <form action="{{ route('materials.store') }}" method="POST">
                                @csrf
                                <div class="form-group mb-3">
                                    <x-input-label for="code" :value="__('Kode')" />
                                    <x-text-input id="code" class="block mt-1 w-full" type="text" name="code" :value="old('code')" required />
                                
                                    @error('code')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <x-input-label for="name" :value="__('Nama')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                                
                                    @error('name')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <x-input-label for="stock" :value="__('Stok')" />
                                    <x-text-input id="stock" class="block mt-1 w-full" type="number" name="stock" :value="old('stock')" required />
                                
                                    @error('stock')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <x-input-label for="price" :value="__('Harga')" />
                                    <x-text-input id="price" class="block mt-1 w-full" type="text" name="price" :value="old('price')" required />
                                
                                    @error('price')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>

                                <div class="mt-4">
                                    <x-input-label for="supplier_id" :value="__('Supplier')" />
                                    <x-input-select id="supplier_id" name="supplier_id" :options="$suppliers->map(fn($supplier) => ['value' => $supplier->id, 'label' => $supplier->name])" />
                                    
                                    @error('supplier')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>

                                <div class="mt-4">
                                    <x-input-label for="condition" :value="__('Kondisi')" />
                                    <select id="condition" name="condition" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                        <option value="">{{ $placeholder ?? 'Pilih' }}</option>
                                        <option value="good">Good</option>
                                        <option value="bad">Bad</option>
                                    </select>
                                    
                                    @error('condition')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>

                                <div class="flex items-center justify-end gap-2 mt-4">
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
        </div>
    </div>
</x-app-layout>
