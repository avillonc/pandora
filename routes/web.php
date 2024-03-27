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
    Route::get('getPrograms', [\App\Http\Controllers\DataController::class, 'getPrograms']);
    Route::post('getMisDatos', [\App\Http\Controllers\DataController::class, 'getMisDatos']);

    Route::post('getPaymentMethods', [\App\Http\Controllers\DataController::class, 'getPaymentMethods']);

    Route::post('getConfiguration', [\App\Http\Controllers\DataController::class, 'getConfiguration']);
    Route::get('getTypeObservation', [\App\Http\Controllers\DataController::class, 'getTypeObservation']);
    Route::get('getTypePaymentsHarson', [\App\Http\Controllers\DataController::class, 'getTypePaymentsHarson']);
    Route::post('getUsers', [\App\Http\Controllers\DataController::class, 'getUsers']);
});

Route::group(['prefix' => 'alumnos', 'middleware' => 'auth:sanctum'], function () {
    Route::post('horarios-nrcs', [\App\Http\Controllers\HorariosController::class, 'getNrcs']);
    Route::post('horarios', [\App\Http\Controllers\HorariosController::class, 'getHorarios']);
    Route::post('datos', [\App\Http\Controllers\BloqueController::class, 'getDatosAlumno']);
    Route::post('bloques-disponibles', [\App\Http\Controllers\BloqueController::class, 'getBloquesDisponibles']);
    Route::post('examenes', [\App\Http\Controllers\ExamenesController::class, 'getExamenes']);
    Route::post('tarifario-disponibles', [\App\Http\Controllers\TarifarioController::class, 'getBloquesDisponibles']);
    Route::post('datos-tarifario', [\App\Http\Controllers\TarifarioController::class, 'getDatosTarifario']);
    Route::post('datos-bolsalaboral', [\App\Http\Controllers\BolsaLaboralController::class, 'getDatosBolsaLaboral']);
    Route::post('cursos', [\App\Http\Controllers\CursosController::class, 'getCursos']);
    Route::post('terminos-condiciones-save', [\App\Http\Controllers\TerminosController::class, 'saveTerminos']);
    Route::post('terminos-validate', [\App\Http\Controllers\TerminosController::class, 'validateTerminos']);
});

Route::group(['prefix' => 'students', 'middleware' => 'auth:sanctum'], function () {
    Route::resource('survey', \App\Http\Controllers\SurveyController::class);
    Route::post('getsurvey', [\App\Http\Controllers\SurveyController::class, 'getSurvey']);
    Route::resource('service', \App\Http\Controllers\ServiceController::class);
    Route::post('getdatos', [\App\Http\Controllers\ServiceController::class, 'getDatosConfirmar']);
    Route::resource('interview', \App\Http\Controllers\InterviewController::class);
    Route::resource('interview-new', \App\Http\Controllers\InterviewNewTeacherController::class);
});

Route::group(['prefix' => 'maintenance', 'middleware' => 'auth:sanctum'], function () {
    Route::resource('variables',   \App\Http\Controllers\VariablesController::class);
    Route::get('variables/{id}', [\App\Http\Controllers\VariablesController::class, 'search']);
});
Route::group(['prefix' => 'minedu', 'middleware' => 'auth:sanctum'], function () {
    Route::post('getegresados', [\App\Http\Controllers\EgresadoController::class, 'rptEgresadosMinisterio']); 
    Route::post('termcode', [\App\Http\Controllers\EgresadoController::class, 'getTermcode']);  
    Route::post('carrerasbynivel', [\App\Http\Controllers\EgresadoController::class, 'getCarreraAllByNivel']); 
    Route::post('get-maestras', [\App\Http\Controllers\EgresadoController::class, 'getMaestras']); 
     
});
Route::get('{any?}', function () {
    return view('application');
})->where('any', '.*');
