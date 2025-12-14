import React, { useEffect, useState, useCallback } from "react";
import Sidebar from "../components/Dashboard/Sidebar";
import PecasToolbar from "../components/Pecas/PecasToolbar";
import PecasList from "../components/Pecas/PecasList";
import PecaForm from "../components/Pecas/PecasForm";
import PecasService from "../services/pecasService";

/**
 * PecasPage - versão final corrigida
 *
 * - handleSave: prioriza o recarregamento do servidor (loadPecas) após criação ou edição para garantir a sincronização total da lista e do total.
 * - Se criar e page !== 1: muda para page 1 e recarrega listagem para garantir visibilidade.
 * - Logs para debug (remova em produção).
 */

export default function PecasPage() {
  const [pecas, setPecas] = useState([]);
  const [loading, setLoading] = useState(true);
  const [query, setQuery] = useState("");
  const [filters, setFilters] = useState({ family: "all", status: "all" });
  const [page, setPage] = useState(1);
  const [pageSize] = useState(12);
  const [total, setTotal] = useState(0);

  const [modalOpen, setModalOpen] = useState(false);
  const [editing, setEditing] = useState(null);

  const loadPecas = useCallback(async (opts = {}) => {
    setLoading(true);
    try {
      const params = { q: query, ...filters, page, pageSize, ...opts };
      const res = await PecasService.fetchAll(params);
      const list = res.data ?? [];
      setPecas(list);
      setTotal(typeof res.total === "number" ? res.total : list.length);
    } catch (err) {
      console.error("[PecasPage.loadPecas] Erro ao buscar peças:", err);
      setPecas([]);
      setTotal(0);
    } finally {
      setLoading(false);
    }
  }, [query, filters, page, pageSize]);

  useEffect(() => {
    loadPecas();
  }, [loadPecas]);

  function openCreate() {
    setEditing(null);
    setModalOpen(true);
  }

  function openEdit(peca) {
    setEditing(peca);
    setModalOpen(true);
  }

  // FINAL handleSave robusto e CORRIGIDO
  async function handleSave(pecaPayload) {
    console.debug("[PecasPage.handleSave] called with payload:", pecaPayload, "editing:", editing);
    try {
      if (editing) {
        // --- LÓGICA DE EDIÇÃO ---
        const updated = await PecasService.update(editing.id, pecaPayload);
        console.debug("[PecasPage.handleSave] update result:", updated);
        
        // Atualiza localmente se o objeto retornado for válido
        if (updated && (updated.id || updated.code)) {
          setPecas((prev) => prev.map((p) => (p.id === updated.id || p.code === updated.code ? updated : p)));
        }
        
        // Em caso de dúvida ou falha na atualização local, recarrega
        await loadPecas(); // <--- GARANTE SINCRONIZAÇÃO APÓS EDIÇÃO

      } else {
        // --- LÓGICA DE CRIAÇÃO (CORRIGIDA) ---
        const created = await PecasService.create(pecaPayload);
        console.debug("[PecasPage.handleSave] create result:", created);

        if (!created) {
          // Se a service não retornou item, recarrega a lista e informa, confiando no servidor.
          await loadPecas();
          window.alert("A criação retornou sem dados válidos. A lista foi recarregada para verificar.");
          setModalOpen(false);
          return;
        }

        // 1. Prioriza o recarregamento total para sincronizar a lista e o total
        
        // 2. Se não estamos na primeira página, força a mudança para a página 1 para que o item seja visível.
        if (page !== 1) {
          setPage(1); // O useEffect de 'page' fará o loadPecas
        } else {
          // Se já estamos na página 1, chamamos loadPecas imediatamente para obter o novo item e o total correto.
          await loadPecas(); // <--- CHAVE DA CORREÇÃO PARA CRIAÇÃO NA PÁGINA 1
        }
        
        // A lógica de setPecas/setTotal local foi removida/simplificada para priorizar o loadPecas,
        // garantindo que a fonte de verdade (o servidor) seja sempre consultada após a mutação.
      }

      setModalOpen(false);
    } catch (err) {
      console.error("[PecasPage.handleSave] error:", err);
      window.alert(err?.message || "Erro ao salvar peça. Veja console/Network para detalhes.");
      throw err;
    }
  }

  // DEBUG helper: chama diretamente PecasService.create com payload de exemplo.
  async function directTestCreate() {
    const sample = {
      code: `TEST-${Date.now()}`,
      title: "Teste de criação direta",
      description: "Criação de teste via botão direto",
      status: "active",
      weight: "1.23",
    };
    console.debug("[PecasPage.directTestCreate] payload:", sample);
    try {
      const result = await PecasService.create(sample);
      console.debug("[PecasPage.directTestCreate] result:", result);
      if (result) {
        window.alert("directTestCreate: serviço retornou: " + JSON.stringify(result));
        
        // Recarrega de forma sincronizada, verificando a página atual.
        if (page !== 1) {
            setPage(1);
        } else {
            await loadPecas();
        }

      } else {
        window.alert("directTestCreate: service retornou null (nenhum item criado). Veja console/Network.");
        await loadPecas();
      }
    } catch (err) {
      console.error("[PecasPage.directTestCreate] erro:", err);
      window.alert("directTestCreate error: " + (err?.message || "ver console"));
    }
  }

  async function handleDelete(id) {
    if (!window.confirm("Confirma remoção desta peça? Esta ação é irreversível.")) return;
    try {
      await PecasService.remove(id);
      
      // Ao invés de atualizar o estado local, recarrega do servidor.
      // Isso é mais seguro para lidar com filtros e paginação.
      await loadPecas();

      // Mantenha a lógica de navegação de página, mas remova a atualização local de total/pecas.
      const totalPages = Math.max(1, Math.ceil(Math.max(0, total - 1) / pageSize));
      if (page > totalPages && page > 1) setPage(totalPages);

    } catch (err) {
      console.error("[PecasPage.handleDelete] Erro ao deletar peça:", err);
      window.alert("Erro ao deletar. Verifique o console para detalhes.");
    }
  }

  return (
    <div className="bg-[#071018] min-h-screen text-gray-100">
      <div className="flex p-6">
        <Sidebar />
        <div className="flex-1">
          <div className="flex items-center justify-between mb-6">
            <div>
              <h1 className="text-2xl font-bold">Gerenciamento de Peças</h1>
              <p className="text-sm text-gray-400">Gerencie o cadastro de peças / itens mestres</p>
            </div>

            <div className="flex items-center gap-3">
              <input
                type="search"
                value={query}
                onChange={(e) => {
                  setQuery(e.target.value);
                  setPage(1);
                }}
                placeholder="Buscar por código, título ou descrição..."
                className="bg-[#0f1720] border border-white/5 rounded-md px-3 py-2 text-sm text-gray-300 placeholder-gray-500 focus:ring-red-500 focus:border-red-500"
              />
              <button
                onClick={openCreate}
                className="px-4 py-2 rounded-md bg-gradient-to-br from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 transition-colors text-white font-semibold shadow-md shadow-pink-500/30"
              >
                Nova Peça
              </button>

              <button
                onClick={directTestCreate}
                className="px-3 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white text-sm"
                title="Chama PecasService.create diretamente para testar"
              >
                Testar criação direta
              </button>
            </div>
          </div>

          <div className="bg-[#0f1720] rounded-xl p-4 border border-white/5 shadow mb-6 flex gap-4">
            <div className="w-1/3">
              <label className="text-xs text-gray-400 block mb-1">Família</label>
              <select
                value={filters.family}
                onChange={(e) => setFilters({ ...filters, family: e.target.value })}
                className="w-full bg-transparent border border-white/5 rounded px-3 py-2 text-sm text-gray-300"
              >
                <option value="all">Todas</option>
                <option value="Família A">Família A</option>
                <option value="Família B">Família B</option>
                <option value="Família C">Família C</option>
              </select>
            </div>
            <div className="w-1/3">
              <label className="text-xs text-gray-400 block mb-1">Status</label>
              <select
                value={filters.status}
                onChange={(e) => setFilters({ ...filters, status: e.target.value })}
                className="w-full bg-transparent border border-white/5 rounded px-3 py-2 text-sm text-gray-300"
              >
                <option value="all">Todos</option>
                <option value="active">Ativo</option>
                <option value="inactive">Inativo</option>
              </select>
            </div>
          </div>

          <div className="grid grid-cols-1 gap-4">
            <PecasToolbar
              total={total}
              page={page}
              pageSize={pageSize}
              setPage={setPage}
              loading={loading}
            />

            <PecasList
              data={pecas}
              loading={loading}
              onEdit={openEdit}
              onDelete={handleDelete}
            />
          </div>
        </div>
      </div>

      {modalOpen && (
        <PecaForm
          initial={editing}
          onClose={() => setModalOpen(false)}
          onSave={handleSave}
        />
      )}
    </div>
  );
}