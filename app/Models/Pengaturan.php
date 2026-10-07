<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturan';
    protected $guarded = [];

    protected static ?array $cache = null;

    /** Ambil satu pengaturan (dimuat sekali per request). */
    public static function ambil(string $kunci, ?string $default = null): ?string
    {
        static::$cache ??= static::pluck('nilai', 'kunci')->all();

        return static::$cache[$kunci] ?? $default;
    }

    public static function simpan(string $kunci, ?string $nilai): void
    {
        static::updateOrCreate(['kunci' => $kunci], ['nilai' => $nilai]);
        static::$cache = null;
    }
}
