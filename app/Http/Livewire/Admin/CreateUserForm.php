<?php

namespace App\Http\Livewire\Admin;

use Illuminate\Validation\Rule;
use Livewire\Component;

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

    public function register()
    {
        $this->validate();

        // Save user data to the database or perform other actions here
        dd($this->all());
        // $default_password = ($request->given_name)[0] . '_' . ($request->family_name)[0] . $request->type;
        // $password = ['password' => Hash::make($default_password)];
        // $user_data = array_merge($request->only('email', 'type', 'given_name', 'family_name'), $password);
        // dd($user_data);
        // User::create($user_data); 

        // Clear form fields after successful registration
        $this->reset(['given_name', 'family_name', 'email', 'type']);

        session()->flash('success', 'User registered successfully!');
    }

    public function render()
    {
        return view('livewire.admin.create-user-form');
    }
}


