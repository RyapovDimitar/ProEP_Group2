<?php

namespace App\Http\Controllers;

use App\Currency;
use App\Transaction;
use App\UserCurrency;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Response;

class TransactionsController extends Controller
{
    public function make_transaction(Request $request){
        if(!isset($request->username)||!isset($request->currencytobuyname)
            ||!isset($request->amount)||!isset($request->currencytosellname))
        {
            return Response::json([
                'message' => 'Incorrect input!'
            ], 201);
        }
        else{
            $user = User::where('username', $request->username)->first() ?: null;
            if(!$user){
                return Response::json([
                    'message' => 'User not found!'
                ], 201);
            }
            $user_id = $user->id;
            $currency_to_buy = Currency::where('name', $request->currencytobuyname)->first() ?: null;
            if(!$currency_to_buy){
                return Response::json([
                    'message' => 'Currency to buy not found!'
                ], 201);
            }
            $currency_to_sell = Currency::where('name', $request->currencytosellname)->first() ?: null;
            if(!$currency_to_sell){
                return Response::json([
                    'message' => 'Currency to sell not found!'
                ], 201);
            }
            $usercurrency_to_buy = UserCurrency::where('user_id', $user_id)
                ->where('crypto_id', $currency_to_buy->id)->first() ?: null;
            if(!$usercurrency_to_buy){
                return Response::json([
                    'message' => 'Currency to buy not found in user wallet!'
                ], 201);
            }
            $usercurrency_to_sell = UserCurrency::where('user_id', $user_id)
                ->where('crypto_id', $currency_to_sell->id)->first() ?: null;
            if(!$usercurrency_to_sell){
                return Response::json([
                    'message' => 'Currency to sell not found in user wallet!'
                ], 201);
            }
            $value_to_buy = $currency_to_buy->stockvalue;
            $amount_to_buy = $request->amount;
            $value_to_buy = $value_to_buy*$amount_to_buy;

            $value_to_sell = $currency_to_sell->stockvalue*$usercurrency_to_sell->balance;
            if($value_to_sell>=$value_to_buy){
                $transaction_buy = new Transaction();
                $transaction_buy->user_id = $user_id;
                $transaction_buy->crypto_id = $currency_to_buy->id;
                $transaction_buy->usercurrency_id = $usercurrency_to_buy->id;
                $transaction_buy->cryptoQuantity = $request->amount;
                $transaction_buy->positive = true;
                $transaction_buy->save();
                $transaction_sell = new Transaction();
                $transaction_sell->user_id = $user_id;
                $transaction_sell->crypto_id = $currency_to_sell->id;
                $transaction_sell->usercurrency_id = $usercurrency_to_sell->id;
                $reminder = $value_to_buy % $currency_to_sell->stockvalue;
                $transaction_sell->cryptoQuantity = floor($value_to_buy / $currency_to_sell->stockvalue);
                if($reminder!=0){
                   $transaction_sell->cryptoQuantity =  $transaction_sell->cryptoQuantity + 1;
                }
                $transaction_sell->positive = false;
                $transaction_sell->save();
                $usercurrency_to_sell->balance = $usercurrency_to_sell->balance - $transaction_sell->cryptoQuantity;
                $usercurrency_to_sell->save();
                $usercurrency_to_buy->balance = $usercurrency_to_buy->balance + $request->amount;
                $usercurrency_to_buy->save();
                return 'transactions saved successfully';
                return $value_to_sell.'there is enough to sell'.$value_to_buy;
            }
        }
    }

    public function make_report($username){
        $user_id = User::where('username', $username)->first() ?: null;
        if(!$user_id){
            return Response::json([
                'message' => 'User not found!'
            ], 201);
        }
        else{
            $user_id = $user_id->id;
            return Transaction::where('user_id', $user_id)->get();
        }
    }
}
