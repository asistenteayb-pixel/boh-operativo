<template id="tpl-menu-semanal">
        <div class="max-w-7xl mx-auto flex flex-col gap-4 pb-10">
            <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm flex flex-wrap items-end justify-between gap-3">
                <div>
                    <h2 class="text-xl font-black text-slate-800"><i class="fas fa-calendar-week text-cp-blue mr-2"></i> MenÃº Semanal</h2>
                    <p class="text-xs text-slate-500">ProgramaciÃ³n de desayuno, almuerzo y cena.</p>
                </div>
                <div class="flex items-end gap-2">
                    <div>
                        <label class="text-[10px] uppercase text-slate-500 font-bold block mb-1">Rango Semanal</label>
                        <div class="flex items-center gap-1 bg-white border border-slate-300 rounded-lg p-0.5 shadow-sm">
                            <button onclick="window.cambiarSemana(-1)" class="p-1.5 hover:bg-slate-100 rounded text-slate-500 transition"><i class="fas fa-chevron-left text-xs"></i></button>
                            <input id="menu-desde" type="date" class="border-none px-2 py-1 text-xs outline-none font-bold text-slate-700 bg-transparent" onchange="window.cargarMenuSemanal()">
                            <button onclick="window.cambiarSemana(1)" class="p-1.5 hover:bg-slate-100 rounded text-slate-500 transition"><i class="fas fa-chevron-right text-xs"></i></button>
                        </div>
                    </div>
                    <button onclick="window.cargarMenuSemanal()" class="bg-cp-blue hover:bg-cp-blue-hover text-white px-4 py-2 rounded-lg text-xs font-bold h-9 flex items-center justify-center gap-1.5 shadow-md transition"><i class="fas fa-sync-alt"></i> Actualizar</button>
                    <button onclick="window.abrirKioskMenu()" class="bg-slate-700 hover:bg-slate-800 text-white px-4 py-2 rounded-lg text-xs font-bold h-9 flex items-center justify-center gap-1.5 shadow-md transition"><i class="fas fa-display"></i> Kiosk</button>
                </div>
            </div>

            <!-- TABS FOR SERVICE SELECTION -->
            <div class="flex gap-1.5 p-1 bg-slate-100 rounded-xl border border-slate-200 w-fit shadow-inner">
                <button type="button" class="menu-srv-tab px-4 py-1.5 bg-cp-blue text-white rounded-lg text-xs font-bold shadow-sm transition" data-val="Desayuno" onclick="window.setMenuServiceTab('Desayuno')"><i class="fas fa-sun mr-1"></i> Desayuno</button>
                <button type="button" class="menu-srv-tab px-4 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold hover:bg-slate-200 transition" data-val="Almuerzo" onclick="window.setMenuServiceTab('Almuerzo')"><i class="fas fa-hamburger mr-1"></i> Almuerzo</button>
                <button type="button" class="menu-srv-tab px-4 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold hover:bg-slate-200 transition" data-val="Cena" onclick="window.setMenuServiceTab('Cena')"><i class="fas fa-moon mr-1"></i> Cena</button>
            </div>

            <!-- WEEKLY PLANNING GRID -->
            <div id="menu-grid-container" class="w-full"></div>

            <!-- ADD TO MENU FORM -->
            <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
                <h3 class="text-xs font-bold text-slate-700 uppercase mb-3 flex items-center gap-1.5"><i class="fas fa-plus-circle text-emerald-500 text-sm"></i> Agregar al MenÃº Semanal</h3>
                <div class="grid grid-cols-1 md:grid-cols-5 gap-3 items-end">
                    <div><label class="text-[10px] uppercase text-slate-500 font-bold block mb-1">Fecha</label><input id="mn-fecha" type="date" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:border-cp-blue shadow-inner bg-slate-50 font-bold text-slate-700"></div>
                    <div><label class="text-[10px] uppercase text-slate-500 font-bold block mb-1">Servicio</label><select id="mn-servicio" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs bg-white outline-none focus:border-cp-blue shadow-inner font-bold text-slate-700"><option>Desayuno</option><option>Almuerzo</option><option>Cena</option></select></div>
                    <div><label class="text-[10px] uppercase text-slate-500 font-bold block mb-1">PreparaciÃ³n</label><input id="mn-preparacion" type="text" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:border-cp-blue shadow-inner" placeholder="Ej: ConsomÃ© de Carne"></div>
                    <div><label class="text-[10px] uppercase text-slate-500 font-bold block mb-1">CategorÃ­a</label><input id="mn-categoria" type="text" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:border-cp-blue shadow-inner" placeholder="Ej: CALDO, PANES, PLATO FUERTE..."></div>
                    <div><button onclick="window.guardarMenuProgramado()" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-xs font-bold h-9 flex items-center justify-center gap-1.5 shadow-md transition"><i class="fas fa-save"></i> Guardar</button></div>
                </div>
                <div class="mt-3">
                    <label class="text-[10px] uppercase text-slate-500 font-bold block mb-1">Notas / Observaciones</label>
                    <input id="mn-notas" type="text" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:border-cp-blue shadow-inner" placeholder="Observaciones operativas del dÃ­a">
                </div>
            </div>
        </div>
    </template>