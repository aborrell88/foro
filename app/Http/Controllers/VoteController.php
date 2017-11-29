<?php

namespace App\Http\Controllers;

use App\Post;

class VoteController extends Controller
{
    /*
    private $voteRepository;

    public function __construct(VoteRepository $voteRepository)
    {
        $this->voteRepository = $voteRepository;
    }
    */

    public function upvote($module, $votable)
    {
        $votable->upvote();

        return [
            'new_score' => $votable->score,
        ];
    }

    public function downvote($module, $votable)
    {
        $votable->downvote();

        return [
            'new_score' => $votable->score,
        ];
    }

    public function undoVote($module, $votable)
    {
        $votable->undoVote();

        return [
            'new_score' => $votable->score,
        ];
    }
}
