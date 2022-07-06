<?php

namespace App\Jobs\Stripewebhooks;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\WebhookClient\Models\WebhookCall;
use App\Models\Place;
use Illuminate\Support\Facades\Auth;

class Chargesucceeded implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /** @var \Spatie\WebhookClient\Models\WebhookCall */
    public $webhookCall;

    public function __construct(WebhookCall $webhookCall)
    {
        $this->webhookCall = $webhookCall;
    }

    public function handle()
    {
        $data = $this->webhookCall->payload['data']['object'];
        $store = new Booking;
        $store->booking_fname = $data['shipping']['name'];
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
        return response()->json(['msg' => 'succeeded']);
    }
}
