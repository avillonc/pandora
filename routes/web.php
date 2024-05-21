<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::prefix('app')->group(function () {
    Route::get('redirect', function () {
        return Socialite::driver('saml2')->redirect();
    });

    Route::get('saml2/metadata', function () {
        return Socialite::driver('saml2')->getServiceProviderMetadata();
    });

    Route::post('saml2/callback', [LoginController::class, 'callbackLogin']);

    Route::get('saml2/logout', function () {
        return Socialite::driver('saml2')->logoutResponse();
    });

    Route::get('logout', function () {
        return Socialite::driver('saml2')->logoutRequest();
    });
});

Route::prefix('auth')->group(function () {

    Route::post('login', [LoginController::class, 'login'])->name("auth.login");
});

Route::group(['prefix' => 'auth', 'middleware' => 'auth:sanctum'], function () {

    Route::post('logout',   [LoginController::class, 'logout']);
});


Route::group(['prefix' => 'data', 'middleware' => 'auth:sanctum'], function () {
    Route::get('termcode', [\App\Http\Controllers\DataController::class, 'getTermcode']);
    Route::post('currentTermCode', [\App\Http\Controllers\DataController::class, 'getCurrentTermCode']);
    Route::post('getUsers', [\App\Http\Controllers\DataController::class, 'getUsers']);
    Route::post('get-maestras', [\App\Http\Controllers\DataController::class, 'getMaestras']); 
});

Route::group(['prefix' => 'programming','middleware' => 'auth:sanctum'], function () {
    Route::resource('appointments', \App\Http\Controllers\AppointmentController::class);
    Route::post('listProgramacionPsicologia', [\App\Http\Controllers\AppointmentController::class, 'listProgramacionPsicologia']); 
    Route::post('programacionHoraria', [\App\Http\Controllers\AppointmentController::class, 'registrarHorario']); 
    Route::post('getCuposDisponibles', [\App\Http\Controllers\AppointmentController::class, 'getCuposDisponibles']); 
    Route::post('listPsicologos', [\App\Http\Controllers\AppointmentController::class, 'listPsicologos']); 
    Route::post('listarCalendario', [\App\Http\Controllers\AppointmentController::class, 'listarCalendario']); 
    Route::post('listCantSesiones', [\App\Http\Controllers\AppointmentController::class, 'listCantSesiones']); 
    Route::post('listAtencionesPaciente', [\App\Http\Controllers\AppointmentController::class, 'listAtencionesPaciente']); 
    Route::post('registrarCita', [\App\Http\Controllers\AppointmentController::class, 'registrarCita']);  
    Route::post('citaPacienteDetalle', [\App\Http\Controllers\AppointmentController::class, 'citaPacienteDetalle']); 
    Route::post('registrarFicha', [\App\Http\Controllers\AppointmentController::class, 'registrarFicha']); 
    Route::post('getFicha', [\App\Http\Controllers\AppointmentController::class, 'getFicha']); 
    Route::post('getCitas', [\App\Http\Controllers\AppointmentController::class, 'getCitas']); 
    Route::post('cancelarCita', [\App\Http\Controllers\AppointmentController::class, 'cancelarCita']); 
    Route::post('getDocumentos', [\App\Http\Controllers\AppointmentController::class, 'getDocumentos']); 
    Route::post('buscarAlumnoxDni', [\App\Http\Controllers\AppointmentController::class, 'buscarAlumnoxDni']);
    Route::post('getInformes', [\App\Http\Controllers\AppointmentController::class, 'getInformes']); 
    Route::post('grabarDocumentos', [\App\Http\Controllers\AppointmentController::class, 'grabarDocumentos']); 
    Route::get('view-document/{file}', [\App\Http\Controllers\AppointmentController::class, 'viewDocument']);
    Route::post('eliminarDocumento', [\App\Http\Controllers\AppointmentController::class, 'eliminarDocumento']); 
    Route::post('registrarInforme', [\App\Http\Controllers\AppointmentController::class, 'registrarInforme']); 
    Route::post('getPaciente', [\App\Http\Controllers\AppointmentController::class, 'getPaciente']);
    Route::post('actualizarDatos', [\App\Http\Controllers\AppointmentController::class, 'actualizarDatos']);
});


Route::get('{any?}', function () {
    return view('application');
})->where('any', '.*');
