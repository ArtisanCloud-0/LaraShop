<?php

namespace App\Livewire\Admin\Auth;

use Livewire\Component;
use Livewire\Attributes\Validate;

use App\Actions\Auth\UpdateProfileAction;

class Profile extends Component
{

    #[Validate('string', message: 'This name must be string value.')]
    #[Validate('required', message: 'The is required please fill it')]
    #[Validate('max:255', message: 'This is too long name, please reduse it.')]
    public string $name = '';

    #[Validate('email', message: 'This is not valid email address.')]
    #[Validate('required', message: 'The is required please fill it')]
    #[Validate('max:255', message: 'This is too long email, please reduse it.')]
    public string $email = '';


    #[Validate('nullable')]
    #[Validate('min:8', message: 'The password at least must be 8 characters.')]
    public string $password = '';

    public function mount()
    {
        $user = auth('panel')->user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function save(UpdateProfileAction $action)
    {
        $this->validate();

        $action->execute(auth('panel')->user(), [
            'name'     => $this->name,
            'email'    => $this->email,
            'password' => $this->password,
        ]);

        session()->flash('status', 'Profile updated successfully.');
    }

    public function render()
    {
        return view('livewire.admin.auth.profile');
    }

}
