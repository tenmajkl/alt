<?php

namespace App\Controllers\Auth;

use App\Contracts\DataManager;
use App\Entities\User;
use Lemon\Contracts\Http\Session;
use Lemon\Http\Request;

class Login
{
    public function get()
    {
        return template('auth.login');
    }

    public function post(Request $request, DataManager $data, Session $session)
    {
        $request->validate([
            'name' => 'max:256',
            'password' => 'max:256',
        ], redirect('login'));

        if (($user = $data->get(User::class, $request->get('name'))) === null) {
            return redirect('login');
        }

        if (!password_verify($request->get('password'), $user->password)) {
            return redirect('login');
        }

        $session->set('name', $user->name);

        return redirect('/');
    }
}
