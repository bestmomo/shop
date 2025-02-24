<?php
use App\Models\Setting;
use Livewire\Volt\Component;

new class extends Component {
    public $promotion;

    public function mount()
    {
        $this->promotion = Setting::where('key', 'promotion')->firstOrCreate(['key' => 'promotion']);
        Debugbar::info('promotion', $this->promotion);
    }

    public function with()
    {
        return [
            'promotion' => $this->promotion,
        ];
    }
}; ?>

<div>
    P R O M O T I O N
    {{-- @if (!is_null($promotion->value))
        <br>
        <x-alert title="{{ __('Global promotion') }} {{ $textPromotion }}"
            description="{{ __('From') }} {{ $promotion->date1->isoFormat('LL') }} {{ __('to') }} {{ $promotion->date2->isoFormat('LL') }} {{ __L('Percentage discount') }} {{ $promotion->value }}%"
            icon="o-currency-euro" class="alert-warning">
            <x-slot:actions>
                <x-button label="{{ __('Edit') }}" class="btn-outline" link="{{ route('admin.products.promotion') }}" />
            </x-slot:actions>
        </x-alert>
    @endIf --}}
</div>
