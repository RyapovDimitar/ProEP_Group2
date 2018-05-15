<?php

namespace App\Http\Controllers;

use App\CurrencyDetails;
use Illuminate\Http\Request;
use App\Currency;
use Illuminate\Support\Facades\Response;

class CurrenciesController extends Controller
{
    public function see_all()
    {
        return Currency::all();
    }

    public function see_concrete($currencyname){
        $cur = Currency::where('name', $currencyname)->first();
        if($cur!=null){
            return $cur;
        }
        else {
            return Response::json([
                'message' => 'Currency not found'
            ], 201);
        }
    }

    public function add(Request $request){
        if(!isset($request->currencyname)||!isset($request->currentvalue)
            ||!isset($request->averageprice))
        {
            return Response::json([
                'message' => 'Incorrect input!'
            ], 201);
        }
        $currency_found = Currency::where('name', '=', $request->currencyname)->get()->count();
        //return $currency_found;
        if($currency_found>0){
            return Response::json([
                'message' => 'Currency already exists!'
            ], 201);
        }
        $cur = new Currency();
        $cur->name = $request->currencyname;
        $cur->stockvalue = $request->currentvalue;
        //$cur->averageprice = $request->averageprice;
        $cur->save();
        $currency_details = new CurrencyDetails();
        $id = Currency::where('name', $request->currencyname)->first()->id;
        $currency_details->crypto_id = $id;
        $currency_details->avg_price = $request->averageprice;
        $currency_details->current_value = $request->currentvalue;
        $currency_details->save();
        return Response::json([
            'message' => 'Currency added successfully'
        ], 200);
    }

    public function changeValue(Request $request){
        if(!isset($request->currencyname)||!isset($request->currentvalue)
            ||!isset($request->averageprice))
        {
            return Response::json([
                'message' => 'Incorrect input!'
            ], 201);
        }
        $currency = Currency::where('name', $request->currencyname)->first();
        $currency->stockvalue = $request->currentvalue;
        $currency->save();
        $id = $currency->id;
        $currency_details = CurrencyDetails::where('crypto_id', $id)->first();
        //return $currency_details;
        $currency_details->current_value = $request->currentvalue;
        $currency_details->avg_price = $request->averageprice;
        $currency_details->save();
        return Response::json([
            'message' => 'Currency updated successfully!'
        ], 200);
    }
}
