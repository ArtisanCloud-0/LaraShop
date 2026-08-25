<?php

namespace App\Livewire\Store\Auth;

use App\Actions\Cart\RemoveItemFromCartAction;
use App\Models\Cart;
use App\Models\CartItem;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;

use App\Models\User;
use App\Services\Cart\MergeGuestCartWithUserCartService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

#[Layout('layouts.store')]
class Reg extends Component
{

    #[Validate('string', message: 'The name must be string.')]
    #[Validate('max:255', message: 'This is too long name must be shorter.')]
    #[Validate('required', message: 'The username is required, please fill it.')]
    public string $name = '';

    #[Validate('string', message: 'The email must be string.')]
    #[Validate('required', message: 'The email is required, please fill it.')]
    #[Validate('email', message: 'This is not valid email address.')]
    #[Validate('unique:' . User::class, message: 'This email address already taken, try another.')]
    public string $email = '';

    #[Validate('required', message: 'The email is required, please fill it.')]
    public string $password = '';

    function register()
    {

        // [ 1 ] Validate the date
        $data = $this->validate();

        // [ 2 ] Create the new user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // [ 3 ] Merge session items
        resolve(MergeGuestCartWithUserCartService::class)->mergeItems($user->id);

        // [ 4 ] Login the use
        Auth::login($user);

        // [ 4 ] Redirect the user home
        return redirect()->to(route('home'));
    }

    public function render()
    {
        return view('livewire.store.auth.reg');
    }
}
