<?php

namespace App\Http\Controllers;

use App\Models\Truck;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;


class TruckController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): view
    {
        return view('trucks.index', [
            'trucks' => Truck::latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Truck $truck): RedirectResponse
    {
        $validated = $request->validate([
            'unit_number' => 'required|string|max:255',
            'year' => 'required|integer|between:1900,'. date('Y') + 5,
            'notes' => 'nullable|string',
        ]);

        $truck->unit_number = $validated['unit_number'];
        $truck->year = $validated['year'];
        if ($validated['notes'] == !null) {
            $truck->notes = $validated['notes'];
        }
        $truck->save();
 
        return redirect(route('trucks.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Truck $truck)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Truck $truck)
    {
        return view('trucks.edit', [
            'truck' => $truck,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Truck $truck)
    {
        $validated = $request->validate([
            'unit_number' => 'required|string|max:255',
            'year' => 'required|integer|between:1900,'. date('Y') + 5,
            'notes' => 'nullable|string',
        ]);
 
        $truck->unit_number = $validated['unit_number'];
        $truck->year = $validated['year'];
        if ($validated['notes'] == !null) {
            $truck->notes = $validated['notes'];
        } else {
            $truck->notes = '';
        }
        $truck->save();
 
        return redirect(route('trucks.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Truck $truck)
    {
        $truck->delete();
 
        return redirect(route('trucks.index'));
    }
}
