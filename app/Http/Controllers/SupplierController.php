<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index() : View
    {
        $suppliers = Supplier::latest()->paginate(10);
        return view('suppliers.index', compact('suppliers'));
    }

    public function create() : View
    {
        return view('suppliers.create');
    }

    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'name'      => 'required',
            'contact'   => 'required',
            'address'   => 'required',
        ]);

        Supplier::create([
            'name'    => $request->name,
            'contact' => $request->contact,
            'address' => $request->address,
        ]);

        return redirect()->route('suppliers.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit(string $id) : View
    {
        $supplier = Supplier::findOrFail($id);
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, string $id) : RedirectResponse
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->update([
            'name'    => $request->name,
            'contact' => $request->contact,
            'address' => $request->address,
        ]);

        return redirect()->route('suppliers.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy(string $id) : RedirectResponse{
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        
        return redirect()->route('suppliers.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
