<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;

class OrderController extends Controller
{
    //

    public function index()
    {
        $orders = Order::with('orderItems')->paginate();

        return OrderResource::collection($orders);
    }

    public function show($id)
    {
        $order = Order::with('orderItems')->find($id);

        return new OrderResource($order);
    }

    public function export()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="orders.csv"',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0',
            'expires' => '0',
        ];

        $callback = function () {
            $orders = Order::all();
            $file = fopen('php://output', 'w');

            fputcsv($file, ['ID', 'Name', 'Email', 'Product Title', 'Price', 'Quantity']);

            foreach ($orders as $order) {
                fputcsv($file, [$order->id, $order->name, $order->email, $order->description, $order->price, $order->quantity]);

                foreach ($orders as $order) {
                     fputcsv($file, [$order->id, $order->name, $order->email, $order->description, $order->price, $order->quantity]);
                }
            }

            fclose($file);
        };


        return \Response::stream($callback, 200, $headers);
    }
}
