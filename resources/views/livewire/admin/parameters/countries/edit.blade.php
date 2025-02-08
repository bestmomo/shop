<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};
use App\Models\{ Country, Range };
use Mary\Traits\Toast;

new #[Title('Dashboard')] #[Layout('components.layouts.admin')] class extends Component
{
    use Toast;
    
    public Country $country;
    public string $name;
    public string $tax;

    public function mount(Country $country): void
    {
        $this->country = $country;
        $this->fill($this->country);
    }

    public function save(): void
    {
        $data = $this->validate([
            'name' => 'required|string|max:100',
            'tax' => 'required|numeric|between:0,0.4',
        ]);

        $this->country->update($data);

        $this->success(__('Country updated successfully.'), redirectTo: '/admin/countries');
    }
   
}; ?>

<div>
    <x-header title="{{ __('Countries') }}" separator progress-indicator>
        <x-slot:actions>
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline lg:hidden"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>
    <x-card title="{!! __('Edit a country') !!}">
        @include('livewire.admin.parameters.countries.form')
    </x-card>
</div>
