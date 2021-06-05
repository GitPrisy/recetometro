<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Mean;
use App\Models\User;
use App\Models\Vote;
use App\Models\Image;
use App\Models\Recipe;
use App\Models\RecipeTag;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreRecipePost;

class RecipeController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::select()->get();
        $means = Mean::select()->get();

        return view("recipe_create", ['recipes' => new Recipe(), 'tags' => $tags, 'means' => $means]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRecipePost $request)
    {
        $mean_id = $request->validated()["mean"];
        $title = $request->validated()["title"];
        $description = $request->validated()["description"];
        $ingredients = $request->validated()["ingredients"];
        $preparation = $request->validated()["preparation"];
        $user_id = Auth::user()->id;
        $recipe = Recipe::create([
            'mean_id' => $mean_id,
            'title' => $title,
            'description' => $description,
            'ingredients' => $ingredients,
            'preparation' => $preparation,
            'user_id' => $user_id,
        ]);
        $slug = Str::slug($request->validated()["title"]." ".$recipe->id);
        $recipe->slug = $slug;
        $recipe->save();

        $recipe_tags = $request->validated()["tag"];
        $recipe_id = $recipe->id;
        foreach ($recipe_tags as $tag_id) {
            RecipeTag::create([
                'tag_id' => $tag_id,
                'recipe_id' => $recipe_id,
            ]);
        }
        
        if($request->hasfile('images')) {
            foreach ($request->file('images') as $key=>$image) {
                $name = $recipe->slug."-".$key.'.'.$image->getClientOriginalExtension();
                $image->move(public_path().'/images/', $name);  
                $recipe_images[] = $name;  
            }

            foreach ($recipe_images as $recipe_image) {
                Image::create([
                    'image' => $recipe_image,
                    'recipe_id' => $recipe_id,
                ]);
            }
        }
        session(['recipe' => $recipe]);
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $recipe = Recipe::select()->firstWhere('slug', $slug);
        $recipe_images = [];

        $images = Recipe::find($recipe->id)->images()->get();
        if (count($images) == null) {
            $recipe_images[] = "images/default.jpeg";
        } else {
            foreach ($images as $image) {
                $recipe_images[] = "images/".$image->image;
            }
        }
        
        return view("recipe_show", ['recipe' => $recipe, 'recipe_images' => $recipe_images]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Create a new vote for the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function vote_up($id)
    {
        $recipe = Recipe::findOrFail($id);
        $user_id = Auth::user()->id;
        $vote = Vote::select()->where('user_id', '=', $user_id)->where('recipe_id', '=', $recipe->id)->get();

        if(!$vote->count()){
            Vote::create(['recipe_id' => $recipe->id, 'user_id' => $user_id]);
        }
        return back();
    }

    /**
     * Delete a vote for the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function vote_down($id)
    {
        $recipe = Recipe::findOrFail($id);
        $user_id = Auth::user()->id;
        $vote = Vote::select()->where('user_id', '=', $user_id)->where('recipe_id', '=', $recipe->id)->get();
        
        if($vote->first()){
            Vote::select()->where('user_id', '=', $user_id)->where('recipe_id', '=', $recipe->id)->delete();
        }
        return back();
    }

    /**
     * Hide the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function hide($id)
    {
        $recipe = Recipe::findOrFail($id);
        if(Auth::user()->rol_id == 1) {
            $recipe->visible = false;
            $recipe->save();
        }
        
        return back();
    }
}
