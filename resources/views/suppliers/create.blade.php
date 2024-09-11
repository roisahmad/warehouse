<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Suppliers') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm rounded">
                        <div class="card-body">
                            <form action="{{ route('suppliers.store') }}" method="POST">
                                @csrf
                                <div class="form-group mb-3">
                                    <x-input-label for="name" :value="__('Nama')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                                
                                    @error('name')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <x-input-label for="contact" :value="__('Kontak')" />
                                    <x-text-input id="contact" class="block mt-1 w-full" type="text" name="contact" :value="old('contact')" required />
                                
                                    @error('contact')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <x-input-label for="address" :value="__('Alamat')" />
                                    <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required />
                                
                                    @error('address')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>

                                <div class="flex items-center justify-end gap-2">
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
