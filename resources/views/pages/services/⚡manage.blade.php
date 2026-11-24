<?php

use App\Livewire\Forms\ServiceForm;
use App\Models\Service;
use Flux\Flux;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    public ServiceForm $form;

    #[Computed]
    public function services(): Collection
    {
        return Service::orderBy('name')
            ->with(['barbers'])
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
        'heading' => 'Manage services',
        'subheading' =>
            'Here you can manage what services your barbers can offer and add new ones. The duration is your estimate and the price is the minimum value the barbers must offer each service. If a barber doesn\'t choose an estimate or a price these values will be applied',
    ])

    <flux:modal.trigger name="create">
        <flux:button variant="primary" color="green">
            {{ __('Add new service') }}
        </flux:button>
    </flux:modal.trigger>

    <flux:table>
        <flux:table.columns>
            <flux:table.column> {{ __('Name') }} </flux:table.column>
            <flux:table.column> {{ __('Duration') }} </flux:table.column>
            <flux:table.column> {{ __('Price') }} </flux:table.column>
            <flux:table.column> {{ __('Currency') }} </flux:table.column>
            <flux:table.column> {{ __('Actions') }} </flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @foreach ($this->services as $service)
                <livewire:services.row :service="$service" :key="$service->id" />
            @endforeach
        </flux:table.rows>
    </flux:table>

    <flux:modal name="create" class="md:w-4xl">
        <form wire:submit="create" class="space-y-6">
            <flux:heading size="lg">
                {{ __('Add new service') }}
            </flux:heading>

            <flux:input wire:model="form.name" type="input" :label="__('Name')" />

            <flux:input wire:model="form.durationMinutes" type="number" :label="__('Duration (minutes)')" />

            <flux:input wire:model="form.price" type="number" :label="__('Price')" />
            <flux:input wire:model="form.currency" disabled variant="filled" :label="__('Currency')" />

            <div class="flex justify-end gap-2">
                <flux:modal.close>
                    <flux:button>{{ __('Cancel') }}</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
            </div>
        </form>
    </flux:modal>
</section>
