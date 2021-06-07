<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Mean;
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
        $recipes = Recipe::where('visible', '=', '1')->orderBy('created_at', 'desc')->paginate(6);
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
        
        if(!isset($n_votes)){
            $n_votes = 0;
        }

        $means = Mean::select()->get();
        $tags = Tag::select()->get();

        return view('home')->with(['recipes' => $recipes, 'recipe_images' => $recipe_images, 'recipe_votes' => $recipe_votes, 'n_votes' => $n_votes, 'means' => $means, 'tags' => $tags]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function search(Request $request)
    {
        $recipes = Recipe::where([
            [function($query) use ($request) {
                if(($titulo = $request->titulo)) {
                    $query->orWhere('title', 'LIKE', '%' . $titulo . '%');
                }
                if(($tag_slug = $request->caracteristica)) {
                    $tag = Tag::where('slug', '=', $tag_slug)->firstOrFail();

                    $recipes = $tag->recipes;

                    if($recipes->first()) {
                        foreach($recipes as $recipe){
                            $query->orWhere('id', '=', $recipe->recipe_id)->get();
                        }
                    } else { 
                        $query->orWhere('id', '=', '0'); 
                    }
                }
                if(($mean_slug = $request->herramienta)) {
                    $mean = Mean::where('slug', '=', $mean_slug)->firstOrFail();

                    $recipes = $mean->recipes;

                    if($recipes->first()) {
                        foreach($recipes as $recipe){
                            $query->orWhere('id', '=', $recipe->id)->get();
                        }
                    } else { 
                        $query->orWhere('id', '=', '0'); 
                    }
                }
            }]
        ])->where('visible', '=', '1')->orderBy('created_at', 'desc')->paginate(6);

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
        
        if(!isset($n_votes)){
            $n_votes = 0;
        }

        $means = Mean::select()->get();
        $tags = Tag::select()->get();

        return view('home')->with(['recipes' => $recipes, 'recipe_images' => $recipe_images, 'recipe_votes' => $recipe_votes, 'n_votes' => $n_votes, 'means' => $means, 'tags' => $tags]);
    }
}
