<?php

namespace App\Jobs\Stripewebhooks;

use App\Models\Place;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\WebhookClient\Models\WebhookCall;


class Chargesucceededs implements ShouldQueue
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

        $name = $this->webhookCall->payload['data']['object']['name'];
        $store  = new Place;
        $store->name = $name;
        $store->state_id = 2;
        $store->created_by = "1";
        $store->status = "1";
        $store->save();
        return response()->json(['hello' => $this->webhookCall->payload]);
        // do your work here

        // you can access the payload of the webhook call with `$this->webhookCall->payload`
        // dd($this->webhookCall->payload);
    }
}
