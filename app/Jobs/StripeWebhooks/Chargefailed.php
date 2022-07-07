<?php

namespace App\Jobs\Stripewebhooks;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\WebhookClient\Models\WebhookCall;

class Chargefailed implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $webhookCall;

    public function __construct(WebhookCall $webhookCall)
    {
        $this->webhookCall = $webhookCall;
    }

    public function handle()
    {

        $data = $this->webhookCall->payload['data']['object'];

        $pizza  = $data['shipping']['name'];

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
        $store->booking_email = $data['metadata']['user_email'];
        $store->booking_phone = $data['shipping']['phone'];
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
        $payment->transaction_id = ($data['balance_transaction']) ? $data['balance_transaction'] : $data['id'];
        $payment->booking_id = $store->id;
        $payment->user_id = $store->users_id;
        $payment->status = ($this->webhookCall->payload['type'] == "charge.failed") ? 3 : 1;
        $payment->amount = $data['amount'];
        $payment->save();

        return response()->json(['msg' => 'succeeded']);
    }
}
