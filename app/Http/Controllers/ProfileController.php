<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\UpdateProfilePut;

class ProfileController extends Controller
{
    public function index($nickname){
        User::where('nickname', '=', $nickname)->firstOrFail();

        $user = User::select()->where('nickname', '=', $nickname)->get();
        $recipes = Recipe::select()->where('user_id', '=', $user[0]->id)->get();

        $n_recipes = $recipes->count();
        $n_votes = 0;
        foreach($recipes as $recipe) {
            $n_votes += $recipe->votes()->count();
        }

        if(Auth::user() == $user[0]){
            return view('profile')->with(['user' => $user[0], 'n_votes' => $n_votes, 'n_recipes' => $n_recipes]);
        }

        return abort(404);
    }

    public function show($nickname, Request $request)
    {
        User::where('nickname', '=', $nickname)->firstOrFail();
        $user = User::select()->where('nickname', '=', $nickname)->get();
        if($user->count()){
            $recipes = Recipe::where('user_id', '=', $user[0]->id)->orderBy('created_at', 'desc')->paginate(6);
            $recipe_images = [];
            $recipe_votes = [];
            $n_votes = [];
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

            return view('profile_index')->with(['user' => $user[0], 'recipes' => $recipes, 'recipe_images' => $recipe_images, 'recipe_votes' => $recipe_votes, 'n_votes' => $n_votes]);
        }
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $nickname
     * @return \Illuminate\Http\Response
     */
    public function edit($nickname)
    {
        User::where('nickname', '=', $nickname)->firstOrFail();

        $user = User::select()->where('nickname', '=', $nickname)->get();
        if(Auth::user() == null || ((Auth::user()->id != $user[0]->id))){
            return abort(404);
        }

        return view('profile_edit', ['user' => $user[0]]);
    }

        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $nickname
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfilePut $request, $nickname)
    {
        User::where('nickname', '=', $nickname)->firstOrFail();

        $user = User::select()->where('nickname', '=', $nickname)->get()[0];
        
        $image = $request->file('profile_image');

        if($request->hasFile('profile_image')){
            if (!is_null($user->profile_image)) {
                if (File::exists('images/user/' . $user->profile_image)){
                    File::delete('images/user/' . $user->profile_image);
                }
            }
  
            $name = $user->nickname.time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('/images/user'), $name);  
            $user->profile_image = $name;
            $user->save();

            return $this->edit($user->nickname);
        }
        $user->update($request->validated());
        $user->save();

        return redirect(route('perfil.edit', $user->nickname));
    }
}
