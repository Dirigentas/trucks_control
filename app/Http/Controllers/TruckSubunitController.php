<?php

namespace App\Http\Controllers;

use App\Models\Truck_subunit;
use App\Models\Truck;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
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
    public function store(Request $request, Truck_subunit $truck_subunit, Truck $truck): RedirectResponse
    {   
         $validator = Validator::make($request->all(), [
            'main_truck' => 'required|string|max:255',
            'subunit' => 'required|string|max:255|different:main_truck',
            'start_date' => 'required|date|',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $validator->after(function ($validator) use ($request) {
            $subunits = Truck_subunit::all();
            $datesArray = [];
            //
            foreach ($subunits as $oneSubunit) {
                $startDate = strtotime($oneSubunit->start_date);
                $endDate = strtotime($oneSubunit->end_date);
        
                for ($currentDate = $startDate; $currentDate <= $endDate; $currentDate += (86400)) {
                    $date = date('Y-m-d', $currentDate);
                    $datesArray[] = $date;
                };
            };
            $datesArray = array_unique($datesArray);

            $reqStartDate = strtotime($request->start_date);
            $reqEndDate = strtotime($request->end_date);
            $reqDatesArray = [];
        
            for ($currentDate = $reqStartDate; $currentDate <= $reqEndDate; $currentDate += (86400)) {
                $date = date('Y-m-d', $currentDate);
                $reqDatesArray[] = $date;
            };
            //
            if (count(array_intersect($reqDatesArray, $datesArray))) {
                $validator->errors()->add('start_date', 'The date interval is invalid, subunit is already exists');
            }
        });

        if ($validator->fails()) {
                $request->flash();
                return redirect()->back()->withErrors($validator);
            }

        // $validated = $request->validate([
        //     'main_truck' => 'required|string|max:255',
        //     'subunit' => 'required|string|max:255|different:main_truck',
        //     'start_date' => 'required|date|',
        //     'end_date' => 'required|date|after_or_equal:start_date|'. Rule::notIn($datesArray),
        // ]);

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
