@props(['barber'])

<x-modals.template name="modify-{{ $barber->id }}" class="md:w-4xl" :heading="$barber->name" text="Manage this barber">
    Maybe some data here (total working hours in the past month, total money gained, etc.)

    <x-modals.footer>
        <flux:button variant="danger">
            {{ __('Fire') }}
        </flux:button>
        <flux:button variant="primary" color="yellow">
            {{ __('Send on vacation') }}
        </flux:button>
    </x-modals.footer>
</x-modals.template>
