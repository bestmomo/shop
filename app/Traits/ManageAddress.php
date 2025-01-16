<?php

namespace App\Traits;
use Illuminate\Support\Collection;

trait ManageAddress
{
    public Collection $countries;
    public bool $professionnal = false;
    public array $civilities = [['id' => 'M.', 'name' => 'M.'], ['id' => 'Mme.', 'name' => 'Mme.']];
    public string $selectedCivility = 'M.';
    public ?string $firstname = null;
    public ?string $name = null;
    public ?string $company = null;
    public string $address = '';
    public ?string $addressbis = null;
    public ?string $bp = null;
    public string $postal = '';
    public string $city = '';
    public int $country_id;
    public string $phone = '';

    protected function rules(): array
    {
        return [
            'professionnal' => 'required|boolean',
            'firstname' => 'required_unless:professionnal,true|nullable|string|max:100',
            'name' => 'required_unless:professionnal,true|nullable|string|max:100',
            'company' => 'required_unless:professionnal,false|nullable|string|max:100',
            'address' => 'required|string|max:255',
            'addressbis' => 'nullable|string|max:255',
            'bp' => 'nullable|string|max:100',
            'postal' => 'required|string',
            'city' => 'required|string|max:100',
            'country_id' => 'required|integer|exists:countries,id',
            'phone' => 'required|numeric',
        ];
    }

    public function updatedprofessionnal(): void
    {
        $this->company = '';
    }
}
