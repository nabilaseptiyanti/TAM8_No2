<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Modules\KelolaKios\Models\Kios;
use Modules\Produk\Models\Produk;
use Tests\TestCase;

class PascerSystemTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Siapkan akun admin
        $this->admin = User::create([
            'name' => 'Admin Pasar',
            'email' => 'admin@pasarcerdas.test',
            'role' => UserRole::Admin,
            'password' => Hash::make('password'),
        ]);

        // Siapkan akun user pedagang
        $this->user = User::create([
            'name' => 'User Pedagang',
            'email' => 'user@pasarcerdas.test',
            'role' => UserRole::User,
            'password' => Hash::make('password'),
        ]);
    }

    /**
     * Test 1: Pengguna tamu yang belum login dialihkan ke halaman login.
     */
    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
        $this->get('/kelola-kios')->assertRedirect('/login');
        $this->get('/produk')->assertRedirect('/login');
    }

    /**
     * Test 2: Otorisasi Role Middleware.
     * Admin boleh membuka Kelola Kios, User mendapatkan 403 Forbidden.
     */
    public function test_role_authorization_for_kelola_kios(): void
    {
        // Admin membuka kelola kios -> 200 OK
        $this->actingAs($this->admin)
            ->get('/kelola-kios')
            ->assertStatus(200)
            ->assertSee('Data Kios Pasar Cerdas');

        // User biasa membuka kelola kios -> 403 Forbidden
        $this->actingAs($this->user)
            ->get('/kelola-kios')
            ->assertStatus(403);
    }

    /**
     * Test 3: Kedua Role (Admin dan User) dapat mengakses modul Produk.
     */
    public function test_both_admin_and_user_can_access_produk(): void
    {
        $this->actingAs($this->admin)
            ->get('/produk')
            ->assertStatus(200);

        $this->actingAs($this->user)
            ->get('/produk')
            ->assertStatus(200);
    }

    /**
     * Test 4: Registrasi akun baru otomatis mendapatkan role User.
     */
    public function test_user_registration_assigns_user_role(): void
    {
        $response = $this->post('/register', [
            'name' => 'Pedagang Baru',
            'email' => 'pedagangbaru@pasarcerdas.test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();

        $newUser = User::where('email', 'pedagangbaru@pasarcerdas.test')->first();
        $this->assertNotNull($newUser);
        $this->assertEquals(UserRole::User, $newUser->role);
    }

    /**
     * Test 5: CRUD Synchronous pada Modul KelolaKios (Hanya Admin).
     */
    public function test_kelolakios_synchronous_crud_operations(): void
    {
        // 5.1 Create / Store
        $kiosData = [
            'kode_kios' => 'KIOS-TEST01',
            'nama_kios' => 'Kios Test Berkah',
            'nama_pemilik' => 'Pak Joko',
            'no_telp' => '081234567890',
            'lokasi' => 'Blok T No. 01 Lantai Dasar',
        ];

        $response = $this->actingAs($this->admin)->post('/kelola-kios', $kiosData);
        $response->assertRedirect('/kelola-kios');
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('kios', ['kode_kios' => 'KIOS-TEST01']);

        $kios = Kios::where('kode_kios', 'KIOS-TEST01')->first();

        // 5.2 Read / Show
        $this->actingAs($this->admin)
            ->get("/kelola-kios/{$kios->id}")
            ->assertStatus(200)
            ->assertSee('Kios Test Berkah');

        // 5.3 Edit / Update
        $updateData = [
            'kode_kios' => 'KIOS-TEST01',
            'nama_kios' => 'Kios Test Berkah Update',
            'nama_pemilik' => 'Pak Joko Santoso',
            'no_telp' => '081299998888',
            'lokasi' => 'Blok T No. 02 Lantai Dasar',
        ];

        $updateResponse = $this->actingAs($this->admin)->put("/kelola-kios/{$kios->id}", $updateData);
        $updateResponse->assertRedirect('/kelola-kios');
        $this->assertDatabaseHas('kios', ['nama_kios' => 'Kios Test Berkah Update']);

        // 5.4 Search
        $this->actingAs($this->admin)
            ->get('/kelola-kios?q=Santoso')
            ->assertStatus(200)
            ->assertSee('Pak Joko Santoso');

        // 5.5 Delete
        $deleteResponse = $this->actingAs($this->admin)->delete("/kelola-kios/{$kios->id}");
        $deleteResponse->assertRedirect('/kelola-kios');
        $this->assertDatabaseMissing('kios', ['id' => $kios->id]);
    }

    /**
     * Test 6: Validasi Modul KelolaKios mencegah duplikasi kode kios.
     */
    public function test_kelolakios_validation_rejects_duplicate_kode(): void
    {
        Kios::create([
            'kode_kios' => 'KIOS-EXIST',
            'nama_kios' => 'Kios Lama',
            'nama_pemilik' => 'Pemilik Lama',
            'no_telp' => '0811111111',
            'lokasi' => 'Blok A',
        ]);

        $response = $this->actingAs($this->admin)->post('/kelola-kios', [
            'kode_kios' => 'KIOS-EXIST',
            'nama_kios' => 'Kios Duplikat',
            'nama_pemilik' => 'Pemilik Baru',
            'no_telp' => '0822222222',
            'lokasi' => 'Blok B',
        ]);

        $response->assertSessionHasErrors(['kode_kios']);
    }

    /**
     * Test 7: CRUD AJAX pada Modul Produk dengan FormData dan Upload File.
     */
    public function test_produk_ajax_crud_and_file_upload(): void
    {
        Storage::fake('public');

        // 7.1 AJAX GET Data
        $this->actingAs($this->user)
            ->getJson('/produk/data')
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'count']);

        // 7.2 AJAX POST Store dengan file foto
        $file = UploadedFile::fake()->create('jeruk.jpg', 500, 'image/jpeg');

        $postData = [
            'nama_produk' => 'Jeruk Manis Segar',
            'kategori' => 'Buah',
            'harga' => 25000,
            'stok' => 50,
            'deskripsi' => 'Jeruk manis langsung dari kebun.',
            'foto' => $file,
        ];

        $storeResponse = $this->actingAs($this->user)->postJson('/produk', $postData);
        $storeResponse->assertStatus(201)
            ->assertJson(['success' => true]);

        $produk = Produk::where('nama_produk', 'Jeruk Manis Segar')->first();
        $this->assertNotNull($produk);
        $this->assertNotNull($produk->foto);

        // Verifikasi berkas tersimpan di storage public
        Storage::disk('public')->assertExists($produk->foto);

        // 7.3 AJAX GET Single Show
        $this->actingAs($this->user)
            ->getJson("/produk/{$produk->id}")
            ->assertStatus(200)
            ->assertJsonPath('data.nama_produk', 'Jeruk Manis Segar')
            ->assertJsonPath('data.foto_url', Storage::disk('public')->url($produk->foto));

        // 7.4 AJAX Update dengan foto baru
        $newFile = UploadedFile::fake()->create('jeruk_baru.png', 600, 'image/png');

        $updateResponse = $this->actingAs($this->user)->postJson("/produk/{$produk->id}", [
            '_method' => 'PUT',
            'nama_produk' => 'Jeruk Manis Super',
            'kategori' => 'Buah',
            'harga' => 30000,
            'stok' => 40,
            'deskripsi' => 'Jeruk kualitas super.',
            'foto' => $newFile,
        ]);

        $updateResponse->assertStatus(200)
            ->assertJson(['success' => true]);

        $produk->refresh();
        $this->assertEquals('Jeruk Manis Super', $produk->nama_produk);
        Storage::disk('public')->assertExists($produk->foto);

        // 7.5 AJAX DELETE Produk
        $deleteResponse = $this->actingAs($this->user)->deleteJson("/produk/{$produk->id}");
        $deleteResponse->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseMissing('produks', ['id' => $produk->id]);
        Storage::disk('public')->assertMissing($produk->foto);
    }

    /**
     * Test 8: Validasi berkas foto produk menolak format terlarang atau ukuran berlebih.
     */
    public function test_produk_validation_rejects_invalid_file_type(): void
    {
        Storage::fake('public');

        // File text bukan file gambar/pdf
        $badFile = UploadedFile::fake()->create('malicious.exe', 500);

        $response = $this->actingAs($this->user)->postJson('/produk', [
            'nama_produk' => 'Produk Cacat',
            'kategori' => 'Sembako',
            'harga' => 10000,
            'stok' => 5,
            'foto' => $badFile,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['foto']);
    }
}
