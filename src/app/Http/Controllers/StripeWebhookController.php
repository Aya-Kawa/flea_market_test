<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Stripe\Stripe;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    /**
     * Handle incoming Stripe webhooks.
     * Verifies signature, handles events and creates Purchase on completed checkout.
     */
    public function __invoke(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');
        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (\UnexpectedValueException $e) {
            return response('Invalid payload', 400);
        } catch (SignatureVerificationException $e) {
            return response('Invalid signature', 400);
        }
        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            $metadata = $session->metadata;
            DB::transaction(function () use ($metadata) {
                if (Purchase::where('item_id', $metadata->item_id)->exists()) {
                    return;
                }
                Purchase::create([
                    'item_id' => $metadata->item_id,
                    'user_id' => $metadata->user_id,
                    'payment_method' => $metadata->payment_method,
                    'postal_code' => $metadata->postal_code,
                    'address' => $metadata->address,
                    'building' => $metadata->building ?: null,
                ]);
            });
        }
        return response('OK', 200);
    }
}