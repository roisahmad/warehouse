<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Supplier') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm rounded">
                        <div class="card-body">
                            <div class="flex items-center justify-end">
                                <x-primary-button class="mb-3" href="{{ route('suppliers.create') }}">
                                    {{ __('Tambah Supplier') }}
                                </x-primary-button>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">NAMA</th>
                                        <th scope="col">KONTAK</th>
                                        <th scope="col">ALAMAT</th>
                                        <th scope="col" style="width: 20%">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($suppliers as $supplier)
                                        <tr>
                                            <td>{{ $supplier->name }}</td>
                                            <td>{{ $supplier->contact }}</td>
                                            <td>{{ $supplier->address }}</td>
                                            <td class="text-center">
                                                <form id="delete-form" onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST">
                                                    <x-primary-button href="{{ route('suppliers.edit', $supplier->id) }}">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </x-primary-button>
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-danger-button type="button" class="ms-3" onclick="confirmDelete()">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </x-danger-button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <div class="alert alert-danger">
                                            Data supplier belum Tersedia.
                                        </div>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $suppliers->links() }}
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
