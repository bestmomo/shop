<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};
use App\Models\{State, Order};
use Mary\Traits\Toast;
use Illuminate\Support\Collection;
use App\Services\Invoice;

new #[Layout('components.layouts.admin')] class extends Component {
    use Toast;

    public Order $order;

    public bool $paid = false;
    public int $annule_indice = 0;
    public Collection $states;
    public ?string $purchase_order = null;
    public string $state = '';

    public function mount(Order $order): void
    {
        $this->order = $order;
        $this->purchase_order = $order->purchase_order ?? null;
        $this->state = $order->state_id;
        $this->order->load('addresses', 'state', 'products', 'payment_infos', 'user', 'user.orders');
        $this->paid = $order->state->indice > 3;

        // Cas du mandat administratif
        $this->annule_indice = State::whereSlug('annule')->first()->indice;
        $this->states = $order->payment === 'mandat' && !$order->purchase_order ? State::where('indice', '<=', $this->annule_indice)->where('indice', '>', 0)->get() : State::where('indice', '>=', $order->state->indice)->get();
    }

    public function generateInvoice(Invoice $invoice): void
    {
        $response = $invoice->create($this->order, true);
        if ($response->successful()) {
            $data = json_decode($response->body());
            $this->order->invoice_id = $data->id;
            $this->order->invoice_number = $data->number;
            $this->order->save();
            $this->success(__('Invoice generated successfully.'));
        }
    }

    public function savePurchaseOrder(Invoice $invoice): void
    {
        $this->order->purchase_order = $this->purchase_order == '' ? null : $this->purchase_order;
        $this->order->save();
        $this->success(__('Purchase order numberupdated successfully.'));
    }

    public function updatedState($value): void
    {
        $this->order->state_id = $value;

        $state = $this->states->find($value);

        if ($state->indice === 1) {
            $this->order->payment = $state->slug;
        }

        $this->order->save();
        $this->order->refresh();

        $this->success(__('State updated successfully.'));
    }
}; ?>

@section('title', __('Order') . ' ' . __L('#') . $order->id)
<div>
    <x-header title="{!! __('Order management') !!}" separator progress-indicator>
        <x-slot:actions>
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline lg:hidden"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>

    <x-card title="{{ __('References') }}" shadow>
        <div class="space-y-4">
            <div>
                <strong>@lang('Number') :</strong>
                <x-badge value="{{ $order->id }}" class="badge-info" />
            </div>
            <div>
                <strong>@lang('Reference') :</strong>
                <x-badge value="{{ $order->reference }}" class="badge-info" />
            </div>
        </div>
    </x-card>
    <br>

    <x-card title="{{ __('Mode of payment') }}" shadow>
        <div class="space-y-4">
            <div>
                {{ $order->payment_text }}
            </div>
            @if ($order->payment_infos)
                <div>
                    <strong>@lang('Payment ID') :</strong>
                    <x-badge value="{{ $order->payment_infos->payment_id }}" class="badge-info" />
                </div>
            @endif
        </div>
    </x-card>
    <br>

    @if ($shop->invoice && ($order->invoice_id || $order->state->indice > $annule_indice))
        <x-card title="{{ __('Invoice') }}" shadow>
            @if ($order->invoice_id)
                <p>@lang('The invoice was generated with id') <strong>{{ $order->invoice_id }}</strong> @langL('And the number')
                    <strong>{{ $order->invoice_number }}</strong>.
                </p>
            @else
                <div class="flex flex-row justify-between">
                    <x-checkbox label="{{ __('Payment has been made') }}" wire:model="paid"
                        hint="{!! __('Tick this box if the invoice has actually been paid.') !!}" />
                    <x-button label="{{ __('Generate invoice') }}" wire:click="generateInvoice" class="btn-primary" />
                </div>
            @endif
        </x-card>
        <br>
    @endif

    @if ($order->payment === 'mandat')
        <x-card title="{{ __('Order form') }}" shadow progress-indicator>
            <x-form wire:submit="savePurchaseOrder">
                <x-input label="{{ __('Purchase order number') }}" wire:model="purchase_order" type="text" />
                <x-slot:actions>
                    <x-button label="{{ __('Update purchase order number') }}" icon="o-paper-airplane" spinner="save"
                        type="submit" class="btn-primary" />
                </x-slot:actions>
            </x-form>
        </x-card>
        <br>
    @endif

    <x-card title="{{ __('State') }}" shadow>
        <x-slot:menu>
            <x-badge value="{{ $order->state->name }}" class="bg-{{ $order->state->color }}-400 mb-4 p-3" />
        </x-slot:menu>
        <x-select label="{!! __('Change state') !!}" :options="$states" wire:model="state" wire:change="$refresh" />
    </x-card>
    <br>

    <x-card title="{{ __('Products') }}" shadow>
        <x-details :content="$order->products" :shipping="$order->shipping" :tax="$order->tax" :total="$order->total" :pick="$order->pick" />
    </x-card>
    <br>

    <x-card title="{{ __('Customer') }}" shadow>
        <div class="space-y-4">
            <div class="flex items-center">
                <x-icon name="o-user" class="mr-3 w-6 h-6 text-primary" />
                <span>
                    <strong>@lang('Name') :</strong>
                    {{ $order->user->name }} {{ $order->user->firstname }}
                </span>
            </div>
            <div class="flex items-center">
                <x-button icon="o-envelope" link="mailto:{{ $order->user->email }}" no-wire-navigate spinner
                    class="mr-3 w-6 h-6 text-primary btn-ghost btn-sm" tooltip="{{ __('Send an email') }}" />
                <span>
                    <strong>@lang('Email') :</strong>
                    {{ $order->user->email }}
                </span>
            </div>
            <div class="flex items-center">
                <x-icon name="o-calendar" class="mr-3 w-6 h-6 text-primary" />
                <span>
                    <strong>@lang('Date of registration') :</strong>
                    {{ $order->user->created_at->isoFormat('LL') }}
                </span>
            </div>
            <div class="flex items-center">
                <x-icon name="o-shopping-cart" class="mr-3 w-6 h-6 text-primary" />
                <span>
                    <strong>@lang('Validated orders') :</strong>
                    <x-badge value="{{ $order->user->orders->where('state_id', '>', 6)->count() }}"
                        class="badge-success" />
                </span>
            </div>
        </div>
        <x-slot:actions>
            <x-button label="{{ __('View customer details') }}" class="btn-primary"
                link="{{ route('admin.customers.show', $order->user) }}" />
        </x-slot:actions>
    </x-card>
    <br>

    <x-card title="{{ __('Addresses') }}" shadow>
        <x-card
            title="{{ __('Billing address') }} {{ $this->order->addresses->count() === 1 && !$this->order->pick ? __('and delivery') : '' }}"
            shadow>
            <x-address :address="$this->order->addresses->first()" />
        </x-card>
        @if ($this->order->pick)
            <x-alert title="{!! __('The customer has chosen to collect the order on site.') !!}" icon="o-exclamation-triangle" class="alert-info" />
        @else
            @if ($this->order->addresses->count() === 2)
                <x-card class="w-full sm:min-w-[50vw]" title="{{ __('Delivery address') }}" shadow separator>
                    <x-address :address="$this->order->addresses->get(1)" />
                </x-card>
            @endif
        @endif
    </x-card>

</div>
