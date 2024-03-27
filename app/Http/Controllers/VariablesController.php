<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Models\Variables;
use Illuminate\Support\Facades\DB;

class VariablesController extends Controller
{

    public function search($id)
    {

        $response = Variables::where('id', $id)->first();

        if (is_null($response)) {
            return response(null, Response::HTTP_OK);
        }

        return response($response->jsonSerialize(), Response::HTTP_OK);
    }

    public function index(Request $request)
    {
        $data = Variables::get();

        return response($data->jsonSerialize(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        //dd($request);

        $entity = Variables::create([
            'name' => $request['name'],
            'defaultvalue' => $request['defaultvalue'],
            'descripcion' => $request['descripcion']
        ]);
        /*$request['name'] = $request->last_name . ' ' . $request->first_name;

        $entity = User::create($request->all());

        $entity->role_name = Role::find($entity->role_id)->name;*/

        return response($entity->jsonSerialize(), Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {

        Variables::where('name', $request['name'])->update([
            'defaultvalue' => $request['defaultvalue'],
            'descripcion' => $request['descripcion']
        ]);

        return response([], Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $entity = Variables::findOrFail($id);
        $entity->delete();

        return response(null, Response::HTTP_OK);
    }
}
