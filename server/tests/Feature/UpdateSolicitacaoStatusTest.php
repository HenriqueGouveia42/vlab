<?php

use App\Models\Solicitacao;
use Illuminate\Foundation\Testing\RefreshDatabase;

// Limpa o banco banco de dados para o teste

// Arrange -> Act -> Assert

uses(RefreshDatabase::class);

test('deve permitir fazer o update do status de RECEBIDA para EM_ANALISE', function () {

    $solicitacao = Solicitacao::factory()->create([
        'status' => 'RECEBIDA'
    ]);

    $response = $this->patchJson("/api/v1/solicitacoes/{$solicitacao->id}/status", [
        'status' => 'EM_ANALISE'
    ]);

    $response->assertStatus(200);

    $this->assertDatabaseHas('solicitacaos', [
        'id' => $solicitacao->id,
        'status' => 'EM_ANALISE'
    ]);


});

test('deve lancar erro ao tentar fazer update do status de RECEBIDA para AGENDADA', function(){

    $solicitacao = Solicitacao::factory()->create([
        'status' => 'RECEBIDA'
    ]);

    $response = $this->patchJson("/api/v1/solicitacoes/{$solicitacao->id}/status", [
        'status' => 'AGENDADA'
    ]);

    $response->assertStatus(400)->assertJsonStructure(['message']);

    $this->assertDatabaseHas('solicitacaos', [
        'id' => $solicitacao->id,
        'status' => 'RECEBIDA' // garante que no banco de dados nada mudou!
    ]);


});

test('deve lancar erro ao tentar criar uma solicitacao de prioridade URGENTE sem justificativa de prioridade', function(){

    $solicitacao = $this->postJson("/api/v1/solicitacoes", [
        'nome_solicitante' => 'Henrique Gouveia',
        'categoria' => 'EXAME',
        'prioridade' => 'URGENTE'

    ]);

    // quem vai lancar esse erro vai ser o FormRequest
    $solicitacao->assertStatus(422)->assertJsonValidationErrors(['justificativa_prioridade']);

});