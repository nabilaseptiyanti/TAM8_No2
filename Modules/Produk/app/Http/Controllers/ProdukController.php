<?php

namespace Modules\Produk\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Modules\Produk\Http\Requests\ProdukRequest;
use Modules\Produk\Models\Produk;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource view.
     */
    public function index(): View
    {
        return view('produk::index');
    }

    /**
     * Fetch all products as JSON for AJAX datatable.
     */
    public function data(Request $request): JsonResponse
    {
        $search = $request->query('q');

        $produks = Produk::when($search, function ($query, $search) {
            $query->where('nama_produk', 'like', "%{$search}%")
                ->orWhere('kategori', 'like', "%{$search}%")
                ->orWhere('deskripsi', 'like', "%{$search}%");
        })
        ->latest()
        ->get();

        return response()->json([
            'success' => true,
            'data' => $produks,
            'count' => $produks->count(),
        ]);
    }

    /**
     * Get single product detail as JSON.
     */
    public function show(Produk $produk): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $produk,
        ]);
    }

    /**
     * Store a newly created product via AJAX FormData.
     */
    public function store(ProdukRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $path = $file->store('foto_produk', 'public');
            $validated['foto'] = $path;
            $validated['nama_foto'] = $file->getClientOriginalName();
        }

        $produk = Produk::create($validated);

        return response()->json([
            'success' => true,
            'message' => "Produk '{$produk->nama_produk}' berhasil ditambahkan.",
            'data' => $produk,
        ], 201);
    }

    /**
     * Update the specified product via AJAX FormData.
     */
    public function update(ProdukRequest $request, Produk $produk): JsonResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('foto')) {
            // Hapus file lama jika ada
            if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
                Storage::disk('public')->delete($produk->foto);
            }

            $file = $request->file('foto');
            $path = $file->store('foto_produk', 'public');
            $validated['foto'] = $path;
            $validated['nama_foto'] = $file->getClientOriginalName();
        }

        $produk->update($validated);

        return response()->json([
            'success' => true,
            'message' => "Produk '{$produk->nama_produk}' berhasil diperbarui.",
            'data' => $produk->fresh(),
        ]);
    }

    /**
     * Remove the specified product from storage via AJAX.
     */
    public function destroy(Produk $produk): JsonResponse
    {
        $nama = $produk->nama_produk;

        if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
            Storage::disk('public')->delete($produk->foto);
        }

        $produk->delete();

        return response()->json([
            'success' => true,
            'message' => "Produk '{$nama}' berhasil dihapus.",
        ]);
    }
}
