<?php

use App\Models\OpeningHour;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    #[Computed]
    public function openingHours()
    {
        return OpeningHour::orderBy('id')->get();
    }
};
?>

<section>
    <div class="relative mb-6 w-full">
        <flux:heading level="1" size="2xl">
            {{ __('Opening hours') }}
        </flux:heading>
        <flux:separator variant="subtle" />
    </div>

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
