<?php

use App\Livewire\Forms\ServiceForm;
use App\Models\Service;
use Flux\Flux;
use Livewire\Component;

new class extends Component {
    public Service $service;
    public ServiceForm $form;

    public function mount(): void
    {
        $this->form->setService($this->service);
    }

    public function modify(): void
    {
        // TODO: Add a "Generate average" button that would fill out the duration and price fields based on every barber that offers that service
        $this->form->modify();
        Flux::modal("modify-{$this->service->id}")->close();
    }

    public function delete(): void
    {
        $this->service->delete();
        Flux::modal("delete-{$this->service->id}")->close();
    }
};
?>

<flux:table.row>
    <flux:table.cell>
        {{ __($this->service->name) }}
    </flux:table.cell>
    <flux:table.cell>
        {{ $this->service->duration_minutes }} m
    </flux:table.cell>
    <flux:table.cell variant="strong">
        {{ $this->service->price }}
    </flux:table.cell>
    <flux:table.cell>
        {{ $this->service->currency }}
    </flux:table.cell>
    <flux:table.cell>
        <flux:modal.trigger name="show-{{ $this->service->id }}">
            <flux:button>
                {{ __('Show') }}
            </flux:button>
        </flux:modal.trigger>

        <flux:modal.trigger name="modify-{{ $this->service->id }}">
            <flux:button variant="primary" color="blue">
                {{ __('Modify') }}
            </flux:button>
        </flux:modal.trigger>

        <flux:modal.trigger name="delete-{{ $this->service->id }}">
            <flux:button variant="primary" color="red">
                {{ __('Delete') }}
            </flux:button>
        </flux:modal.trigger>

        <flux:modal name="show-{{ $this->service->id }}" class="md:w-4xl">
            <div class="relative mb-6 w-full">
                <flux:heading size="lg">
                    {{ __($this->service->name) }}
                </flux:heading>
                <flux:subheading>
                    {{ __('A list of every barber that offers this service') }}
                </flux:subheading>

                <flux:separator variant="subtle" />
            </div>

            <x-offering-table :rows="$this->service->barbers->map(
                fn($barber) => [
                    'name' => $barber->name,
                    'duration' => $this->service->duration_minutes,
                    'price' => $this->service->price,
                    'currency' => $this->service->currency,
                ],
            )" />

            <div class="flex justify-end gap-2">
                <flux:modal.close>
                    <flux:button>{{ __('Cancel') }}</flux:button>
                </flux:modal.close>
            </div>
        </flux:modal>

        <flux:modal name="modify-{{ $this->service->id }}" class="md:w-96">
            <form wire:submit="modify" class="space-y-6">
                <flux:heading size="lg">
                    {{ __($this->service->name) }}
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

        <flux:modal name="delete-{{ $this->service->id }}" class="md:w-4xl">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg"> {{ __('Delete service') }} </flux:heading>
                    <flux:text class="mt-2">
                        {{ __('Are you sure you want to delete this service?') }}
                    </flux:text>
                </div>

                <flux:card>
                    <flux:heading size="lg"> {{ $this->service->name }} </flux:heading>

                    <flux:card.body>
                        <flux:subheading>
                            {{ __('Barbers that offer this service:') }}
                        </flux:subheading>
                        <x-offering-table :rows="$this->service->barbers->map(
                            fn($barber) => [
                                'name' => $barber->name,
                                'duration' => $this->service->duration_minutes,
                                'price' => $this->service->price,
                                'currency' => $this->service->currency,
                            ],
                        )" />
                    </flux:card.body>
                </flux:card>

                <div class="flex">
                    <flux:spacer />

                    <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                        <flux:modal.close>
                            <flux:button variant="ghost"> {{ __('Cancel') }} </flux:button>
                        </flux:modal.close>
                        <flux:button variant="danger" wire:click="delete">
                            {{ __('Delete') }}
                        </flux:button>
                    </div>
                </div>
            </div>
        </flux:modal>
    </flux:table.cell>
</flux:table.row>
