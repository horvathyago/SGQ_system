// src/components/inspection/InspectionPhase.jsx (Estrutura Genérica)

import React, { useState, useEffect } from 'react';
import InspectionService from '../../services/InspectionService';

const InspectionPhase = ({ phaseId, phaseName, inspectionId, checklistTemplateId, onComplete }) => {
    
    const [templateItems, setTemplateItems] = useState([]);
    const [results, setResults] = useState({}); // Estado para armazenar os resultados dos itens
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        // 1. GET: Carregar os Template Items para esta fase
        const fetchItems = async () => {
            setLoading(true);
            try {
                // 💡 Ponto de Extensão: O backend (TemplateItemController) deve aceitar o 'phaseId'
                // para filtrar apenas os itens com o atributo 'grupo' = 'phaseId'
                const items = await InspectionService.getTemplateItems(checklistTemplateId, phaseId);
                setTemplateItems(items);
                // Inicializa o estado de resultados
                const initialResults = items.reduce((acc, item) => ({ 
                    ...acc, 
                    [item.id]: { template_item_id: item.id, result_value: '', is_ok: null } 
                }), {});
                setResults(initialResults);
            } catch (err) {
                console.error(`Erro ao carregar itens da fase ${phaseId}:`, err);
            } finally {
                setLoading(false);
            }
        };

        fetchItems();
    }, [checklistTemplateId, phaseId]);
    
    // ... Lógica para atualizar 'results' conforme o inspetor preenche ...

    const handleSubmitPhase = async () => {
        // 2. Validação: Checar se todos os itens foram preenchidos
        const allFilled = templateItems.every(item => results[item.id] && results[item.id].is_ok !== null);
        
        if (!allFilled) {
            alert("Preencha todos os itens do checklist antes de avançar!");
            return;
        }

        setLoading(true);
        try {
            // 3. POST: Salvar todos os Inspection Items de uma vez (batch)
            const payload = Object.values(results).map(result => ({
                ...result,
                inspection_id: inspectionId
            }));

            await InspectionService.saveInspectionItemResults(payload);
            
            // 4. Conclui a fase e avança
            onComplete(); 

        } catch (error) {
            console.error(`Erro ao salvar resultados da fase ${phaseId}:`, error);
            alert("Erro ao salvar a fase. Tente novamente.");
            setLoading(false);
        }
    };


    if (loading) return <div>Carregando checklist da {phaseName}...</div>;

    return (
        <div className="checklist-form">
            {templateItems.map(item => (
                <div key={item.id} className="checklist-item">
                    <p>Item {item.ordem}: **{item.descricao}**</p>
                    {/* ... Componente de input/radio para registrar o resultado (OK/NOK, valor medido) ... */}
                </div>
            ))}
            
            <button onClick={handleSubmitPhase} disabled={loading}>
                {loading ? 'Salvando...' : `Salvar e Ir para a ${PHASES_LIST.find(p => p.index === PHASES_LIST.find(p => p.id === phaseId).index + 1)?.name}`}
            </button>
        </div>
    );
};

export default InspectionPhase;