<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Http\Resources\UserResource;
use App\Models\Profile;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request['include']) {
            return UserResource::collection(Wallet::with(explode(',', $request['include']))->get(), 200);
        } else {
            return UserResource::collection(Wallet::all(), 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $request->validate([
            'email' => 'required|string|unique:users|email',
            'password' => 'required|string|confirmed|min:8',
            'role' => ['required', 'string', Rule::in(UserRole::toArray())],
        ]);
        $request['password'] = Hash::make($request['password']);
        $request['status'] = UserStatus::APPROVED;

        $user = User::create($request->all());

        Profile::create([
            'user_id' => $user->id
        ]);

        return new UserResource($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {
        if ($request['include']) {
            return new UserResource(User::where('id', $user->id)->with(explode(',', $request['include']))->first(), 200);
        } else {
            return new UserResource($user, 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'password' => 'string|confirmed|min:8',
            'role' => ['string', Rule::in(UserRole::toArray())],
        ]);

        $user->update($request->all());

        return new UserResource($user, 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'Deleted successfully'], 204);
    }

    /**
     * Update the status to approved.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function approve(User $user)
    {
        $user->status = UserStatus::APPROVED;
        $user->update();

        return new UserResource($user, 202);
    }

    /**
     * Update the status to blocked.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function block(User $user)
    {
        $user->status = UserStatus::BLOCKED;
        $user->update();

        return new UserResource($user, 202);
    }
}
