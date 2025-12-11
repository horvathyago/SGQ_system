/**
 * src/services/InspectionService.js
 * * Serviço responsável por comunicar com as rotas dos Controladores de Inspeção.
 */

// URL base definida no .env (http://localhost:8765)
const BASE_URL = import.meta.env.VITE_API_BASE_URL;

/**
 * Helper genérico para fazer as requisições (DRY - Don't Repeat Yourself)
 */
const request = async (controllerName, endpoint, options = {}) => {
    // ... (Função request mantida inalterada)
    const CONTROLLER_URL = `${BASE_URL}/${controllerName}`;
    const defaultHeaders = {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    };

    const config = {
        ...options,
        headers: {
            ...defaultHeaders,
            ...options.headers,
        },
        credentials: 'include', 
    };

    try {
        const response = await fetch(`${CONTROLLER_URL}${endpoint}`, config);
        
        let data = {};
        try {
            data = await response.json();
        } catch (e) {
            // Se não for JSON (ex: 204 No Content), data continua vazio
        }

        if (!response.ok) {
            const errorMessage = data.message || `Erro HTTP: ${response.status} ${response.statusText}`;
            const error = new Error(errorMessage);
            if (response.status === 422 && data.errors) {
                error.validationErrors = data.errors;
            }
            error.status = response.status;
            throw error;
        }

        return data;

    } catch (error) {
        console.error(`Erro na requisição para ${controllerName}${endpoint}:`, error);
        throw error;
    }
};

const InspectionService = {

    // =========================================================================
    // ITEM MASTER (Seleção da Peça/Produto a ser Inspecionado)
    // =========================================================================

    /**
     * [GET] Lista todos os Itens Mestre (Produtos/Peças).
     * Endpoint: /item-master/index.json
     */
    getAllItemMasters: async () => {
        const data = await request('item-master', '/index.json'); 
        
        console.log("API Response Data Bruto (ItemMaster):", data); 
        
        // 🚨 CORREÇÃO CRÍTICA APLICADA: 
        // 1. Verifica se a resposta (data) JÁ É o array puro.
        if (Array.isArray(data)) {
            console.log("Parsing: Sucesso! Resposta JSON é um Array Direto.");
            return data;
        }
        
        // 2. Fallback: Procura pela chave 'itemMaster' dentro do objeto (caso a serialização mude)
        const items = data.itemMaster;

        if (Array.isArray(items)) {
            console.log("Parsing: Sucesso! Array puro de ItemMaster encontrado na chave 'itemMaster'.");
            return items;
        }

        console.warn("Parsing: Falha na extração. A resposta não é um array nem contém a chave 'itemMaster'. Retornando vazio.");
        return []; 
    },

    /**
     * [GET] Busca um Item Mestre pelo ID.
     * Endpoint: /item-master/view/{id}.json
     */
    getItemMasterById: async (id) => {
        const data = await request('item-master', `/view/${id}.json`);
        return data.itemMaster;
    },

    // =========================================================================
    // CHECKLIST TEMPLATE (Estrutura do Checklist)
    // =========================================================================
    
    /**
     * [GET] Busca um Template de Checklist pelo ID.
     * Endpoint: /checklist-template/view/{id}.json
     */
    getChecklistTemplate: async (id) => {
        const data = await request('checklist-template', `/view/${id}.json`);
        return data.checklistTemplate;
    },

    // =========================================================================
    // TEMPLATE ITEM (Os Passos Individuais do Checklist)
    // =========================================================================

    /**
     * [GET] Lista todos os Itens do Template (Passos do Checklist).
     * Endpoint: /template-item/index.json?checklist_id=X&phase_id=Y
     */
    getTemplateItems: async (checklistId, phaseId) => {
        
        let query = '';
        if (checklistId) {
            query += `checklist_id=${checklistId}`;
        }
        if (phaseId) {
            query += `${query ? '&' : ''}phase_id=${phaseId}`;
        }
        
        const endpoint = query ? `/index.json?${query}` : '/index.json';
        
        const data = await request('template-item', endpoint);
        return data.templateItem || []; 
    },

    // =========================================================================
    // INSPECTION (Cabeçalho da Inspeção)
    // =========================================================================

    /**
     * [POST] Cria um novo registro de Inspeção.
     * Endpoint: /inspection/add.json
     */
    createInspection: async (inspectionData) => {
        const data = await request('inspection', '/add.json', {
            method: 'POST',
            body: JSON.stringify(inspectionData),
        });
        return data.inspection || data;
    },

    /**
     * [PATCH] Atualiza o Status da Inspeção (e.g., para 'Concluído').
     * Endpoint: /inspection/edit/{id}.json
     */
    updateInspectionStatus: async (id, updateData) => {
        const data = await request('inspection', `/edit/${id}.json`, {
            method: 'PATCH',
            body: JSON.stringify(updateData),
        });
        return data.inspection || data;
    },

    // =========================================================================
    // INSPECTION ITEM (Registro dos Resultados do Checklist)
    // =========================================================================

    /**
     * [POST] Salva múltiplos resultados de itens de inspeção.
     * Endpoint: /inspection-item/add.json
     */
    saveInspectionItemResults: async (itemResults) => {
        return await request('inspection-item', '/add.json', {
            method: 'POST',
            body: JSON.stringify(itemResults),
        });
    }
};

export default InspectionService;