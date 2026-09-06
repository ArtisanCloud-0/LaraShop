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
    public string $phone = '';
    public string $password = '';
    public ?object $image = null;

    public function mount()
    {
        $user = auth('panel')->user();
        $this->name = $user->name ?? '';
        $this->email = $user->email ?? '';
        $this->phone = $user->phone ?? '';
    }

    public function save(UpdateProfileAction $action)
    {
        $this->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255',
            'phone'    => 'nullable|string|max:20',
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
            $imageName = $this->image->hashName();
            $this->image->storeAs('profiles', $imageName, 'public');
        }

        $action->execute(auth('panel')->user(), [
            'name'     => $this->name,
            'email'    => $this->email,
            'phone'    => $this->phone,
            'password' => $this->password,
            'image'    => $imageName,
        ]);

        $this->reset('image', 'password');

        // Dispatch globally so parent layout/navbar updates avatar and user info instantly
        $this->dispatch('profile-updated');

        $this->dispatch('toast', message: 'Profile updated successfully.', type: 'success');
    }

    public function render()
    {
        return view('livewire.admin.auth.profile');
    }
}
