@props(['name', 'class' => 'md:w-96', 'heading', 'text'])

<flux:modal :name="$name" :class="$class">
    <div class="space-y-6">
        <x-modals.header :heading="$heading" :text="$text" />

        {{ $slot }}
    </div>
</flux:modal>
