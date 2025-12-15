<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Customer;

class StripeController extends Controller
{
    public function createPaymentIntent(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // 1️⃣ Recibir datos del frontend
        $amount     = $request->input('amount', 0);
        $email      = $request->input('email', 'cliente@ejemplo.com');
        $name       = $request->input('name', 'Cliente Invitado');
        $user_id    = $request->input('user_id', 1);
        $product_id = $request->input('product_id', 55);
        $order_id   = $request->input('order_id', 'ORD-' . rand(10000, 99999));

        try {
            // 2️⃣ Buscar si ya existe el cliente en Stripe por correo
            $existing = Customer::all(['email' => $email, 'limit' => 1]);
            $customer = count($existing->data) > 0
                ? $existing->data[0]
                : Customer::create([
                    'name'    => $name,
                    'email'   => $email,
                    'metadata' => ['user_id' => $user_id],
                ]);

            // 3️⃣ Crear PaymentIntent vinculado al cliente
            $paymentIntent = PaymentIntent::create([
                'amount'   => intval($amount * 100), // en centavos
                'currency' => 'mxn',
                'customer' => $customer->id,
                'description' => "Compra del producto #{$product_id}",
                'receipt_email' => $email,
                'metadata' => [
                    'user_id' => $user_id,
                    'product_id' => $product_id,
                    'order_id' => $order_id,
                    'email' => $email,
                    'customer_id' => $customer->id,
                ],
                'automatic_payment_methods' => ['enabled' => true],
            ]);

            // 4️⃣ (Opcional) Guardar una orden localmente (simulada aquí)
            // Order::create([
            //     'user_id' => $user_id,
            //     'product_id' => $product_id,
            //     'amount' => $amount,
            //     'status' => 'pending',
            //     'stripe_payment_intent_id' => $paymentIntent->id,
            //     'email' => $email,
            //     'order_id' => $order_id,
            // ]);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
                'paymentIntentId' => $paymentIntent->id,
                'customerId' => $customer->id,
                'order_id' => $order_id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
