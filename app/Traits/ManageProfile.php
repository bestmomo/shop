<?php

namespace App\Traits;

trait ManageProfile
{
	public string $firstname = '';
	public string $name = '';
	public string $email = '';
	public string $password = '';
	public string $password_confirmation = '';
	public bool   $newsletter = false;

    public function generatePassword(int $length = 16): void
    {
        $characters = array_merge(
            range('A', 'Z'), 
            range('a', 'z'),
            range('0', '9'), 
            str_split('!@#$%^&*()_+-=[]{}|;:,.<>?')
        );

        $password = '';
        $max = count($characters) - 1;

        $password .= chr(random_int(65, 90)); 
        $password .= chr(random_int(97, 122));
        $password .= chr(random_int(48, 57));
        $password .= $characters[array_rand(array_slice($characters, 62))];

        while (strlen($password) < $length) {
            $password .= $characters[random_int(0, $max)];
        }

        $this->password = str_shuffle($password);
        $this->password_confirmation = $this->password;
    }
}
