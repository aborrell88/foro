<?php

namespace App;

use Collective\Html\HtmlFacade as Html;

trait CanBeVoted
{
    public function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    public function getCurrentVoteAttribute()
    {
        if (auth()->check()) {
            return $this->getVoteFrom(auth()->user());
        }
    }

    public function getVoteComponentAttribute()
    {
        if (auth()->check()) {
            return Html::tag('app-vote', '',[
                'module' => $this->getTable(), // posts, comments, ...
                'id' => $this->id,
                'score' => $this->score,
                'vote' => $this->current_vote
            ]);
        }
    }

    public function getVoteFrom(User $user)
    {
        return $this->votes()
            ->where('user_id', $user->id)
            ->value('vote');
    }

    public function upvote()
    {
        $this->addVote(1);
    }

    public function downvote()
    {
        $this->addVote(-1);
    }

    protected function addVote($vote)
    {
        $this->votes()->updateOrCreate(
            ['user_id' => auth()->id()],
            ['vote' => $vote]
        );

        $this->refreshPostScore();
    }

    public function undoVote()
    {
        $this->votes()
            ->where('user_id', auth()->id())
            ->delete();

        $this->refreshPostScore();
    }

    protected function refreshPostScore()
    {
        $this->score = $this->votes()->sum('vote');

        $this->save();
    }
}