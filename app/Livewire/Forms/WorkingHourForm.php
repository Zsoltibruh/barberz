<?php

namespace App\Livewire\Forms;

use App\Models\WorkingHour;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Form;

class WorkingHourForm extends Form
{
    public ?WorkingHour $workingHour = null;

    public string $weekday = '';

    public string $start = '';

    public string $end = '';

    public function setWorkingHour(WorkingHour $workingHour): void
    {
        $this->workingHour = $workingHour;
        $this->weekday = $workingHour->weekday;
        $this->start = $workingHour->start_time;
        $this->end = $workingHour->end_time;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'weekday' => ['required', 'string', Rule::unique(WorkingHour::class, 'weekday')
                ->where('barber_id', Auth::user()->id)
                ->ignore($this->workingHour?->id)],
            'start' => ['required', 'date_format:H:i'],
            'end' => ['required', 'date_format:H:i'],
        ];
    }

    public function create(): WorkingHour
    {
        $this->validate();

        return WorkingHour::create([
            'weekday' => $this->weekday,
            'start_time' => $this->start,
            'end_time' => $this->end,
            'barber_id' => Auth::user()->id,
        ]);
    }

    public function modify(): void
    {
        $this->validate();

        $this->workingHour->update([
            'start_time' => $this->start,
            'end_time' => $this->end,
        ]);
    }
}
