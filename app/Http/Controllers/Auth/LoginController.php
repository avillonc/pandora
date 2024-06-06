<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\MenuItem;
use App\Models\UserSystem;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{

    public function callbackLogin(Request $request)
    {
        $user = Socialite::driver('saml2')->stateless()->user(); //->stateless()

        if (is_null($user)) return redirect($_ENV["APP_URL"] . "/login");

        $id = $user->id;

        $dni = explode("@", $id);

       // dd($user);

        if (isset($dni[0])) {

            $userExists = User::where('dni', $dni[0])
                ->first();
            if ($userExists) {
                if ($userExists->role_id == 1) { //ADMIN
                    $rol = 1;
                } else {
                    // Obtiene ROL de GORIROL
                    //dd($dni[0]);
                    
                    $rol = $this->getUserRol($dni[0]);
                    if (!$rol) {
                        return redirect($_ENV["APP_URL"] . "/app/logout");
                    }
                    $request->session()->put('pidm', $rol[0]['PIDM']);
                    $rol = implode(",", array_column($rol, 'ROL'));
                }

                if ($userExists->datos_actualizados == 0) {
                    User::where('dni', $dni[0])
                        ->update([
                            'name' => ($user->last_name ?? '') . ' ' . ($user->first_name ?? ''),
                            'first_name' => ($user->first_name ?? ''),
                            'last_name' => ($user->last_name ?? ''),
                            'email' => ($user->email ?? ''),
                            'update_data' => 1,
                        ]);
                }
            } else {
                //$userExists = User::where('dni', $dni[0])->first();
                $rol = $this->getUserRol($dni[0]);

                if (!$rol) {
                    return redirect($_ENV["APP_URL"] . "/app/logout");
                }
                $request->session()->put('pidm', $rol[0]['PIDM']);
                $rol = implode(",", array_column($rol, 'ROL'));

                $userExists = User::create([
                    'name' => ($user->last_name ?? '') . ' ' . ($user->first_name ?? ''),
                    'first_name' => ($user->first_name ?? ''),
                    'last_name' => ($user->last_name ?? ''),
                    'email' => ($user->email ?? ''),
                    'update_data' => 1,
                    'dni' => $dni[0]
                ]);
            }

            $request->session()->put('roles', $rol);

            $token = $userExists->createToken("auth_token")->plainTextToken;

            return redirect($_ENV["APP_URL"] . "/login/" . $userExists->dni . "/" . $token);
        }

        return redirect($_ENV["APP_URL"] . "/app/logout");
    }

    public function login(Request $request)
    {

        $userExists = User::where('dni', $request['id'])->first();

        if (is_null($userExists)) {
            return $this->unauthorized($request);
        }

        $token = explode("|", $request['password']);

        if (!isset($token[0])) {
            return $this->unauthorized($request);
        }

        $tokenable = DB::table('personal_access_tokens')
            ->where('id', $token[0])
            ->where('token', hash('sha256', $token[1]))
            ->first();

        if (is_null($tokenable)) return $this->unauthorized($request);

        if ($userExists->id == $tokenable->tokenable_id) {
            auth::guard('web')->loginUsingId($userExists->id);
        } else {
            return $this->unauthorized($request);
        }

        $user = auth::guard('web')->user();

        //$user->role = Role::find($user->role_id)->name;

        //$request->session()->put('pidm', '200946');

        $menu = new MenuItem();

        $response = [
            'token' => $request['password'],
            'user' =>  $user,
            //'menu' => $menu->getItemsByRole($user->role_id)
            'menu' => $menu->getItemsByRole()
        ];

        return response($response, Response::HTTP_OK);
    }


    public function logout(Request $request)
    {

        if (auth()->check()) {
            //$token=explode("|", $request['userToken']);
            //auth()->user()->tokens()->where('id', $token[0])->delete();
            auth()->user()->tokens()->delete();
            auth()->guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }

    public function unauthorized(Request $request)
    {
        //return response()->json(['error' => 'No Autorizado'], 401);
        $response = ['message' => 'No Autorizado'];
        return response($response, Response::HTTP_UNAUTHORIZED);
    }

    public function getUserRol($dni)
    {
        $pdo = DB::connection('oracle')->getPdo();
        $stmt = $pdo->prepare("BEGIN ISIL.SP_ISILNET_GET_ROL_USUARIO(:dni, :cursor); END;");
        $stmt->bindParam(':dni', $dni, \PDO::PARAM_STR);
        $stmt->bindParam(':cursor', $cursor, \PDO::PARAM_STMT | \PDO::PARAM_INPUT_OUTPUT);

        // Ejecutar la llamada al procedimiento almacenado
        $stmt->execute();

        oci_execute($cursor);
        oci_fetch_all($cursor, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        //dd($data);
        //dd($data);
        return  $data;
    }
}
