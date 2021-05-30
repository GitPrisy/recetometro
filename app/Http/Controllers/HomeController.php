<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $recipes = Recipe::orderBy('created_at', 'desc')->paginate(6);
        $recipe_images = [];
        $recipe_votes = [];
        foreach ($recipes as $recipe) {
            $images = Recipe::find($recipe->id)->images()->get();
            if (count($images) == null) {
                $recipe_images[] = "images/default.jpeg";
            } else {
                $recipe_images[] = "images/".$images[0]->image;
            }

            $recipe_votes[] = Recipe::find($recipe->id)->votes;
            $n_votes[] = Recipe::find($recipe->id)->votes->count();
        }

        if ($request->ajax()) {
            $view = view('layouts.cards')->with(['recipes' => $recipes, 'recipe_images' => $recipe_images, 'recipe_votes' => $recipe_votes, 'n_votes' => $n_votes])->render();
                
            return response()->json(['html'=>$view]);
        }

        return view('home')->with(['recipes' => $recipes, 'recipe_images' => $recipe_images, 'recipe_votes' => $recipe_votes, 'n_votes' => $n_votes]);
    }
}
