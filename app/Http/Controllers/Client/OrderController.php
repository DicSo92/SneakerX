<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\UserOrderMail;
use App\Mail\UserOrderMailAdmin;
use App\Order;
use App\OrdersBillingAddress;
use App\OrdersDeliveryAddress;
use App\OrdersProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        $orderId = $request->query('oId');
//
//        $order = Order::findOrFail($orderId);
//        $order->ordersBillingAddresses;
//        $order->ordersDeliveryAddresses;
//
//        foreach ($order->ordersProducts as $oProduct) {
//            $oProduct->product;
//        }
//
//        return response()->json($order);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'products' => 'required',
            'totalPrice' => 'required',
            'cardNumbers' => 'required',
            'dateExp' => 'required',
            'billingAddress' => 'required',
            'deliveryAddress' => 'required',
        ]);
        $newOrder = new Order();

        $newOrder->totalPrice = $request->get('totalPrice');
        $newOrder->cardNumbers = $request->get('cardNumbers');
        $newOrder->dateExp = $request->get('dateExp');
        $newOrder->email = auth()->user()->email;
        $newOrder->user_id = auth()->user()->id;
        $newOrder->save();

//        --------------------------------------------------------------------------------------------------------------

        $billingAddress = json_decode($request->get('billingAddress'));
        $newBillingAddress = new OrdersBillingAddress();

        $newBillingAddress->firstName = $billingAddress->firstName;
        $newBillingAddress->lastName = $billingAddress->lastName;
        $newBillingAddress->address = $billingAddress->address;
        $newBillingAddress->additionalAddress = $billingAddress->additionalAddress;
        $newBillingAddress->postalCode = $billingAddress->postalCode;
        $newBillingAddress->city = $billingAddress->city;
        $newBillingAddress->country = $billingAddress->country;
        $newBillingAddress->phone = $billingAddress->phone;
        $newBillingAddress->order_id = $newOrder->id;
        $newBillingAddress->save();


        $deliveryAddress = json_decode($request->get('deliveryAddress'));
        $newDeliveryAddress = new OrdersDeliveryAddress();

        $newDeliveryAddress->firstName = $deliveryAddress->firstName;
        $newDeliveryAddress->lastName = $deliveryAddress->lastName;
        $newDeliveryAddress->address = $deliveryAddress->address;
        $newDeliveryAddress->additionalAddress = $deliveryAddress->additionalAddress;
        $newDeliveryAddress->postalCode = $deliveryAddress->postalCode;
        $newDeliveryAddress->city = $deliveryAddress->city;
        $newDeliveryAddress->country = $deliveryAddress->country;
        $newDeliveryAddress->phone = $deliveryAddress->phone;
        $newDeliveryAddress->order_id = $newOrder->id;
        $newDeliveryAddress->save();

//        --------------------------------------------------------------------------------------------------------------

        $cartProducts = json_decode($request->get('products'));

        $ordersProducts = [];
        foreach ($cartProducts as $product) {
            $newOrdersProduct = new OrdersProduct();

            $newOrdersProduct->quantity = $product->total;
            $newOrdersProduct->size = $product->size;
            $newOrdersProduct->color = $product->color->name;
            $newOrdersProduct->product_id = $product->product->id;
            $newOrdersProduct->order_id = $newOrder->id;
            $newOrdersProduct->save();

            array_push($ordersProducts, $newOrdersProduct);
        }

//        --------------------------------------------------------------------------------------------------------------
        $user = [
            'name' => auth()->user()->name,
            'info' => 'Order succesfully created. You will receive your product as soon as possible'
        ];
        $admin = [
            'name' => auth()->user()->email,
            'info' => 'A new order as been made'
        ];

        Mail::to(auth()->user()->email)->send(new UserOrderMail($user));
        Mail::to('luzzi.charly@gmail.com')->send(new UserOrderMailAdmin($admin));

