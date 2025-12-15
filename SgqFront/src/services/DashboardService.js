// src/services/DashboardService.js
import NonConformityService from './NonConformityService';

// Simulação de chamadas de API para as outras partes do dashboard para não quebrar a página
const mockDelay = (data) => new Promise(resolve => setTimeout(() => resolve(data), 500));

const DashboardService = {
    /**
     * Busca o resumo (KPIs) do Dashboard
     * Calcula o total de NCs abertas baseadas na lista atual
     */
    fetchSummary: async (filters) => {
        try {
            // 1. Busca todas as NCs usando o serviço existente
            const allNCs = await NonConformityService.getAll();

            // 2. Filtra NCs que são consideradas "Abertas"
            // (Ajuste os status conforme o que você usa no banco: 'Open', 'Investigating', etc.)
            const openNCs = allNCs.filter(nc => {
                const status = nc.status || 'Open';
                // Retorna verdadeiro se o status NÃO for 'Closed' ou 'Encerrada'
                return !['Closed', 'Encerrada', 'Concluido'].includes(status);
            });

            // 3. Retorna o objeto no formato que o DashboardPage espera
            return {
                inspections: 0, // Placeholder
                checklists: 0,  // Placeholder
                openNC: openNCs.length, // ✅ AQUI ESTÁ A LIGAÇÃO DO CONTADOR
                compliance: 100, // Placeholder
                calibOverdue: 0 // Placeholder
            };
        } catch (error) {
            console.error("Erro ao calcular resumo do dashboard:", error);
            return { openNC: 0 };
        }
    },

    // --- Mocks para os outros gráficos (para a página não quebrar) ---
    
    fetchTrends: async () => {
        return mockDelay([
            { label: 'Jan', value: 10 }, { label: 'Fev', value: 15 }, { label: 'Mar', value: 8 }
        ]);
    },

    fetchBreakdown: async () => {
        return mockDelay([
            { label: 'Dimensional', value: 40 }, { label: 'Visual', value: 60 }
        ]);
    },

    fetchRecent: async () => {
        return mockDelay({ data: [], meta: {} });
    }
};

export default DashboardService;