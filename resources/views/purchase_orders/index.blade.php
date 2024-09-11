<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Purchase Order') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm rounded">
                        <div class="card-body">
                            <div class="flex items-center justify-end">
                                @if(Auth::user()->role->name != 'Staff Gudang' && Auth::user()->role->name != 'Manager A')
                                    <x-primary-button class="mb-3" href="{{ route('purchase_orders.create') }}">
                                        {{ __('Tambah PO') }}
                                    </x-primary-button>
                                @endif
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">SUPPLIER</th>
                                        <th scope="col">TOTAL KUANTITAS</th>
                                        <th scope="col">TOTAL HARGA</th>
                                        <th scope="col">STATUS</th>
                                        <th scope="col" style="width: 20%">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($orders as $po)
                                        <tr>
                                            <td>{{ $po->supplier->name }}</td>
                                            <td>{{ $po->total_quantity }}</td>
                                            <td class="text-right">{{ $po->total_price }}</td>
                                            <td class="text-center">
                                                {{ strtoupper($po->status) }}
                                            </td>
                                            <td class="text-center">
                                                <x-primary-button href="{{ route('purchase_orders.show', $po->id) }}">
                                                    <i class="fa-regular fa-eye"></i>
                                                </x-primary-button>
                                            </td>
                                        </tr>
                                    @empty
                                        <div class="alert alert-danger">
                                            Data po belum Tersedia.
                                        </div>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete() {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form').submit();
                }
            })
        }
    </script>
</x-app-layout>