//        --------------------------------------------------------------------------------------------------------------
//        return response()->json([
//            "order" => $newOrder,
//            "ordersProducts" => $ordersProducts,
//            "billingAddress" => $newBillingAddress,
//            "deliveryAddress" => $newDeliveryAddress,
//        ]);
        return response()->json($newOrder->load(['ordersProducts.product', 'ordersBillingAddresses', 'ordersDeliveryAddresses']));
    }

    /**
     * Display the specified resource.
     *
     * @param $orderId
     *
     * @return \Illuminate\Http\Response
     */
    public function show($orderId)
    {
        $orderF = Order::findOrFail($orderId);

        if ($orderF->tempConfirmation) {
            $orderF->tempConfirmation = false;
            $orderF->save();

//            $order = Order::find($orderId)->with(['ordersProducts.product', 'ordersBillingAddresses', 'ordersDeliveryAddresses'])->first();
            $order = Order::where('id', '=', $orderId)->with(['ordersProducts.product', 'ordersBillingAddresses', 'ordersDeliveryAddresses'])->firstOrFail();
            return response()->json($order);
        } else {
            return response()->json(["error" => true, "message" => "Forbidden"], 403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeNoAccount(Request $request)
    {
        $request->validate([
            'products' => 'required',
            'totalPrice' => 'required',
            'cardNumbers' => 'required',
            'dateExp' => 'required',
            'email' => 'required',
            'billingAddress' => 'required',
            'deliveryAddress' => 'required',
        ]);
        $newOrder = new Order();

        $newOrder->totalPrice = $request->get('totalPrice');
        $newOrder->cardNumbers = $request->get('cardNumbers');
        $newOrder->dateExp = $request->get('dateExp');
        $newOrder->email = $request->get('email');
        $newOrder->save();

//        --------------------------------------------------------------------------------------------------------------

        $billingAddress = json_decode($request->get('billingAddress'));
        $newBillingAddress = new OrdersBillingAddress();

        $newBillingAddress->firstName = $billingAddress->firstName;
        $newBillingAddress->lastName = $billingAddress->lastName;
        $newBillingAddress->address = $billingAddress->address;
        $newBillingAddress->additionalAddress = $billingAddress->additionalAddress;
        $newBillingAddress->postalCode = $billingAddress->postalCode;
        $newBillingAddress->city = $billingAddress->city;
        $newBillingAddress->country = $billingAddress->country;
        $newBillingAddress->phone = $billingAddress->phone;
        $newBillingAddress->order_id = $newOrder->id;
        $newBillingAddress->save();


        $deliveryAddress = json_decode($request->get('deliveryAddress'));
        $newDeliveryAddress = new OrdersDeliveryAddress();

        $newDeliveryAddress->firstName = $deliveryAddress->firstName;
        $newDeliveryAddress->lastName = $deliveryAddress->lastName;
        $newDeliveryAddress->address = $deliveryAddress->address;
        $newDeliveryAddress->additionalAddress = $deliveryAddress->additionalAddress;
        $newDeliveryAddress->postalCode = $deliveryAddress->postalCode;
        $newDeliveryAddress->city = $deliveryAddress->city;
        $newDeliveryAddress->country = $deliveryAddress->country;
        $newDeliveryAddress->phone = $deliveryAddress->phone;
        $newDeliveryAddress->order_id = $newOrder->id;
        $newDeliveryAddress->save();

//        --------------------------------------------------------------------------------------------------------------

        $cartProducts = json_decode($request->get('products'));

        $ordersProducts = [];
        foreach ($cartProducts as $product) {
            $newOrdersProduct = new OrdersProduct();

            $newOrdersProduct->quantity = $product->total;
            $newOrdersProduct->size = $product->size;
            $newOrdersProduct->color = $product->color->name;
            $newOrdersProduct->product_id = $product->product->id;
            $newOrdersProduct->order_id = $newOrder->id;
            $newOrdersProduct->save();

            array_push($ordersProducts, $newOrdersProduct);
        }

//        --------------------------------------------------------------------------------------------------------------
        $user = [
            'name' => $request->get('email'),
            'info' => 'Order succesfully created. You will receive your product as soon as possible'
        ];
        $admin = [
            'name' => $request->get('email'),
            'info' => 'A new order as been made'
        ];

        Mail::to($request->get('email'))->send(new UserOrderMail($user));
        Mail::to('luzzi.charly@gmail.com')->send(new UserOrderMailAdmin($admin));

//        --------------------------------------------------------------------------------------------------------------
//        return response()->json([
//            "order" => $newOrder,
//            "ordersProducts" => $ordersProducts,
//            "billingAddress" => $newBillingAddress,
//            "deliveryAddress" => $newDeliveryAddress,
//        ]);
        return response()->json($newOrder->load(['ordersProducts.product', 'ordersBillingAddresses', 'ordersDeliveryAddresses']));
    }
}
