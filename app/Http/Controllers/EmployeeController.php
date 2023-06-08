<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use App\Models\Company;
use App\Models\Position;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;



class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $model = Employee::paginate(12);

        $user = auth()->user();

        return Inertia::render('Employee/Index', [
            'databaseResponse' => session('database_response'),
            'EmployeeList' => $model,
            'User' => $user,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        return Inertia::render('Employee/Create', [
           'user' => $user->id,
            'databaseResponse' => session('database_response'),
            'companies' => Company::orderBy('name')->get(),
            'positions' => Position::orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request)
    {
        $data_response = [
            'database_response' => '',
        ];

        $obj = new Employee($request->validated());

        try {
             $obj->save();

        } catch (\Exception $e) {

            $data_response['database_response'] = "Error, algo sucedio con el regitro!";
            return to_route('employees.create')->with($data_response);
        }

        if($obj->employee_id) {
            return redirect()->route('employees.create')->with('database_response','Registro guardado exitosamente!');
        }
        return redirect()->route('employees.create')->with('database_response','Error, Nada que guardar!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $model = Employee::
        select( 'emp.*', "com.name as company", "pos.name as position")
        ->from("employees as emp")
        ->leftjoin("companies as com", "com.id", "=", "emp.company_id"  )
        ->leftjoin("positions as pos", "pos.id", "=", "emp.position_id" )
        ->where('employee_id',$id)->first();

        return Inertia::render('Employee/Show', [
            'databaseResponse' => session('database_response'),
            'model' => $model,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $model = Employee::where('employee_id',$id)->first();

        return Inertia::render('Employee/Edit', [
            'databaseResponse' => session('database_response')!=null?session('database_response'):'',
            'model' => $model,
            'companies' => Company::orderBy('name')->get(),
            'positions' => Position::orderBy('name')->get(),

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id, EmployeeRequest $request)
    {
        $model = Employee::where('employee_id',$id)->first();

        $result = $model->update(array_filter($request->validated()));

        return to_route('employees.edit', $model->employee_id)->with('database_response','Datos Actualizados Exitosamente!'); //inertia redirect

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $model = Employee::where('employee_id',$id)->first();
        $result = $model->delete();

        return to_route('employees.index')->with('database_response','Registro Eliminado Exitosamente!'); //inertia redirect
    }


    function all(){//Request $request
        $employee =  Employee::
        select( 'emp.*', "com.name as company", "pos.name as position")
        ->from("employees as emp")
        ->leftjoin("companies as com", "com.id", "=", "emp.company_id"  )
        ->leftjoin("positions as pos", "pos.id", "=", "emp.position_id" )
        ->get()->toArray();


        foreach($employee as $key => $value){
                $employee[$key]['employee_id'] = "<a href=\"". route('employees.show', $employee[$key]['employee_id'] ) ."\">" . $employee[$key]['employee_id'] . "</a></b>";
                $employee[$key]['name'] = "<b>" . $employee[$key]['name'] . "</b>";
                $employee[$key]['start_at'] = "<b>" . date("Y-m-d", $employee[$key]['start_at']) . "</b>";
            }


    //When the data is the MODEL then it needs to be converted to simple object and formatted with json encode
     $data = new \stdClass();
     $data->data = $employee;
    //print_r(json_encode($data));exit;

    return ($data);
    }
}
