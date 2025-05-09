<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function root()
    {
        return view('index', ['currentComponent' => 'login']); // Show login by default at "/"
    }
    
    public function index(Request $request)
    {
        //? Match the route parameter to a specific Livewire component
        $component = match($request->route('page')) {
            'login' => 'login',
            'register' => 'registration',
            'dashboard' => 'dashboard',
            'profile' => 'profile',
            default => 'not-found',
        };

        //? Return the view and pass the component name
        return view('index', ['currentComponent' => $component]);
    }
}
