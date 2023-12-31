<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;

class PenjualanController extends Controller
{
    // Mendapatkan semua data penjualan
    public function index()
    {
        $penjualan = Penjualan::all();
        $total = Penjualan::sum('total_penjualan');
        $totals = Penjualan::sum('total_penjualans');
        // return response()->json($penjualan, 200);

        $data = [
            'makanan' => Penjualan::where('kategori', 'makanan')->get(),
            'minuman' => Penjualan::where('kategori', 'minuman')->get(),
            'total' => Penjualan::sum('total_penjualan'),
            'totals' => Penjualan::sum('total_penjualans'),
        ];       
         return view('laporan2022', $data, compact('penjualan', 'total', 'totals'));
        
    }

    // Menyimpan data penjualan baru
    public function store(Request $request)
    {
        $request->validate([
            'menu' => 'required|string',
            'total_penjualan' => 'required|integer',
        ]);

        $penjualan = Penjualan::create($request->all(
            'menu',
            'total_penjualan'
        ));

        return response()->json($penjualan, 201);
    }

    // Mendapatkan data penjualan berdasarkan ID
    public function show($id)
    {
        $penjualan = Penjualan::find($id);

        if (!$penjualan) {
            return response()->json(['message' => 'Data penjualan tidak ditemukan'], 404);
        }

        return response()->json($penjualan, 200);
    }

    // Memperbarui data penjualan berdasarkan ID
    public function update(Request $request, $id)
    {
        $request->validate([
            'menu' => 'required|string',
            'kategori' => 'required|string',
        ]);

        $penjualan = Penjualan::find($id);

        if (!$penjualan) {
            return response()->json(['message' => 'Data penjualan tidak ditemukan'], 404);
        }

        $penjualan->update($request->all());

        return response()->json($penjualan, 200);
    }

    // Menghapus data penjualan berdasarkan ID
    public function destroy($id)
    {
        $penjualan = Penjualan::find($id);

        if (!$penjualan) {
            return response()->json(['message' => 'Data penjualan tidak ditemukan'], 404);
        }

        $penjualan->delete();

        return response()->json(['message' => 'Data penjualan berhasil dihapus'], 200);
    }
}
