<?php

namespace App\Models;

use App\Enums\Role;
use App\Enums\UserStatus;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property Carbon|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['first_name', 'surname', 'email', 'password'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**'barber_id', 'service_id',
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => UserStatus::class,
            'role' => Role::class,
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        $initials = Str::initials($this->name, true);

        return Str::length($initials) > 1
            ? Str::substr($initials, 0, 1).Str::substr($initials, -1)
            : $initials;
    }

    public function getFullName(): string
    {
        return $this->first_name.' '.$this->surname;
    }

    /**
     * Full name in Hungarian format (Surname Firstname)
     *
     * @return Attribute<non-falsy-string, never>
     */
    protected function name(): Attribute
    {
        return Attribute::get(fn () => $this->surname.' '.$this->first_name);
    }

    /**
     * @return HasMany<WorkingHour, $this>
     */
    public function workingHours(): HasMany
    {
        return $this->hasMany(WorkingHour::class, 'barber_id');
    }

    /**
     * @return HasMany<Appointment, $this>
     */
    public function barberAppointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'barber_id');
    }

    /**
     * @return HasMany<Appointment, $this>
     */
    public function customerAppointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'customer_id');
    }

    /**
     * @return BelongsToMany<Service, $this>
     */
    public function barberServices(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'barber_service', 'barber_id', 'service_id');
    }
}
