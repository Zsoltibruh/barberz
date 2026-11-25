@props(['name', 'class' => 'md:w-96', 'heading', 'text', 'click'])

<x-modals.template :name="$name" :class="$class" :heading="$heading" :text="$text">
    {{ $slot }}
    <x-modals.footer>
        <x-buttons.delete :text="$heading" :click="$click" />
    </x-modals.footer>
</x-modals.template>
