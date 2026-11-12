<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\RazorpayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Razorpay\Api\Errors\Error;

class RazorpayPaymentController extends Controller
{
    public function createOrder(Request $request, RazorpayService $razorpay)
    {
        $validator = Validator::make($request->all(), [
            'amount' => ['required', 'integer', 'min:100'],
            'currency' => ['required', 'string', 'size:3'],
            'receipt' => ['required', 'string', 'max:40'],
        ]);
        if ($validator->fails()) return response()->json(['message' => 'Invalid order details.', 'errors' => $validator->errors()], 400);
        $data = $validator->validated();

        try {
            $result = $razorpay->createOrder(
                $data['amount'],
                strtoupper($data['currency']),
                $data['receipt']
            );
            if (preg_match('/^order_(\d+)$/', $data['receipt'], $matches)) {
                Order::whereKey($matches[1])->where('user_id', $request->user()->id)->update(['razorpay_order_id' => $result['order_id']]);
            }
            return response()->json($result);
        } catch (Error $exception) {
            $status = str_contains(strtolower($exception->getMessage()), 'auth') ? 401 : 500;

            return response()->json(['message' => 'Unable to create Razorpay order.'], $status);
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json(['message' => 'Unable to create Razorpay order.'], 500);
        }
    }

    public function verifyPayment(Request $request, RazorpayService $razorpay)
    {
        $validator = Validator::make($request->all(), [
            'razorpay_order_id' => ['required', 'string'],
            'razorpay_payment_id' => ['required', 'string'],
            'razorpay_signature' => ['required', 'string'],
        ]);
        if ($validator->fails()) return response()->json(['message' => 'Payment details are required.', 'errors' => $validator->errors()], 400);
        $data = $validator->validated();

        if (! $razorpay->verifySignature($data['razorpay_order_id'], $data['razorpay_payment_id'], $data['razorpay_signature'])) {
            return response()->json(['message' => 'Payment signature verification failed.'], 400);
        }

        $order = Order::where('razorpay_order_id', $data['razorpay_order_id'])
            ->where('user_id', $request->user()->id)
            ->with('items')
            ->first();

        if (! $order) {
            return response()->json(['message' => 'Order not found.'], 400);
        }

        if ($order->status !== 'paid') {
            $order->markPaid();
            foreach ($order->items as $item) {
                $item->product()->decrement('stock', $item->quantity);
            }
        }

        $request->session()->forget('cart');

        return response()->json(['success' => true, 'order_id' => $order->id]);
    }
}
