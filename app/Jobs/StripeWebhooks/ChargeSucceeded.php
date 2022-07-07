<?php

namespace App\Jobs\Stripewebhooks;

use App\Models\Booking;
use App\Models\Payment;
use App\Mail\newMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\WebhookClient\Models\WebhookCall;


class Chargesucceeded implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var \Spatie\WebhookClient\Models\WebhookCall */

    public $webhookCall;

    public function __construct(WebhookCall $webhookCall)
    {
        $this->webhookCall = $webhookCall;
    }

    public function handle()
    {

        $data = $this->webhookCall->payload['data']['object'];

        $pizza  = $data['billing_details']['name'];

        $pizza = trim($pizza);

        if (strpos($pizza, " ") !== false) {

            $pieces = explode(" ", $pizza);
            $fname = $pieces[0];
            $lname = $pieces[1];
        } else {

            echo $pizza;
        }

        $store = new Booking;
        $store->booking_fname = $fname;
        $store->booking_lname = $lname;
        $store->booking_email = $data['billing_details']['email'];
        $store->users_id = $data['metadata']['user_id'];
        $store->product_id = $data['metadata']['product_id'];
        $store->county_id = $data['metadata']['county_id'];
        $store->pickup_id = $data['metadata']['pickup_id'];
        $store->event_id = $data['metadata']['event_id'];
        $store->booking_phone = $data['billing_details']['phone'];
        $store->booking_info = $data['metadata']['additional_information'];
        $store->booking_date = date("Y-m-d H:i:s");
        $store->fare_amount = $data['amount'];
        $store->total_amount = $data['amount'];
        $store->coupon_id = '1';
        $store->number_of_seats = '1';
        $store->newsletter_status = '1';
        $store->status = "1";
        $store->save();
        $payment = new Payment;
        $payment->transaction_id = $data['balance_transaction'];
        $payment->booking_id = $store->id;
        $payment->user_id = $store->users_id;
        $payment->status = ($this->webhookCall->payload['type'] == "charge.succeeded") ? 4 : 1;
        $payment->amount = $data['amount'];
        $payment->save();
        \Mail::to('topowo5526@jrvps.com')->send(new newMail($store));
        return response()->json(['msg' => 'succeeded']);
    }
}
