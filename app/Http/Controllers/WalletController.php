<?php

namespace App\Http\Controllers;

use App\Http\Resources\WalletResource;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        if ($request['include']) {
            return WalletResource::collection(Wallet::where('user_id', $user->id)->with(explode(',', $request['include']))->get(), 200);
        } else {
            return WalletResource::collection(Wallet::where('user_id', $user->id)->get(), 200);
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
        $request['user_id'] = $user->id;
        $request->validate([
            'user_id' =>  'required|numeric|exists:users,id'
        ]);

        $wallet = Wallet::create($request->all());
        return new WalletResource($wallet, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user, Wallet $wallet)
    {
        if ($request['include']) {
            return new WalletResource(Wallet::where('id', $wallet->id)->where('user_id', $user->id)->with(explode(',', $request['include']))->first(), 200);
        } else {
            return new WalletResource(Wallet::where('id', $wallet->id)->where('user_id', $user->id)->first(), 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Wallet $wallet)
    {
        if ($wallet->user_id == $user->id) {
            $wallet->delete();
            return response()->json(['message' => 'Deleted successfully'], 204);
        }
        return response()->json(['error' => 'Entry for Wallet not found'], 404);
    }

    /**
     * Update the balance - credit (in).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function in(Request $request, User $user, Wallet $wallet)
    {
        $request->validate([
            'amount' =>  'required|numeric',
        ]);

        if ($wallet->user_id == $user->id) {
            $wallet->balance += $request['amount'];
            $wallet->update();

            return new WalletResource($wallet, 202);
        }

        return response()->json(['error' => 'Entry for Wallet not found'], 404);
    }

    /**
     * Update the balance - credit (in).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function out(Request $request, User $user, Wallet $wallet)
    {
        $request->validate([
            'amount' =>  'required|numeric',
        ]);

        if ($wallet->user_id == $user->id) {
            $wallet->balance -= $request['amount'];
            $wallet->update();

            return new WalletResource($wallet, 202);
        }
        return response()->json(['error' => 'Entry for Wallet not found'], 404);
    }
}
