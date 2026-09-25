import { render, screen, fireEvent } from '@testing-library/react';
import { describe, it, expect, vi, beforeEach } from 'vitest';
import FormNovaSolicitacao from './FormNovaSolicitacao';
import { Prioridade, Categoria } from '../dtos/SolicitacaoDTO';

describe('FormNovaSolicitacao', () => {

    const alertMock = vi.spyOn(window, 'alert').mockImplementation(() => {});

    beforeEach(() => {
        alertMock.mockClear();
    });

    it('deve exibir um alerta se o nome do solicitante não for preenchido', () => {
        const mockSubmit = vi.fn();
        render(<FormNovaSolicitacao onSubmit={mockSubmit} />);

        const botaoSalvar = screen.getByText('Salvar Solicitação');
        fireEvent.click(botaoSalvar);

        expect(alertMock).toHaveBeenCalledWith('O nome do solicitante é obrigatório.');
        expect(mockSubmit).not.toHaveBeenCalled();
    });

    it('deve exigir justificativa quando a prioridade for URGENTE', () => {
        const mockSubmit = vi.fn();
        render(<FormNovaSolicitacao onSubmit={mockSubmit} />);

        fireEvent.change(screen.getByPlaceholderText('Nome do Solicitante *'), { target: { value: 'João da Silva' } });
        fireEvent.change(screen.getByPlaceholderText('Descrição da solicitação *'), { target: { value: 'Paciente com febre alta' } });

        const selects = screen.getAllByRole('combobox');
        const prioridadeSelect = selects[1]; 
        
        fireEvent.change(prioridadeSelect, { target: { value: Prioridade.URGENTE } });

        const botaoSalvar = screen.getByText('Salvar Solicitação');
        fireEvent.click(botaoSalvar);

        expect(alertMock).toHaveBeenCalledWith('A justificativa é obrigatória para solicitações urgentes.');
        expect(mockSubmit).not.toHaveBeenCalled();
    });

    it('deve chamar onSubmit com os dados corretos no caminho feliz', () => {
        const mockSubmit = vi.fn();
        render(<FormNovaSolicitacao onSubmit={mockSubmit} />);

        fireEvent.change(screen.getByPlaceholderText('Nome do Solicitante *'), { target: { value: 'Maria' } });
        
        const selects = screen.getAllByRole('combobox');
        fireEvent.change(selects[0], { target: { value: Categoria.EXAME } });

        fireEvent.change(screen.getByPlaceholderText('Descrição da solicitação *'), { target: { value: 'Exame de sangue rotina' } });

        const botaoSalvar = screen.getByText('Salvar Solicitação');
        fireEvent.click(botaoSalvar);

        expect(mockSubmit).toHaveBeenCalledTimes(1);
        expect(mockSubmit).toHaveBeenCalledWith(expect.objectContaining({
            nome_solicitante: 'Maria',
            categoria: Categoria.EXAME,
            descricao: 'Exame de sangue rotina',
            prioridade: Prioridade.BAIXA
        }));
    });

    it('deve exibir mensagens de erro de validação vindas da API (validationErrors)', () => {
        const mockSubmit = vi.fn();
        
        const errosDoBackend = {
            nome_solicitante: ['O campo nome do solicitante não pode conter números.'],
            descricao: ['A descrição precisa ter pelo menos 10 caracteres.']
        };

        render(
            <FormNovaSolicitacao 
                onSubmit={mockSubmit} 
                validationErrors={errosDoBackend} 
            />
        );

        expect(screen.getByText('O campo nome do solicitante não pode conter números.')).toBeDefined();
        expect(screen.getByText('A descrição precisa ter pelo menos 10 caracteres.')).toBeDefined();
    });
});