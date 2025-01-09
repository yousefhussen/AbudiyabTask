<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'sometimes|string',
            'price_min' => 'sometimes|numeric|min:0',
            'price_max' => 'sometimes|numeric|min:0',
            'availability_status' => 'sometimes|boolean',
            'name' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $query = Car::query();

        if ($request->has('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->has('price_min')) {
            $query->where('price_per_day', '>=', $request->input('price_min'));
        }

        if ($request->has('price_max')) {
            $query->where('price_per_day', '<=', $request->input('price_max'));
        }

        if ($request->has('availability_status')) {
            $query->where('availability_status', $request->input('availability_status'));
        }

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        return $query->get();
    }

    public function showImage($filename)
    {
        $path = resource_path('images/' . $filename);

        if (!file_exists($path)) {
            return response()->json(['error' => 'Image not found'], 404);
        }

        return response()->file($path);
    }
}
