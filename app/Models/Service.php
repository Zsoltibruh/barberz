<?php

namespace App\Models;

use Database\Factories\ServiceFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'duration_minutes', 'price', 'currency'])]
#[WithoutTimestamps]
class Service extends Model
{
    /** @use HasFactory<ServiceFactory> */
    use HasFactory;

    public function casts(): array
    {
        return [
            'name' => 'string',
        ];
    }

    /**
     * @return BelongsToMany<User, $this>
     */
    public function barbers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'barber_service', 'service_id', 'barber_id');
    }

    /**
     * @return HasMany<Appointment, $this>
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
