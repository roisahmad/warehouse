<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Material;
use App\Models\Supplier;

class MaterialController extends Controller
{
    public function index() : View
    {
        $materials = Material::with('supplier')->latest()->paginate(10);
        return view('materials.index', compact('materials'));
    }

    public function create() : View
    {
        $suppliers = Supplier::all();
        return view('materials.create', compact('suppliers'));
    }

    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'name'        => 'required',
            'code'        => 'required|unique:m_materials,code',
            'price'       => 'required',
            'supplier_id' => 'required',
            'stock'       => 'required|integer',
            'condition'   => 'required|in:good,bad',
        ]);

        Material::create([
            'name'        => $request->name,
            'code'        => $request->code,
            'price'       => $request->price,
            'supplier_id' => $request->supplier_id,
            'stock'       => $request->stock,
            'condition'   => $request->condition
        ]);

        return redirect()->route('materials.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit(string $id) : View
    {
        $material = Material::findOrFail($id);
        $suppliers = Supplier::all();

        return view('materials.edit', compact('material', 'suppliers'));
    }

    public function update(Request $request, string $id) : RedirectResponse
    {
        $material = Material::findOrFail($id);
        $material->update([
            'name'        => $request->name,
            'code'        => $request->code,
            'price'       => $request->price,
            'supplier_id' => $request->supplier_id,
            'stock'       => $request->stock,
            'condition'   => $request->condition
        ]);

        return redirect()->route('materials.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy(string $id) : RedirectResponse{
        $material = Material::findOrFail($id);
        $material->delete();
        
        return redirect()->route('materials.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
