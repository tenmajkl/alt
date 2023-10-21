<?php

namespace App\Controllers;

use App\Contracts\DataManager;
use App\Entities\Post;
use Lemon\Templating\Template;
use Lemon\Contracts\Http\Session;

class Welcome
{
    public function handle(DataManager $data, Session $session): Template
    {
        $admin = $session->get('name') !== null;
        return template('welcome', posts: $data->all(Post::class), admin: $admin);
    }
}
