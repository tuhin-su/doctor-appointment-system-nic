<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class Profile extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $password;
    public $confirm_password;
    public $profile_image;

    public function mount()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login');
        }

        $this->name = $user->name;
        $this->email = $user->email;

        // You can preload the base64 string if already stored
        $this->profile_image = $user->profile_image ? $user->profile_image : 'https://picsum.photos/200?random=1';
    }

    protected $rules = [
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'nullable|min:6',
        'confirm_password' => 'same:password',
    ];

    public function save()
    {
        $this->validate();

        $user = Auth::user();
        $user->name = $this->name;
        $user->email = $this->email;

        if ($this->password) {
            $user->password = bcrypt($this->password);
        }

        // Check if image is a file upload (not a string)
        if (is_object($this->profile_image)) {
            $imageContents = file_get_contents($this->profile_image->getRealPath());
            $base64Image = base64_encode($imageContents);
            $mime = $this->profile_image->getMimeType();
            $user->profile_image = "data:$mime;base64,$base64Image";
        }

        $user->save();

        session()->flash('message', 'Profile updated successfully.');
    }

    public function render()
    {
        return view('livewire.profile');
    }
}
