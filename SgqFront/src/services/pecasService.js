/**
 * src/services/pecasService.js
 * Serviço responsável pelo CRUD de Peças/Itens.
 */

const BASE_URL = import.meta.env.VITE_API_BASE_URL;

// ⚠️ ATENÇÃO: Verifique se o nome do seu controller no CakePHP é 'pecas' ou 'item-master'
// Se a URL for .../pecas/index.json, use 'pecas'.
// Se a URL for .../item-master/index.json, use 'item-master'.
const CONTROLLER = 'item-master'; 

const request = async (endpoint, options = {}) => {
    const url = `${BASE_URL}/${CONTROLLER}${endpoint}`;
    
    const defaultHeaders = {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    };

    const config = {
        ...options,
        headers: { ...defaultHeaders, ...options.headers },
        credentials: 'include',
    };

    try {
        console.log(`[PecasService] Request: ${config.method || 'GET'} ${url}`);
        const response = await fetch(url, config);
        
        let data = {};
        try {
            data = await response.json();
        } catch (e) {
            console.warn("[PecasService] Resposta não é JSON válido.");
        }

        if (!response.ok) {
            console.error("[PecasService] Erro HTTP:", response.status, data);
            const error = new Error(data.message || `Erro HTTP: ${response.status}`);
            error.status = response.status;
            error.body = data;
            throw error;
        }

        return data;
    } catch (error) {
        console.error(`[PecasService] Falha na conexão:`, error);
        throw error;
    }
};

const PecasService = {
    fetchAll: async (params = {}) => {
        // Monta a query string
        const queryParams = new URLSearchParams();
        if (params.page) queryParams.append('page', params.page);
        if (params.pageSize) queryParams.append('limit', params.pageSize);
        if (params.q) queryParams.append('q', params.q);
        if (params.family && params.family !== 'all') queryParams.append('family', params.family);
        if (params.status && params.status !== 'all') queryParams.append('status', params.status);

        const endpoint = `/index.json?${queryParams.toString()}`;
        const rawData = await request(endpoint);

        console.log("[PecasService] Dados brutos recebidos:", rawData);

        // LÓGICA DE RESGATE DE DADOS (Tenta encontrar o array onde quer que ele esteja)
        let list = [];
        
        if (Array.isArray(rawData)) {
            list = rawData;
        } else if (rawData.data && Array.isArray(rawData.data)) {
            list = rawData.data;
        } else if (rawData.items && Array.isArray(rawData.items)) {
            list = rawData.items;
        } else if (rawData.pecas && Array.isArray(rawData.pecas)) {
            list = rawData.pecas;
        } else if (rawData.itemMasters && Array.isArray(rawData.itemMasters)) {
            list = rawData.itemMasters;
        } else {
            // Última tentativa: pega o primeiro valor que for um array dentro do objeto
            const possibleArray = Object.values(rawData).find(val => Array.isArray(val));
            list = possibleArray || [];
        }

        // Tenta achar o total para paginação
        const total = rawData.count || rawData.total || rawData?.pagination?.count || list.length;

        return { data: list, total };
    },

    getById: async (id) => {
        return await request(`/view/${id}.json`);
    },

    create: async (payload) => {
        return await request('/add.json', {
            method: 'POST',
            body: JSON.stringify(payload),
        });
    },

    update: async (id, payload) => {
        return await request(`/edit/${id}.json`, {
            method: 'PUT',
            body: JSON.stringify(payload),
        });
    },

    remove: async (id) => {
        return await request(`/delete/${id}.json`, {
            method: 'DELETE',
        });
    }
};

export default PecasService;