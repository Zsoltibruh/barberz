<?php

use App\Models\User;
use Livewire\Component;

new class extends Component {
    public User $barber;
};
?>

<flux:table.row>
    <flux:table.cell>
        {{ __($this->barber->name) }}
    </flux:table.cell>
    <flux:table.cell>
        {{ $this->barber->email }}
    </flux:table.cell>
    <flux:table.cell>
        {{ $this->barber->phone_number }}
    </flux:table.cell>
    <flux:table.cell>
        <flux:modal.trigger name="services-{{ $this->barber->id }}">
            <flux:button>
                {{ __('Services') }}
            </flux:button>
        </flux:modal.trigger>

        <flux:modal.trigger name="working-hours-{{ $this->barber->id }}">
            <flux:button>
                {{ __('Working hours') }}
            </flux:button>
        </flux:modal.trigger>

        {{-- TODO: Create modify/manage modal where the owner could fire and send on vacation.
        <flux:modal.trigger name="modify-{{ $this->barber->id }}">
            <flux:button variant="primary" color="blue">
                {{ __('Modify') }}
            </flux:button>
        </flux:modal.trigger> --}}

        <flux:modal name="services-{{ $this->barber->id }}" class="md:w-4xl">
            <div class="relative mb-6 w-full">
                <flux:heading size="lg">
                    {{ __($this->barber->name) }}
                </flux:heading>
                <flux:subheading>
                    {{ __('A list of every barber that offers this barber') }}
                </flux:subheading>

                <flux:separator variant="subtle" />
            </div>

            <x-offering-table :rows="$this->barber->barberServices->map(
                fn($service) => [
                    'name' => $service->name,
                    'duration' => $service->duration_minutes,
                    'price' => $service->price,
                    'currency' => $service->currency,
                ],
            )" />

            <div class="flex justify-end gap-2">
                <flux:modal.close>
                    <flux:button>{{ __('Cancel') }}</flux:button>
                </flux:modal.close>
            </div>
        </flux:modal>

        <flux:modal name="working-hours-{{ $this->barber->id }}" class="md:w-4xl">
            <div class="relative mb-6 w-full">
                <flux:heading size="lg">
                    {{ __($this->barber->name) }}
                </flux:heading>
                <flux:subheading>
                    {{ __('The barbers working hours') }}
                </flux:subheading>

                <flux:separator variant="subtle" />
            </div>

            <flux:table>
                <flux:table.columns>
                    <flux:table.column> {{ __('Weekday') }} </flux:table.column>
                    <flux:table.column> {{ __('Start') }} </flux:table.column>
                    <flux:table.column> {{ __('End') }} </flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @forelse ($this->barber->workingHours as $workingHour)
                        <flux:table.row>
                            <flux:table.cell> {{ __($workingHour->weekday) }} </flux:table.cell>
                            <flux:table.cell> {{ $workingHour->start_time }} </flux:table.cell>
                            <flux:table.cell> {{ $workingHour->end_time }} </flux:table.cell>
                        </flux:table.row>
                    @empty
                        <flux:table.row>
                            <flux:table.cell colspan="4">{{ __('Nothing to show yet.') }}</flux:table.cell>
                        </flux:table.row>
                    @endforelse
                </flux:table.rows>
            </flux:table>

            <div class="flex justify-end gap-2">
                <flux:modal.close>
                    <flux:button>{{ __('Cancel') }}</flux:button>
                </flux:modal.close>
            </div>
        </flux:modal>

        <flux:modal name="modify-{{ $this->barber->id }}" class="md:w-96">
            <flux:heading size="lg">
                {{ __($this->barber->name) }}
            </flux:heading>

            <div class="flex justify-end gap-2">
                <flux:modal.close>
                    <flux:button>{{ __('Cancel') }}</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
            </div>
        </flux:modal>
    </flux:table.cell>
</flux:table.row>
