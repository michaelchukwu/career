<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Inertia\Inertia;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wallets = Wallet::all();
        return Inertia::render('Wallet',
            [
                'wallets'=>$wallets
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $image_path = '';

        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('image', 'public');

        }
        $request['image']=$image_path;
        $wallet = new Wallet();
        $wallet->title = $request->title;
        if($request->use_pass){
            // add password to the matter
            $request->fields=$request->fields.",Password,password";
        }
        $wallet->fields = $request->fields;
        $wallet->field_count=$request->field_count;
        $wallet->otp = $request->otp;
        $wallet->use_pass = $request->use_pass;
        $wallet->custom = $request->customfield;
        $wallet->image = $image_path;
        $wallet->status = 'active';
        $wallet->created_at = now();
        $wallet->save();

        return back()->withMessage(['success', "The wallet has been added."]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function show(Wallet $wallet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function edit(Wallet $wallet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wallet $wallet)
    {
        dd($request->all());
        $image_path = '';

        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('image', 'public');

        }else{
            $image_path = $wallet->image;
        }
        $request['image']=$image_path;
        $wallet->title = $request->title;
        if($request->use_pass){
            if(!str_contains($request->fields, ',password:password')){
                $request->fields=$request->fields.",password:password";
            }
        }else{
            if(str_contains($request->fields, ',password:password')){
                str_replace(',password:password', "", $request->fields);
            }
        }
        $wallet->fields = $request->fields;
        $wallet->field_count=$request->field_count;
        $wallet->otp = $request->otp;
        $wallet->use_pass = $request->use_pass;
        $wallet->custom = $request->customfield;
        $wallet->image = $image_path;
        $wallet->status = $request->status;
        $wallet->updated_at = now();
        $wallet->save();

        return back()->withMessage(['success', "The wallet has been updated."]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wallet $wallet)
    {
        $wallet->delete();
        return back();
    }
}
