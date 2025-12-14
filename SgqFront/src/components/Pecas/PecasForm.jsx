import React, { useState, useEffect } from "react";

export default function PecaForm({ initial = null, onClose = () => {}, onSave = async () => {} }) {
  const [code, setCode] = useState("");
  const [title, setTitle] = useState("");
  const [description, setDescription] = useState("");
  const [status, setStatus] = useState("active");
  const [weight, setWeight] = useState("");
  const [saving, setSaving] = useState(false);
  const [error, setError] = useState("");

  useEffect(() => {
    if (initial) {
      setCode(initial.code ?? "");
      setTitle(initial.title ?? "");
      setDescription(initial.description ?? "");
      setStatus(initial.status ?? "active");
      setWeight(initial.weight ?? "");
    } else {
      setCode("");
      setTitle("");
      setDescription("");
      setStatus("active");
      setWeight("");
    }
  }, [initial]);

  async function submit(e) {
    e.preventDefault();
    setError("");
    if (saving) return;

    if (!code || !code.trim()) {
      setError("O código da peça é obrigatório.");
      return;
    }

    const payload = {
      code: code.trim(),
      title: title.trim(),
      description: description.trim(),
      status,
      weight: weight ? weight : undefined,
    };

    // LOG: garante que o submit está sendo chamado e mostra payload
    console.debug("[PecaForm] submit payload:", payload);

    setSaving(true);
    try {
      await onSave(payload);
      // onSave deve fechar o modal se sucesso
    } catch (err) {
      console.error("Erro ao salvar peça (form):", err);
      
      // 🚨 CORREÇÃO DE TRATAMENTO DE ERRO:
      let errorMessage = err?.message || "Erro ao salvar peça.";
      
      // Verifica se o erro veio do servidor com um corpo (e.g., validação 422)
      if (err?.body?.message) {
          errorMessage = err.body.message;
      } else if (err?.body?.errors?.codigo_item) {
          // Se o erro for de validação do CakePHP no campo 'codigo_item'
          errorMessage = `Código: ${err.body.errors.codigo_item.join(", ")}`;
      } else if (err?.body?.errors && Object.keys(err.body.errors).length > 0) {
          // Captura qualquer outro erro de validação
          const firstField = Object.keys(err.body.errors)[0];
          errorMessage = `${firstField}: ${err.body.errors[firstField][0]}`;
      }
      
      setError(errorMessage);
    } finally {
      setSaving(false);
    }
  }

  return (
    <div className="fixed inset-0 flex items-center justify-center z-50">
      <div className="absolute inset-0 bg-black/60" onClick={onClose}></div>
      <form onSubmit={submit} className="relative bg-[#072022] rounded-lg p-6 w-[720px] z-10">
        <h2 className="text-lg font-semibold mb-4">{initial ? "Editar Peça" : "Nova Peça"}</h2>

        {error && <div className="mb-3 text-sm text-red-400">{error}</div>}

        <div className="grid grid-cols-2 gap-4">
          <div>
            <label className="block text-xs text-gray-400 mb-1">Código *</label>
            <input value={code} onChange={(e) => setCode(e.target.value)} className="w-full bg-transparent border border-white/5 rounded px-3 py-2 text-sm text-gray-200" />
          </div>

          <div>
            <label className="block text-xs text-gray-400 mb-1">Título</label>
            <input value={title} onChange={(e) => setTitle(e.target.value)} className="w-full bg-transparent border border-white/5 rounded px-3 py-2 text-sm text-gray-200" />
          </div>

          <div className="col-span-2">
            <label className="block text-xs text-gray-400 mb-1">Descrição</label>
            <textarea value={description} onChange={(e) => setDescription(e.target.value)} className="w-full bg-transparent border border-white/5 rounded px-3 py-2 text-sm text-gray-200" rows={4} />
          </div>

          <div>
            <label className="block text-xs text-gray-400 mb-1">Peso</label>
            <input value={weight} onChange={(e) => setWeight(e.target.value)} className="w-full bg-transparent border border-white/5 rounded px-3 py-2 text-sm text-gray-200" />
          </div>

          <div>
            <label className="block text-xs text-gray-400 mb-1">Status</label>
            <select value={status} onChange={(e) => setStatus(e.target.value)} className="w-full bg-transparent border border-white/5 rounded px-3 py-2 text-sm text-gray-200">
              <option value="active">Ativo</option>
              <option value="inactive">Inativo</option>
            </select>
          </div>
        </div>

        <div className="mt-6 flex items-center justify-end gap-3">
          <button type="button" onClick={onClose} className="px-4 py-2 rounded bg-gray-700 hover:bg-gray-600 text-white">Cancelar</button>
          <button type="submit" disabled={saving} className="px-4 py-2 rounded bg-gradient-to-br from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 text-white">
            {saving ? "Salvando..." : "Salvar"}
          </button>
        </div>
      </form>
    </div>
  );
}