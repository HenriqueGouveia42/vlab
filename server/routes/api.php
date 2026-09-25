<?php

use App\Http\Controllers\SolicitacaoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum'); -> resto de templat 

Route::post('/v1/solicitacoes', [SolicitacaoController::class, 'store']);

Route::get('/v1/solicitacoes', [SolicitacaoController::class, 'index']);

Route::get('/v1/solicitacoes/{id}', [SolicitacaoController::class, 'show']);

Route::patch('/v1/solicitacoes/{id}/status', [SolicitacaoController::class, 'updateStatus']);

Route::get('/v1/health', function () {
    try {
        DB::connection()->getPdo();
        
        return response()->json([
            'status' => 'ok',
            'database' => 'connected'
        ], 200);
        
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'database' => 'disconnected',
            'message' => 'Não foi possível ligar à base de dados.'
        ], 500);
    }
});