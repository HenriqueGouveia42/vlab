<?php

use App\Http\Controllers\SolicitacaoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/v1/solicitacoes', [SolicitacaoController::class, 'store']);
