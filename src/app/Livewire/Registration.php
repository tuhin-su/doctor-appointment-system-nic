<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
class Registration extends Component
{
    public $name;
    public $email;
    public $passwd;
    public $passwd_confirmation;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'passwd' => 'required|min:8',
        'passwd_confirmation' => 'required|same:passwd',
    ];

    public function register(){
        $this->validate();
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->passwd),
        ]);
   
        $this->dispatch(
            "alert",
            type: "success",
            title: "Success",
            text: "Registration successful!",
        );
        return redirect('/login');
    }
    public function render()
    {
        return view('livewire.registration');
    }
}
