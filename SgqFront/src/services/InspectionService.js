/**
 * src/services/InspectionService.js
 * * Serviço responsável por comunicar com as rotas dos Controladores de Inspeção.
 */

// URL base definida no .env (http://localhost:8765)
const BASE_URL = import.meta.env.VITE_API_BASE_URL;

// Função request Helper (copiada e adaptada do UserAccountService para DRY)
const request = async (controllerName, endpoint, options = {}) => {
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
        // 🌟 IMPORTANTE: Garante o envio de Cookies de sessão
        credentials: 'include', 
    };

    try {
        const response = await fetch(`${CONTROLLER_URL}${endpoint}`, config);
        
        let data = {};
        try {
            // Tenta fazer o parse do JSON
            data = await response.json();
        } catch (e) {
            // Se for 204 No Content, não há corpo JSON
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
     * Endpoint: /item-master.json
     */
    getAllItemMasters: async () => {
        const data = await request('item-master', '.json'); 
        return data.itemMaster || []; // Retorna a lista de produtos
    },

    /**
     * [GET] Busca um Item Mestre pelo ID.
     * Endpoint: /item-master/{id}.json
     */
    getItemMasterById: async (id) => {
        const data = await request('item-master', `/${id}.json`);
        return data.itemMaster;
    },

    // =========================================================================
    // CHECKLIST TEMPLATE (Estrutura do Checklist)
    // =========================================================================
    
    /**
     * [GET] Busca um Template de Checklist pelo ID.
     * Endpoint: /checklist-template/{id}.json
     */
    getChecklistTemplate: async (id) => {
        const data = await request('checklist-template', `/${id}.json`);
        return data.checklistTemplate;
    },

    // =========================================================================
    // TEMPLATE ITEM (Os Passos Individuais do Checklist)
    // =========================================================================

    /**
     * [GET] Lista todos os Itens do Template (Passos do Checklist).
     * Nota: Normalmente filtrado por checklist_id
     * Endpoint: /template-item.json?checklist_id=X
     */
    getTemplateItems: async (checklistId) => {
        // Envia o checklistId como query param para o Controller filtrar
        const query = checklistId ? `?checklist_id=${checklistId}` : '';
        const data = await request('template-item', `.json${query}`);
        return data.templateItem || []; // Retorna a lista de passos
    },

    // =========================================================================
    // INSPECTION (Cabeçalho da Inspeção)
    // =========================================================================

    /**
     * [POST] Cria um novo registro de Inspeção.
     * Endpoint: /inspection.json
     * @param {object} inspectionData - { item_master_id, inspector_id, status, etc. }
     */
    createInspection: async (inspectionData) => {
        const data = await request('inspection', '.json', {
            method: 'POST',
            body: JSON.stringify(inspectionData),
        });
        return data.inspection; // Retorna o objeto Inspeção criado
    },

    /**
     * [PATCH] Atualiza o Status da Inspeção (e.g., para 'Concluído').
     * Endpoint: /inspection/{id}.json
     * @param {number|string} id 
     * @param {object} updateData - { status: 'CONCLUIDO', observations: '...' }
     */
    updateInspectionStatus: async (id, updateData) => {
        const data = await request('inspection', `/${id}.json`, {
            method: 'PATCH',
            body: JSON.stringify(updateData),
        });
        return data.inspection;
    },

    // =========================================================================
    // INSPECTION ITEM (Registro dos Resultados do Checklist)
    // =========================================================================

    /**
     * [POST] Salva múltiplos resultados de itens de inspeção.
     * Nota: O backend pode precisar de uma rota de POST customizada para receber um array de InspectionItems.
     * Endpoint: /inspection-item.json
     * @param {array} itemResults - Array de { inspection_id, template_item_id, result_value, is_ok }
     */
    saveInspectionItemResults: async (itemResults) => {
        // Assume que o controlador 'add' pode receber um array (se configurado)
        // Se o seu controlador precisar de um item por vez, este método precisará de um loop.
        return await request('inspection-item', '.json', {
            method: 'POST',
            body: JSON.stringify(itemResults),
        });
        // Retorna a resposta do backend (geralmente status 201)
    }
};

export default InspectionService;