<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\ViewErrorBag;

class BidPayController extends Controller
{
    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel()
    {
        return redirect("/")->with("error", _i("Your payment is canceled"));
    }

    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function success(Request $request)
    {
        // $provider = new PayPalClient();
        // $config = config("paypal");
        // $provider->setApiCredentials($config);
        // //  $provider->setAccessToken($request->query("token"));
        // $provider->getAccessToken();
        // $res = $provider->capturePaymentOrder($request->query("id"));
        // dd($res);
       try {
            $trans = new \App\Transaction();
            $trans->getBid();
            $transaction = $trans->getTransaction();
            $date = Carbon::make($transaction->GetAccepted()->created_at);
            $date->addDays($transaction->Bid()->first()->duration);
            return view("payment.bid.success", compact("transaction", "date"));
        } catch (Exception $ex) {
            $errors = new \Illuminate\Support\MessageBag();
            // add your error messages:
            $errors->add('Exc', $ex->getMessage());
            return view("website.error")->withErrors($errors);;
        }
    }
}
