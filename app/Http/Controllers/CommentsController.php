<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCommentPost;

class CommentController extends Controller
{
    public function store(StoreCommentPost $request)
    {
        $recipe = Recipe::findOrFail($request->recipe_id);
        
        Comment::create([
            'text' => $request->text,
            'user_id' => Auth::id(),
            'post_id' => $recipe->id
        ]);
        return redirect()->back();
    }
}
