<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Kandang\Models\PopulationLog;
use Modules\Kandang\Models\SupplierLog;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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

    public function adminlte_image()
    {
        $email = $this->attributes['email'];
        $hash = md5(strtolower(trim($email)));
        $url = "https://www.gravatar.com/avatar/{$hash}?s=200&d=identicon&r=pg";
        return  $url;
    }

    public function adminlte_desc()
    {
        return 'desc';
    }

    public function recordedLogs()
{
    return $this->hasMany(SupplierLog::class, 'recorded_by');
}

}
