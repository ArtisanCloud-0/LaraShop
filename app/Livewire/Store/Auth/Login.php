<?php

namespace App\Livewire\Store\Auth;

use App\Actions\Auth\LoginUserAction;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;

#[Layout('layouts.store')]
class Login extends Component
{

    #[Validate('string')]
    #[Validate('required', message: 'The email is required, please fill it.')]
    #[Validate('email', message: 'This is not valid email address.')]
    public string $email = "";

    #[Validate('string')]
    #[Validate('required', message: 'The email is required, please fill it.')]
    public string $password = "";

    public function login()
    {

        $data = $this->validate();

        $targetUrl = resolve(LoginUserAction::class)->execute($data['email'], $data['password']);

        return redirect()->to($targetUrl);
    }

    public function render()
    {
        return view('livewire.store.auth.login');
    }
}
