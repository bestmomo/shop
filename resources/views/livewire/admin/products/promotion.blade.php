<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};
use App\Models\Setting;
use Mary\Traits\Toast;
use Carbon\Carbon;

new #[Layout('components.layouts.admin')] #[Title('Global promotion')] class extends Component {

    use Toast;

    public bool $promotion = false;
    public ?int $promotion_percentage = null;
    public ?string $promotion_start_date = null;
    public ?string $promotion_end_date = null;
    public Setting $setting;

    public function mount(): void
    {
        $this->setting = Setting::where('key', 'promotion')->firstOrCreate(['key' => 'promotion']);
        $this->promotion = !is_null($this->setting->value);
        if($this->promotion){
            $this->promotion_percentage = $this->setting->value;
            $this->promotion_start_date = $this->setting->date1->format('Y-m-d');
            $this->promotion_end_date = $this->setting->date2->format('Y-m-d');
        }
    }

    public function save(): void
    {
        $data = $this->validate(
            [
                'promotion_percentage' => 'required_if:promotion,true|nullable|numeric|min:0|max:100',
                'promotion_start_date' => 'required_if:promotion,true|nullable|date',
                'promotion_end_date' => 'required_if:promotion,true|nullable|date|after:promotion_start_date',
            ]
        );

        $data = [
            'value' => $this->promotion ? $this->promotion_percentage : null,
            'date1' => $this->promotion ? $this->promotion_start_date : null,
            'date2' => $this->promotion ? $this->promotion_end_date : null,
        ];

        $this->setting->update($data);

        $this->success(__('Promotion updated successfully.'), redirectTo: '/admin/dashboard');
    }
    
}; ?>

<div>
    <x-header title="{!! __('Global promotion') !!}" separator progress-indicator >
        <x-slot:actions>
            <x-button 
                icon="s-building-office-2" 
                label="{{ __('Dashboard') }}" 
                class="btn-outline lg:hidden" 
                link="{{ route('admin') }}" 
            />
        </x-slot:actions>
    </x-header>
    <x-card >
        <x-form wire:submit="save">
            <x-checkbox label="{{ __('Active promotion') }}" wire:model="promotion" wire:change="$refresh" />
        
            @if($promotion)
                <x-input 
                    label="{{ __('Percentage discount') }}" 
                    wire:model="promotion_percentage" 
                    placeholder="{{ __('Enter discount percentage') }}"
                    type="number"
                />
        
                <x-datetime  
                    label="{{ __('Start date') }}" 
                    icon="o-calendar"
                    wire:model="promotion_start_date" 
                />
        
                <x-datetime  
                    label="{{ __('End date') }}" 
                    icon="o-calendar"
                    wire:model="promotion_end_date"
                />                
            @endif

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
    </x-card>
</div>
