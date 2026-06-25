<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Backbone;
use Illuminate\Http\Request;

class BackbonesController extends Controller
{
    public function index()
    {
        $backbones = Backbone::latest()->paginate(10);
        
        // Statistik ringkas untuk ditaruh di atas tabel nanti jika perlu
        $stats = [
            'total'      => Backbone::count(),
            'aktif'      => Backbone::where('status', 'aktif')->count(),
            'gangguan'   => Backbone::where('status', 'gangguan')->count(),
            'maintenance'=> Backbone::where('status', 'maintenance')->count(),
        ];

        return view('admin.network.backbones.index', compact('backbones', 'stats'));
    }

    public function create()
    {
        return view('admin.network.backbones.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_backbone'  => 'required|unique:backbones,kode_backbone',
            'nama_jalur'     => 'required|string|max:255',
            'kapasitas_core' => 'required|integer|min:1',
            'core_terpakai'  => 'required|integer|min:0|lte:kapasitas_core',
            'panjang_kabel'  => 'required|numeric|min:0',
            'tipe_kabel'     => 'required|in:aerial,underground,submarine',
            'status'         => 'required|in:aktif,gangguan,maintenance',
            'keterangan'     => 'nullable|string',
        ]);

        Backbone::create($validated);

        return redirect()->route('admin.network.backbones.index')
            ->with('success', 'Kabel Backbone berhasil ditambahkan!');
    }

    public function show(Backbone $backbone)
    {
        return view('admin.network.backbones.show', compact('backbone'));
    }

    public function edit(Backbone $backbone)
    {
        return view('admin.network.backbones.edit', compact('backbone'));
    }

    public function update(Request $request, Backbone $backbone)
    {
        $validated = $request->validate([
            'kode_backbone'  => 'required|unique:backbones,kode_backbone,' . $backbone->id,
            'nama_jalur'     => 'required|string|max:255',
            'kapasitas_core' => 'required|integer|min:1',
            'core_terpakai'  => 'required|integer|min:0|lte:kapasitas_core',
            'panjang_kabel'  => 'required|numeric|min:0',
            'tipe_kabel'     => 'required|in:aerial,underground,submarine',
            'status'         => 'required|in:aktif,gangguan,maintenance',
            'keterangan'     => 'nullable|string',
        ]);

        $backbone->update($validated);

        return redirect()->route('admin.network.backbones.index')
            ->with('success', 'Data Backbone berhasil diperbarui!');
    }

    public function destroy(Backbone $backbone)
    {
        $backbone->delete();

        return redirect()->route('admin.network.backbones.index')
            ->with('success', 'Kabel Backbone berhasil dihapus dari sistem!');
    }
}