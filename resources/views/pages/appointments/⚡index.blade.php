<?php

use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    #[Computed]
    public function appointments()
    {
        return auth()
            ->user()
            ->appointments()
            ->with(['barber', 'customer', 'service'])
            ->orderBy('date', 'desc')
            ->get();
    }
};
?>

<section class="w-full flex flex-col gap-2">
    <h1 class="text-3xl font-bold"> {{ __('Appointments') }} </h1>

    @foreach ($this->appointments as $appointment)
        <livewire:appointments.card :appointment="$appointment" :key="$appointment->id" />
    @endforeach
</section>
