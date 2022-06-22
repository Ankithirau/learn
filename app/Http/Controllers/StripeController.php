<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Session;
use Stripe;
use GuzzleHttp\Client;

class StripeController extends Controller
{
    public function stripePost(Request $request)
    {
        $stripeToken = $this->stripeWithGuzzle($request);
        if ($stripeToken == 'Credit Card Number' || $stripeToken == 'CVC' || $stripeToken == 'Expiration Month' || $stripeToken == 'Expiration Year') {
            return response()->json([
                "status" => 400,
                "message" => $stripeToken . ' is required.'
            ], 200);
        }
        if (!isset($request->amount) || is_null($request->amount)) {
            return response()->json([
                "status" => 400,
                "message" => 'Amount is required.'
            ], 200);
        }


        Stripe\Stripe::setApiKey(config('constants.stripe_secret'));
        $response = Stripe\Charge::create([
            "amount" => $request->amount * 100,
            "currency" => "usd",
            "source" => $stripeToken,
            "description" => "Test payment from Lookyda."
        ]);

        if (isset($response) && ($response->status == 'succeeded')) {
            return response()->json([
                "status" => 200,
                "message" => 'Payment Successful',
                "details" => $response
            ], 200);
        } else {
            return response()->json([
                "status" => 400,
                "message" => 'Something went wrong'
            ], 200);
        }
    }

    public function stripeWithGuzzle($data)
    {
        $client = new \GuzzleHttp\Client();
        $pubKey = config('constants.stripe_key');
        if (!isset($data->card_number) || is_null($data->card_number)) {
            return 'Credit Card Number';
        }
        if (!isset($data->cvc) || is_null($data->cvc)) {
            return 'CVC';
        }
        if (!isset($data->expiration_month) || is_null($data->expiration_month)) {
            return 'Expiration Month';
        }
        if (!isset($data->expiration_year) || is_null($data->expiration_year)) {
            return 'Expiration Year';
        }
        $cardNumber = $data->card_number;
        $cvc = $data->cvc;
        $expMonth = $data->expiration_month;
        $expYear = $data->expiration_year;


        $headers = [
            'Pragma' => 'no-cache',
            'Origin' => 'https://js.stripe.com',
            'Accept-Encoding' => 'gzip, deflate',
            'Accept-Language' => 'en-US,en;q=0.8',
            'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.104 Safari/537.36',
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json',
            'Cache-Control' => 'no-cache',
            'Referer' => 'https://js.stripe.com/v2/channel.html?stripe_xdm_e=http%3A%2F%2Fwww.beanstalk.dev&stripe_xdm_c=default176056&stripe_xdm_p=1',
            'Connection' => 'keep-alive'
        ];
        $postBody = [
            'key' => $pubKey,
            'payment_user_agent' => 'stripe.js/Fbebcbe6',
            'card[number]' => $cardNumber,
            'card[cvc]' => $cvc,
            'card[exp_month]' => $expMonth,
            'card[exp_year]' => $expYear,
        ];

        $response = $client->post('https://api.stripe.com/v1/tokens', [
            'headers' => $headers,
            'form_params' => $postBody
        ]);
        $response = json_decode($response->getbody()->getContents());


        return $response->id;
    }

    public function createPaymentIntent(Request $request)
    {
        // $stripe = new \Stripe\StripeClient(
        //     config('constants.stripe_secret')
        // );

        \Stripe\Stripe::setApiKey(config('constants.stripe_secret'));

        $intent = \Stripe\PaymentIntent::create([
            'amount' => 1099,
            'currency' => 'gbp',
        ]);

        $client_secret = $intent->client_secret;


        return response()->json($intent);
        die();


        $response = $stripe->paymentIntents->confirm(
            $request->clientid,
            ['payment_method' => 'pm_card_visa']
        );

        return response()->json($request);
        $fields = $request->validate([
            'amount' => 'required|integer',
            // 'currency' => 'required|string',
            // 'token' => 'required'

        ]);
        // dd($request);


        try {
            // $stripe = new \Stripe\StripeClient(
            //     'sk_test_51LCegmSH9vE4HJsnYUtv
            //     tNmSn4PJqg0A5qxWzopdM0P9mY2UOTAO6d7X2CzwdE7Hkr9IgtOPaVOBH04XEMyvZOnP00Sb73eoIc'
            // );

            $stripe = Stripe\Stripe::setApiKey(config('constants.stripe_secret'));

            // $result = $stripe->charges->create([
            //     'amount' => $request->amount,
            //     'currency' => $request->currency,
            //     "customer" => $request->token
            // ]);
            // $result = $stripe->charges->create([
            //     "amount" => $request->amount,
            //     "currency" => "usd",
            //     "source" => $request->token,
            //     "description" => "Test payment from Lookyda."
            // ]);
            // $result = Stripe\Charge::create([
            //     "amount" => $request->amount,
            //     "currency" => "usd",
            //     "source" => $request->token,
            //     "description" => "Test payment from Lookyda."
            // ]);

            // $customer = \Stripe\Customer::create([
            //     'name' => 'Jenny Rosen',
            //     'email' => 'jenyy@hotmail.co.us',
            //     'address' => [
            //         'line1' => '510 Townsend St',
            //         'postal_code' => '98140',
            //         'city' => 'San Francisco',
            //         'state' => 'CA',
            //         'country' => 'US',
            //     ],
            // ]);

            // \Stripe\Customer::createSource(
            //     $customer->id,
            //     ['source' => $request->token]
            // );

            // Stripe\Charge::create([
            //     "customer" => $customer->id,
            //     "amount" => 100 * 100,
            //     "currency" => "usd",
            //     "description" => "Test payment from stripe.test.",
            // ]);

            // $result = $stripe->paymentIntent->create([
            //     'amount' => $fields['amount'],
            //     'description' => 'test description',
            //     'currency' => "USD",
            //     'payment_method' => "pm_1LD6TjSH9vE4HJsnAzttzB6G",
            //     'capture_method' => 'manual',
            //     'confirm'        => true,
            //     // 'confirm' => true,
            //     // 'payment_method_types' => ['card'],
            //     // 'metadata' => [
            //     //     'books' => '6735',
            //     // ],
            // ]);
            $result = Stripe\PaymentIntent::create([
                'amount' => 1099,
                'currency' => 'usd',
                'payment_method_types' => ['card'],
                'confirm' => true,
            ]);
            // } catch (Stripe\Exception\InvalidRequestException $e) {
            //     $error = $e;
            // }
        } catch (Stripe\Exception\AuthenticationException $e) {
            $error = $e->getMessage();
        } catch (Stripe\Exception\InvalidArgumentException $e) {
            $error = $e->getMessage();
        } catch (Exception $e) {
            $error = $e->getMessage();
        }

        if (!empty($result)) {

            $response['status'] = 200;

            $response['message'] = 'success';

            $response['data'] = $result;
        } else {

            $response['status'] = 200;

            $response['message'] = 'failure';

            $response['data'] = ($error) ? $error : 'something went wrong';
        }

        return response()->json($response);
    }

    public function ConfirmPayment(Request $request)
    {
        // $stripe = new \Stripe\StripeClient(
        //     config('constants.stripe_secret')
        // );

        // $response = $stripe->paymentIntents->confirm(
        //     $request->clientid,
        //     ['payment_method' => 'pm_card_visa']
        // );
        $stripe = new \Stripe\StripeClient(
            config('constants.stripe_secret')
        );
        $response = $stripe->paymentIntents->confirm(
            $request->clientid,
            ['payment_method' => 'pm_card_visa']
        );

        return response()->json($response);
    }
}
