<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Warehouse Entries') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm rounded">
                        <div class="card-body">
                            <div class="flex items-center justify-end">
                                @if(Auth::user()->role->name != 'Staff Pembelian' && Auth::user()->role->name != 'Manager A')
                                    <x-primary-button class="mb-3" href="{{ route('warehouse.create') }}">
                                        {{ __('Tambah Data') }}
                                    </x-primary-button>
                                @endif
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">SUPPLIER</th>
                                        <th scope="col">MATERIAL</th>
                                        <th scope="col">KUANTITAS</th>
                                        <th scope="col">TANGGAL DATANG</th>
                                        <th scope="col">KONDISI</th>
                                        <th scope="col" style="width: 20%">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($warehouseEntries as $entry)
                                        <tr>
                                            <td>{{ $entry->supplier->name }}</td>
                                            <td>{{ $entry->details->first()->material->name }}</td>
                                            <td>{{ $entry->details->sum('quantity') }}</td>
                                            <td>{{ $entry->arrival_date }}</td>
                                            <td>{{ strtoupper($entry->details->first()->condition) }}</td>
                                            <td class="text-center">
                                                <x-primary-button href="{{ route('warehouse.show', $entry->id) }}">
                                                    <i class="fa-regular fa-eye"></i>
                                                </x-primary-button>
                                                <!-- <x-primary-button href="{{ route('warehouse.edit', $entry->id) }}">
                                                    <i class="fa-regular fa-edit"></i>
                                                </x-primary-button> -->
                                                @if(Auth::user()->role->name != 'Manager A')
                                                    <x-danger-button onclick="confirmDelete()">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </x-danger-button>

                                                    <form id="delete-form" action="{{ route('warehouse.destroy', $entry->id) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <div class="alert alert-danger">
                                            Data gudang belum Tersedia.
                                        </div>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $warehouseEntries->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete() {
            Swal.fire({
                title: 'Are you sure?',
                text: "This data will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form').submit();
                }
            })
        }
    </script>
</x-app-layout>
