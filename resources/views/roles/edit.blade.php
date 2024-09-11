<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Roles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm rounded">
                        <div class="card-body">
                            <form action="{{ route('roles.update', $role->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group mb-3">
                                    <x-input-label for="name" :value="__('Name')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $role->name)" required />

                                
                                    @error('name')
                                        <x-input-error :messages="$message" class="mt-2" />
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <x-input-label for="level" :value="__('Level')" />
                                    <x-text-input id="level" class="block mt-1 w-full" type="text" name="level" :value="old('level', $role->level)" required />
                                
                                    @error('level')
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
