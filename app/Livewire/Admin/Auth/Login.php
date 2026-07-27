<?php

namespace App\Livewire\Admin\Auth;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Layout;

use App\Actions\Auth\LoginUserAction;

#[Layout('layouts.admin-guest')]
class Login extends Component
{

    /*
    * Main Variables
    **/ 
    #[Validate('email', message: 'Email must be vaild email address')]
    #[Validate('required', message: 'Email is required, please fill it')]
    public string $email = '';

    #[Validate('required', message: 'Password is required, please fill it')]
    public string $password = '';

    public bool $remember = false;

    /*
    * Authentication Process upon the guard ['panel' => 'Control Panel', 'web' => 'Public view']
    **/ 
    public function authenticate(LoginUserAction $loginAction)
    {
        
        // [ 1 ] Validate the data the user enter in the login form
        $this->validate();

        //  [ 2 ] Call the exectute function to handle user login in [Control Panel Login]
        $redirectURL = $loginAction->execute(
            $this->email,
            $this->password,
            $this->remember,
            'panel'
        );

        // [ 3 ] Redirect the admin user to the control panel
        return redirect()->to($redirectURL);

    }

    /*
    * Rendering the view
    **/ 
    public function render()
    {
        return view('livewire.admin.auth.login');
    }
}
