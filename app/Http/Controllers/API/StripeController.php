<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function StripePaymentIntent(Request $request)
    {
        $request->validate(
            [
                'firstname' => 'required|string',
                'lastname' => 'required|string',
                'email' => 'required|email',
                'address' => 'required|string|max:100',
                'postal_code' => 'required|string',
                'city' => 'required|string',
                'state' => 'required|string',
                'country' => 'required|string',
                'amount' => 'required|regex:/^\d+(\.\d{1,2})?$/',
                'currency' => 'required|string',
            ],
            [
                'name.required'      => 'Username is required.',
                'address.required'      => 'Address is required.',
            ]
        );

        \Stripe\Stripe::setApiKey(config('constants.stripe_secret'));

        $results = \Stripe\PaymentIntent::create([
            'amount' => $request->amount * 100,
            'currency' => $request->currency,
            'description' => 'Payment Collected on behalf of travelmaster.ie',
            'shipping' => [
                'name' => $request->firstname .  $request->lastname,
                'address' => [
                    'line1' => $request->address,
                    'postal_code' => $request->postal_code,
                    'city' => $request->city,
                    'state' => $request->state,
                    'country' => $request->country,
                ],
            ],
            'receipt_email' => $request->email
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
                "message" => 'Something went wrong'
            );
        }
        return response()->json($response);
    }
}
