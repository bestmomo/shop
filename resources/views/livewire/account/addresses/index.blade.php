<?php

use App\Models\Address;
use Livewire\Volt\Component;
use Illuminate\Support\Collection;
use Livewire\Attributes\Title;

new #[Title('Addresses')]
class extends Component {

    public function deleteAddress(Address $address): void
    {
        $address->delete();
    }

    public function with(): array
    {
        return [
            'addresses' => Auth::user()->addresses()->with('country')->get(),
        ];
    }
    
}; ?>

<x-card class="flex justify-center items-center mt-6" title="{{ __('My addresses') }}" shadow separator >
    <div class="container mx-auto">
        <div class="grid gap-6 md:grid-cols-2">
            @foreach ($addresses as $address)
                <x-card
                    class="w-full shadow-md transition duration-500 ease-in-out shadow-gray-500 hover:shadow-xl hover:shadow-gray-500"
                    title="">
                    <x-address :address="$address" />
                    <hr>
                    <x-slot:actions>
                        <x-popover>
                            <x-slot:trigger>
                                <x-button 
                                    icon="s-arrow-path" 
                                    link="{{ route('addresses.edit', $address) }}"
                                    spinner 
                                    class="text-blue-500 btn-ghost btn-circle btn-sm" 
                                />
                            </x-slot:trigger>
                            <x-slot:content class="pop-small">
                                @lang('Update')
                            </x-slot:content>
                        </x-popover>
                        <x-popover>
                            <x-slot:trigger>
                                <x-button 
                                    icon="o-trash" 
                                    wire:click="deleteAddress({{ $address->id }})" 
                                    wire:confirm="{{ __('Are you sure to delete this address?') }}" 
                                    spinner 
                                    class="text-red-500 btn-ghost btn-circle btn-sm" 
                                />
                            </x-slot:trigger>
                            <x-slot:content class="pop-small">
                                @lang('Delete')
                            </x-slot:content>
                        </x-popover>
                    </x-slot:actions>
                </x-card>
            @endforeach
        </div>
    </div>
    <x-slot:actions>
        <x-button label="{{ __('Create a new address') }}" link="{{ route('addresses.create') }}" class="btn-primary" />
    </x-slot:actions>
</x-card>