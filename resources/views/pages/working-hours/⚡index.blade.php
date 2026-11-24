<?php

use App\Livewire\Forms\WorkingHourForm;
use App\Models\WorkingHour;
use Flux\Flux;
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
        Flux::modal('create')->close();
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

    <flux:modal name="create" class="md:w-4xl">
        <form wire:submit="create" class="space-y-6">
            <flux:heading size="lg">
                {{ __('Add new working hour') }}
            </flux:heading>

            <flux:select wire:model="form.weekday" :placeholder="__('Weekday')">
                <flux:select.option> {{ __('monday') }} </flux:select.option>
                <flux:select.option> {{ __('tuesday') }} </flux:select.option>
                <flux:select.option> {{ __('wednesday') }} </flux:select.option>
                <flux:select.option> {{ __('thursday') }} </flux:select.option>
                <flux:select.option> {{ __('friday') }} </flux:select.option>
            </flux:select>

            <flux:input wire:model="form.start" type="time" :label="__('Start')" />
            <flux:input wire:model="form.end" type="time" :label="__('End')" />

            <div class="flex justify-end gap-2">
                <flux:modal.close>
                    <flux:button>{{ __('Cancel') }}</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
            </div>
        </form>
    </flux:modal>
</section>
