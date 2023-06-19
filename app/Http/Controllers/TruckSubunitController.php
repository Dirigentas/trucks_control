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
    
    public function create(Truck $truck): view
    {
        $trucks = Truck::all();

        return view('subunits.create', [
            'truck' => $truck,
            'trucks' => $trucks
        ]);
    }


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

                for ($i = strtotime($oneSubunit->start_date); $i <= strtotime($oneSubunit->end_date); $i += (86400)) {
                    $date = date('Y-m-d', $i);
                    $truckHasSubunitsDatesArray[] = $date;
                };
            };
            $truckHasSubunitsDatesArray = array_unique($truckHasSubunitsDatesArray);

                // Gauname datų masyvą, su datomis iš Form-data intervalo
            $reqDatesArray = [];
        
            for ($i = strtotime($request->start_date); $i <= strtotime($request->end_date); $i += (86400)) {
                $date = date('Y-m-d', $i);
                $requestDatesArray[] = $date;
            };
                // Pridedame validaciją
            if (count(array_intersect($requestDatesArray, $truckHasSubunitsDatesArray))) {
                $validator->errors()->add('start_date', 'Subunit for this date interval already exists');
            }

            // Sprendimas sąlygos punktui: Jei truck’as yra subunit’as kitam truck’ui - jam pačiam tuo laikotarpiu neleistų uždėti subunit’o
            $truckIsSubunit = Truck_subunit::where('subunit', $truck->unit_number)->get();
            $truckIsSubunitDatesArray = [];

            foreach ($truckIsSubunit as $oneSubunit) {
        
                for ($i = strtotime($oneSubunit->start_date); $i <= strtotime($oneSubunit->end_date); $i += (86400)) {
                    $date = date('Y-m-d', $i);
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
}
