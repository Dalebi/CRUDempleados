<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Employee;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $model = Employee::paginate(12);

        $user = auth()->user();

        return Inertia::render('User/Index', [
            'database_response' => session('database_response'),
            'EmployeeList' => $model,
            'User' => $user,
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $model = User::where('id',$id)->first();

        //Recover all the Roles with user permissons
        $roles = Role::
            select("rol.id", "rol.name", "mhr.model_id as has_role")
            ->from("roles as rol")
            ->leftJoin("model_has_roles as mhr", function($join) use ($id)
            {
                $join->on("mhr.role_id", "=", "rol.id");
                $join->where("mhr.model_id","=", "$id");
            })
            ->get();

        $Roles = auth()->user()->getRoleNames(); //Roles From User Logged

        return Inertia::render('User/Show', [
            'database_response' => session('database_response'),
            'model' => $model,
            'roles' => $roles,
            'Roles' => $Roles,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $model = User::where('id',$id)->first();

        $roles = Role::
            select("rol.id", "rol.name", "mhr.model_id as has_role")
            ->from("roles as rol")
            ->leftJoin("model_has_roles as mhr", function($join) use ($id)
            {
                $join->on("mhr.role_id", "=", "rol.id");
                $join->where("mhr.model_id","=", "$id");
            })
            ->get();

        return Inertia::render('User/Edit', [
            'database_response' => session('database_response')!=null?session('database_response'):'',
            'model' => $model,
            'roles' => $roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::where('id',$id)->first();

        $prepareRoles = function($obj){
            if($obj['has_role']>0){
                return $obj['name'];
            }
        };

        $roles = array_map($prepareRoles, $request->all());
        $res =    $user->syncRoles($roles);

       // $permissions = $user->getPermissionsViaRoles();
        return to_route('users.edit', $id)->with('database_response','Permisos Actualizados Exitosamente!'); //inertia redirect

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    function all(){//Request $request
        $User =  User::orderBy('name', 'asc')->get()->toArray();
/*
        $User = User::
        select( 'ce.id','internal_id','serial','conc.name as concept','brand.name as brand','model.name as model','processor','memory' )
            ->from("computer_equipments as ce")
            ->leftjoin("lst_concepts as conc", "conc.id", "=", "ce.concept_id")
            ->leftjoin("lst_brands as brand", "brand.id", "=", "ce.brand_id")
            ->leftjoin("lst_models as model", "model.id", "=", "ce.model_id")
            ->get()->toArray();
*/
            foreach($User as $key => $value){
                $User[$key]['id'] = "<a href=\"". route('users.show', $User[$key]['id'] ) ."\">" . $User[$key]['id'] . "</a></b>";
                $User[$key]['name'] = "<b>" . $User[$key]['name'] . "</b>";
            }


    //When the data is the MODEL then it needs to be converted to simple object and formatted with json encode
     $data = new \stdClass();
     $data->data = $User;
    //print_r(json_encode($data));exit;

    return ($data);
    }
}
