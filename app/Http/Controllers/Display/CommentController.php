<?php

namespace App\Http\Controllers\Display;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CommentController extends Controller
{
    public function newComment(Request $request) {
        if (!$request->content) {
            return response()->json([
                'new_comment' => 'null'
            ], 422);
        }

        $user = Auth::user();
        $comment = Comment::create([
            'content' => $request->content,
            'user_id' => $user->id,
            'post_id' => $request->post_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        return response()->json([
            'new_comment' => $comment
        ]);
    }

    public function getCommentsByPostID($id) {
        $comments = Comment::with(['user'])->where('post_id', $id)->get();
        $count_comment = count($comments);
        return response()->json([
            'comments' => $comments,
            'count_comment' => $count_comment
        ]);
    }
}
