<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\KelolaKios\Models\Kios;
use Modules\Produk\Models\Produk;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        $totalKios = class_exists(Kios::class) ? Kios::count() : 0;
        $totalProduk = class_exists(Produk::class) ? Produk::count() : 0;
        $totalStok = class_exists(Produk::class) ? (int) Produk::sum('stok') : 0;
        $totalUsers = User::count();

        $recentKios = class_exists(Kios::class) ? Kios::latest()->take(5)->get() : collect();
        $recentProduk = class_exists(Produk::class) ? Produk::latest()->take(5)->get() : collect();

        return view('dashboard', compact(
            'totalKios',
            'totalProduk',
            'totalStok',
            'totalUsers',
            'recentKios',
            'recentProduk'
        ));
    }
}
