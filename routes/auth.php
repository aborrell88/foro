<?php

// Routes that require authentication.

Route::post('logout', 'LoginController@logout');

// Posts
Route::get('posts/create', [
    'uses' => 'CreatePostController@create',
    'as' => 'posts.create'
]);

Route::post('posts/create', [
    'uses' => 'CreatePostController@store',
    'as' => 'posts.store'
]);

// Votes
Route::pattern('module', '[a-z]+');

Route::bind('votable', function ($votableId, $route) {

    $modules = [
        'posts' => 'App\Post',
        'comments' => 'App\Comment'
    ];

    $model = $modules[$route->parameter('module')];

    abort_unless($model ?? null, 404);

    return $model::findOrFail($votableId);
});

Route::post('{module}/{votable}/vote/1', [
    'uses' => 'VoteController@upvote'
]);

Route::post('{module}/{votable}/vote/-1', [
    'uses' => 'VoteController@downvote'
]);

Route::delete('{module}/{votable}/vote', [
    'uses' => 'VoteController@undoVote'
]);

// Votes - Comment
/*
Route::post('comments/{comment}/vote/1', [
    'uses' => 'VoteCommentController@upvote'
]);

Route::post('comments/{comment}/vote/-1', [
    'uses' => 'VoteCommentController@downvote'
]);

Route::delete('comments/{comment}/vote', [
    'uses' => 'VoteCommentController@undoVote'
]);
*/

// Comments
Route::post('posts/{post}/comment', [
   'uses' => 'CommentController@store',
   'as' => 'comments.store'
]);

Route::post('comments/{comment}/accept', [
   'uses' => 'CommentController@accept',
   'as' => 'comments.accept'
]);

Route::post('posts/{post}/subscribe', [
    'uses' => 'SubscriptionController@subscribe',
    'as' => 'posts.subscribe'
]);

Route::delete('posts/{post}/unsubscribe', [
    'uses' => 'SubscriptionController@unsubscribe',
    'as' => 'posts.unsubscribe'
]);

Route::get('mis-posts/{category?}', [
    'uses' => 'ListPostController',
    'as' => 'posts.mine'
]);