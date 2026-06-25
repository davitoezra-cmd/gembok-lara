<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $fillable = [
        'user_id',
        'role',
        'photo',
        'latitude',
        'longitude',
        'address',
        'check_in',
        'check_out',
        'status',
        'notes',
        'date',
    ];

    protected $casts = [
        'check_in'  => 'datetime',
        'check_out' => 'datetime',
        'date'      => 'date',
        'latitude'  => 'float',
        'longitude' => 'float',
    ];

    // -------------------------------------------------------
    // Relations
    // -------------------------------------------------------

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // -------------------------------------------------------
    // Scopes
    // -------------------------------------------------------

    /** Filter berdasarkan tanggal hari ini */
    public function scopeToday($query)
    {
        return $query->whereDate('date', today());
    }

    /** Filter berdasarkan role */
    public function scopeByRole($query, string $role)
    {
        return $query->where('role', $role);
    }

    // -------------------------------------------------------
    // Helpers
    // -------------------------------------------------------

    /** Cek apakah user sudah check-in hari ini */
    public static function sudahCheckIn(int $userId): bool
    {
        return static::where('user_id', $userId)
            ->whereDate('date', today())
            ->whereNotNull('check_in')
            ->exists();
    }

    /** Cek apakah user sudah check-out hari ini */
    public static function sudahCheckOut(int $userId): bool
    {
        return static::where('user_id', $userId)
            ->whereDate('date', today())
            ->whereNotNull('check_out')
            ->exists();
    }

    /** Ambil record absen hari ini milik user */
    public static function hariIni(int $userId): ?static
    {
        return static::where('user_id', $userId)
            ->whereDate('date', today())
            ->first();
    }
}