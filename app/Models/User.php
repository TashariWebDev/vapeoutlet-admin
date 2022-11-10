<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class User extends Authenticatable
{
    use SoftDeletes;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->name = Str::title($user->name);
            $user->email = Str::lower($user->email);
        });

        static::saving(function ($user) {
            $user->name = Str::title($user->name);
            $user->email = Str::lower($user->email);
        });

        static::updating(function ($user) {
            $user->name = Str::title($user->name);
            $user->email = Str::lower($user->email);
        });
    }

    public function scopeSearch($query, $searchQuery)
    {
        return $query
            ->where('name', 'like', $searchQuery.'%')
            ->orWhere('email', 'like', $searchQuery.'%');
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class, 'creator_id');
    }

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class, 'salesperson_id');
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function permissions(): belongsToMany
    {
        return $this->belongsToMany(Permission::class)
            ->as('permission')
            ->orderBy('name');
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function hasPermissionTo($permission): bool
    {
        if (
            auth()
                ->user()
                ->permissions->contains('name', $permission)
        ) {
            return true;
        }

        return false;
    }

    public function scopeStaff($query)
    {
        return $query->where('email', '!=', 'ridwan@tashari.co.za');
    }
}
