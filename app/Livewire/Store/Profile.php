<?php

namespace App\Livewire\Store;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

#[Layout('layouts.store')]
#[Title('My Profile')]
class Profile extends Component
{
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public $new_image;

    public string $current_password = '';
    public string $new_password = '';
    public string $new_password_confirmation = '';

    public function mount()
    {
        $user = auth()->user();
        $this->name = $user->name ?? '';
        $this->email = $user->email ?? '';
        $this->phone = $user->phone ?? '';
    }

    public function updateProfile()
    {
        $user = auth()->user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'new_image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($this->new_image) {
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }
            $validated['image'] = $this->new_image->store('profiles', 'public');
        }

        unset($validated['new_image']);

        $user->update($validated);

        $this->reset('new_image');

        // Dispatch event to refresh the navbar dropdown island
        $this->dispatch('profile-updated');

        session()->flash('success', 'Profile details updated successfully!');
    }

    public function removeImage()
    {
        $user = auth()->user();

        if ($user->image && Storage::disk('public')->exists($user->image)) {
            Storage::disk('public')->delete($user->image);
        }

        $user->update(['image' => null]);

        // Dispatch event to refresh the navbar dropdown island
        $this->dispatch('profile-updated');

        session()->flash('success', 'Profile photo removed.');
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'confirmed', Password::defaults()],
        ]);

        auth()->user()->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        session()->flash('success', 'Password updated successfully!');
    }

    public function render()
    {
        return view('livewire.store.profile', [
            'user' => auth()->user(),
        ]);
    }
}
