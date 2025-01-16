<?php

use App\Models\Country;
use Livewire\Volt\Component;
use Livewire\Attributes\Title;
use Mary\Traits\Toast;
use Illuminate\Support\Collection;
use App\Traits\ManageAddress;

new #[Title('Create address')]
class extends Component
{
    use Toast, ManageAddress;

    public function mount(): void
    {
        $this->countries = Country::all();
        $this->country_id = $this->countries->first()->id;
    }

    public function save(): void
    {
        $data = $this->validate($this->rules());

        Auth::user()->addresses()->create($data);

        $this->success(__('Address created successfully.'), redirectTo: '/account/addresses');
    }
}

?>

<div>
    <x-card class="flex justify-center items-center mt-6" title="{!! __('Create an address') !!}" shadow separator progress-indicator>
        @include('livewire.account.addresses.form')
    </x-card>
</div>