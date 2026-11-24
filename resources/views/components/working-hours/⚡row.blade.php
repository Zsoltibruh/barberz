<?php

use App\Livewire\Forms\WorkingHourForm;
use App\Models\WorkingHour;
use Flux\Flux;
use Livewire\Component;

new class extends Component {
    public WorkingHour $workingHour;
    public WorkingHourForm $form;

    public function mount(): void
    {
        $this->form->setWorkingHour($this->workingHour);
    }

    public function modify(): void
    {
        $this->form->modify();
        Flux::modal("modify-{$this->workingHour->id}")->close();
    }

    public function delete(): void
    {
        $this->workingHour->delete();
        Flux::modal("delete-{$this->workingHour->id}")->close();
    }
};
?>

<flux:table.row>
    <flux:table.cell>
        {{ __($this->workingHour->weekday) }}
    </flux:table.cell>
    <flux:table.cell>
        {{ $this->workingHour->start_time }}
    </flux:table.cell>
    <flux:table.cell>
        {{ $this->workingHour->end_time }}
    </flux:table.cell>
    <flux:table.cell>
        <flux:modal.trigger name="modify-{{ $this->workingHour->id }}">
            <flux:button variant="primary" color="blue">
                {{ __('Modify') }}
            </flux:button>
        </flux:modal.trigger>

        <flux:modal.trigger name="delete-{{ $this->workingHour->id }}">
            <flux:button variant="primary" color="red">
                {{ __('Delete') }}
            </flux:button>
        </flux:modal.trigger>

        <flux:modal name="modify-{{ $this->workingHour->id }}" class="md:w-96">
            <form wire:submit="modify" class="space-y-6">
                <flux:heading size="lg">
                    {{ __($this->workingHour->weekday) }}
                </flux:heading>

                <flux:input wire:model="form.start" type="time" format="H:i" :label="__('Start')" />
                <flux:input wire:model="form.end" type="time" format="H:i" :label="__('End')" />

                <div class="flex justify-end gap-2">
                    <flux:modal.close>
                        <flux:button>{{ __('Cancel') }}</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
                </div>
            </form>
        </flux:modal>

        <flux:modal name="delete-{{ $this->workingHour->id }}" class="md:w-4xl">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg"> {{ __('Delete working hour') }} </flux:heading>
                    <flux:text class="mt-2">
                        {{ __('Are you sure you want to delete this workingHour?') }}
                    </flux:text>
                </div>

                <flux:card>
                    <flux:heading size="lg"> {{ $this->workingHour->weekday }} </flux:heading>

                    <div class="flex">
                        <flux:spacer />

                        <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                            <flux:modal.close>
                                <flux:button variant="ghost"> {{ __('Cancel') }} </flux:button>
                            </flux:modal.close>
                            <flux:button variant="danger" wire:click="delete">
                                {{ __('Delete') }}
                            </flux:button>
                        </div>
                    </div>
            </div>
        </flux:modal>
    </flux:table.cell>
</flux:table.row>
