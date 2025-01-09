<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function storeCar(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'price_per_day' => 'required|numeric|min:0',
            'image' => 'required|file|image|mimes:jpeg,png,jpg,svg|max:4096',
        ]);

        // Store image
        $image = $request->file('image');
        $destinationPath = 'images';
        $filename = $image->getClientOriginalName();

        Storage::disk('resources')->putFileAs($destinationPath, $image, $filename);

        $image_url = Storage::disk('resources')->url($destinationPath . '/' . $filename);

        $car = Car::create([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'price_per_day' => $validated['price_per_day'],
            'availability_status' => 1, // Default to available
            'image' => url($image_url),
        ]);

        return response()->json($car, 201);


        //I can resize the image if it's bigger using GD composer package,
        // but I won't do it now because it's not required

    }

    public function markCarForMaintenance($car_id)
    {
        $car = Car::find($car_id);
        if (!$car) {
            return response()->json(['error' => 'Car not found'], 404);
        }

        $car->update(['availability_status' => 2]); // Set status to unavailable for maintenance

        return response()->json($car);
    }
}
