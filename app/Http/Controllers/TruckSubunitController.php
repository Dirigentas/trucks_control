<?php

namespace App\Http\Controllers;

use App\Models\Truck_subunit;
use App\Models\Truck;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

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
    public function create(Truck $truck): view
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
    public function store(Request $request, Truck_subunit $truck_subunit, Truck $truck): RedirectResponse
    {   
         $validator = Validator::make($request->all(), [
            'main_truck' => 'required|string|max:255',
            'subunit' => 'required|string|max:255|different:main_truck',
            'start_date' => 'required|date|',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        // Papildoma validacija
        $validator->after(function ($validator) use ($request, $truck) {
            
            // Sprendimas sąlygos punktui: kad nepersikirstų subunit’ų datos
                // Gauname datų masyvą, su datomis, kuriomis pasirinktas truck'as jau turi Subunit'ą
            $truckHasSubunits = Truck_subunit::where('main_truck_id', $truck->id)->get();
            $truckHasSubunitsDatesArray = [];
            foreach ($truckHasSubunits as $oneSubunit) {
                $startDate = strtotime($oneSubunit->start_date);
                $endDate = strtotime($oneSubunit->end_date);
        
                for ($currentDate = $startDate; $currentDate <= $endDate; $currentDate += (86400)) {
                    $date = date('Y-m-d', $currentDate);
                    $truckHasSubunitsDatesArray[] = $date;
                };
            };
            $truckHasSubunitsDatesArray = array_unique($truckHasSubunitsDatesArray);

                // Gauname datų masyvą, su datomis iš Form-data intervalo
            $reqStartDate = strtotime($request->start_date);
            $reqEndDate = strtotime($request->end_date);
            $reqDatesArray = [];
        
            for ($currentDate = $reqStartDate; $currentDate <= $reqEndDate; $currentDate += (86400)) {
                $date = date('Y-m-d', $currentDate);
                $reqDatesArray[] = $date;
            };
                // Pridedame validaciją
            if (count(array_intersect($reqDatesArray, $truckHasSubunitsDatesArray))) {
                $validator->errors()->add('start_date', 'Subunit for this date interval already exists');
            }

            // Sprendimas sąlygos punktui: Jei truck’as yra subunit’as kitam truck’ui - jam pačiam tuo laikotarpiu neleistų uždėti subunit’o
            $truckIsSubunit = Truck_subunit::where('subunit', $truck->unit_number)->get();
            $truckIsSubunitDatesArray = [];

            foreach ($truckIsSubunit as $oneSubunit) {
                $startDate = strtotime($oneSubunit->start_date);
                $endDate = strtotime($oneSubunit->end_date);
        
                for ($currentDate = $startDate; $currentDate <= $endDate; $currentDate += (86400)) {
                    $date = date('Y-m-d', $currentDate);
                    $truckIsSubunitDatesArray[] = $date;
                };
            };
            $truckIsSubunitDatesArray = array_unique($truckIsSubunitDatesArray);

            // Pridedame validaciją
            if (count(array_intersect($reqDatesArray, $truckIsSubunitDatesArray))) {
                $validator->errors()->add('start_date', 'This truck is already a subunit of other truck');
            }
        });

        if ($validator->fails()) {
                $request->flash();
                return redirect()->back()->withErrors($validator);
            }

        $truck_subunit->main_truck_id = $truck->id;
        $truck_subunit->main_truck = $request->main_truck;
        $truck_subunit->subunit = $request->subunit;
        $truck_subunit->start_date = $request->start_date;
        $truck_subunit->end_date = $request->end_date;
        
        $truck_subunit->save();
 
        return redirect(route('trucks.index', $truck));
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
