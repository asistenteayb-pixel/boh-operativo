<template id="tpl-admin-catalogo">
        <div class="flex flex-col lg:flex-row gap-6 h-full max-w-7xl mx-auto">
            <div class="w-full lg:w-1/3 bg-white border border-slate-200 rounded-2xl shadow-sm flex flex-col overflow-hidden h-fit">
                <div class="p-4 border-b border-slate-100 bg-slate-50 font-black text-slate-800 flex items-center" id="form-insumo-title">
                    <i class="fas fa-box-open text-cp-blue mr-2 text-lg"></i> Crear/Editar Insumo
                </div>
                <div class="p-6 space-y-4 bg-white">
                    <input type="hidden" id="cat-id">
                    <div><label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">CÃ³digo Interno</label><input type="text" id="cat-cod" class="w-full border border-slate-300 rounded-xl px-3 py-2.5 text-sm outline-none focus:border-cp-blue mt-1 uppercase" placeholder="Ej: 1020"></div>
                    <div><label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Nombre del Insumo</label><input type="text" id="cat-nom" class="w-full border border-slate-300 rounded-xl px-3 py-2.5 text-sm outline-none focus:border-cp-blue mt-1 uppercase" placeholder="Ej: ACEITE OLIVA X 5000 GR"></div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">CategorÃ­a</label>
                            <select id="cat-categoria" class="w-full border border-slate-300 rounded-xl px-3 py-2.5 text-xs outline-none focus:border-cp-blue bg-white mt-1">
                                <option value="VEGETALES Y FRUTAS">Vegetales y Frutas</option><option value="GRANOS">Granos</option><option value="GRUPO DE VIVERES">VÃ­veres</option><option value="GRUPO LACTEOS">LÃ¡cteos</option><option value="GRUPO CARNES FRIAS">Carnes FrÃ­as</option><option value="GRUPO ENCURTIDOS">Encurtidos</option><option value="GRUPO DE PULPAS">Pulpas</option><option value="GRUPO CONGELADOS">Congelados</option><option value="CARNES ROJAS">Carnes Rojas</option><option value="CARNES BLANCAS">Carnes Blancas</option><option value="PESCADOS">Pescados y Mariscos</option><option value="PANES">Panes y ReposterÃ­a</option><option value="OTROS">Otros</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Unidad de Medida</label>
                            <select id="cat-unidad" class="w-full border border-slate-300 rounded-xl px-3 py-2.5 text-xs outline-none focus:border-cp-blue bg-white mt-1">
                                <option value="KILOS">KILOS</option><option value="GRAMOS">GRAMOS</option><option value="LITROS">LITROS</option><option value="UNIDAD">UNIDAD</option><option value="PAQUETE">PAQUETE</option><option value="GALON">GALON</option><option value="LATA">LATA</option><option value="CAJA">CAJA</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div><label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Formato</label><select id="cat-formato" class="w-full border border-slate-300 rounded-xl px-3 py-2.5 text-xs outline-none focus:border-cp-blue bg-white mt-1"><option value="FAYB">FAYB-130</option><option value="FRUVER">FRUVER</option></select></div>
                        <div><label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide">Costo Est. ($)</label><input type="number" id="cat-costo" class="w-full border border-slate-300 rounded-xl px-3 py-2.5 text-sm outline-none focus:border-cp-blue mt-1" value="0"></div>
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button onclick="window.guardarInsumoCatalogo()" id="btn-save-cat" class="flex-1 bg-cp-blue hover:bg-cp-blue-hover text-white font-bold text-sm py-3 rounded-xl shadow-md transition">GUARDAR</button>
                        <button onclick="window.limpiarFormCatalogo()" class="bg-slate-100 text-slate-600 hover:bg-slate-200 font-bold text-sm py-3 px-4 rounded-xl transition"><i class="fas fa-times"></i></button>
                    </div>
                </div>
            </div>

            <!-- Lista Catalogo -->
            <div class="flex-1 bg-white border border-slate-200 rounded-2xl shadow-sm flex flex-col overflow-hidden">
                <div class="p-4 border-b border-slate-100 bg-slate-50 font-black text-slate-800 flex justify-between items-center">
                    <div><i class="fas fa-list text-slate-400 mr-2 text-lg"></i> Base de Datos de Insumos</div>
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-2 text-slate-400 text-xs"></i>
                        <input type="text" id="busqueda-catalogo" placeholder="Buscar insumo..." class="pl-8 pr-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none focus:border-cp-blue" onkeyup="window.filtrarTablaCatalogo()">
                    </div>
                </div>
                <div class="flex-1 overflow-auto p-2">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 border-b border-slate-200 sticky top-0 z-10">
                            <tr><th class="p-3 font-bold uppercase tracking-wider text-[10px]">CÃ³digo</th><th class="p-3 font-bold uppercase tracking-wider text-[10px]">Nombre Oficial</th><th class="p-3 font-bold uppercase tracking-wider text-[10px]">CategorÃ­a</th><th class="p-3 font-bold uppercase tracking-wider text-[10px]">Und.</th><th class="p-3 font-bold uppercase tracking-wider text-[10px]">Costo</th><th class="p-3 font-bold uppercase tracking-wider text-[10px] text-center">AcciÃ³n</th></tr>
                        </thead>
                        <tbody id="tbl-catalogo-list" class="divide-y divide-slate-100"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </template>