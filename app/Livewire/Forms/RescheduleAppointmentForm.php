<?php

namespace App\Livewire\Forms;

use App\Models\Appointment;
use App\Rules\MinimumTime;
use App\Rules\WithinWorkingHours;
use Carbon\CarbonImmutable;
use Livewire\Form;

class RescheduleAppointmentForm extends Form
{
    public Appointment $appointment;

    public string $date = '';

    public string $time = '';

    public function setAppointment(Appointment $appointment): void
    {
        $this->appointment = $appointment;
        $this->date = $appointment->date->format('Y-m-d');
        $this->time = $appointment->date->format('H:i');
    }

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'date' => ['bail', 'required', 'date_format:Y-m-d', 'after_or_equal:today'],
            'time' => ['bail', 'required', 'date_format:H:i', new WithinWorkingHours($this->appointment->barber), new MinimumTime],
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function messages(): array
    {
        return [
            'date.required' => __('Please select a date'),
            'date.date_format' => __('Please select a valid date'),
            'date.after_or_equal' => __('Please select a valid date'),
            'time.required' => __('Please select a time'),
            'time.date_format' => __('Please select a valid time'),
        ];
    }

    public function reschedule(): Appointment
    {
        $this->validate();

        $this->appointment->update([
            'date' => CarbonImmutable::createFromFormat('Y-m-d H:i', "{$this->date} {$this->time}"),
        ]);

        return $this->appointment;
    }
}
