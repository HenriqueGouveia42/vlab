import { useState } from 'react'
import { type SolicitacaoDTO, Status } from '../dtos/SolicitacaoDTO'

const BASE_URL = 'http://localhost:8000/api/v1';

export function useApi(){

    const [loading, setLoading] = useState(false);
    const [error, setError] = useState<string | null>(null);

    const request = async <T,>(endpoint:String, options?: RequestInit): Promise<T | null> => {
        
        setLoading(true);
        setError(null);

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
                throw new Error(errorData.erro || errorData.message ||  'Erro na requisição');

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
            status,
            categoria,
            prioridade
        });

        return request<{data: SolicitacaoDTO[], total: number}>(`/solicitacoes?${params}`);
    };

    const getSolicitacao = (id: string) => {

        request<SolicitacaoDTO>(`/solicitacoes/${id}`);

    }

    const criarSolicitacao = (data: SolicitacaoDTO) => {

        request<SolicitacaoDTO>(`/solicitacoes`, 
            { 
                method: 'POST',
                body: JSON.stringify(data)
            }
        );
    }

    const atualizarStatus = (id:string, status: Status) => {

        request<SolicitacaoDTO>(`/solicitacoes/${id}/status`,
            {
                method: 'PATCH',
                body: JSON.stringify({status})
            }
        )
    }

    return {
        loading,
        error,
        getSolicitacoes,
        getSolicitacao,
        criarSolicitacao,
        atualizarStatus
    };

}