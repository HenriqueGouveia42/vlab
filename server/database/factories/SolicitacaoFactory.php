<?php

namespace Database\Factories;

use App\Models\Solicitacao;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Solicitacao>
 */
class SolicitacaoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome_solicitante' => fake()->name(),
            'categoria' => 'CONSULTA',
            'prioridade' => 'MEDIA',
            'status' => 'RECEBIDA',
            'descricao' => fake()->sentence(),
        ];
    }
}
