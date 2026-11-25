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

    <x-services.create-modal />
</section>
