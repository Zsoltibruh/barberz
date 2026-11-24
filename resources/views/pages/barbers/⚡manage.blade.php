<?php

use App\Enums\Role;
use App\Livewire\Forms\BarberForm;
use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    public BarberForm $form;

    #[Computed]
    public function barbers(): Collection
    {
        return User::role(Role::Barber)
            ->with(['workingHours', 'barberServices'])
            ->orderBy('last_name')
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
        'heading' => 'Manage barbers',
        'subheading' => 'Here you can manage your employed barbers and hire new ones',
    ])

    <flux:modal.trigger name="create">
        <flux:button variant="primary" color="green">
            {{ __('Hire new barber') }}
        </flux:button>
    </flux:modal.trigger>

    <flux:table>
        <flux:table.columns>
            <flux:table.column> {{ __('Name') }} </flux:table.column>
            <flux:table.column> {{ __('Email') }} </flux:table.column>
            <flux:table.column> {{ __('Phone') }} </flux:table.column>
            <flux:table.column> {{ __('Actions') }} </flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @forelse ($this->barbers as $barber)
                <livewire:barbers.row :barber="$barber" :key="$barber->id" />
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
                {{ __('Hire new barber') }}
            </flux:heading>

            <flux:input wire:model="form.firstName" :label="__('First name')" />
            <flux:input wire:model="form.lastName" :label="__('Last name')" />

            <flux:input wire:model="form.email" type="email" :label="__('Email')" />
            <flux:input wire:model="form.phone" :label="__('Phone')" />

            <div class="flex justify-end gap-2">
                <flux:modal.close>
                    <flux:button>{{ __('Cancel') }}</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
            </div>
        </form>
    </flux:modal>
</section>
