import { useState } from 'react'
import { type SolicitacaoDTO, Status, type CreateSolicitacaoDTO } from '../dtos/SolicitacaoDTO'

const BASE_URL = import.meta.env.VITE_API_BASE_URL;

export function useApi(){

    const [loading, setLoading] = useState(false);
    const [error, setError] = useState<string | null>(null);
    const [validationErrors, setValidationErrors] = useState<Record<string, string[]> | null>(null);

    const request = async <T,>(endpoint:String, options?: RequestInit): Promise<T | null> => {
        
        setLoading(true);
        setError(null);
        setValidationErrors(null);

        try{

            const response = await fetch(`${BASE_URL}${endpoint}`, {
                ...options,
                headers: {
                    'Content-Type': 'application/json',
                    ...options?.headers
                }
            })

            if(!response.ok){

                const errorData = await response.json();

                if (response.status === 422 && errorData.errors) {
                    setValidationErrors(errorData.errors);
                }

                throw new Error(errorData.message || 'Erro na requisição');

            }

            return await response.json();

        }catch(error: any){
            setError(error.message || 'Erro desconhecido da API');
            return null;
        } finally{
            setLoading(false);
        }
    }

    const getSolicitacoes = (page = 1, status = '', categoria = '', prioridade = '') => {
        const params = new URLSearchParams({
            page: String(page),
            ...(status && { status }),
            ...(categoria && { categoria }),
            ...(prioridade && { prioridade })
        });

        return request<{ data: SolicitacaoDTO[], meta: { total: number } }>(`/solicitacoes?${params}`);
    };

    const getSolicitacao = (id: string) => {
        return request<{ data: SolicitacaoDTO }>(`/solicitacoes/${id}`);
    }

    const criarSolicitacao = (data: CreateSolicitacaoDTO) => {
        return request<{ data: SolicitacaoDTO }>(`/solicitacoes`, 
            { 
                method: 'POST',
                body: JSON.stringify(data)
            }
        );
    }

    const atualizarStatus = (id: string, status: Status) => {
        return request<{ data: SolicitacaoDTO }>(`/solicitacoes/${id}/status`,
            {
                method: 'PATCH',
                body: JSON.stringify({ status })
            }
        );
    }

    return {
        loading,
        error,
        validationErrors,
        getSolicitacoes,
        getSolicitacao,
        criarSolicitacao,
        atualizarStatus
    };

}