<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{


    public function store(Request $request)
    {
        $request->input('user_id', auth()->id());
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $car = Car::find($validated['car_id']);
        $start_date = new \DateTime($validated['start_date']);
        $end_date = new \DateTime($validated['end_date']);

        return DB::transaction(function () use ($validated, $car, $start_date, $end_date) {
            // Check for overlapping bookings
            $overlappingOrders = Order::where('car_id', $validated['car_id'])
                ->where(function ($query) use ($start_date, $end_date) {
                    $query->where(function ($query) use ($start_date, $end_date) {
                        $query->where('start_date', '<=', $end_date)
                            ->where('end_date', '>=', $start_date);
                    });
                })
                ->exists();

            if ($overlappingOrders) {
                return response()->json(['error' => 'The car is already booked for the selected dates.'], 400);
            }

            $interval = $start_date->diff($end_date);
            $days = $interval->days + 1; // Include the start date

            // Apply discount for rentals longer than 7 days
            $discount = 0;
            $discountMessage = '';
            if ($days > 7) {
                $discount = 0.10; // 10% discount
                $discountMessage = 'A 10% discount has been applied for rentals longer than 7 days.';
            }

            $total_price = $days * $car->price_per_day;
            $total_price -= $total_price * $discount; // Apply discount

            $car->update(['availability_status' => 0]);

            $order = Order::create([
                'user_id' => $validated['user_id'],
                'car_id' => $validated['car_id'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'total_price' => $total_price,
                'payment_status' => 'unpaid',
            ]);

            return response()->json([
                'order' => $order,
                'message' => $discountMessage
            ], 201);
        });
    }

    public function pay($order_id)
    {
        $order = Order::find($order_id);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }
        $order->update(['payment_status' => 'paid']);

        return response()->json($order);
    }

    public function index(Request $request)
    {
        $user_id = $request->input('user_id');
        //eager loading to avoid N+1 problem
        $orders = Order::where('user_id', $user_id)->with('car')->get();

        if ($orders->isEmpty()) {
            return response()->json(['error' => 'No orders found'], 404);
        }

        return response()->json($orders);
    }
}
