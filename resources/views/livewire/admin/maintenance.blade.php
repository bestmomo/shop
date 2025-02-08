<?php

use Illuminate\Support\Facades\Artisan;
use Livewire\Attributes\{Layout, Rule};
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new #[Title('Maintenance')] #[Layout('components.layouts.admin')] class extends Component
{
	use Toast;

	public bool $maintenance = false;

	public function mount(): void
	{
		$this->maintenance = App::isDownForMaintenance();
	}

	public function updatedMaintenance(): void
	{
		if ($this->maintenance)
		{
			Artisan::call('down', ['--secret' => env('APP_MAINTENANCE_SECRET')]);
		}
		else
		{
			Artisan::call('up');
		}
	}
};

?>

<div>
    <x-header title="{{ __('Maintenance mode') }}" separator progress-indicator>
        <x-slot:actions>
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline lg:hidden"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>
	<x-card separator class="mb-6 border-4 {{ $maintenance ? 'bg-red-300' : 'bg-zinc-100' }} border-zinc-950">
		<div class="flex items-center justify-between">
			<x-toggle label="{{ __('Maintenance mode') }}" wire:model="maintenance" wire:change="$refresh" />
			@if($maintenance)
				<x-button label="{{ __('Go to bypass page')}}" link="/{{ env('APP_MAINTENANCE_SECRET') }}"  />
			@endif
		</div>
	</x-card>
</div>
