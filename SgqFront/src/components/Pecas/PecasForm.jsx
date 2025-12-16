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
      // CORREÇÃO: Lê 'codigo_item' ao abrir edição
      setCode(initial.codigo_item || initial.code || ""); 
      
      setTitle(initial.titulo || initial.title || ""); 
      setDescription(initial.description || initial.descricao || "");
      
      const st = initial.status ?? initial.ativo ?? "active";
      setStatus((st === true || st === 1 || st === 'active') ? "active" : "inactive");
      
      setWeight(initial.weight || initial.peso || "");
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
      // CORREÇÃO: Envia a chave 'codigo_item' para o backend
      codigo_item: code.trim(),
      
      titulo: title.trim(),
      description: description.trim(),
      status: status === "active" ? 1 : 0,
      weight: weight ? parseFloat(weight) : null,
    };

    setSaving(true);
    try {
      await onSave(payload);
    } catch (err) {
      let errorMessage = err?.message || "Erro ao salvar peça.";
      if (err?.body?.message) errorMessage = err.body.message;
      setError(errorMessage);
    } finally {
      setSaving(false);
    }
  }

  const labelClass = "block text-[10px] uppercase font-bold text-slate-500 tracking-wider mb-1.5";
  const inputClass = "w-full bg-slate-950 border border-slate-700 rounded-lg px-3 py-2.5 text-sm text-slate-200 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-600 transition-colors";

  return (
    <div className="fixed inset-0 z-50 flex items-center justify-center p-4">
      <div className="absolute inset-0 bg-slate-950/80 backdrop-blur-sm transition-opacity" onClick={onClose}></div>
      
      <form onSubmit={submit} className="relative bg-slate-900 border border-slate-800 rounded-xl shadow-2xl w-full max-w-2xl overflow-hidden">
        <div className="px-6 py-4 border-b border-slate-800 flex justify-between items-center bg-slate-900">
            <h2 className="text-lg font-bold text-white tracking-tight">
                {initial ? "Editar Item" : "Novo Item"}
            </h2>
            <button type="button" onClick={onClose} className="text-slate-500 hover:text-white">✕</button>
        </div>

        <div className="p-6 space-y-4">
            {error && (
                <div className="p-3 bg-rose-950/30 border border-rose-900/50 rounded-lg text-rose-300 text-sm">
                    {error}
                </div>
            )}

            <div className="grid grid-cols-2 gap-5">
              <div>
                  <label className={labelClass}>Código *</label>
                  <input 
                      value={code} 
                      onChange={(e) => setCode(e.target.value)} 
                      className={`${inputClass} font-mono`}
                      placeholder="Ex: MP-0012"
                      autoFocus 
                  />
              </div>

              <div>
                  <label className={labelClass}>Título</label>
                  <input 
                      value={title} 
                      onChange={(e) => setTitle(e.target.value)} 
                      className={inputClass}
                      placeholder="Nome do item"
                  />
              </div>

              <div className="col-span-2">
                  <label className={labelClass}>Descrição Técnica</label>
                  <textarea 
                      value={description} 
                      onChange={(e) => setDescription(e.target.value)} 
                      className={inputClass} 
                      rows={3} 
                  />
              </div>

              <div>
                  <label className={labelClass}>Peso (kg)</label>
                  <input 
                      value={weight} 
                      onChange={(e) => setWeight(e.target.value)} 
                      className={inputClass} 
                      type="number" step="0.01"
                  />
              </div>

              <div>
                  <label className={labelClass}>Status</label>
                  <select value={status} onChange={(e) => setStatus(e.target.value)} className={inputClass}>
                      <option value="active">Ativo</option>
                      <option value="inactive">Inativo</option>
                  </select>
              </div>
            </div>
        </div>

        <div className="px-6 py-4 bg-slate-950 border-t border-slate-800 flex items-center justify-end gap-3">
          <button type="button" onClick={onClose} className="px-4 py-2 rounded-lg border border-slate-700 text-slate-300 hover:bg-slate-800 text-sm">Cancelar</button>
          <button type="submit" disabled={saving} className="px-6 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-bold shadow-lg">
            {saving ? "Salvando..." : "Salvar"}
          </button>
        </div>
      </form>
    </div>
  );
}