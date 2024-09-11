<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\Material;
use App\Models\PurchaseOrderDetail;

class PurchaseOrderController extends Controller
{
    public function index() : View
    {
        $orders = PurchaseOrder::with('details.material', 'supplier')->paginate(10);
        return view('purchase_orders.index', compact('orders'));
    }

    public function create() : View
    {
        $suppliers = Supplier::all();
        $materials = Material::all();
        return view('purchase_orders.create', compact('suppliers', 'materials'));
    }

    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'supplier_id' => 'required|exists:m_suppliers,id',
            'materials' => 'required|array',
        ]);

        $totalPrice = 0;
        $totalQuantity = 0;

        $purchaseOrder = PurchaseOrder::create([
            'user_id' => auth()->id(),
            'supplier_id' => $request->supplier_id,
            'status' => 'pending',
            'total_price' => 0, 
            'total_quantity' => 0,
        ]);

        foreach ($request->materials as $material) {
            $quantity = $material['quantity'];
            $materialData = Material::find($material['material_id']);
            $pricePerUnit = $materialData->price;

            $totalPrice += $pricePerUnit * $quantity;
            $totalQuantity += $quantity;

            PurchaseOrderDetail::create([
                'purchase_order_id' => $purchaseOrder->id,
                'material_id' => $material['material_id'],
                'quantity' => $quantity,
            ]);
        }

        $purchaseOrder->update([
            'total_price' => $totalPrice,
            'total_quantity' => $totalQuantity,
        ]);

        return redirect()->route('purchase_orders.index')->with('success', 'Berhasil menambahkan purchase order');
    }

    public function approve($id) : RedirectResponse
    {
        $order = PurchaseOrder::find($id);
        $order->status = 'approved';
        $order->approved_by = auth()->id();
        $order->save();

        return redirect()->back()->with('success', 'Purchase order approved.');
    }

    public function reject($id) : RedirectResponse
    {
        $order = PurchaseOrder::find($id);
        $order->status = 'rejected';
        $order->approved_by = auth()->id();
        $order->save();

        return redirect()->back()->with('success', 'Purchase order rejected.');
    }

    public function show($id) : View
    {
        $order = PurchaseOrder::with('details.material', 'supplier', 'user')->find($id);
        return view('purchase_orders.show', compact('order'));
    }
}
