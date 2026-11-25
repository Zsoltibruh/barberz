<?php

use App\Livewire\Forms\WorkingHourForm;
use App\Models\WorkingHour;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    public WorkingHourForm $form;

    #[Computed]
    public function workingHours(): Collection
    {
        $user = Auth::user();
        return WorkingHour::where(['barber_id' => $user->id])
            ->orderBy('id')
            ->get();
    }

    public function create(): void
    {
        $this->form->create();
        $this->modal('create')->close();
    }
};
?>

<section>
    @include('partials.general-heading', [
        'heading' => 'Manage working hours',
        'subheading' => 'Here you can manage on which days you work from start to end',
    ])

    <flux:modal.trigger name="create">
        <flux:button variant="primary" color="green">
            {{ __('Add new working hour') }}
        </flux:button>
    </flux:modal.trigger>
    <flux:table>
        <flux:table.columns>
            <flux:table.column> {{ __('Weekday') }} </flux:table.column>
            <flux:table.column> {{ __('Start') }} </flux:table.column>
            <flux:table.column> {{ __('End') }} </flux:table.column>
            <flux:table.column> {{ __('Actions') }} </flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @forelse ($this->workingHours as $workingHour)
                <livewire:working-hours.row :workingHour="$workingHour" :key="$workingHour->id" />
            @empty
                <flux:table.row>
                    <flux:table.cell colspan="4">{{ __('Nothing to show yet.') }}</flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>

    <x-working-hours.create-modal />
</section>
