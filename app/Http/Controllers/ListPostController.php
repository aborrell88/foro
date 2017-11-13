<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Http\Request;

class ListPostController extends Controller
{
    public function __invoke(Category $category = null, Request $request)
    {
        list($orderColumn, $orderDirection) = $this->getListOrder($request->get('orden'));

        $posts = Post::query()
            ->with(['user', 'category']) // Optimizar el número de consultas SQL
            ->category($category)
            ->scopes($this->getRouteScope($request))
            ->orderBy($orderColumn, $orderDirection)
            //->appends($request->intersect(['orden']))
            ->paginate();

        return view('posts.index', compact('posts', 'category'));
    }

    protected function getRouteScope(Request $request)
    {
        $scopes = [
            'posts.mine' => ['byUser' => [$request->user()]],
            'posts.pending' => ['pending'],
            'posts.completed' => ['completed']
        ];

        // Es lo mismo con sintaxis de PHP7
        return $scopes[$request->route()->getName()] ?? []; // return isset ($scopes[$name]) ? $scopes[$name] : [];
    }

    protected function getListOrder($order)
    {
        $orders = [
            'recientes' => ['created_at', 'desc'],
            'antiguos' => ['created_at', 'asc']
        ];

        return $orders[$order] ?? ['created_at', 'desc'];
    }
}
