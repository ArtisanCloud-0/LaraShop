<?php

namespace App\Livewire\Admin\Auth;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Actions\Auth\UpdateProfileAction;

class Profile extends Component
{
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public ?object $image = null;

    public function mount()
    {
        $user = auth('panel')->user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function save(UpdateProfileAction $action)
    {

        $this->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255',
            'password' => 'nullable|min:8',
            'image'    => 'nullable|image|max:2048',
        ], [
            'name.required'  => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email'    => 'This is not a valid email address.',
            'password.min'   => 'The password must be at least 8 characters.',
            'image.image'    => 'The file must be a valid image (png, jpg, webp).',
            'image.max'      => 'The image size must be under 2MB.',
        ]);

        $imageName = null;

        if ($this->image) {
            $imageName = $this->image;
            $imageName = $imageName->hashName();
            $this->image->storeAs('profiles', $imageName, 'public');
        }

        $action->execute(auth('panel')->user(), [
            'name'     => $this->name,
            'email'    => $this->email,
            'password' => $this->password,
            'image'    => $imageName,
        ]);

        $this->reset('image', 'password');

        $this->dispatch('toast', message: 'Profile updated successfully.', type: 'success');
    }

    public function render()
    {
        return view('livewire.admin.auth.profile');
    }
}
