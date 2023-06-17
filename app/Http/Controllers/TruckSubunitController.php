<?php

namespace App\Http\Controllers;

use App\Models\Truck_subunit;
use App\Models\Truck;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class TruckSubunitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Truck $truck)
    {
        $trucks = Truck::all();

        return view('subunits.create', [
            'truck' => $truck,
            'trucks' => $trucks
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Truck_subunit $truck_subunit, Truck $truck)
    {
        // dump($request->main_truck);
        // die;

        $truck_subunit->main_truck_id = $truck->id;
        $truck_subunit->main_truck = $request->main_truck;
        $truck_subunit->subunit = $request->subunit;
        $truck_subunit->start_date = $request->start_date;
        $truck_subunit->end_date = $request->end_date;
        
        $truck_subunit->save();
 
        return redirect(route('subunits.create', $truck));
    }

    /**
     * Display the specified resource.
     */
    public function show(Truck_subunit $truck_subunit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Truck_subunit $truck_subunit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Truck_subunit $truck_subunit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Truck_subunit $truck_subunit)
    {
        //
    }
}
