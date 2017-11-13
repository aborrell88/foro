@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>
                {{ $category->exists ? 'Posts de ' . $category->name : 'Posts' }}
            </h1>
        </div>
    </div>
    <div class="row">
        @include('posts.sidebar')
        <div class="col-md-10">
            {!! Form::open(['method' => 'get', 'class' => 'form form-inline']) !!}
                {!! Form::select(
                    'orden',
                    trans('options.posts-order'),
                    request('orden'),
                    ['class' => 'form-control']
                ) !!}
                <button type="submit" class="btn btn-default">Ordenar</button>
            {!! Form::close() !!}

            @each('posts.item', $posts, 'post')
            {{-- Equivalente a --}}
            {{--
            @foreach($posts as $post)
                @include('posts.item', compact('post'))
            @endforeach
            --}}

            {{-- appends() nos permite cambiar de página sin perder el filtro 'orden' --}}
            {{ $posts->appends(request()->intersect(['orden']))->render() }}

        </div>
    </div>
@endsection