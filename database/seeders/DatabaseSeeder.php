<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\KelolaKios\Models\Kios;
use Modules\Produk\Models\Produk;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin Demo
        User::updateOrCreate(
            ['email' => 'admin@pasarcerdas.test'],
            [
                'name' => 'Administrator Pasar',
                'role' => UserRole::Admin,
                'password' => Hash::make('password'),
            ]
        );

        // 2. Akun User Demo
        User::updateOrCreate(
            ['email' => 'user@pasarcerdas.test'],
            [
                'name' => 'Pedagang Pasar Cerdas',
                'role' => UserRole::User,
                'password' => Hash::make('password'),
            ]
        );

        // 3. Data Awal Modul KelolaKios (CRUD Synchronous)
        $kiosData = [
            [
                'kode_kios' => 'KIOS-A01',
                'nama_kios' => 'Toko Berkah Tani',
                'nama_pemilik' => 'H. Syamsul Arifin',
                'no_telp' => '081234567890',
                'lokasi' => 'Blok A No. 01, Lantai Dasar',
            ],
            [
                'kode_kios' => 'KIOS-A02',
                'nama_kios' => 'Sayur Segar Bu Lina',
                'nama_pemilik' => 'Lina Marlina',
                'no_telp' => '081298765432',
                'lokasi' => 'Blok A No. 05, Lantai Dasar',
            ],
            [
                'kode_kios' => 'KIOS-B03',
                'nama_kios' => 'Daging Barokah Sejahtera',
                'nama_pemilik' => 'Rahmat Hidayat',
                'no_telp' => '085211223344',
                'lokasi' => 'Blok B No. 03, Area Daging Basah',
            ],
            [
                'kode_kios' => 'KIOS-C04',
                'nama_kios' => 'Bumbu Nusantara Mak Ijah',
                'nama_pemilik' => 'Khadijah',
                'no_telp' => '087788990011',
                'lokasi' => 'Blok C No. 12, Lantai 1',
            ],
            [
                'kode_kios' => 'KIOS-D05',
                'nama_kios' => 'Buah Manis Nusantara',
                'nama_pemilik' => 'Budi Santoso',
                'no_telp' => '081344556677',
                'lokasi' => 'Blok D No. 08, Area Depan',
            ],
        ];

        foreach ($kiosData as $item) {
            Kios::updateOrCreate(['kode_kios' => $item['kode_kios']], $item);
        }

        // 4. Data Awal Modul Produk (CRUD AJAX)
        $produkData = [
            [
                'nama_produk' => 'Beras Pandan Wangi 5 Kg',
                'kategori' => 'Sembako',
                'harga' => 78000,
                'stok' => 45,
                'deskripsi' => 'Beras pulen aromatik kualitas super asli Cianjur kemasan 5 kg.',
                'foto' => null,
                'nama_foto' => null,
            ],
            [
                'nama_produk' => 'Daging Sapi Has Dalam 1 Kg',
                'kategori' => 'Daging',
                'harga' => 135000,
                'stok' => 20,
                'deskripsi' => 'Daging sapi segar potongan has dalam (tenderloin) higienis.',
                'foto' => null,
                'nama_foto' => null,
            ],
            [
                'nama_produk' => 'Bayam Hijau Segar Ikat',
                'kategori' => 'Sayuran',
                'harga' => 3500,
                'stok' => 120,
                'deskripsi' => 'Bayam hijau segar langsung dipetik dari petani lokal setiap subuh.',
                'foto' => null,
                'nama_foto' => null,
            ],
            [
                'nama_produk' => 'Jeruk Medan Manis 1 Kg',
                'kategori' => 'Buah',
                'harga' => 28000,
                'stok' => 35,
                'deskripsi' => 'Jeruk Medan segar berkulit tipis dengan rasa manis berair.',
                'foto' => null,
                'nama_foto' => null,
            ],
            [
                'nama_produk' => 'Bawang Merah Brebes 500 Gram',
                'kategori' => 'Bumbu',
                'harga' => 22000,
                'stok' => 60,
                'deskripsi' => 'Bawang merah super kering pilihan khas Brebes.',
                'foto' => null,
                'nama_foto' => null,
            ],
            [
                'nama_produk' => 'Minyak Goreng Sawit 2 Liter',
                'kategori' => 'Sembako',
                'harga' => 34500,
                'stok' => 50,
                'deskripsi' => 'Minyak goreng kelapa sawit higienis dengan dua kali penyaringan.',
                'foto' => null,
                'nama_foto' => null,
            ],
        ];

        foreach ($produkData as $prod) {
            Produk::updateOrCreate(['nama_produk' => $prod['nama_produk']], $prod);
        }
    }
}
