<?php

namespace App\Controllers\Admin;

use App\Contracts\DataManager;
use App\Entities\Post;
use DateTimeImmutable;
use Lemon\Http\Request;

class Posts
{
    public function create()
    {
        return template('admin.new');
    }

    public function store(Request $request, DataManager $data)
    {
        $request->validate([
            'title' => 'max:256',
            'content' => 'min:8',
        ], redirect('/posts/create'));

        $post = new Post(count($data->all(Post::class)), $request->get('title'), $request->get('content'), new DateTimeImmutable());

        $data->set($post);
		$data->save();
        return redirect('/');
    }
}

