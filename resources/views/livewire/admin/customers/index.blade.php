<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};
use App\Models\User;
use Mary\Traits\Toast;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

new #[Layout('components.layouts.admin')] class extends Component {
    use Toast, WithPagination;

    public int $perPage = 10;
    public string $search = '';
    public bool $deleteButton = true;

    public array $sortBy = [
        'column' => 'created_at',
        'direction' => 'desc',
    ];

    public function headers(): array
    {
        return [['key' => 'name', 'label' => __('Name')], ['key' => 'firstname', 'label' => __('Firstname')], ['key' => 'email', 'label' => __('Email')], ['key' => 'created_at', 'label' => __('Registration')], ['key' => 'newsletter', 'label' => __('Newsletter')]];
    }

    public function deleteUser(User $user): void
    {
        $user->delete();
        $this->success(__('User deleted successfully.'));
    }

    public function with(): array
    {
        return [
            'users' => User::orderBy(...array_values($this->sortBy))
                ->when($this->search, function (Builder $query) {
                    $query
                        ->where('name', 'like', "%{$this->search}%")
                        ->orWhere('firstname', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%");
                })
                ->paginate($this->perPage),
            'headers' => $this->headers(),
        ];
    }
}; ?>

@section('title', __('Customers'))
<div>
    <x-header title="{{ __('Customers') }}" separator progress-indicator>
        <x-slot:actions>
            <x-input placeholder="{{ __('Search a name...') }}" wire:model.live.debounce="search" clearable
                icon="o-magnifying-glass" />
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline lg:hidden"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>

    <x-card>
        <x-table striped :headers="$headers" :rows="$users" :sort-by="$sortBy" per-page="perPage" with-pagination
            link="/admin/customers/{id}">
            @scope('cell_newsletter', $user)
                @if ($user->newsletter)
                    <x-icon name="o-check-circle" />
                @endif
            @endscope
            @scope('cell_created_at', $user)
                <span class="whitespace-nowrap">
                    {{ $user->created_at->isoFormat('LL') }}
                    @if (!$user->created_at->isSameDay($user->updated_at))
                        <p>@lang('Change') : {{ $user->updated_at->isoFormat('LL') }}</p>
                    @endif
                </span>
            @endscope
            @scope('actions', $user, $deleteButton)
                <div class="flex">
                    <x-popover>
                        <x-slot:trigger>
                            <x-button icon="o-envelope" link="mailto:{{ $user->email }}" no-wire-navigate spinner
                                class="text-blue-500 btn-ghost btn-sm" />
                        </x-slot:trigger>
                        <x-slot:content class="pop-small">
                            @lang('Send an email')
                        </x-slot:content>
                    </x-popover>
                    @if ($deleteButton)
                        <x-popover>
                            <x-slot:trigger>
                                <x-button icon="o-trash" wire:click="deleteUser({{ $user->id }})"
                                    wire:confirm="{{ __('Are you sure you want to delete this customer?') }}" spinner
                                    class="text-red-500 btn-ghost btn-sm" />
                            </x-slot:trigger>
                            <x-slot:content class="pop-small">
                                @lang('Delete')
                            </x-slot:content>
                        </x-popover>
                    @endif
                </div>
            @endscope
        </x-table>
    </x-card>

</div>
