<x-form wire:submit="save">
    <x-input 
        label="{{ __('Name') }}" 
        wire:model="name" 
        required 
        placeholder="{!! __('Enter state name') !!}" 
    />
    
    <x-input 
        label="{{ __('Slug') }}" 
        wire:model="slug" 
        required 
        placeholder="{{ __('Enter unique slug') }}" 
    />

    <x-input 
        type="number" 
        label="{{ __('Indice') }}" 
        wire:model="indice" 
        required 
    />
    
    <x-select 
        label="{{ __('Color') }}" 
        wire:model="color" 
        :options="$colors" 
        required 
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
