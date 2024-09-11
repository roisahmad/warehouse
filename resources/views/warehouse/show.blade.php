<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Warehouse Entry Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm rounded">
                        <div class="card-body">
                            <div class="mb-4">
                                <x-primary-button href="{{ route('warehouse.index') }}">
                                    {{ __('Kembali') }}
                                </x-primary-button>
                            </div>
                            <h3 class="font-semibold text-lg">{{ __('Informasi Data Masuk') }}</h3>
                            <table class="table table-bordered">
                                <tr>
                                    <th scope="col">Supplier</th>
                                    <td>{{ $warehouseEntry->supplier->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Tanggal Datang</th>
                                    <td>{{ $warehouseEntry->arrival_date }}</td>
                                </tr>
                            </table>

                            <h3 class="font-semibold text-lg mt-4">{{ __('Material Diterima') }}</h3>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Material</th>
                                        <th scope="col">Kuantitas</th>
                                        <th scope="col">Kondisi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($warehouseEntry->details as $detail)
                                        <tr>
                                            <td>{{ $detail->material->name }}</td>
                                            <td>{{ $detail->quantity }}</td>
                                            <td>{{ ucfirst($detail->condition) }}</td>
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
</x-app-layout>
