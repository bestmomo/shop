<?php

use App\Models\{Address, Country};
use Livewire\Volt\Component;
use Livewire\Attributes\Title;
use Mary\Traits\Toast;
use Illuminate\Support\Collection;
use App\Traits\ManageAddress;

new #[Title('Update address')] 
class extends Component {
    use Toast, ManageAddress;

    public Address $myAddress;

    public function mount(Address $address): void
    {
        $this->myAddress = $address;
        $this->fill($this->myAddress);
        $this->countries = Country::all();
    }

    public function save(): void
    {
        $data = $this->validate($this->rules());

        $this->myAddress->update($data);

        $this->success(__('Address updated with success.'), redirectTo: '/account/addresses');
    }
};

?>

<div>
    <x-card class="flex justify-center items-center mt-6" title="{!! __('Update an address') !!}" shadow separator
        progress-indicator>
        @include('livewire.account.addresses.form')
    </x-card>
</div>
