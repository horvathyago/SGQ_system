/**
 * src/services/pecasService.js
 */

const BASE_URL = import.meta.env.VITE_API_BASE_URL;
const CONTROLLER = 'item-master'; // Confirme se é 'item-master' ou 'pecas'

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
        const response = await fetch(url, config);
        let data = {};
        try { data = await response.json(); } catch (e) {}

        if (!response.ok) {
            const error = new Error(data.message || `Erro HTTP: ${response.status}`);
            error.status = response.status;
            error.body = data;
            throw error;
        }
        return data;
    } catch (error) {
        console.error(`[PecasService] Falha:`, error);
        throw error;
    }
};

const PecasService = {
    fetchAll: async (params = {}) => {
        const queryParams = new URLSearchParams();
        
        // Passa os parâmetros padrão
        if (params.page) queryParams.append('page', params.page);
        
        // Permite sobrescrever o limite (importante para a busca funcionar)
        if (params.pageSize) queryParams.append('limit', params.pageSize); 
        
        // Parâmetro de busca enviado ao backend (caso ele suporte no futuro)
        if (params.q) {
            queryParams.append('q', params.q);
        }
        
        if (params.family && params.family !== 'all') queryParams.append('family', params.family);
        if (params.status && params.status !== 'all') queryParams.append('status', params.status);

        const endpoint = `/index.json?${queryParams.toString()}`;
        const rawData = await request(endpoint);

        // Identifica onde está a lista no JSON retornado
        let list = [];
        if (Array.isArray(rawData)) {
            list = rawData;
        } else if (rawData.data && Array.isArray(rawData.data)) {
            list = rawData.data;
        } else if (rawData.itemMasters && Array.isArray(rawData.itemMasters)) {
            list = rawData.itemMasters;
        } else {
            const possibleArray = Object.values(rawData).find(val => Array.isArray(val));
            list = possibleArray || [];
        }

        const total = rawData.count || rawData.total || rawData?.pagination?.count || list.length;

        return { data: list, total };
    },

    getById: async (id) => request(`/view/${id}.json`),
    
    create: async (payload) => request('/add.json', {
        method: 'POST',
        body: JSON.stringify(payload),
    }),
    
    update: async (id, payload) => request(`/edit/${id}.json`, {
        method: 'PUT',
        body: JSON.stringify(payload),
    }),
    
    remove: async (id) => request(`/delete/${id}.json`, {
        method: 'DELETE',
    })
};

export default PecasService;