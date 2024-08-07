<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;



class StripeController extends Controller
{
    public function stripe(Request $request ){
        $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
        $response =$stripe->checkout->sessions->create([
            'line_items' => [
              [
                'price_data' => [
                  'currency' => 'usd',
                  'product_data' => ['name' => $request->product_name],
                  'unit_amount' => $request->price*100, //In stripe unit amont must be in cents that's why it is multiplied by 100
                  
                ],
                
                'quantity' => $request->quantity,
              ],
            ],
            
            'mode' => 'payment',
            'success_url' => route('success') . '?session_id={CHECKOUT_SESSION_ID}',            // 'success_url' => route('success'),
            'cancel_url' => route('cancel') 
          ]);
        //   dd($response);
          if (isset($response->id) && $response->id != '') {
            session()->put('product_name', $request->product_name);
            session()->put('quantity', $request->quantity);
            session()->put('price', $request->price);
            return redirect($response->url);
        } else {
            return redirect()->route('cancel');
        }
    }


    public function success(Request $request){
        if(isset($request->session_id)){
            $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk')); 
            $response =$stripe->checkout->sessions->retrieve($request->session_id)   ;
            // dd($response);
            $payment= new Payment();
            $payment->payment_id= $response->id;
            $payment->product_name= session()->get('product_name');
            $payment->amount= session()->get('price');
            $payment->quantity= session()->get('quantity');
            $payment->currency= $response->currency;
            $payment->payer_name = $response->customer_details->name;
            $payment->payer_email= $response->customer_details->email;
            $payment->payment_status= $response->status;
            $payment->payment_method= "Stripe";
            $payment->save();
    
            return "payment is successfull";
    
            session()->forget('product_name');
            session()->forget('quantity');
            session()->forget('price');
    
        }
        else{
          $message='payment is successful';
          return view('success')->with(['message'=> $message]);
        }
       

    }
    
    public function cancel(){
      return 'cancel';
    }
}
