<?php
namespace App\Livewire;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class Login extends Component
{
    public $email;
    public $passwd;

    public function mount() {
        if (Auth::check()) {
            return redirect('/dashboard');
        }
    }
    
    // Validation rules
    protected $rules = [
        'email' => 'required|email',
        'passwd' => 'required|min:8',
    ];

    // Login method
    public function login()
    {
        // Validate inputs
        $this->validate();

        // Attempt login
        if (Auth::attempt(['email' => $this->email, 'password' => $this->passwd])) {
             session([
                'user' => Auth::user(),
            ]);

            session()->flash('message', 'Successfully logged in!');
            return redirect()->route('/dashboard');
        }

        // If login fails, throw validation exception
        throw ValidationException::withMessages([
            'email' => ['The provided credentials do not match our records.'],
        ]);
    }
    
    public function render()
    {
        return view('livewire.login');
    }
}
