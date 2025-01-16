<?php

use App\Models\User;
use Illuminate\Support\Facades\{Auth, Hash};
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use App\Traits\ManageProfile;
use App\Rules\StrongPassword;

new #[Title('Profile')]
class extends Component {
	use Toast, ManageProfile;

	public User $user;
	
	public function mount(): void
	{
		$this->user = Auth::user();
		$this->fill($this->user);
	}

	public function save(): void
	{
		$data = $this->validate([
			'firstname'  => 'required|string|max:255',
			'name'       => 'required|string|max:255',
			'newsletter' => 'nullable',
			'email'      => ['required', 'email', Rule::unique('users')->ignore($this->user->id)],
			'password'   => ['required', 'string', 'min:8', 'confirmed', new StrongPassword()],
		]);

		
		if (empty($data['password'])) {
			unset($data['password']);
		} else {
			$data['password'] = Hash::make($data['password']);
		}

		$this->user->update($data);

		$this->success(__('Profile updated with success.'), redirectTo: '/');
	}

}; ?>

<div>
	<x-card class="flex justify-center items-center mt-6" title="{{ __('My personal informations') }}" shadow separator progress-indicator>

        <x-form wire:submit="save" x-data="{ rgpd: false }" class="pb-4" >
			<x-input label="{{ __('Your firstName') }}" wire:model="firstname" icon="o-user" required />
            <x-input label="{{ __('Your name') }}" wire:model="name" icon="o-user" required />
            <x-input label="{{ __('Your e-mail') }}" wire:model="email" icon="o-envelope" required />

            <hr>

            <x-input label="{{ __('Your password') }}" wire:model="password" icon="o-key" hint="{{ __('Please fill in only if you wish to change your password. Otherwise leave blank.') }}" clearable />
            <x-input label="{{ __('Confirm Password') }}" wire:model="password_confirmation" icon="o-key"  />
            <x-button label="{{ __('Generate a secure password') }}" wire:click="generatePassword()" icon="m-wrench"
                class="btn-outline btn-sm" />

			<hr>

			<x-checkbox label="{{ __('I would like to receive your newsletter') }}" wire:model="newsletter" />
			<x-checkbox label="{!! __('I accept the terms and conditions of the privacy policy') !!}" x-model="rgpd" />

			<p class="text-xs text-gray-500"><span class="text-red-600">*</span> @lang('Required information')</p>

            <x-slot:actions>
                <x-button label="{{ __('Cancel') }}" link="/" class="btn-ghost" />
                <x-button x-show="rgpd" label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit"
                    class="btn-primary" />
            </x-slot:actions>

        </x-form>
		<hr><br>
		<p class="text-sm text-gray-500">@lang('To find out about your rights regarding the personal data you entrust to us, please consult our Privacy Policy')</p>
    </x-card>
</div>
