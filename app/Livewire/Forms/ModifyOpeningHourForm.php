<?php

namespace App\Livewire\Forms;

use App\Models\OpeningHour;
use Carbon\Carbon;
use Livewire\Form;

class ModifyOpeningHourForm extends Form
{
    public OpeningHour $openingHour;

    public string $opening = '';

    public string $closing = '';

    public bool $closed = false;

    public function setOpeningHour(OpeningHour $openingHour): void
    {
        $this->openingHour = $openingHour;
        $this->opening = $openingHour->opens_at ? Carbon::parse($openingHour->opens_at)->format('H:i') : '';
        $this->closing = $openingHour->closes_at ? Carbon::parse($openingHour->closes_at)->format('H:i') : '';
        $this->closed = $openingHour->is_closed;
    }

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'opening' => ['bail', 'required', 'date_format:H:i'],
            'closing' => ['bail', 'required', 'date_format:H:i'],
            'closed' => ['required', 'boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function messages(): array
    {
        return [
            'opening.required' => __('Please select a time'),
            'opening.date_format' => __('Please select a valid time'),
            'closing.required' => __('Please select a time'),
            'closing.date_format' => __('Please select a valid time'),
        ];
    }

    public function modify(): void
    {
        $this->validate();

        $this->openingHour->update([
            'opens_at' => $this->opening === '' ? null : $this->opening,
            'closes_at' => $this->closing === '' ? null : $this->closing,
            'is_closed' => $this->closed,
        ]);
    }
}
