<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Client;
use App\Models\Employee;
use App\Models\LocationEmployee;
use App\Models\State;
use App\Models\Place;
use Illuminate\Http\Request;
use App\Utils\Util;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class APIClientController extends Controller
{
    protected $util;

    public function __construct(Util $util)
    {
        $this->util = $util;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results =  Client::select('clients.*',  'cities.name as city_name', 'places.name as place_name')
            ->join('cities', 'cities.id', '=', 'clients.city_id')
            ->join('places', 'places.id', '=', 'clients.place_id')
            ->get();
        return array('companies' => $results);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    public function getEmployee()
    {
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
    //Update status

    public function status($id)
    {
    }
    //Update kyc status
    public function kycStatus($id)
    {
    }
    public function getEmployeeData($ip, $port, $api_key, $serial_number)
    {
    }
    //Generate Random Password
    public function randomPassword()
    {
    }
}
