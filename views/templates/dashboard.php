<template id="tpl-dashboard">
        <div class="h-full flex flex-col gap-6 overflow-y-auto pr-2 pb-6 max-w-7xl mx-auto">
            <div class="flex justify-between items-end flex-wrap gap-4">
                <div>
                    <h2 class="text-2xl font-black text-slate-800 tracking-tight">Overview</h2>
                    <p class="text-sm text-slate-500 font-medium">Indicadores Operativos (Ãšltimos 30 dÃ­as)</p>
                </div>
                <div class="flex items-center gap-3">
                    <button onclick="window.proyectarPedidosGlobales()" class="bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-bold px-4 py-2 rounded-xl shadow-md transition flex items-center gap-2">
                        <i class="fas fa-chart-line"></i> Proyecciones
                    </button>
                    <div class="bg-white border border-slate-200 p-1.5 rounded-xl shadow-sm flex items-center gap-2">
                        <span class="text-[10px] font-bold text-slate-500 uppercase ml-2"><i class="fas fa-users mr-1"></i> Pax:</span>
                        <div class="flex gap-1 text-[10px]">
                            <div class="flex items-center bg-slate-50 px-2 py-1 rounded-lg border border-slate-100"><span class="text-slate-400 mr-1">Des:</span><input type="number" id="quick-pax-des" class="w-10 text-center font-bold text-slate-700 bg-transparent outline-none"></div>
                            <div class="flex items-center bg-slate-50 px-2 py-1 rounded-lg border border-slate-100"><span class="text-slate-400 mr-1">Alm:</span><input type="number" id="quick-pax-alm" class="w-10 text-center font-bold text-slate-700 bg-transparent outline-none"></div>
                            <div class="flex items-center bg-slate-50 px-2 py-1 rounded-lg border border-slate-100"><span class="text-slate-400 mr-1">Cen:</span><input type="number" id="quick-pax-cen" class="w-10 text-center font-bold text-slate-700 bg-transparent outline-none"></div>
                            <div class="flex items-center bg-slate-50 px-2 py-1 rounded-lg border border-slate-100"><span class="text-slate-400 mr-1">Eve:</span><input type="number" id="quick-pax-eve" class="w-10 text-center font-bold text-slate-700 bg-transparent outline-none"></div>
                        </div>
                        <button onclick="window.guardarPaxRapido()" class="bg-cp-blue hover:bg-cp-blue-hover text-white font-bold px-3 py-1.5 rounded-lg text-[10px] transition shadow-sm"><i class="fas fa-save"></i></button>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center"><i class="fas fa-stopwatch text-2xl text-blue-200"></i></div>
                    <div class="relative z-10">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Ciclo de RequisiciÃ³n</p>
                        <h3 class="text-3xl font-black text-slate-800" id="kpi-ciclo-req">0h</h3>
                        <p class="text-[11px] text-emerald-600 mt-2 font-medium bg-emerald-50 inline-block px-2 py-0.5 rounded-md"><i class="fas fa-check-circle"></i> Prom. CreaciÃ³n a Despacho</p>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-16 h-16 bg-red-50 rounded-full flex items-center justify-center"><i class="fas fa-times-circle text-2xl text-red-200"></i></div>
                    <div class="relative z-10">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Tasa de Rechazo</p>
                        <h3 class="text-3xl font-black text-slate-800" id="kpi-tasa-rechazo">0%</h3>
                        <p class="text-[11px] text-slate-500 mt-2 font-medium">Pedidos devueltos</p>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-16 h-16 bg-amber-50 rounded-full flex items-center justify-center"><i class="fas fa-boxes text-2xl text-amber-200"></i></div>
                    <div class="relative z-10">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Insumos Movidos</p>
                        <h3 class="text-3xl font-black text-slate-800" id="kpi-ins-movidos">0</h3>
                        <p class="text-[11px] text-emerald-600 mt-2 font-medium" id="kpi-ins-trend"><i class="fas fa-arrow-up"></i> 0% vs mes anterior</p>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-16 h-16 bg-emerald-50 rounded-full flex items-center justify-center"><i class="fas fa-dollar-sign text-2xl text-emerald-200"></i></div>
                    <div class="relative z-10">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Costo Operativo Est.</p>
                        <h3 class="text-2xl font-black text-slate-800" id="dash-costo">$0</h3>
                        <p class="text-[11px] text-slate-500 mt-2 font-medium">ValorizaciÃ³n de despachos</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm lg:col-span-2 flex flex-col">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-sm font-bold text-slate-800"><i class="fas fa-chart-line text-cp-blue mr-2"></i>Tendencia de Pedidos (Ãšltimos 7 dÃ­as)</h3>
                    </div>
                    <div class="flex-1 relative w-full min-h-[250px]"><canvas id="chartLineSolicitudes"></canvas></div>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col">
                    <h3 class="text-sm font-bold text-slate-800 mb-4"><i class="fas fa-chart-pie text-cp-gold mr-2"></i>Costos por CategorÃ­a</h3>
                    <div class="flex-1 relative w-full min-h-[250px] flex justify-center items-center"><canvas id="chartCategorias"></canvas></div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                <h3 class="text-sm font-bold text-slate-800 mb-4"><i class="fas fa-fire text-orange-500 mr-2"></i>Top 10 Insumos de Mayor Gasto</h3>
                <div class="overflow-x-auto rounded-xl border border-slate-100">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 text-slate-500 border-b border-slate-200">
                            <tr>
                                <th class="p-3 font-bold uppercase tracking-wider text-[10px]">Producto</th>
                                <th class="p-3 font-bold uppercase tracking-wider text-[10px] text-center">CategorÃ­a</th>
                                <th class="p-3 font-bold uppercase tracking-wider text-[10px] text-center">Unidad</th>
                                <th class="p-3 font-bold uppercase tracking-wider text-[10px] text-right">Cant. Total</th>
                                <th class="p-3 font-bold uppercase tracking-wider text-[10px] text-right">Costo Estimado</th>
                            </tr>
                        </thead>
                        <tbody id="dash-top-costos" class="divide-y divide-slate-100 text-slate-700">
                            <tr><td colspan="5" class="text-center py-6 text-slate-400">Cargando datos...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </template>