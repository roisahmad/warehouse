<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\WarehouseEntry;
use App\Models\Supplier;
use App\Models\Material;
use App\Models\WarehouseEntryDetail;
use App\Models\PurchaseOrder;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouseEntries = WarehouseEntry::with('purchaseOrder', 'details.material', 'supplier')
            ->latest()
            ->paginate(10);

        return view('warehouse.index', compact('warehouseEntries'));
    }

public function create()
{
    $purchaseOrders = PurchaseOrder::with('supplier')->where('status', 'approved')->get();

    return view('warehouse.create', compact('purchaseOrders'));
}

public function store(Request $request)
{
    $request->validate([
        'purchase_order_id' => 'required|exists:t_purchase_orders,id',
        'arrival_date' => 'required|date',
        'materials' => 'required|array',
    ]);

    $warehouseEntry = WarehouseEntry::create([
        'purchase_order_id' => $request->purchase_order_id,
        'supplier_id' => PurchaseOrder::find($request->purchase_order_id)->supplier_id,
        'arrival_date' => $request->arrival_date,
    ]);

    foreach ($request->materials as $material) {
        WarehouseEntryDetail::create([
            'warehouse_entry_id' => $warehouseEntry->id,
            'material_id' => $material['material_id'],
            'quantity' => $material['quantity'],
            'condition' => $material['condition'],
            'unique_code' => uniqid(), 
        ]);

        $materialData = Material::find($material['material_id']);
        $materialData->increment('stock', $material['quantity']);
    }

    return redirect()->route('warehouse.index')->with('success', 'Material received and stock updated successfully.');
}

    public function getMaterials($purchaseOrderId, Request $request)
    {
        $purchaseOrder = PurchaseOrder::with('details.material')->findOrFail($purchaseOrderId);

        $entryDetails = [];
        if ($request->has('entry_id')) {
            $warehouseEntry = WarehouseEntry::with('details')->findOrFail($request->entry_id);
            $entryDetails = $warehouseEntry->details->pluck('quantity', 'material_id')->toArray();
        }

        $materials = $purchaseOrder->details->map(function ($detail) use ($entryDetails) {
            return [
                'id' => $detail->material_id,
                'name' => $detail->material->name,
                'quantity' => $entryDetails[$detail->material_id] ?? $detail->quantity,
                'condition' => $detail->condition ?? 'good',
                'location' => $detail->location ?? '',
            ];
        });

        return response()->json(['materials' => $materials]);
    }

    public function edit($id)
    {
         $purchaseOrders = PurchaseOrder::with('supplier')->where('status', 'approved')->get();
        $warehouseEntry = WarehouseEntry::with('details')->findOrFail($id);
        $suppliers = Supplier::all();
        $materials = Material::all();

        return view('warehouse.edit', compact('warehouseEntry', 'suppliers', 'materials', 'purchaseOrders'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'purchase_order_id' => 'required|exists:purchase_orders,id',
            'arrival_date' => 'required|date',
            'materials' => 'required|array',
        ]);

        $warehouseEntry = WarehouseEntry::findOrFail($id);

        $warehouseEntry->update([
            'purchase_order_id' => $request->purchase_order_id,
            'supplier_id' => PurchaseOrder::find($request->purchase_order_id)->supplier_id,
            'arrival_date' => $request->arrival_date,
        ]);

        WarehouseEntryDetail::where('warehouse_entry_id', $id)->delete();

        foreach ($request->materials as $material) {
            WarehouseEntryDetail::create([
                'warehouse_entry_id' => $warehouseEntry->id,
                'material_id' => $material['material_id'],
                'quantity' => $material['quantity'],
                'condition' => $material['condition'],
                'unique_code' => uniqid(),
                'location' => $material['location'],
            ]);
        }

        return redirect()->route('warehouse.index')->with('success', 'Warehouse entry updated successfully.');
    }


    public function destroy($id)
    {
        $warehouseEntry = WarehouseEntry::findOrFail($id);
        $warehouseEntry->details()->delete(); 
        $warehouseEntry->delete();

        return redirect()->route('warehouse.index')->with('success', 'Warehouse entry deleted successfully.');
    }

    public function show($id)
    {
        $warehouseEntry = WarehouseEntry::with('details.material', 'supplier')->findOrFail($id);

        return view('warehouse.show', compact('warehouseEntry'));
    }


    // public function report(Request $request)
    // {
    //     $request->validate([
    //         'start_date' => 'required|date',
    //         'end_date' => 'required|date',
    //     ]);

    //     $warehouseEntries = WarehouseEntry::whereBetween('arrival_date', [$request->start_date, $request->end_date])
    //         ->with('details.material')
    //         ->get();

    //     return view('warehouse.report', compact('warehouseEntries'));
    // }
}
