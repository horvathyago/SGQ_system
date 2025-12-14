import React, { useEffect, useState } from 'react';
import InspectionService from '../../services/InspectionService';

const StartPhase = ({ onComplete, user, inspectionData }) => {
    const [loading, setLoading] = useState(false);
    const [loadingLists, setLoadingLists] = useState(true);
    const [error, setError] = useState(null);
    const [validationDetails, setValidationDetails] = useState(null);

    const [checklistTemplates, setChecklistTemplates] = useState([]);
    const [itemMasters, setItemMasters] = useState([]);

    const [selectedChecklistId, setSelectedChecklistId] = useState(inspectionData.checklistTemplateId || '');
    const [selectedItemMasterId, setSelectedItemMasterId] = useState(inspectionData.itemMasterId || '');

    const loadLists = async () => {
        setLoadingLists(true);
        setError(null);
        try {
            const [templates, items] = await Promise.all([
                InspectionService.getAllChecklistTemplates(),
                InspectionService.getAllItemMasters()
            ]);
            setChecklistTemplates(templates || []);
            setItemMasters(items || []);
            if ((!templates || templates.length === 0) && (!items || items.length === 0)) {
                setError('Nenhum checklist nem item mestre retornado pelo servidor.');
            }
        } catch (err) {
            console.error('Erro ao carregar listas para StartPhase:', err);
            // Mostramos info útil ao usuário e logs no console
            const serverInfo = err && err.responseData ? err.responseData : err.message;
            setError('Não foi possível carregar Checklists. Verifique console e tente novamente.');
            console.debug('Detalhe do erro ao carregar Checklists:', serverInfo);
        } finally {
            setLoadingLists(false);
        }
    };

    useEffect(() => {
        loadLists();
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, []);

    const handleStart = async () => {
        setLoading(true);
        setError(null);
        setValidationDetails(null);

        try {
            const payload = {
                checklist_template_id: selectedChecklistId,
                inspector_id: user?.id || null,
                item_master_id: selectedItemMasterId || null,
                origem: 'FRONTEND',
            };

            const created = await InspectionService.createInspection(payload);

            if (!created || !created.id) {
                throw new Error('Resposta inesperada do servidor ao criar inspeção.');
            }

            onComplete({
                inspectionId: created.id,
                checklistTemplateId: selectedChecklistId,
                itemMasterId: selectedItemMasterId || null,
            });
        } catch (err) {
            console.error('Erro ao iniciar inspeção:', err);
            setError(err.message || 'Erro ao iniciar inspeção.');
            if (err.responseData) {
                console.debug('responseData:', err.responseData);
            }
            if (err.validationErrors) {
                setValidationDetails(err.validationErrors);
            }
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="start-phase space-y-4">
            <h2 className="text-xl font-bold text-white">Iniciar Inspeção</h2>

            {loadingLists ? (
                <div className="text-gray-400">Carregando opções...</div>
            ) : (
                <>
                    {error && (
                        <div className="p-3 mb-2 bg-red-900/30 text-red-200 rounded">
                            <div><strong>Erro:</strong> {error}</div>
                            <div className="mt-2 text-sm text-gray-300">Tente recarregar as opções. Se o problema persistir, verifique o servidor (consulte o console para detalhes).</div>
                            <div className="mt-2">
                                <button onClick={loadLists} className="px-3 py-1 bg-gray-700 rounded text-white">Tentar novamente</button>
                            </div>
                        </div>
                    )}

                    <div>
                        <label className="block text-sm text-gray-300 mb-1">Checklist Template</label>
                        <select
                            value={selectedChecklistId}
                            onChange={(e) => setSelectedChecklistId(e.target.value)}
                            className="w-full p-2 rounded bg-gray-900 text-white border border-gray-700"
                        >
                            <option value="">-- Selecione um Checklist --</option>
                            {checklistTemplates.map(t => (
                                <option key={t.id} value={t.id}>
                                    {t.titulo || t.nome || t.name || t.title || (`${t.id}`)}
                                </option>
                            ))}
                        </select>
                    </div>

                    <div>
                        <label className="block text-sm text-gray-300 mb-1">Item Mestre (opcional)</label>
                        <select
                            value={selectedItemMasterId}
                            onChange={(e) => setSelectedItemMasterId(e.target.value)}
                            className="w-full p-2 rounded bg-gray-900 text-white border border-gray-700"
                        >
                            <option value="">-- Selecionar Item Mestre (opcional) --</option>
                            {itemMasters.map(it => (
                                <option key={it.id} value={it.id}>
                                    {it.titulo || it.nome || it.title || it.codigo_item_snapshot || (`${it.id}`)}
                                </option>
                            ))}
                        </select>
                    </div>

                    <div className="flex items-center space-x-2">
                        <button
                            onClick={handleStart}
                            disabled={loading || !selectedChecklistId}
                            className="px-4 py-2 bg-red-600 rounded text-white disabled:opacity-50"
                        >
                            {loading ? 'Iniciando...' : 'Iniciar Inspeção'}
                        </button>
                    </div>
                </>
            )}

            {validationDetails && (
                <div className="p-3 mt-2 bg-yellow-900/20 text-yellow-100 rounded">
                    <strong>Detalhes de validação:</strong>
                    <pre className="text-xs mt-2 overflow-auto" style={{ maxHeight: 200 }}>
                        {JSON.stringify(validationDetails, null, 2)}
                    </pre>
                </div>
            )}
        </div>
    );
};

export default StartPhase;