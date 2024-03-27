<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function userbydni($dni)
    {
        
        $response = User::select('dni','name', 'role_id')->where('dni', $dni)->with('role')->first();

        if(is_null($response)) {
          return response(null, Response::HTTP_OK);      
        }
        
        return response($response->jsonSerialize(), Response::HTTP_OK);   
    }

    public function index(Request $request)
    {
        $data = User::listaUsuarios($request);
        
        return response($data->jsonSerialize(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {   
        $request['name'] = $request->last_name.' '.$request->first_name;

        $entity = User::create($request->all());

        $entity->role_name = Role::find($entity->role_id)->name;

        return response($entity->jsonSerialize(), Response::HTTP_OK);   
    }

    public function update(Request $request, $id)
    {

        $entity = User::find($id);
        
        $entity->update($request->all());

        $entity->role_name = Role::find($entity->role_id)->name;

        return response($entity->jsonSerialize(), Response::HTTP_OK);
    }

     public function destroy($id)
    {   
        $entity = User::findOrFail($id);
        $entity->delete();
        
        return response(null, Response::HTTP_OK);
    }

}
