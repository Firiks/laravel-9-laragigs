<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create() {
    return view('users.register');
  }

  /**
   * Show the login form.
   *
   * @return \Illuminate\Http\Response
   */
  public function login() {
    return view('users.login');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request) {
    $validated = $request->validate([
      'name' => ['required', 'min:3'],
      'email' => ['required', 'email', Rule::unique('users', 'email')],
      'password' => 'required|confirmed|min:6' // matches _confirmation
    ]);

    // hash pass
    $validated['password'] = bcrypt($validated['password']);

    $validated['user_id'] = auth()->id();

    $user = User::create($validated);

    // login user
    auth()->login($user);

    return redirect('/')->with('message', 'Registered.'); // redirect with flash message
  }

  /**
   * Authentificate regitered user
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function authenticate(Request $request) {
    $validated = $request->validate([
      'email' => ['required', 'email'],
      'password' => 'required'
    ]);

    // try to log in user
    if( auth()->attempt($validated) ) {
      $request->session()->regenerate();
      return redirect('/')->with('message', 'Logged in.');
    }

    // show only one message on error
    return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
  }

  /**
   * Show the login form.
   *
   * @return \Illuminate\Http\Response
   */
  public function logout(Request $request) {
    // logout
    auth()->logout();

    // delete session
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // redirect
    return redirect('/')->with('message', 'Logged out.');
  }
}
