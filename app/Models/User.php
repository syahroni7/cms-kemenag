<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;

    protected $fillable = [
        'name',
        'jabatan',
        'username',
        'email',
        'password',
        'block',
        'status',
        'created_by',
        'updated_by',
        'last_login_at',
        'last_login_ip',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'plain_password',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at'     => 'datetime',
        'deleted_at'        => 'datetime',
    ];

    protected $appends = ['age', 'name_phone'];

    /**
     * Auto-hash password
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] =
            strlen($value) === 60 && str_starts_with($value, '$2y$')
                ? $value
                : bcrypt($value);
    }

    /**
     * Contoh accessor: umur user berdasarkan format NIK/username (18 digit)
     */
    public function getAgeAttribute()
    {
        $raw = strlen($this->username ?? '') === 18
            ? substr($this->username, 0, 8)
            : null;

        if (!$raw) {
            return 'undetected';
        }

        $birthDate = substr($raw, 0, 4) . '-' . substr($raw, 4, 2) . '-' . substr($raw, 6, 2);

        try {
            $interval = date_diff(date_create(), date_create($birthDate));
            return $interval->format("%Y Tahun, %M Bulan, %d Hari");
        } catch (\Exception $e) {
            return 'undetected';
        }
    }

    /**
     * Contoh accessor: gabungan name & no_hp
     * (pastikan kolom no_hp ada)
     */
    public function getNamePhoneAttribute()
    {
        return ($this->name ?? '') . '_' . ($this->no_hp ?? '');
    }
}
