<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string $password
 * @property Carbon|null $deleted_at
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Customer[] $customers
 * @property-read int|null $customers_count
 * @property-read Collection|Note[] $notes
 * @property-read int|null $notes_count
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read Collection|Purchase[] $purchases
 * @property-read int|null $purchases_count
 * @property-read Collection|PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 *
 * @method static UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User search($searchQuery)
 * @method static \Illuminate\Database\Eloquent\Builder|User staff()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static Builder|User withTrashed()
 * @method static Builder|User withoutTrashed()
 *
 * @mixin Eloquent
 */
class User extends Authenticatable
{
    use SoftDeletes;
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $fillable = ['name', 'email', 'password', 'is_super_admin'];

    protected $hidden = ['password', 'remember_token', 'is_super_admin'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $withCount = ['sales_channels'];

    public function name(): Attribute
    {
        return new Attribute(
            get: fn ($value) => Str::title($value),
            set: fn ($value) => Str::title($value)
        );
    }

    public function email(): Attribute
    {
        return new Attribute(
            get: fn ($value) => Str::lower($value),
            set: fn ($value) => Str::lower($value)
        );
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
        return $this->belongsToMany(Permission::class)->orderBy('name');
    }

    public function sales_channels(): belongsToMany
    {
        return $this->belongsToMany(SalesChannel::class)
            ->orderBy('name')
            ->withPivot('is_default');
    }

    public function defaultSalesChannel()
    {
        return $this->sales_channels()
            ->wherePivot('is_default', true)
            ->first() ?? $this->sales_channels()->first();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function hasPermissionTo($permission): bool
    {
        if ($this->permissions->contains('name', $permission)) {
            return true;
        }

        return false;
    }

    public function scopeStaff($query)
    {
        return $query->where('is_super_admin', false);
    }
}
