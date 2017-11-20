<?php

namespace App\Repositories;
use App\{Post, Vote};

class VoteRepository
{
    public function upvote(Post $post)
    {
        $this->addVote($post, 1);
    }

    public function downvote(Post $post)
    {
        $this->addVote($post, -1);
    }

    protected function addVote(Post $post, $vote)
    {
        Vote::updateOrCreate(
            ['post_id' => $post->id,'user_id' => auth()->id()],
            ['vote' => $vote]
        );

        $this->refreshPostScore($post);
    }

    public function undoVote(Post $post)
    {
        Vote::where([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
        ])->delete();

        $this->refreshPostScore($post);
    }

    protected function refreshPostScore(Post $post)
    {
        $post->score = Vote::where('post_id', $post->id)->sum('vote');

        $post->save();
    }
}