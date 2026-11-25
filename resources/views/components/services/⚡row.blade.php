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

        <x-services.show-modal :service="$this->service" />
        <x-services.modify-modal :service="$this->service" />
        <x-services.delete-modal :service="$this->service" />
    </flux:table.cell>
</flux:table.row>
