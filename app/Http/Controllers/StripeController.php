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
        $fields = $request->validate([
            'amount' => 'required|integer',
            'currency' => 'required|string',
        ]);

        $stripe = new \Stripe\StripeClient(
            config('constants.stripe_secret')
        );

        try {

            $result = $stripe->paymentIntents->create([
                'amount' => $fields['amount'],
                'description' => 'test description',
                'currency' => $fields['currency'],
                'payment_method_types' => ['card'],
                'metadata' => [
                    'books' => '6735',
                ],
            ]);
        } catch (Stripe\Exception\InvalidRequestException $e) {
            $error = "An invalid request occuurred";
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
}
