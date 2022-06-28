<?php

namespace App\Jobs\Stripewebhooks;

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
        $name = $this->webhookCall->payload['data']['object']['billing_details']['name'];
        $store  = new Place;
        $store->name = $name;
        $store->state_id = "2";
        $store->created_by = "1";
        $store->status = "1";
        $store->save();
        return response()->json(['hellos' => $this->webhookCall->payload]);
    }
}
