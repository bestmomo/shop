<?php

use App\Models\User;
use App\Traits\ManageProfile;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use App\Notifications\NewUser;
use App\Rules\StrongPassword;
use App\Mail\UserRegistered;
use Illuminate\Support\Facades\Mail;

new #[Title('Register')] 
class extends Component {
	use ManageProfile;

	public ?string $gender = null;

	public function register()
	{
		if ($this->gender) {
			abort(403);
		}

		$data = $this->validate([
			'firstname'  => 'required|string|max:255',
			'name'       => 'required|string|max:255|unique:users',
			'newsletter' => 'nullable',
			'email'      => 'required|email|unique:users',
			'password'   => ['required','string','min:8','confirmed', new StrongPassword,],
			'password_confirmation' => 'required',
		]);

		$data['password'] = Hash::make($data['password']);
		$user = User::create($data);
		auth()->login($user);
		request()->session()->regenerate();

		Mail::to(auth()->user())->send(new UserRegistered());

		session()->flash('registered', __('Your account has been successfully created. An email has been sent to you with all the details.'));

		return redirect('/');
	}
	
}; ?>

<div>
    <x-card 
		class="flex justify-center items-center mt-6" 
		title="{{ __('Register') }}" 
		shadow 
		separator
        progress-indicator
	>
        <x-form wire:submit="register" x-data="{ rgpd: false }" class="w-full sm:min-w-[50vw]">
			<x-input 
				label="{{ __('Your firstName') }}" 
				wire:model="firstname" icon="o-user" 
				required 
			/>
            <x-input 
				label="{{ __('Your name') }}" 
				wire:model="name" 
				icon="o-user" 
				required 
			/>
            <x-input 
				label="{{ __('Your e-mail') }}" 
				wire:model="email" 
				icon="o-envelope" 
				required 
			/>
            <x-input 
				label="{{ __('Your password') }}" 
				wire:model="password" 
				icon="o-key"
				hint="{{ __('Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number and one special character') }}"
				required
			/>
            <x-input 
				label="{{ __('Confirm Password') }}" 
				wire:model="password_confirmation" 
				icon="o-key" 
				required
			/>
			<x-button 
				label="{{ __('Generate a secure password') }}" 
				wire:click="generatePassword()" 
				icon="m-wrench"
				class="btn-outline btn-sm" 
			/>
			<hr>
			<x-checkbox 
				label="{{ __('I would like to receive your newsletter') }}" 
				wire:model="newsletter" 
			/>
			<x-checkbox 
				label="{!! __('I accept the terms and conditions of the privacy policy') !!}" 
				x-model="rgpd" 
			/>        
            <div style="display: none;">
                <x-input 
					wire:model="gender" 
					type="text" 
					inline 
				/>
            </div>
			<p class="text-xs text-gray-500"><span class="text-red-600">*</span> @lang('Required information')</p>
            <x-slot:actions>
                <x-button 
					label="{{ __('Already registered?') }}" 
					class="btn-ghost" 
					link="/login" 
				/>
                <x-button 
					x-show="rgpd" 
					label="{{ __('Register') }}" 
					type="submit" 
					icon="o-paper-airplane" 
					class="btn-primary"
                    spinner="login" 
				/>
            </x-slot:actions>
        </x-form>

    </x-card>
</div>