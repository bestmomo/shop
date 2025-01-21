<x-card class="flex justify-center items-center mt-6" title="{!! $title !!}" shadow separator progress-indicator>
    <x-form wire:submit="save" class="w-full sm:min-w-[50vw]">
        <x-checkbox label="{!! __('It is a professionnal address') !!}" wire:model="professionnal" wire:change="$refresh" />

        <x-radio label="{{ __('Civility') }}" :options="$civilities" wire:model="selectedCivility" :required="!$professionnal" />

        <x-input label="{{ __('Name') }}" type="text" wire:model="name" icon="o-user"
            hint="{{ $professionnal ? __('Optional') : '' }}" :required="!$professionnal" />
        <x-input label="{{ __('FirstName') }}" type="text" wire:model="firstname" icon="o-user"
            hint="{{ $professionnal ? __('Optional') : '' }}" :required="!$professionnal" />
        <x-input label="{{ __('Company name') }}" type="text" wire:model="company" icon="o-building-library"
            :disabled="!$professionnal" :required="$professionnal" />
        <x-input label="{{ __('Street number and name') }}" type="text" wire:model="address" icon="o-home"
            required />
        <x-input label="{{ __('Building') }}" type="text" hint="{{ __('Optional') }}" wire:model="addressbis"
            icon="o-home" />
        <x-input label="{{ __('Place name or PO') }}" type="text" hint="{{ __('Optional') }}" wire:model="bp"
            icon="c-map-pin" />
        <x-input label="{{ __('Postcode') }}" type="text" wire:model="postal" icon="c-map-pin" required />
        <x-input label="{{ __('City') }}" type="text" wire:model="city" icon="c-map-pin" required />
        <x-select label="{{ __('Country') }}" :options="$countries" wire:model="country_id" icon="c-map-pin" required />
        <x-input label="{{ __('Phone number') }}" type="text" wire:model="phone" icon="o-phone" required />
        <p class="text-xs text-gray-500"><span class="text-red-600">*</span> @lang('Required information')</p>
        <x-slot:actions>
            <x-button label="{{ __('Cancel') }}" link="/account/addresses" class="btn-ghost" />
            <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit"
                class="btn-primary" />
        </x-slot:actions>
    </x-form>
</x-card>
<script>
    setTimeout(() => {
        const civ = <?= json_encode($myAddress->civility ?? null) ?>;
        console.log('civ:', civ);
        if (civ) document.querySelector('input[value="' + civ + '"]').click();
    }, 250);
</script>
