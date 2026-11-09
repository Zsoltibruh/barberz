<?php

namespace App\Livewire\Forms;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\User;
use App\Rules\MinimumTime;
use App\Rules\WithinWorkingHours;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Form;

class BookAppointmentForm extends Form
{
    public User $barber;

    public string $serviceId = '';

    public string $date = '';

    public string $time = '';

    public function setBarber(User $barber): void
    {
        $this->barber = $barber;
    }

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'serviceId' => ['required', Rule::exists('barber_service', 'service_id')->where('barber_id', $this->barber->id)],
            'date' => ['bail', 'required', 'date_format:Y-m-d', 'after_or_equal:today'],
            'time' => ['bail', 'required', 'date_format:H:i', new WithinWorkingHours($this->barber), new MinimumTime],
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function messages(): array
    {
        return [
            'serviceId.required' => __('Please select a service'),
            'serviceId.exists' => __('Please select a valid service'),
            'date.required' => __('Please select a date'),
            'date.date_format' => __('Please select a valid date'),
            'date.after_or_equal' => __('Please select a valid date'),
            'time.required' => __('Please select a time'),
            'time.date_format' => __('Please select a valid time'),
        ];
    }

    public function store(): Appointment
    {
        $this->validate();

        return Appointment::create([
            'barber_id' => $this->barber->id,
            'customer_id' => Auth::id(),
            'service_id' => $this->serviceId,
            'date' => Carbon::createFromFormat('!Y-m-d H:i', "{$this->date} {$this->time}"),
            'status' => AppointmentStatus::Confirmed,
        ]);
    }
}
