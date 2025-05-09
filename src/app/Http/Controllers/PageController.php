<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function root()
    {
        return view('index', ['currentComponent' => 'login']);
    }

    public function index(Request $request)
    {
        $page = $request->route('page');
        $user = Auth::user();
        $routes = config('routes');

        if (!isset($routes[$page])) {
            return view('index', ['currentComponent' => 'not-found']);
        }

        $route = $routes[$page];

        if ($route['auth'] ?? false) {
            if (!$user) {
                return redirect('/login');
            }

            if (isset($route['roles']) && !in_array($user->role, $route['roles'])) {
                abort(403, 'Unauthorized');
            }
        }

        return view('index', ['currentComponent' => $route['component']]);
    }
}
