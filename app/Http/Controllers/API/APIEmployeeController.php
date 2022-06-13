<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Validator;
use Illuminate\Http\Request;
use App\Utils\Util;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class APIEmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $util;

    public function __construct(Util $util)
    {
        $this->util = $util;
    }
    public function index($client_id)
    {
        $employees = Employee::where('client_id', $client_id)->get();
        return array('employess' => $employees);
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
        $rules = [];
        $validator = Validator::make(
            $request->all(),
            [
                'company' => 'required',
                'name' => 'required|regex:/^[\pL\s\-]+$/u|min:3|max:25',
                'mobile' => 'required|numeric|digits:10',
                'EmployeeCode' => 'required|unique:employees',
                'password' => [
                    'required',
                    'string',
                    'confirmed',
                    'min:10',             // must be at least 10 characters in length
                    'regex:/[a-z]/',      // must contain at least one lowercase letter
                    'regex:/[A-Z]/',      // must contain at least one uppercase letter
                    'regex:/[0-9]/',      // must contain at least one digit
                    'regex:/[@$!%*#?&]/', // must contain a special character
                ]
            ],
            [
                'password.regex' => 'Password should be at least 10 characters, contain upper case, lower case, numbers and special characters (!@£$%^&)',
                'email.ends_with' => 'Enter Email id ending with @wiespl.com only'
            ]
        );
        if ($validator->fails()) {
            $errors = [];
            foreach ($validator->errors()->messages() as $key => $value) {
                if ($key == 'EmployeeCode' || $key == 'password') {
                    $key = 'msg';
                    $result = array("status" =>  200, 'msg' => is_array($value) ? implode(',', $value) : $value);
                    return $result;
                } else {
                    $errors[$key] = is_array($value) ? implode(',', $value) : $value;
                }
                //implode is for when you have multiple errors for a same key
                //like email should valid as well as unique
            }
            $result = array("status" => count($errors) ? 422 : 200, 'data' => $errors);
            return $result;
        }
        try {
            $store  = new Employee();
            $store->client_id = $request->company;
            $store->name = $request->name;
            $store->email = $request->email;
            $store->mobile = $request->mobile;
            $store->EmployeeCode = $request->EmployeeCode;
            $store->password = Hash::make($request->password);
            $store->created_by = 1;
            $store->save();
            $employee['company'] = $store->client_id;
            $employee['EmployeeCode'] = $store->EmployeeCode;
            $employee['name'] = $store->name;
            $employee['email'] = $store->email;
            $employee['mobile'] = $store->mobile;
            $employee['kyc_status'] = $store->kyc_status;
            $employee['kyc_date'] = $store->kyc_date;
            $token = $store->createToken('mytoken');
            $response = array('status' => 200, 'msg' => 'Employee created successfully...!', 'employee' => $employee, 'token' => $token->plainTextToken);
        } catch (\Throwable $th) {
            $response = array('status' => 500, 'msg' => 'Something went wrong...!');
        }
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Employee::find($id);
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
        try {
            $update  = User::find($id);
            $update->name = $request->name;
            $update->email = $request->email;
            $update->mobile = $request->mobile;
            $update->kyc_status = ($request->kyc_status) ? $request->kyc_status : 0;
            $update->save();
            DB::commit();
            $response = array('status' => 200, 'msg' => 'Employee profile updated successfully');
        } catch (\Throwable $th) {
            $response = array('status' => 500, 'msg' => 'Something went wrong...!');
        }
        return json_encode($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    //Login Employee
    public function doLogin(Request $request)
    {
        $request->validate(
            [
                'company' => 'required',
                'EmployeeCode' => 'required',
                'password' => 'required|min:8'
            ]
        );

        try {
            $employee  = Employee::where(['EmployeeCode' => $request->EmployeeCode, 'client_id' => $request->company])->first();
            if ($employee) {
                if (Hash::check($request->password, $employee->password)) {
                    $token = $employee->createToken('mytoken');
                    $response = array('status' => 200, 'employee' => $employee, 'token' => $token->plainTextToken);
                } else {
                    $response = array('status' => 500, 'msg' => 'Invalid password!');
                }
            } else {
                $response = array('status' => 500, 'msg' => "Employee not exist...!");
            }
        } catch (\Throwable $th) {
            $response = array('status' => 500, 'msg' => 'Something went wrong...!');
        }
        return $response;
    }
    //Logout function
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return array('status' => 200, 'token' => 'Destroy successfully');
    }
    //Update password
    public function update_password(Request $request, $id)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => [
                'required',
                'string',
                'confirmed',
                'min:8',             // must be at least 10 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],
        ], ['password.regex' => 'Password should be at least 10 characters, contain upper case, lower case, numbers and special characters (!@£$%^&)']);
        try {
            $update  = Employee::find($id);
            if ($update) {
                if (Hash::check($request->current_password, $update->password)) {
                    $update->password = Hash::make($request->password);
                    $update->save();
                    $response = array('status' => 200, 'msg' => 'Password changed successfully...!');
                } else {
                    $response = array('status' => 500, 'msg' => 'Invalid current password!');
                }
            } else {
                $response = array('status' => 500, 'msg' => "User not exist...!");
            }
        } catch (\Throwable $th) {
            $response = array('status' => 500, 'msg' => 'Something went wrong...!');
        }

        return json_encode($response);
    }

    //Get Employees Log
    public function employees_log_list($prefix)
    {
        $log_list = DB::connection('mysql2')->table("zenon_$prefix")->get();
        $response = array('status' => 200, 'result' => $log_list);
        return $response;
    }
    //Get Employee Log
    public function employee_log($prefix, $empid)
    {
        $employee_log = DB::connection('mysql2')->table("zenon_$prefix")->where('empid', $empid)->get();
        $response = array('status' => 200, 'result' => $employee_log);
        return $response;
    }

    //Get Employee Log filter
    public function employee_log_filter(Request $request, $prefix, $empid)
    {
        $startDate = $request->start_date . " 00:00:00";
        $endDate = $request->end_date . " 23:59:59";
        $employee_log = DB::connection('mysql2')->table("zenon_$prefix")->where('empid', $empid)->whereBetween('logdt', [$startDate, $endDate])
            ->select("empid", DB::connection('mysql2')->raw('MIN(logdt) as check_in'), DB::connection('mysql2')->raw('MAX(logdt) as check_out'))
            ->groupBy("empname")
            ->groupBy(DB::connection('mysql2')->raw('DATE(logdt)'))
            ->get();
        $response = array('status' => 200, 'result' => $employee_log);
        return $response;
    }

    //Update profile image
    public function update_image(Request $request, $id)
    {
        $request->validate([
            'kyc_status' => 'required',
            'kyc_date' => 'required'
        ]);
        try {
            $update  = Employee::find($id);
            $update->kyc_status = $request->kyc_status;
            $update->kyc_date = $request->kyc_date;
            if ($request->hasFile('image')) {
                ($update->image) ? $this->util->unlinkFile($update->image) : null;
                $update->image = $this->util->uploadFile($request->image);
            }
            $update->save();
            DB::commit();
            $response = array('status' => 200, 'msg' => 'Employee profile updated successfully', 'profile_image' => $update->image);
        } catch (\Throwable $th) {
            $response = array('status' => 500, 'msg' => 'Something went wrong...!');
        }
        return $response;
    }
}
