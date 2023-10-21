<?php

namespace App\Middlewares;

use Lemon\Contracts\Http\Session;

class Auth
{
    public function onlyAdmin(Session $session)
    {
        if (!$session->has('name')) {
            return redirect('login');
        }
    }

    public function onlyGuest(Session $session)
    {
        if ($session->has('name')) {
            return redirect('/');
        }
    }
}
