<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        $page_title = 'Login';
        $page_description = '';
        $action = __FUNCTION__;
        // return view('auth.login');
        return view('page.login', compact('page_title', 'page_description', 'action'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        // Validate the login credentials
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Define credentials for login (only username and password)
        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];
        // dd(DB::connection()->getDatabaseName());

        // Attempt login using username and password
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            // Regenerate the session to prevent session fixation
            $request->session()->regenerate();

            // Redirect to the intended page or default home page
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        // If login fails, return with error
        return back()->withErrors([
            'username' => __('Username atau password yang anda masukkan salah.'),
        ])->onlyInput('username');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
