<?php

namespace Tests\Feature;

use App\Models\Berita;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebsiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_beranda_tampil_dengan_data_seeder(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('BUSTANUL ULUM')
            ->assertSee('Berita Terbaru')
            ->assertSee('Program Keahlian');
    }

    public function test_berita_daftar_dan_detail(): void
    {
        $this->get('/berita')->assertOk();

        $berita = Berita::firstOrFail();
        $this->get('/berita/' . $berita->slug)->assertOk()->assertSee($berita->judul);
    }

    public function test_berita_tidak_terbit_tidak_bisa_dibuka(): void
    {
        $berita = Berita::firstOrFail();
        $berita->update(['terbit' => false]);

        $this->get('/berita/' . $berita->slug)->assertNotFound();
    }

    public function test_galeri_tampil(): void
    {
        $this->get('/galeri')->assertOk();
    }

    public function test_admin_wajib_login(): void
    {
        $this->get('/admin')->assertRedirect('/login');
        $this->get('/admin/berita')->assertRedirect('/login');
    }

    public function test_login_admin_dan_buka_dashboard(): void
    {
        $this->post('/login', ['email' => 'admin@smkibu.sch.id', 'password' => 'admin12345'])
            ->assertRedirect('/admin');

        $this->get('/admin')->assertOk()->assertSee('Dashboard');
    }

    public function test_login_gagal_dengan_password_salah(): void
    {
        $this->post('/login', ['email' => 'admin@smkibu.sch.id', 'password' => 'salah'])
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_admin_bisa_menambah_pengumuman(): void
    {
        $this->actingAs(User::firstOrFail())
            ->post('/admin/pengumuman', [
                'judul' => 'Tes Pengumuman', 'kategori' => 'Umum', 'tanggal' => '2026-10-07',
            ])
            ->assertRedirect('/admin/pengumuman');

        $this->assertDatabaseHas('pengumuman', ['judul' => 'Tes Pengumuman']);
    }
}
