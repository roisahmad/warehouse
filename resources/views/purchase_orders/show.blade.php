<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Purchase Order Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="font-semibold text-xl">{{ __('Detail Order') }}</h3>
                    <table class="table-auto w-full mt-4 mb-6">
                        <tr>
                            <th class="text-left py-2">Supplier</th>
                            <td class="py-2">{{ $order->supplier->name }}</td>
                        </tr>
                        <tr>
                            <th class="text-left py-2">Dibuat Oleh</th>
                            <td class="py-2">{{ $order->user->name }}</td>
                        </tr>
                        <tr>
                            <th class="text-left py-2">Status</th>
                            <td class="py-2">{{ ucfirst($order->status) }}</td>
                        </tr>
                        <tr>
                            <th class="text-left py-2">Total Kuantitas</th>
                            <td class="py-2">{{ $order->total_quantity }}</td>
                        </tr>
                        <tr>
                            <th class="text-left py-2">Total Harga</th>
                            <td class="py-2">{{ number_format($order->total_price, 2) }}</td>
                        </tr>
                    </table>

                    <h3 class="font-semibold text-xl">{{ __('Material') }}</h3>
                    <table class="table-auto w-full mt-4 mb-6">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="text-left py-2">Material</th>
                                <th class="text-left py-2">Kuantitas</th>
                                <th class="text-left py-2">Harga</th>
                                <th class="text-left py-2">Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->details as $detail)
                                <tr>
                                    <td class="py-2">{{ $detail->material->name }}</td>
                                    <td class="py-2">{{ $detail->quantity }}</td>
                                    <td class="py-2">{{ number_format($detail->material->price, 2) }}</td>
                                    <td class="py-2">{{ number_format($detail->material->price * $detail->quantity, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-6 flex items-center justify-end gap-2">
                        <a href="{{ route('purchase_orders.index') }}" class="btn-back">Kembali</a>
                        @if(Auth::user()->role->level == 'Manager' && $order->status == 'pending')
                            <form action="{{ route('purchase_orders.reject', $order->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn-reject">Reject</button>
                            </form>
                            <form action="{{ route('purchase_orders.approve', $order->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn-approve">Approve</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .btn-back {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
        }

        .btn-back:hover {
            background-color: #2980b9;
        }

        .btn-approve {
            background-color: #27ae60;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-approve:hover {
            background-color: #229954;
        }

        .btn-reject {
            background-color: #e74c3c;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-reject:hover {
            background-color: #c0392b;
        }
    </style>
</x-app-layout>
