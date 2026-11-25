@props(['workingHour'])

<x-modals.confirm name="delete-{{ $workingHour->id }}" class="md:w-4xl" heading="Delete working hour"
    text="Are you sure you want to delete this workingHour?" click="delete">
    <flux:heading size="lg">
        {{ __($workingHour->weekday) }}
    </flux:heading>
</x-modals.confirm>
