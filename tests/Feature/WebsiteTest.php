<?php

namespace Tests\Feature;

use App\Models\Berita;
use App\Models\Pengaturan;
use App\Models\Slide;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\DemoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class WebsiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Pengaturan::lupakan();
        $this->seed(DatabaseSeeder::class);
        $this->seed(DemoSeeder::class);
        Pengaturan::lupakan();
    }

    private function admin(): User
    {
        return User::factory()->admin()->create();
    }

    // ---------- Publik ----------

    public function test_beranda_tampil_dengan_data_demo(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('BUSTANUL ULUM')
            ->assertSee('Berita Terbaru')
            ->assertSee('Program Keahlian')
            ->assertSee('images/hero.jpg'); // cadangan saat belum ada banner
    }

    public function test_banner_aktif_tampil_dan_nonaktif_tidak(): void
    {
        Slide::create(['gambar' => 'konten/aktif.jpg', 'urutan' => 1, 'aktif' => true]);
        Slide::create(['gambar' => 'konten/mati.jpg', 'urutan' => 2, 'aktif' => false]);

        $this->get('/')->assertOk()->assertSee('konten/aktif.jpg')->assertDontSee('konten/mati.jpg');
    }

    public function test_berita_daftar_detail_dan_pencarian(): void
    {
        $this->get('/berita')->assertOk();

        $berita = Berita::firstOrFail();
        $this->get('/berita/' . $berita->slug)->assertOk()->assertSee($berita->judul);

        $this->get('/berita?q=Juara')->assertOk()->assertSee('Juara 2')->assertDontSee('Halal bi Halal');
        // Karakter khusus LIKE dicari apa adanya, bukan sebagai wildcard.
        $this->get('/berita?q=%25')->assertOk()->assertSee('Tidak ada berita yang cocok');
    }

    public function test_berita_tidak_terbit_tidak_bisa_dibuka(): void
    {
        $berita = Berita::firstOrFail();
        $berita->update(['terbit' => false]);

        $this->get('/berita/' . $berita->slug)->assertNotFound();
    }

    public function test_halaman_pengumuman_agenda_dan_galeri(): void
    {
        $this->get('/pengumuman')->assertOk()->assertSee('Jadwal Ujian Tengah Semester');
        $this->get('/agenda')->assertOk()->assertSee('Rapat Wali Murid');
        $this->get('/galeri')->assertOk();
    }

    public function test_tautan_sosmed_hanya_tampil_bila_diisi(): void
    {
        $this->get('/')->assertDontSee('bi-facebook');

        Pengaturan::simpan('sosmed_facebook', 'https://facebook.com/smkibu');
        $this->get('/')->assertSee('https://facebook.com/smkibu', false)->assertSee('bi-facebook');
    }

    // ---------- Seeder ----------

    public function test_seeder_membuat_satu_admin_dan_tidak_menimpa_password(): void
    {
        $this->assertSame(1, User::where('is_admin', true)->count());

        $hashLama = User::where('is_admin', true)->value('password');
        $this->seed(DatabaseSeeder::class);

        $this->assertSame(1, User::where('is_admin', true)->count());
        $this->assertSame($hashLama, User::where('is_admin', true)->value('password'));
    }

    // ---------- Akses admin ----------

    public function test_admin_wajib_login(): void
    {
        $this->get('/admin')->assertRedirect('/login');
        $this->get('/admin/berita')->assertRedirect('/login');
    }

    public function test_user_biasa_tidak_boleh_masuk_admin(): void
    {
        $this->actingAs(User::factory()->create())->get('/admin')->assertForbidden();
    }

    public function test_user_biasa_tidak_bisa_login_lewat_form_admin(): void
    {
        $user = User::factory()->create(['password' => 'rahasia-123']);

        $this->post('/login', ['email' => $user->email, 'password' => 'rahasia-123'])
            ->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_login_admin_dan_buka_dashboard(): void
    {
        $admin = User::factory()->admin()->create(['password' => 'rahasia-123']);

        $this->post('/login', ['email' => $admin->email, 'password' => 'rahasia-123'])->assertRedirect('/admin');
        $this->get('/admin')->assertOk()->assertSee('Dashboard');
    }

    public function test_login_gagal_dengan_password_salah(): void
    {
        $admin = User::factory()->admin()->create(['password' => 'rahasia-123']);

        $this->post('/login', ['email' => $admin->email, 'password' => 'salah'])->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    // ---------- CRUD admin ----------

    public function test_admin_bisa_menambah_pengumuman_dan_kategori_divalidasi(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post('/admin/pengumuman', [
            'judul' => 'Tes Pengumuman', 'kategori' => 'Umum', 'tanggal' => '2026-10-07',
        ])->assertRedirect('/admin/pengumuman');
        $this->assertDatabaseHas('pengumuman', ['judul' => 'Tes Pengumuman']);

        $this->actingAs($admin)->post('/admin/pengumuman', [
            'judul' => 'Kategori Ngawur', 'kategori' => 'Bebas', 'tanggal' => '2026-10-07',
        ])->assertSessionHasErrors('kategori');
        $this->assertDatabaseMissing('pengumuman', ['judul' => 'Kategori Ngawur']);
    }

    public function test_berita_bisa_disembunyikan_lewat_kotak_centang(): void
    {
        $berita = Berita::firstOrFail();

        $this->actingAs($this->admin())->put('/admin/berita/' . $berita->id, [
            'judul' => $berita->judul, 'kategori' => $berita->kategori,
            'tanggal' => $berita->tanggal->toDateString(), 'ringkas' => $berita->ringkas,
            'isi' => $berita->isi, 'terbit' => '0', // nilai hidden saat kotak tidak dicentang
        ])->assertRedirect('/admin/berita');

        $this->assertFalse($berita->fresh()->terbit);
    }

    public function test_foto_besar_otomatis_diperkecil(): void
    {
        Storage::fake('public');

        $this->actingAs($this->admin())->post('/admin/berita', [
            'judul' => 'Berita Bergambar', 'kategori' => 'Kegiatan', 'tanggal' => '2026-10-07',
            'ringkas' => 'Ringkas', 'isi' => 'Isi berita', 'terbit' => '1',
            'gambar' => UploadedFile::fake()->image('besar.jpg', 3200, 2400),
        ])->assertRedirect('/admin/berita');

        $berita = Berita::where('judul', 'Berita Bergambar')->firstOrFail();
        Storage::disk('public')->assertExists($berita->gambar);

        [$lebar] = getimagesizefromstring(Storage::disk('public')->get($berita->gambar));
        $this->assertLessThanOrEqual(1600, $lebar);
    }

    public function test_banner_wajib_punya_foto(): void
    {
        Storage::fake('public');
        $admin = $this->admin();

        $this->actingAs($admin)->post('/admin/slide', ['urutan' => 1, 'aktif' => '1'])
            ->assertSessionHasErrors('gambar');

        $this->actingAs($admin)->post('/admin/slide', [
            'urutan' => 1, 'aktif' => '1', 'gambar' => UploadedFile::fake()->image('hero.jpg', 1800, 700),
        ])->assertRedirect('/admin/slide');
        $this->assertSame(1, Slide::count());
    }

    public function test_pengaturan_menolak_tautan_berbahaya(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->put('/admin/pengaturan', ['sosmed_facebook' => 'javascript:alert(1)'])
            ->assertSessionHasErrors('sosmed_facebook');

        $this->actingAs($admin)->put('/admin/pengaturan', ['sosmed_facebook' => 'https://facebook.com/smkibu'])
            ->assertSessionHasNoErrors();
        $this->assertSame('https://facebook.com/smkibu', Pengaturan::ambil('sosmed_facebook'));
    }

    public function test_ikon_program_keahlian_harus_berformat_bootstrap_icons(): void
    {
        $this->actingAs($this->admin())->post('/admin/program', [
            'nama' => 'Program Uji', 'ikon' => '"><script>', 'urutan' => 9,
        ])->assertSessionHasErrors('ikon');
    }
}
