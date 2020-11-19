<?php

namespace App\Http\Controllers;

use App\Enums\UserSex;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request,User $user)
    {
        if ($request['include']) {
            return new ProfileResource(Profile::where('user_id', $user->id)->with(explode(',', $request['include']))->first(), 200);
        } else {
            return new ProfileResource(Profile::where('user_id', $user->id)->first(), 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        $profile= Profile::where('user_id', $user->id)->first();

            $request->validate([
                'name' => 'required|string',
                'cpf_cnpj' => 'cpf_cnpj|unique:users',
                'birthdate' => 'date',
                'cellphone' => 'required|numeric|unique:users',
                'sex' => ['string', Rule::in(UserSex::toArray())]
            ]);

            $profile->update($request->all());

            return new ProfileResource($profile, 202);

    }

    /**
     * Upload a newly created resource or update profile image in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(User $user, Request $request)
    {
        $profile = Profile::where('user_id',$user->id)->first();

        $disk = \Storage::disk('local');
        $request->validate([
            'img' => 'required|image|max:2000',
        ]);

        if($profile->img){
            \Storage::disk('local')->delete($profile->img);
        }

        $folders = array_merge(['profile'], str_split($profile->id));
        $dir = implode('/', $folders);
        $name = time() . '.' . $request->img->getClientOriginalExtension();

        if (!$disk->has($dir)) {
            $disk->makeDirectory($dir);
        }

        $path = $disk->putFileAs($dir, $request->img, $name);

        $profile->img = $path;
        $profile->update();

        return new ProfileResource($profile, 201);
    }
}
