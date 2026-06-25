<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tiang;
use Illuminate\Http\Request;

class TiangController extends Controller
{
    public function index(Request $request)
    {
        $query = Tiang::query();

        // Fitur Pencarian Nomor Tiang atau Lokasi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_tiang', 'like', "%{$search}%")
                  ->orWhere('lokasi_spesifik', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan status tiang (baik, miring, rusak)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tiangs = $query->latest()->paginate(20);

        // Statistik ringkas untuk dashboard aset tiang
        $stats = [
            'total' => Tiang::count(),
            'baik' => Tiang::where('status', 'baik')->count(),
            'miring' => Tiang::where('status', 'miring')->count(),
            'rusak' => Tiang::where('status', 'rusak')->count(),
        ];

        return view('admin.network.tiangs.index', compact('tiangs', 'stats'));
    }

    public function create()
    {
        return view('admin.network.tiangs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_tiang'     => 'required|string|max:50|unique:tiangs,nomor_tiang',
            'lokasi_spesifik' => 'required|string',
            'latitude'        => 'nullable|numeric|between:-90,90',
            'longitude'       => 'nullable|numeric|between:-180,180',
            'status'          => 'required|in:baik,miring,rusak',
        ]);

        Tiang::create($validated);

        return redirect()->route('admin.network.tiang.index')
            ->with('success', 'Aset Tiang berhasil ditambahkan!');
    }

    public function edit(Tiang $tiang)
    {
        return view('admin.network.tiangs.edit', compact('tiang'));
    }

    public function update(Request $request, Tiang $tiang)
    {
        $validated = $request->validate([
            'nomor_tiang'     => 'required|string|max:50|unique:tiangs,nomor_tiang,' . $tiang->id,
            'lokasi_spesifik' => 'required|string',
            'latitude'        => 'nullable|numeric|between:-90,90',
            'longitude'       => 'nullable|numeric|between:-180,180',
            'status'          => 'required|in:baik,miring,rusak',
        ]);

        $tiang->update($validated);

        return redirect()->route('admin.network.tiang.index')
            ->with('success', 'Data Tiang berhasil diperbarui!');
    }

    public function destroy(Tiang $tiang)
    {
        $tiang->delete();
        return redirect()->route('admin.network.tiang.index')
            ->with('success', 'Aset Tiang berhasil dihapus!');
    }
}