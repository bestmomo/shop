<x-form wire:submit="save">
    <x-input 
        label="{{ __('Name') }}" 
        wire:model="name" 
        required 
        placeholder="{{ __('Enter name') }}" 
    />

    <x-input 
        type="text" 
        wire:model="tax" 
        label="{{ __('VAT') }}" 
        required 
        placeholder="{{ __('Enter VAT (e.g., 0.2)') }}" 
    />

    <x-slot:actions>
        <x-button 
            label="{{ __('Save') }}" 
            icon="o-paper-airplane" 
            spinner="save" 
            type="submit" 
            class="btn-primary" 
        />
    </x-slot:actions>
</x-form>
