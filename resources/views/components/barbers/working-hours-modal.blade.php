@props(['barber'])

<x-modals.template name="working-hours-{{ $barber->id }}" class="md:w-4xl" heading="Working hours"
    text="The barbers working hours">
    <flux:table>
        <flux:table.columns>
            <flux:table.column> {{ __('Weekday') }} </flux:table.column>
            <flux:table.column> {{ __('Start') }} </flux:table.column>
            <flux:table.column> {{ __('End') }} </flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @forelse ($barber->workingHours as $workingHour)
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

    <x-modals.footer />
</x-modals.template>
