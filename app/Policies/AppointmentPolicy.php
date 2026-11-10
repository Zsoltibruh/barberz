<?php

namespace App\Policies;

use App\Enums\AppointmentStatus;
use App\Enums\Role;
use App\Models\Appointment;
use App\Models\User;

class AppointmentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(Role::Customer);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Appointment $appointment): bool
    {
        return $user->can('view own appointments')
        && $appointment->customer_id === $user->id;
    }

    public function cancel(User $user, Appointment $appointment): bool
    {
        if ($appointment->status !== AppointmentStatus::Confirmed->value) {
            return false;
        }

        return $user->can('cancel own appointments')
        && $appointment->customer_id === $user->id;
    }

    public function reschedule(User $user, Appointment $appointment): bool
    {
        if ($appointment->status !== AppointmentStatus::Confirmed->value) {
            return false;
        }

        return $user->can('reschedule own appointments')
        && ($appointment->customer_id === $user->id
        || $appointment->barber_id === $user->id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(Role::Customer);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Appointment $appointment): bool
    {
        return $appointment->customer_id === $user->id
        || $appointment->barber_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Appointment $appointment): bool
    {
        return $appointment->customer_id === $user->id || $user->hasRole([Role::Admin, Role::Owner]);
    }
}
