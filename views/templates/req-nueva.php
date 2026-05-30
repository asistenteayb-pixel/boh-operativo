<template id="tpl-req-nueva">
        <div class="h-full flex flex-col bg-white border border-slate-200 rounded-2xl shadow-sm max-w-7xl mx-auto relative overflow-hidden">
            <!-- HEADER ROW (Title + Selection Mode) -->
            <div class="px-4 py-2.5 border-b border-slate-100 bg-white flex flex-col sm:flex-row gap-2 justify-between items-center z-10 relative">
                <div class="flex items-center gap-2">
                    <i class="fas fa-paper-plane text-cp-gold text-base"></i>
                    <div>
                        <h3 class="font-black text-sm text-slate-800 uppercase tracking-tight">SOLICITUD DE INSUMOS COCINA</h3>
                        <p class="text-[9px] text-slate-400 font-bold">FAYB-98 V:01 16/10/2025</p>
                    </div>
                </div>
                
                <!-- Modo de SelecciÃ³n -->
                <div class="flex items-center gap-2">
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider"><i class="fas fa-list-ul text-cp-blue mr-1"></i> Modo:</span>
                    <div class="flex bg-slate-100 p-0.5 rounded-lg text-[10px] font-bold border border-slate-200 shadow-sm">
                        <button type="button" id="btn-modo-cat" class="px-2.5 py-1 rounded bg-white text-slate-700 shadow-sm transition" onclick="window.setModoRequisicion('cat')">CatÃ¡logo</button>
                        <button type="button" id="btn-modo-blanco" class="px-2.5 py-1 rounded text-slate-500 hover:text-slate-700 transition" onclick="window.setModoRequisicion('blanco')">Lista en Blanco</button>
                    </div>
                    <input type="hidden" id="inp-modo-req" value="cat">
                </div>
            </div>

            <!-- FILTERS ROW (EstaciÃ³n, Servicio, PAX) -->
            <div class="p-2 border-b border-slate-200 bg-slate-50/50 grid grid-cols-1 sm:grid-cols-3 gap-2 z-10">
                <!-- EstaciÃ³n select -->
                <div class="flex items-center gap-2 bg-white px-2.5 py-1 rounded-xl border border-slate-200 shadow-inner">
                    <label class="text-[9px] font-bold text-slate-400 uppercase whitespace-nowrap"><i class="fas fa-boxes text-slate-400"></i> EstaciÃ³n:</label>
                    <select id="inp-estacion" class="w-full text-xs font-bold text-slate-700 bg-transparent outline-none border-none cursor-pointer">
                        <option value="General">General</option>
                        <option value="Desayuno">Desayuno</option>
                        <option value="Piso 10">Piso 10</option>
                        <option value="Pantry">Pantry</option>
                        <option value="Sushi">Sushi</option>
                        <option value="Reposteria">ReposterÃ­a</option>
                        <option value="Le Place">Le Place</option>
                    </select>
                </div>

                <!-- Servicio select -->
                <div class="flex items-center gap-2 bg-white px-2.5 py-1 rounded-xl border border-slate-200 shadow-inner">
                    <label class="text-[9px] font-bold text-slate-400 uppercase whitespace-nowrap"><i class="fas fa-utensils text-slate-400"></i> Servicio:</label>
                    <select id="inp-servicio" class="w-full text-xs font-bold text-slate-700 bg-transparent outline-none border-none cursor-pointer">
                        <option value="Desayuno">AM (Desayuno)</option>
                        <option value="Almuerzo">PM (Almuerzo)</option>
                        <option value="Cena">Cena</option>
                        <option value="Eventos">Eventos</option>
                    </select>
                </div>

                <!-- PAX count -->
                <div class="flex items-center gap-2 bg-white px-2.5 py-1 rounded-xl border border-slate-200 shadow-inner">
                    <label class="text-[9px] font-bold text-slate-400 uppercase whitespace-nowrap"><i class="fas fa-users text-slate-400"></i> PAX:</label>
                    <input type="number" id="inp-pax-count" value="0" min="0" class="w-full text-xs font-black text-emerald-700 bg-transparent border-none outline-none text-center" oninput="window.actualizarAsistenteMRP()">
                    <span class="text-[9px] text-slate-400 font-bold whitespace-nowrap">personas</span>
                </div>
            </div>

            <!-- SEARCH / VOICE ROW -->
            <div class="p-2 border-b border-slate-200 bg-white flex items-center gap-2 relative shadow-sm z-10">
                <div class="relative flex-1">
                    <i class="fas fa-search absolute left-3 top-2.5 text-slate-400 text-xs"></i>
                    <input type="text" id="inp-search-req" placeholder="Buscar producto o dictar con IA..." class="w-full text-xs bg-slate-50 border border-slate-200 rounded-full py-1.5 pl-8 pr-4 outline-none focus:border-cp-blue focus:ring-1 focus:ring-blue-100 transition shadow-inner" onkeyup="window.filterReq()">
                </div>
                <button onclick="window.toggleDictation()" id="btn-mic" class="bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white w-9 h-9 rounded-full transition shadow-md flex items-center justify-center text-base flex-shrink-0" title="Dictado Inteligente">
                    <i class="fas fa-microphone"></i>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto bg-slate-50/50 p-2">
                <table class="w-full table-dense text-xs bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                    <thead class="sticky top-0 z-10 bg-slate-100 border-b border-slate-200">
                        <tr>
                            <th class="w-20 text-center py-3">CÃ³digo</th>
                            <th class="py-3 text-left">Insumo del CatÃ¡logo</th>
                            <th class="w-16 text-center py-3">Und</th>
                            <th class="w-32 text-center bg-blue-50 text-cp-blue py-3"><i class="fas fa-shopping-cart mr-1"></i> A Pedir (Proyectado)</th>
                        </tr>
                    </thead>
                    <tbody id="lista-catalogo" class="divide-y divide-slate-50 text-slate-700"></tbody>
                    <tbody id="lista-manual" class="divide-y divide-slate-50 text-slate-700 border-t-2 border-slate-200"></tbody>
                </table>
                <div class="p-4 text-center mt-2">
                    <button onclick="window.agregarFilaManual()" class="text-xs font-bold text-slate-500 border-2 border-dashed border-slate-300 bg-white hover:bg-slate-50 hover:border-cp-blue hover:text-cp-blue py-2 px-6 rounded-xl transition"><i class="fas fa-plus mr-2"></i> AGREGAR INSUMO MANUAL O NO CATALOGADO</button>
                </div>
            </div>
            <div class="p-4 border-t border-slate-200 bg-white flex justify-between items-center shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] z-10">
                <p class="text-[11px] text-slate-500 font-medium"><i class="fas fa-info-circle text-cp-blue mr-1"></i> Digite los Comensales (PAX) para calcular automÃ¡ticamente la proyecciÃ³n a pedir.</p>
                <button onclick="window.generarRadicado(false)" class="bg-cp-blue hover:bg-cp-blue-hover text-white text-sm font-black py-3 px-8 rounded-xl shadow-lg transition flex items-center gap-2 transform hover:-translate-y-0.5"><i class="fas fa-paper-plane text-lg"></i> PROCESAR Y ENVIAR</button>
            </div>
        </div>
    </template>