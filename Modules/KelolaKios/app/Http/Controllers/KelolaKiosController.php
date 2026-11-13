<?php

namespace Modules\KelolaKios\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\KelolaKios\Http\Requests\KiosRequest;
use Modules\KelolaKios\Models\Kios;

class KelolaKiosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->query('q');

        $kios = Kios::when($search, function ($query, $search) {
            $query->where('kode_kios', 'like', "%{$search}%")
                ->orWhere('nama_kios', 'like', "%{$search}%")
                ->orWhere('nama_pemilik', 'like', "%{$search}%")
                ->orWhere('lokasi', 'like', "%{$search}%")
                ->orWhere('no_telp', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

        return view('kelolakios::index', compact('kios', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $kios = new Kios();

        return view('kelolakios::create', compact('kios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KiosRequest $request): RedirectResponse
    {
        $kios = Kios::create($request->validated());

        return redirect()->route('kelola-kios.index')
            ->with('success', "Kios '{$kios->nama_kios}' ({$kios->kode_kios}) berhasil ditambahkan.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Kios $kios): View
    {
        return view('kelolakios::show', compact('kios'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kios $kios): View
    {
        return view('kelolakios::edit', compact('kios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KiosRequest $request, Kios $kios): RedirectResponse
    {
        $kios->update($request->validated());

        return redirect()->route('kelola-kios.index')
            ->with('success', "Data kios '{$kios->nama_kios}' berhasil diperbarui.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kios $kios): RedirectResponse
    {
        $nama = $kios->nama_kios;
        $kios->delete();

        return redirect()->route('kelola-kios.index')
            ->with('success', "Kios '{$nama}' berhasil dihapus.");
    }
}
