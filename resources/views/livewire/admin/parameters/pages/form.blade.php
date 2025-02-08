<x-form wire:submit="save">
    <x-input 
        label="{{ __('Title') }}" 
        wire:model.live.lazy="title" 
        required 
        placeholder="{!! __('Enter page title') !!}" 
    />
    
    <x-input 
        label="{{ __('Slug') }}" 
        wire:model="slug" 
        required 
        placeholder="{{ __('Enter unique slug') }}" 
    />

    <x-editor 
        wire:model="text" 
        label="{{ __('Text') }}" 
        :config="config('tinymce.config_page')" 
        folder="photos" 
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
