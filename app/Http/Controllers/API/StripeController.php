<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Booking;

use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function StripePaymentIntent(Request $request)
    {
        $request->validate(
            [
                "product_id" => 'required|integer',
                "county_id" => 'required|integer',
                "pickup_id" => 'required|integer',
                "event_id" => 'required|integer',
                "number_of_seats" => 'required|integer',
                'amount' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            ],
            [
                'product_id.required'      => 'Product id is required.',
                'county_id.required'      => 'County id is required.',
                'pickup_id.required'      => 'Point Point id is required.',
                'event_id.required'      => 'Event id is required.',
                'number_of_seats.required'     => 'Number of seats is required.',
                'amount.required'      => 'Amount is required.',
            ]
        );

        \Stripe\Stripe::setApiKey(config('constants.stripe_secret'));

        $results = \Stripe\PaymentIntent::create([
            'amount' => $request->amount * 100,
            'currency' => 'EUR',
            'description' => 'Payment Collected on behalfs of travelmaster.ie',
            'shipping' => [
                'name' => 'Travelmaster',
                'address' => [
                    'line1' => '510 Townsend St',
                    'postal_code' => '98140',
                    'city' => 'San Francisco',
                    'state' => 'CA',
                    'country' => 'US',
                ],
                'phone' => '9977945123',
            ],
            "metadata" => [
                "additional_information" => $request->description,
                'user_id' => $request->user_id,
                "product_id" => $request->product_id,
                "county_id" => $request->county_id,
                "pickup_id" => $request->pickup_id,
                "event_id" => $request->event_id,
                "coupon_id" => $request->coupon_id,
                "newsletter_status" => $request->newsletter_status,
                "number_of_seats" => $request->number_of_seats,
            ],
            'payment_method_types' => ['card'],
        ]);

        if (isset($results) && ($results->status == 'requires_payment_method')) {
            $response = array(
                "status" => 200,
                "message" => 'Payment Intent Created Successfully',
                "client_secret" => $results->client_secret
            );
        } else {
            $response = array(
                "status" => 400,
                "message" => 'Something went wrong..!'
            );
        }
        return response()->json($response);
    }
}
