<?php

use App\Models\OpeningHour;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    #[Computed]
    public function openingHours(): Collection
    {
        return OpeningHour::orderBy('id')->get();
    }
};
?>

<section>
    @include('partials.general-heading', [
        'heading' => 'Opening hours',
        'subheading' =>
            'Here you can manage when the barbershop opens and closes on each day, barbers can\'t create working hours outside these hours',
    ])

    <flux:table>
        <flux:table.columns>
            <flux:table.column> {{ __('Day') }} </flux:table.column>
            <flux:table.column> {{ __('Opening') }} </flux:table.column>
            <flux:table.column> {{ __('Closing') }} </flux:table.column>
            <flux:table.column> {{ __('Closed') }} </flux:table.column>
            <flux:table.column> {{ __('Actions') }} </flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @foreach ($this->openingHours as $openingHour)
                <livewire:opening-hours.row :openingHour="$openingHour" :key="$openingHour->id" />
            @endforeach
        </flux:table.rows>
    </flux:table>
</section>
