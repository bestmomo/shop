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

@include('livewire.account.addresses.components.form', ['title' => __('Update an address')])
