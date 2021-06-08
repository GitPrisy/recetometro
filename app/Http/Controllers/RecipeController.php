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
use Illuminate\Support\Facades\File;
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
        } else {
            Image::create([
                'image' => 'default.jpeg',
                'recipe_id' => $recipe_id,
            ]);
        }
        session(['recipe' => $recipe]);
        
        return redirect('/recetobot');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $recipe = Recipe::where('slug', '=', $slug)->where('visible', '=', '1')->firstOrFail();

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
    public function edit($slug)
    {
        $recipe = Recipe::where('slug', '=', $slug)->where('visible', '=', '1')->firstOrFail();

        $recipe_images = [];

        $images = Recipe::find($recipe->id)->images()->get();
        if (count($images) == null) {
            $recipe_images[] = "images/default.jpeg";
        } else {
            foreach ($images as $image) {
                $recipe_images[] = "images/".$image->image;
            }
        }
    
        $tags = Tag::select()->get();        
        $means = Mean::select()->get();
        return view("recipe_edit", ['recipe' => $recipe, 'recipe_images' => $recipe_images, 'tags' => $tags, 'means' => $means, 'images' => $images]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRecipePost $request, $slug)
    {
        $recipe = Recipe::where('slug', '=', $slug)->where('visible', '=', '1')->firstOrFail();

        $mean_id = $request->validated()["mean"];
        $title = $request->validated()["title"];
        $description = $request->validated()["description"];
        $ingredients = $request->validated()["ingredients"];
        $preparation = $request->validated()["preparation"];

        $recipe->update([
            'mean_id' => $mean_id,
            'title' => $title,
            'description' => $description,
            'ingredients' => $ingredients,
            'preparation' => $preparation,
        ]);
        $slug = Str::slug($title." ".$recipe->id);
        $recipe->slug = $slug;
        $recipe->save();

        RecipeTag::where('recipe_id', $recipe->id)->delete();

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

        return redirect(route('receta.show', $recipe));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $recipe = Recipe::where('id', '=', $id)->firstOrFail();

        $recipe->delete();

        return redirect(route('home'));   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_recipe_image($slug, $image_id)
    {
        $recipe = Recipe::where('slug', '=', $slug)->where('visible', '=', '1')->firstOrFail();
        
        $image = Image::where('id', '=', $image_id)->firstOrFail();
        if ($recipe->images->count() == 1) {
            return response('No se puede eliminar esta imagen...', 503);
        }

        if ($image->recipe->id == $recipe->id) {
            if (File::exists('images/' . $image->image)){
                File::delete('images/' . $image->image);
            }
        }

        $image->delete();

        return back();        
    }

    /**
     * Create a new vote for the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function vote_up($id)
    {
        $recipe = Recipe::where('id', '=', $id)->where('visible', '=', '1')->firstOrFail();

        $recipe->increment('total_votes');

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
        $recipe = Recipe::where('id', '=', $id)->where('visible', '=', '1')->firstOrFail();

        $recipe->decrement('total_votes');

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
        $recipe = Recipe::where('id', '=', $id)->where('visible', '=', '1')->firstOrFail();
        if(Auth::user()->rol_id == '1' || Auth::user()->rol_id == '2') {
            $recipe->visible = false;
            $recipe->save();
        }
        
        return back();
    }
}
