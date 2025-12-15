import React, { useEffect, useState } from "react";

// ✅ 1. ÁREA DE IMPORTS
import Header from "../components/Dashboard/Header";
import Sidebar from "../components/Dashboard/Sidebar";
import KpiCard from "../components/Dashboard/KpiCard";
import TrendChart from "../components/Dashboard/TrendChart";
import BreakdownChart from "../components/Dashboard/BreakdownChart";
import RecentTable from "../components/Dashboard/RecentTable";
import DetailPanel from "../components/Dashboard/DetailPanel";

// ✅ 2. SERVIÇO
import DashboardService from "../services/DashboardService";

export default function DashboardPage() {
  const [summary, setSummary] = useState(null);
  const [trends, setTrends] = useState([]);
  const [breakdown, setBreakdown] = useState([]);
  const [recent, setRecent] = useState({ data: [], meta: {} });
  const [loading, setLoading] = useState(true);
  const [selected, setSelected] = useState(null);
  const [filters, setFilters] = useState({
    period: "30d",
    product: "All",
    line: "All",
    owner: "All",
  });

  useEffect(() => {
    let mounted = true;

    async function loadAll() {
      setLoading(true);
      try {
        if (!DashboardService) {
           throw new Error("DashboardService não encontrado");
        }

        const [sumRes, trendsRes, breakRes, recentRes] = await Promise.all([
          DashboardService.fetchSummary(filters).catch(() => ({})), 
          DashboardService.fetchTrends("inspections", filters).catch(() => []),
          DashboardService.fetchBreakdown("nc_type", filters).catch(() => []),
          DashboardService.fetchRecent("inspections", 1, 10, filters).catch(() => ({ data: [] })),
        ]);

        if (!mounted) return;
        
        setSummary(sumRes || {});
        setTrends(trendsRes || []);
        setBreakdown(breakRes || []);
        setRecent(recentRes || { data: [] });
        
      } catch (err) {
        console.error("Erro carregando dashboard:", err);
        setSummary({});
      } finally {
        if (mounted) setLoading(false);
      }
    }

    loadAll();
    return () => {
      mounted = false;
    };
  }, [filters]);

  function handleApplyFilters(newFilters) {
    setFilters((prev) => ({ ...prev, ...newFilters }));
  }

  return (
    <div className="min-h-screen bg-slate-950 text-slate-200 font-sans">
       {/* Sidebar Fixa */}
       <Sidebar /> 

      <main className="pl-72 w-full transition-all duration-300">
        <div className="max-w-[1600px] mx-auto p-8">
          
          <Header onApplyFilters={handleApplyFilters} filters={filters} />

          <div className="mt-8 space-y-6">
            {/* KPI Grid */}
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
              <KpiCard
                title="Inspeções (30d)"
                value={summary?.inspections ?? "—"}
                icon="clipboard"
                onClick={() => console.log("Filtro: inspections")}
              />
              <KpiCard
                title="Checklists Concluídos"
                value={summary?.checklists ?? "—"}
                icon="check"
                onClick={() => console.log("Filtro: checklists")}
              />
              <KpiCard
                title="NCs Abertas"
                value={loading ? "..." : (summary?.openNC ?? 0)}
                accent="red"
                icon="alert"
                onClick={() => console.log("Filtro: openNC")}
              />
              <KpiCard
                title="Conformidade Global"
                value={summary?.compliance ? `${summary.compliance}%` : "—"}
                accent="green"
                icon="chart"
              />
              <KpiCard
                title="Calibração Vencida"
                value={summary?.calibOverdue ?? "—"}
                accent="yellow"
                icon="clock"
              />
            </div>

            {/* Charts Row */}
            <div className="grid grid-cols-1 lg:grid-cols-3 gap-6 h-auto lg:h-[26rem]">
              <div className="lg:col-span-2 bg-slate-900/50 backdrop-blur-sm rounded-xl border border-slate-800 p-6 flex flex-col shadow-sm">
                <div className="flex justify-between items-center mb-6">
                  <h3 className="text-sm font-semibold text-slate-300 tracking-wide uppercase">
                    Tendência de Qualidade
                  </h3>
                  <span className="text-xs text-slate-500 bg-slate-800 px-2 py-1 rounded">Últimos 30 dias</span>
                </div>
                <div className="flex-1 w-full min-h-0 relative">
                  <TrendChart data={trends} loading={loading} />
                </div>
              </div>

              <div className="grid grid-rows-2 gap-6 h-full">
                <div className="bg-slate-900/50 backdrop-blur-sm rounded-xl border border-slate-800 p-5 flex flex-col relative overflow-hidden shadow-sm">
                  <h4 className="text-xs font-bold text-slate-400 uppercase mb-4 z-10">NCs por Tipo</h4>
                  <div className="flex-1 flex items-center justify-center z-10">
                      <BreakdownChart data={breakdown} type="donut" />
                  </div>
                  <div className="absolute top-0 right-0 w-24 h-24 bg-indigo-500/5 rounded-full blur-2xl -mr-10 -mt-10 pointer-events-none"></div>
                </div>

                <div className="bg-slate-900/50 backdrop-blur-sm rounded-xl border border-slate-800 p-5 flex flex-col shadow-sm">
                   <h4 className="text-xs font-bold text-slate-400 uppercase mb-4">Top Ofensores (Pareto)</h4>
                   <div className="flex-1 flex items-center">
                      <BreakdownChart data={breakdown} type="bars" />
                   </div>
                </div>
              </div>
            </div>

            {/* Recent Activity Row */}
            <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
              <div className="lg:col-span-2 bg-slate-900 border border-slate-800 rounded-xl shadow-sm overflow-hidden flex flex-col">
                <div className="p-5 border-b border-slate-800 flex justify-between items-center bg-slate-900/80">
                  <h3 className="text-sm font-semibold text-slate-300 uppercase tracking-wide">Registro de Atividades</h3>
                  <button className="text-xs text-indigo-400 hover:text-indigo-300 font-medium">Ver todos</button>
                </div>
                <RecentTable data={recent?.data || []} loading={loading} onOpen={(row) => setSelected(row)} />
              </div>

              <div className="h-full">
                <DetailPanel item={selected} />
              </div>
            </div>
          </div>

          {/* Floating Action Button */}
          <button
            className="fixed right-8 bottom-8 group flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white px-5 py-4 rounded-full shadow-[0_8px_30px_rgb(79,70,229,0.3)] transition-all active:scale-95 z-50"
            onClick={() => (window.location.href = "/inspection")}
          >
            <span className="text-2xl leading-none font-light mb-1">+</span>
            <span className="font-semibold text-sm pr-1">Nova Inspeção</span>
          </button>
        </div>
      </main>
    </div>
  );
}