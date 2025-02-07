<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};
use App\Models\Shop;
use Mary\Traits\Toast;

new 
#[Title('Store')] 
#[Layout('components.layouts.admin')] 
class extends Component
{
    use Toast;
    
    public Shop $shop;
    public string $name;
    public string $address;
    public string $email;
    public string $phone;
    public string $facebook;
    public string $holder;
    public string $bank;
    public string $bank_address;
    public string $bic;
    public string $iban;
    public string $home;
    public string $home_infos;
    public string $home_shipping;
    public bool $invoice;
    public bool $billing;
    public bool $card;
    public bool $transfer;
    public bool $check;
    public bool $mandat;

    public function mount(): void
    {
        $this->shop = Shop::firstOrFail();

        $this->fill($this->shop);
    }

    public function save(): void
    {
        $data = $this->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'holder' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'bic' => 'required|regex:/^[a-z]{6}[0-9a-z]{2}([0-9a-z]{3})?\z/i',
            'iban' => 'required|regex:/^[a-zA-Z]{2}[0-9]{2}[a-zA-Z0-9]{4,}$/',
            'bank' => 'required|string|max:255',
            'bank_address' => 'required|string|max:255',
            'phone' => 'required|regex:/^[+]?[(]?[0-9]{3}[)]?[-\s.]?[0-9]{3}[-\s.]?[0-9]{4,6}$/|max:25',
            'facebook' => 'required|url|regex:/^(https?:\/\/)?(www\.)?facebook\.com\/.+/i|max:255',
            'home' => 'required|string|max:16777215',
            'home_infos' => 'required|string|max:16777215',
            'home_shipping'=> 'required|string|max:16777215',
            'invoice' => 'required|boolean',
            'card' => 'required|boolean',
            'transfer' => 'required|boolean',
            'check' => 'required|boolean',
            'mandat' => 'required|boolean',
        ]);

        $this->shop->update($data);

        $this->success(__('Store updated with success.'));
    }
    
}; ?>

<div>
    <x-header title="{{ __('Store') }}" separator progress-indicator>
        <x-slot:actions>
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline lg:hidden"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>
    <x-card shadow separator progress-indicator >
        <x-form wire:submit="save">
            <x-card title="{{ __('Identity') }}" shadow separator >
                <div class="space-y-2">
                    <x-input label="{{ __('Name') }}" wire:model="name" required />
                    <x-input label="{{ __('Address') }}" wire:model="address" required />
                    <x-input label="{{ __('Email') }}" wire:model="email" required />
                    <x-input label="{{ __('Phone') }}" wire:model="phone" required />
                    <x-input label="{{ __('Facebook') }}" wire:model="facebook" required />
                </div>
            </x-card>
            <x-card title="{{ __('Bank') }}" shadow separator >
                <div class="space-y-2">
                    <x-input label="{{ __('Holder') }}" wire:model="holder" required />
                    <x-input label="{{ __('Name') }}" wire:model="bank" required />
                    <x-input label="{{ __('Address') }}" wire:model="bank_address" required />
                    <x-input label="{{ __('BIC') }}" wire:model="bic" required />
                    <x-input label="{{ __('IBAN') }}" wire:model="iban" required />
                </div>
            </x-card>
            <x-card title="{{ __('Home') }}" shadow separator >
                <div class="space-y-2">
                    <x-editor wire:model="home" label="{{ __('Title') }}" :config="config('tinymce.config')" folder="photos" />
                    <x-editor wire:model="home_infos" label="{{ __('General informations') }}" :config="config('tinymce.config')" folder="photos" />
                    <x-editor wire:model="home_shipping" label="{{ __('Shipping costs') }}" :config="config('tinymce.config')" folder="photos" />
                </div>
            </x-card>
            <x-card title="{{ __('Billing') }}" shadow separator >
                <x-checkbox label="{{ __('Activation of billing') }}" wire:model="invoice" />
            </x-card>
            <x-card title="{{ __('Accepted payment methods') }}" shadow separator >
                <div class="space-y-4">
                    <x-checkbox label="{{ __('Credit card') }}" wire:model="card" />
                    <x-checkbox label="{{ __('Bank transfer') }}" wire:model="transfer" />
                    <x-checkbox label="{{ __('Check') }}" wire:model="check" />
                    <x-checkbox label="{{ __('Administrative mandate') }}" wire:model="mandat" />
                </div>
            </x-card>

            <x-slot:actions>
                <x-button 
                    label="{{ __('Save') }}" 
                    icon="o-paper-airplane" 
                    spinner="save" 
                    type="submit"
                    class="btn-primary" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>
