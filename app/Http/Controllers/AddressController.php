<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Address;
use App\Division;
use App\District;
use App\Upazila;
use Auth;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $address = new Address;
        $address->user_id = Auth::user()->id;
        $address->address = $request->address;
        $address->country = $request->country;
        $address->division = $request->division;
        $address->district = $request->district;
        $address->city = $request->city;
        $address->postal_code = $request->postal_code;
        $address->phone = $request->phone;
        $address->type = $request->type;
        $address->save();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $address = Address::findOrFail($id);
        if(!$address->set_default){
            $address->delete();
            return back();
        }
        flash('Default address can not be deleted')->warning();
        return back();
    }

    public function set_default($id){
        foreach (Auth::user()->addresses as $key => $address) {
            $address->set_default = 0;
            $address->save();
        }
        $address = Address::findOrFail($id);
        $address->set_default = 1;
        $address->save();

        return back();
    }

    public function city_by_region(Request $request){
        // dd(123);
        // dd($request->input());

        $region=Division::where('name',$request->region)->first();

        $city=District::where('division_id',$region->id)->orderBy('name','asc')->get();

        return $city;

    }

    public function area_by_city(Request $request){
        // dd(123);
        // dd($request->input());


        $city=District::where('name',$request->city)->first();
        $area=Upazila::where('district_id',$city->id)->orderBy('name','asc')->get();

        return $area;

    }
}
