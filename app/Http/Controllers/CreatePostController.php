<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CreatePostController extends Controller
{
    public function create()
    {
        $categories = Category::pluck('name', 'id')->toArray();

        return view('posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        $post =  auth()->user()->createPost($request->all());

        return redirect($post->url);
    }
}
