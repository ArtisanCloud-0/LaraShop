<?php

namespace App\Livewire\Admin\Auth;

use App\Models\User;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

use App\Services\User\UserServices;

use App\Actions\Auth\DeleteUserAction;
use App\Actions\Auth\RegisterUserAction;

class AdminUsers extends Component
{

    use WithPagination;                 // Shown N of elements per page

    public string $search = '';         // Provide search ability if not empty
    public bool $showModal = false;     // Toggle shown the add || edit modal to manage users
    public ?int $editingUserId = null;  // Toggle the mode from adding new users if it [null] || update exsist user is have int value 

    public string $name = '';           // User will br known by this name
    public string $email = '';          // The email the user will going to use to enter the control panel
    public string $password = '';       // The password the user will use to enter the control panel
    public string $role = 'Admin';      // The user rule in the system, by default for admin form is 'Admin'

    protected function rules(): array   // The validation rules the constraint input fields
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $this->editingUserId],
            'password' => [$this->editingUserId ? 'nullable' : 'required', 'string', 'min:8'],
            'role' => ['required', 'in:admin,super_admin'],
        ];
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function openEditModal(User $user)
    {
        $this->editingUserId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->password = '';
        $this->showModal = true;
    }

    public function save()
    {
        $validated = $this->validate();

        $user = $this->editingUserId ? User::findOrFail($this->editingUserId) : null;

        resolve(RegisterUserAction::class)->execute($validated, $user);

        session()->flash('status', $this->editingUserId ? 'Admin updated successfully.' : 'New admin created successfully.');

        $this->closeModal();
    }

    public function delete(int $userId)
    {
        try {

            $user = User::findOrFail($userId);
            
            resolve(DeleteUserAction::class)->execute($user, auth()->user());
            
            session()->flash('status', 'Admin user removed.');
        
        } catch (\Exception $e) {
        
            session()->flash('error', $e->getMessage());
        
        }
    
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->editingUserId = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = 'admin';
        $this->resetValidation();
    }

    #[Title('Users Management')]
    public function render()
    {
        return view('livewire.admin.auth.admin-users', [
            'admins' => resolve(UserServices::class)->getAdminUsers($this->search),
        ]);
    }
}
