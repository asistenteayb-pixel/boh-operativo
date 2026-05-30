<template id="tpl-recetario">
        <div class="h-full flex flex-col max-w-7xl mx-auto gap-4">
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex flex-wrap justify-between items-center gap-4">
                <div>
                    <h2 class="text-xl font-black text-slate-800"><i class="fas fa-book-open text-cp-gold mr-2"></i> LIBRO RECETARIO LE PLACE</h2>
                    <p class="text-xs text-slate-500 font-bold mt-1">CODIGO: OAYB-38 V:02 05/02/2026 (RECETARIO)</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-2.5 text-slate-400"></i>
                        <input type="text" id="busqueda-receta" placeholder="Buscar receta..." class="pl-9 pr-4 py-2 border border-slate-200 rounded-xl text-sm focus:border-cp-blue outline-none" onkeyup="window.filtrarRecetario()">
                    </div>
                    <select id="filtro-servicio" class="border border-slate-200 rounded-xl px-4 py-2 text-sm font-bold text-slate-700 bg-slate-50 outline-none" onchange="window.cargarTarjetasRecetario()">
                        <option value="Todos">Todos los Servicios</option>
                        <option value="Desayuno">Desayuno</option>
                        <option value="Almuerzo">Almuerzo</option>
                        <option value="Cena">Cena</option>
                    </select>
                </div>
            </div>
            <div class="flex-1 overflow-y-auto pb-6">
                <div id="grid-recetas" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5"></div>
            </div>
        </div>
    </template>