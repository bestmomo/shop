<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};
use App\Models\State;
use Mary\Traits\Toast;
use App\Traits\ManageState;

new 
#[Title('State creation')] 
#[Layout('components.layouts.admin')] 
class extends Component
{
    use Toast, ManageState;
    
    public State $state;

    public function save(): void
    {
        $data = $this->validateStateData();

        State::create($data);

        $this->success(__('State created successfully.'), redirectTo: '/admin/states');
    }
   
}; ?>

<div>
    <x-header title="{!! __('Order status') !!}" separator progress-indicator >
        <x-slot:actions>
            <x-button 
                icon="s-building-office-2" 
                label="{{ __('Dashboard') }}" 
                class="btn-outline lg:hidden" 
                link="{{ route('admin') }}" 
            />
        </x-slot:actions>
    </x-header>
    <x-card title="{!! __('Create a new state') !!}">
        @include('livewire.admin.parameters.states.form')
    </x-card>
</div>
