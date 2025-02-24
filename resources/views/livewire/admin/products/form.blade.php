<x-form wire:submit="save">
    <x-input
        label="{{ __('Name') }}"
        wire:model="name"
        required
        placeholder="{!! __('Enter product name') !!}"
    />

    <x-textarea
        label="{{ __('Description') }}"
        wire:model="description"
        placeholder="{!! __('Enter product description') !!}"
        rows="5"
        required
    />

    <x-input
        label="{{ __('Weight in kg') }}"
        wire:model="weight"
        required
        placeholder="{{ __('Enter product weight') }}"
    />

    <x-input
        label="{{ __('Price') }}"
        wire:model="price"
        required
        placeholder="{{ __('Enter product price') }}"
    />

    <x-input
        label="{{ __('Quantity available') }}"
        wire:model="quantity"
        type="number"
        required
        placeholder="{{ __('Enter product quantity') }}"
    />

    <x-input
        label="{{ __('Quantity for stock alert') }}"
        wire:model="quantity_alert"
        type="number"
        required
        placeholder="{{ __('Enter product quantity') }}"
    />

    <x-checkbox label="{{ __('Active product') }}" wire:model="active" />

    <div class="text-red-500">
        <x-checkbox label="{{ __('Promotion') }}" wire:model="promotion" wire:change="$refresh" />
    </div>

    @if($promotion)
        <x-input
            label="{{ __('Promotion price') }}"
            wire:model="promotion_price"
            placeholder="{{ __('Enter product promotion price') }}"
        />

        <x-datetime
            label="{{ __('Promotion start date') }}"
            icon="o-calendar"
            wire:model="promotion_start_date"
            type="date"
        />

        <x-datetime
            label="{{ __('Promotion end date') }}"
            icon="o-calendar"
            wire:model="promotion_end_date"
            type="date"
        />
    @endif

    <x-hr separator progress-indicator />

    <x-file
        wire:model="image"
        label="{{ __('Image') }}"
        hint="{!! __('Click on this image to modify it') !!}"
        accept="image/png, image/jpeg">
        <img src="{{ $image == '' ? asset('storage/ask.jpg') : asset('storage/photos/' . $image) }}" class="h-40" />
    </x-file>

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
