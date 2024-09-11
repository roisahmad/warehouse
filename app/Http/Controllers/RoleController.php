<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Role;

class RoleController extends Controller
{
    public function index() : View
    {
        $roles = Role::latest()->paginate(10);
        return view('roles.index', compact('roles'));
    }

    public function create() : View
    {
        return view('roles.create');
    }

    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'name'  => 'required',
            'level' => 'required',
        ]);

        Role::create([
            'name'  => $request->name,
            'level' => $request->level
        ]);

        return redirect()->route('roles.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit(string $id) : View
    {
        $role = Role::findOrFail($id);
        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, string $id) : RedirectResponse
    {
        $role = Role::findOrFail($id);
        $role->update([
            'name' => $request->name,
            'level' => $request->level,
        ]);

        return redirect()->route('roles.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy(string $id) : RedirectResponse{
        $role = Role::findOrFail($id);
        $role->delete();
        
        return redirect()->route('roles.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
