<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Comment;
use Illuminate\Http\Request;
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
            'recipe_id' => $recipe->id
        ]);
        
        $recipe_images = [];

        $images = $recipe->images()->get();
        if (count($images) == null) {
            $recipe_images[] = "images/default.jpeg";
        } else {
            foreach ($images as $image) {
                $recipe_images[] = "images/".$image->image;
            }
        }

        return back();
    }
}
