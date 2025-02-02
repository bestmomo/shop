<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};
use App\Models\User;
use Mary\Traits\Toast;

new 
#[Title('Customer')] 
#[Layout('components.layouts.admin')] 
class extends Component
{
    use Toast;
    
    public User $user;

    public function headers(): array
    {
        return [
            ['key' => 'reference', 'label' => __('Reference')], 
            ['key' => 'created_at', 'label' => __('Date')],            
            ['key' => 'total', 'label' => __('Total price')],
            ['key' => 'state', 'label' => __('State')],
        ];
    }

    public function mount(User $user): void
    {
        $this->user = $user;
        $this->user->load('addresses', 'orders', 'orders.state');
    }

    public function with(): array
	{
		return [	
			'headers' => $this->headers(),
		];
	}
   
}; ?>

<div>
    <x-header title="{{ __('Customer details') }}" separator progress-indicator>
        <x-slot:actions>
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline lg:hidden"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>

    <x-card 
        title="{{ __('Identity') }}" 
        shadow 
        class="h-full"
    >
        <div class="space-y-4">
            <div class="flex items-center">
                <x-icon name="o-user" class="w-6 h-6 mr-3 text-primary" />
                <span>
                    <strong>@lang('Name') :</strong> 
                    {{ $user->name }}
                </span>
            </div>
            <div class="flex items-center">
                <x-icon name="o-user" class="w-6 h-6 mr-3 text-primary" />
                <span>
                    <strong>@lang('Firstname') :</strong> 
                    {{ $user->firstname }}
                </span>
            </div>
            <div class="flex items-center">
                <x-button icon="o-envelope" link="mailto:{{ $user->email }}" no-wire-navigate spinner
                    class="w-6 h-6 mr-3 text-primary btn-ghost btn-sm" tooltip="{{ __('Send an email') }}" />
                <span>
                    <strong>@lang('Email') :</strong> 
                    {{ $user->email }}
                </span>
            </div>
            <div class="flex items-center">
                <x-icon name="o-calendar" class="w-6 h-6 mr-3 text-primary" />
                <span>
                    <strong>@lang('Date of registration') :</strong> 
                    {{ $user->created_at->isoFormat('LL') }}
                </span>
            </div>
            <div class="flex items-center">
                <x-icon name="o-calendar" class="w-6 h-6 mr-3 text-primary" />
                <span>
                    <strong>@lang('Last update') :</strong> 
                    {{ $user->updated_at->isoFormat('LL') }}
                </span>
            </div>
            <div class="flex items-center">
                <x-icon name="o-newspaper" class="w-6 h-6 mr-3 text-primary" />
                <span>
                    <strong>@lang('Newsletter') :</strong> 
                    {{ $user->newsletter ? __('Yes') : __('No') }}
                </span>
            </div>
        </div>
    </x-card>
    <br>
    
    <x-card 
        title="{{ __('Orders') }}" 
        shadow 
        class="h-full"
    >
        <x-table 
            :headers="$headers" 
            :rows="$user->orders" 
            link="/admin/orders/{id}"
        >
            @scope('cell_reference', $order)
                <strong>{{ $order->reference }}</strong>
            @endscope
            @scope('cell_created_at', $order)
                {{ $order->created_at->isoFormat('LL') }}
            @endscope
            @scope('cell_total', $order)
                {{ $order->total }} €
            @endscope
            @scope('cell_state', $order)
                <x-badge value="{{ $order->state->name }}" class="p-3 bg-{{ $order->state->color }}-400 self-start sm:self-center" />
            @endscope
        </x-table>
    </x-card><br>

    <x-card 
        title="{{ __('Adresses') }}" 
        shadow 
        class="h-full"
    >
        <div class="container mx-auto">
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                @foreach ($user->addresses as $address)
                    <x-card
                        class="w-full shadow-md"
                        title="">
                        <x-address :address="$address" />
                    </x-card>
                @endforeach
            </div>
        </div>   
    </x-card>

</div>
