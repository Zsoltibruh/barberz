<?php

use App\Enums\Role;
use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    #[Computed]
    public function barbers()
    {
        return User::role(Role::Barber)->orderBy('last_name', 'asc')->get();
    }
};
?>

<section>
    <div class="relative mb-6 w-full">
        <flux:heading level="1" size="2xl">
            {{ __('Barbers') }}
        </flux:heading>
        <flux:separator variant="subtle" />
    </div>

    <div class="w-full flex flex-wrap gap-4">
        @foreach ($this->barbers as $barber)
            <x:barber-summary :barber="$barber" />
        @endforeach
    </div>
</section>
