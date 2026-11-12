<?php

use App\Enums\AppointmentStatus;
use App\Enums\Role;
use App\Models\Service;
use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;

new class extends Component {
    #[Url]
    public string $search = '';

    #[Url]
    public string $status = AppointmentStatus::Confirmed->value;

    #[Url]
    public string $service = '';

    #[Computed]
    public function appointments()
    {
        // TODO: Filter dates: from and to inputs
        return auth()
            ->user()
            ->appointments()
            ->with(['barber', 'customer', 'service'])
            ->when($this->search, function ($query) {
                $ids = User::search($this->search)->keys();
                auth()->user()->hasRole(Role::Barber) ? $query->whereIn('customer_id', $ids) : $query->whereIn('barber_id', $ids);
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->when($this->service, function ($query) {
                $query->whereHas('service', function ($query) {
                    $query->where('name', $this->service);
                });
            })
            ->orderBy('date', 'desc')
            ->paginate(config('app.pagination'));
    }

    #[Computed]
    public function services()
    {
        return Service::whereHas('barbers')->get();
    }
};
?>

<section class="w-full flex flex-col gap-2">
    <h1 class="text-3xl font-bold"> {{ __('Appointments') }} </h1>

    <x:search target="barbers">
        <flux:select wire:model.live="status" :placeholder="__('Choose status...')">
            <flux:select.option value="">{{ __('Every status') }}</flux:select.option>
            @foreach (AppointmentStatus::cases() as $status)
                <flux:select.option :value="$status"> {{ $status->label() }} </flux:select.option>
            @endforeach
        </flux:select>

        <flux:select wire:model.live="service" :placeholder="__('Choose service...')">
            <flux:select.option value="">{{ __('Any service') }}</flux:select.option>
            @foreach ($this->services as $service)
                <flux:select.option> {{ $service->name }} </flux:select.option>
            @endforeach
        </flux:select>
    </x:search>

    @foreach ($this->appointments as $appointment)
        <livewire:appointments.card :appointment="$appointment" :key="$appointment->id" />
    @endforeach

    {{ $this->appointments->links() }}
</section>
