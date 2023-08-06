<?php

namespace App\Http\Livewire\Admin;

use App\Events\User\UserCreated;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Illuminate\Support\Str;

class CreateUserForm extends Component
{
    public $given_name;
    public $family_name;
    public $email;
    public $type;

    protected $rules = [
        'family_name' => 'required|string|max:255',
        'given_name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'type'  => 'required|string', 
    ]; 

    public function create()
    {
        $this->validate();

        // Create a password for the user
        $default_password = Str::random(10);
        $password = ['password' => Hash::make($default_password)];
        $user_data = array_merge($this->all(), $password);
        
        // Save user in DB
        $user = User::create($user_data);  

        $user->password = $default_password;

        event(new UserCreated($user));

        // Clear form fields after successful registration
        $this->reset(['given_name', 'family_name', 'email', 'type']);

        return redirect()->back()->with(['success' => 'User created successfully!']);
    }

    public function render()
    {
        return view('livewire.admin.create-user-form');
    }
}


