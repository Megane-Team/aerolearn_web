<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_karyawan',
        'id_eksternal',
        'email',
        'password',
        'user_role',
        'user_type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    function internal()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }
    function eksternal()
    {
        return $this->belongsTo(Eksternal::class, 'id_eksternal');
    }
    function info()
    {
        if ($this->id_karyawan) {
            return $this->internal(); // Jika id_karyawan ada, maka dia internal
        }

        if ($this->id_eksternal) {
            return $this->eksternal(); // Jika id_eksternal ada, maka dia eksternal
        }

        return null; // Jika tidak ada keduanya
    }
    function notif()
    {
        return $this->hasMany(Notifications::class, 'id_peserta')
        ->orderBy('created_at', 'desc') // Urutkan berdasarkan tanggal terbaru
        ->take(4); // Ambil hanya 4 data
    }
}
