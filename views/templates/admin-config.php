<template id="tpl-admin-config">
        <div class="h-full flex flex-col bg-white border border-slate-200 rounded-2xl shadow-sm max-w-6xl mx-auto overflow-hidden">
            <!-- TAB BAR -->
            <div class="flex border-b border-slate-200 bg-slate-50 p-1 gap-1 flex-shrink-0 select-none">
                <button onclick="window.setAdminConfigTab('general')" class="admin-tab-btn px-4 py-2.5 text-xs font-bold rounded-lg transition-all bg-white text-cp-blue shadow-sm border border-slate-200" data-tab="general"><i class="fas fa-sliders-h mr-1.5 text-cp-blue"></i> Gral e IA</button>
                <button onclick="window.setAdminConfigTab('pax')" class="admin-tab-btn px-4 py-2.5 text-xs font-bold rounded-lg transition-all text-slate-600 hover:bg-slate-200" data-tab="pax"><i class="fas fa-users mr-1.5"></i> Comensales (PAX)</button>
                <button onclick="window.setAdminConfigTab('bodegas')" class="admin-tab-btn px-4 py-2.5 text-xs font-bold rounded-lg transition-all text-slate-600 hover:bg-slate-200" data-tab="bodegas"><i class="fas fa-warehouse mr-1.5"></i> Bodegas / Estaciones</button>
                <button onclick="window.setAdminConfigTab('recetas')" class="admin-tab-btn px-4 py-2.5 text-xs font-bold rounded-lg transition-all text-slate-600 hover:bg-slate-200" data-tab="recetas"><i class="fas fa-mortar-pestle mr-1.5"></i> FÃ³rmulas / Recetas</button>
                <button onclick="window.setAdminConfigTab('ajustes')" class="admin-tab-btn px-4 py-2.5 text-xs font-bold rounded-lg transition-all text-slate-600 hover:bg-slate-200" data-tab="ajustes"><i class="fas fa-balance-scale mr-1.5"></i> Cierre y Ajustes</button>
            </div>
            
            <!-- PANEL CONTENT -->
            <div class="flex-1 overflow-y-auto p-6" id="admin-config-tab-content">
                
                <!-- PANEL GENERAL & IA -->
                <div id="admin-tab-general" class="admin-tab-panel space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="border border-slate-200 rounded-2xl p-6 flex flex-col justify-between bg-slate-50 shadow-sm">
                            <div>
                                <h4 class="font-bold text-slate-800 mb-2 flex items-center"><i class="fas fa-palette text-cp-blue mr-2"></i> Tema y Colores</h4>
                                <p class="text-xs text-slate-500 mb-4">Personaliza el color primario de la plataforma.</p>
                            </div>
                            <div class="flex gap-4 items-center">
                                <input type="color" id="inp-color-primary" value="#22438A" class="w-16 h-12 rounded cursor-pointer border-none bg-transparent">
                                <button onclick="window.guardarColor()" class="bg-slate-700 hover:bg-slate-800 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-md transition">APLICAR COLOR</button>
                            </div>
                        </div>
                        <div class="border border-slate-200 rounded-2xl p-6 flex flex-col justify-between bg-slate-50 shadow-sm">
                            <div>
                                <h4 class="font-bold text-slate-800 mb-2 flex items-center"><i class="fas fa-file-signature text-slate-400 mr-2"></i> CÃ³digo de Calidad Documental</h4>
                                <p class="text-xs text-slate-500 mb-4">AparecerÃ¡ en los pies de pÃ¡gina de los formatos impresos.</p>
                            </div>
                            <div class="flex gap-3"><input type="text" id="inp-cod-calidad" class="flex-1 text-xs border border-slate-300 rounded-xl px-4 py-2.5 outline-none focus:border-cp-blue bg-white" placeholder="Ej: FAYB-98 V:01"><button onclick="window.guardarCodigoCalidad()" class="bg-slate-700 hover:bg-slate-800 text-white px-6 py-2.5 rounded-xl text-xs font-bold shadow-md transition">GUARDAR</button></div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="border border-slate-200 rounded-2xl p-6 flex flex-col items-center text-center justify-center bg-slate-50 shadow-sm hover:border-cp-blue transition"><i class="fas fa-image text-4xl text-slate-300 mb-3"></i><h4 class="font-bold text-slate-800 mb-1">Logo Completo</h4><p class="text-[11px] text-slate-500 mb-4">Se muestra en el login y en el menÃº abierto.</p><button onclick="document.getElementById('logo-upload').click()" class="bg-cp-blue hover:bg-cp-blue-hover text-white px-5 py-2 rounded-lg text-xs font-bold shadow-sm transition"><i class="fas fa-upload mr-1.5"></i> SUBIR COMPLETO</button></div>
                        <div class="border border-slate-200 rounded-2xl p-6 flex flex-col items-center text-center justify-center bg-slate-50 shadow-sm hover:border-cp-gold transition"><i class="fas fa-compress text-4xl text-slate-300 mb-3"></i><h4 class="font-bold text-slate-800 mb-1">Logo Resumido (Ãcono)</h4><p class="text-[11px] text-slate-500 mb-4">Se muestra cuando el menÃº estÃ¡ contraÃ­do.</p><button onclick="document.getElementById('logo-compact-upload').click()" class="bg-cp-gold hover:bg-cp-gold-hover text-white px-5 py-2 rounded-lg text-xs font-bold shadow-sm transition"><i class="fas fa-upload mr-1.5"></i> SUBIR ÃCONO</button></div>
                    </div>
                    
                    <div class="border border-emerald-200 rounded-2xl p-6 flex flex-col justify-center bg-gradient-to-br from-emerald-50/50 to-white shadow-sm relative overflow-hidden">
                        <i class="fas fa-brain absolute -right-4 -bottom-4 text-9xl text-emerald-100 opacity-30 pointer-events-none"></i>
                        <div class="relative z-10">
                            <div class="flex items-center gap-4 mb-4"><i class="fas fa-robot text-4xl text-emerald-500"></i><div><h4 class="font-bold text-base text-emerald-900">Cerebro AI (Gemini Flash 2.5)</h4><p class="text-xs text-emerald-700 font-medium mt-1">Motor de procesamiento de lenguaje natural y dictado por voz.</p></div></div>
                            <div class="flex flex-col gap-2 mt-4"><label class="text-[10px] uppercase font-bold text-slate-600">Referencia Edge Function IA</label><div class="flex flex-col sm:flex-row gap-3"><input type="text" id="inp-api-key" class="flex-1 text-xs border border-emerald-200 rounded-xl px-4 py-2.5 outline-none focus:border-emerald-500 font-mono bg-white shadow-inner" placeholder="chef-ai-proxy"><button onclick="window.guardarAPIKey()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-xl text-xs font-bold transition shadow-md"><i class="fas fa-shield-alt mr-1.5"></i> ACTUALIZAR REFERENCIA</button></div></div>
                        </div>
                    </div>
                </div>
                
                <!-- PANEL PAX -->
                <div id="admin-tab-pax" class="admin-tab-panel hidden space-y-6">
                    <div class="bg-slate-50 border border-slate-200 p-6 rounded-2xl shadow-sm">
                        <h4 class="font-bold text-slate-800 mb-2 flex items-center"><i class="fas fa-users text-cp-blue mr-2 text-base"></i> ParametrizaciÃ³n de Comensales Base (PAX)</h4>
                        <p class="text-xs text-slate-500 mb-6">Establece la cantidad de comensales por defecto para la requisiciÃ³n y el cÃ¡lculo dinÃ¡mico del recetario.</p>
                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                            <div><label class="text-[10px] uppercase font-extrabold text-slate-500 block mb-1">Desayuno (PAX)</label><input type="number" id="inp-pax-des" class="w-full border border-slate-300 rounded-xl px-3 py-2.5 text-sm font-bold text-center text-slate-800 focus:border-cp-blue shadow-inner" value="100"></div>
                            <div><label class="text-[10px] uppercase font-extrabold text-slate-500 block mb-1">Almuerzo (PAX)</label><input type="number" id="inp-pax-alm" class="w-full border border-slate-300 rounded-xl px-3 py-2.5 text-sm font-bold text-center text-slate-800 focus:border-cp-blue shadow-inner" value="100"></div>
                            <div><label class="text-[10px] uppercase font-extrabold text-slate-500 block mb-1">Cena (PAX)</label><input type="number" id="inp-pax-cen" class="w-full border border-slate-300 rounded-xl px-3 py-2.5 text-sm font-bold text-center text-slate-800 focus:border-cp-blue shadow-inner" value="100"></div>
                            <div><label class="text-[10px] uppercase font-extrabold text-slate-500 block mb-1">Eventos (PAX)</label><input type="number" id="inp-pax-eve" class="w-full border border-slate-300 rounded-xl px-3 py-2.5 text-sm font-bold text-center text-slate-800 focus:border-cp-blue shadow-inner" value="100"></div>
                        </div>
                        <div class="flex justify-end mt-6 pt-4 border-t border-slate-200">
                            <button onclick="window.guardarAdminPax()" class="bg-cp-blue hover:bg-cp-blue-hover text-white px-6 py-2.5 rounded-xl text-xs font-black shadow-md transition flex items-center gap-1.5"><i class="fas fa-save"></i> GUARDAR COMENSALES</button>
                        </div>
                    </div>
                </div>
                
                <!-- PANEL BODEGAS / ESTACIONES -->
                <div id="admin-tab-bodegas" class="admin-tab-panel hidden space-y-6">
                    <div class="flex flex-col md:flex-row gap-6">
                        <!-- Form -->
                        <div class="w-full md:w-1/3 bg-slate-50 border border-slate-200 p-5 rounded-2xl flex flex-col gap-4 h-fit">
                            <h4 class="font-black text-slate-800 text-xs uppercase flex items-center gap-1.5"><i class="fas fa-plus-circle text-cp-blue text-sm"></i> Nueva EstaciÃ³n / Bodega</h4>
                            <div>
                                <label class="text-[10px] uppercase font-bold text-slate-500 block mb-1">Nombre de la EstaciÃ³n</label>
                                <input type="text" id="inp-bodega-nombre" class="w-full border border-slate-300 rounded-xl px-3 py-2 text-xs outline-none focus:border-cp-blue bg-white uppercase font-bold text-slate-700" placeholder="Ej: COCINA FRÃA">
                            </div>
                            <button onclick="window.guardarEstacion()" class="bg-cp-blue hover:bg-cp-blue-hover text-white text-xs font-bold py-2.5 rounded-xl shadow-md transition flex items-center justify-center gap-1.5"><i class="fas fa-save"></i> GUARDAR ESTACIÃ“N</button>
                        </div>
                        <!-- List -->
                        <div class="flex-1 bg-white border border-slate-200 rounded-2xl overflow-hidden flex flex-col min-h-[350px]">
                            <div class="bg-slate-50 p-3 border-b font-bold text-xs text-slate-600 flex items-center"><i class="fas fa-list mr-1.5"></i> Estaciones / Bodegas Activas</div>
                            <div class="overflow-y-auto flex-1 max-h-[350px]">
                                <table class="w-full text-xs text-left border-collapse">
                                    <thead class="bg-slate-100/50 sticky top-0 border-b z-10">
                                        <tr><th class="p-3 text-[10px] font-bold text-slate-500 uppercase">Nombre EstaciÃ³n / Bodega</th><th class="p-3 text-[10px] font-bold text-slate-500 uppercase text-center w-32">Acciones</th></tr>
                                    </thead>
                                    <tbody id="tbl-admin-bodegas" class="divide-y divide-slate-100">
                                        <tr><td colspan="2" class="p-8 text-center text-slate-400">Cargando estaciones...</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- PANEL RECETAS / FÃ“RMULAS -->
                <div id="admin-tab-recetas" class="admin-tab-panel hidden flex flex-col lg:flex-row gap-6">
                    <!-- Left Sidebar List -->
                    <div class="w-full lg:w-1/3 bg-slate-50 border border-slate-200 p-4 rounded-2xl flex flex-col gap-3 h-[580px]">
                        <h4 class="font-black text-slate-800 text-xs uppercase flex items-center justify-between">
                            <span><i class="fas fa-mortar-pestle text-cp-gold mr-1.5"></i> Maestro de Recetas</span>
                            <button onclick="window.iniciarNuevaRecetaAdmin()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-2.5 py-1 rounded-lg text-[9px] font-bold shadow-sm transition"><i class="fas fa-plus"></i> Nueva</button>
                        </h4>
                        <div>
                            <div class="relative">
                                <i class="fas fa-search absolute left-3 top-2.5 text-slate-400 text-[10px]"></i>
                                <input type="text" id="inp-receta-search" class="w-full border border-slate-300 rounded-xl pl-8 pr-3 py-1.5 text-xs outline-none focus:border-cp-blue bg-white" placeholder="Buscar receta..." onkeyup="window.filtrarRecetasAdminList()">
                            </div>
                        </div>
                        <div class="flex-1 overflow-y-auto border border-slate-200 rounded-xl bg-white list-none p-1 divide-y divide-slate-100" id="lst-admin-recetas">
                            <div class="p-4 text-center text-slate-400 text-[11px]">Cargando recetario...</div>
                        </div>
                    </div>
                    
                    <!-- Right Editor -->
                    <div class="flex-1 bg-white border border-slate-200 rounded-2xl p-5 shadow-sm flex flex-col gap-4 min-h-[580px]">
                        <h4 class="font-black text-slate-800 text-xs uppercase border-b pb-3 flex items-center justify-between" id="lbl-receta-editor-title">
                            <span><i class="fas fa-edit text-cp-blue mr-1.5"></i> Editor de Receta / FormulaciÃ³n</span>
                            <span class="text-[10px] text-slate-400 font-mono" id="lbl-receta-id-display">ID: Nuevo</span>
                        </h4>
                        <input type="hidden" id="inp-receta-id">
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <div>
                                <label class="text-[10px] uppercase font-bold text-slate-500 block mb-1">Nombre de la Receta</label>
                                <input type="text" id="inp-receta-nombre" class="w-full border border-slate-300 rounded-xl px-3 py-2 text-xs bg-slate-50 font-bold uppercase text-slate-800" placeholder="Ej: CARNE EN BISTEC">
                            </div>
                            <div>
                                <label class="text-[10px] uppercase font-bold text-slate-500 block mb-1">Servicio</label>
                                <select id="inp-receta-servicio" class="w-full border border-slate-300 rounded-xl px-3 py-2 text-xs bg-white outline-none font-bold text-slate-700">
                                    <option value="Desayuno">Desayuno</option>
                                    <option value="Almuerzo">Almuerzo</option>
                                    <option value="Cena">Cena</option>
                                    <option value="General">General</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-[10px] uppercase font-bold text-slate-500 block mb-1">Rendimiento Base (Pax)</label>
                                <input type="number" id="inp-receta-rinde" class="w-full border border-slate-300 rounded-xl px-3 py-2 text-xs text-center font-bold text-slate-700 bg-slate-50" value="100">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <label class="text-[10px] uppercase font-bold text-slate-500 block mb-1">AlÃ©rgenos</label>
                                <input type="text" id="inp-receta-alergenos" class="w-full border border-slate-300 rounded-xl px-3 py-2 text-xs" placeholder="Ej: GLUTEN, LÃCTEOS">
                            </div>
                            <div>
                                <label class="text-[10px] uppercase font-bold text-slate-500 block mb-1">CategorÃ­a</label>
                                <input type="text" id="inp-receta-categoria" class="w-full border border-slate-300 rounded-xl px-3 py-2 text-xs uppercase" placeholder="Ej: SOPAS Y CREMAS">
                            </div>
                        </div>
                        <div>
                            <label class="text-[10px] uppercase font-bold text-slate-500 block mb-1">Procedimiento / FormulaciÃ³n Sensorial</label>
                            <textarea id="inp-receta-procedimiento" class="w-full border border-slate-300 rounded-xl px-3 py-2 text-xs h-16 outline-none resize-none leading-relaxed" placeholder="Describe los pasos para preparar la receta..."></textarea>
                        </div>
                        
                        <!-- Recipe Ingredients Subtable -->
                        <div class="border border-slate-200 rounded-xl overflow-hidden bg-slate-50 flex flex-col flex-1 shadow-inner">
                            <div class="bg-slate-100 p-2.5 border-b font-bold text-xs text-slate-600 flex justify-between items-center">
                                <span><i class="fas fa-egg mr-1 text-orange-500"></i> Ingredientes y Costos EstÃ¡ndar</span>
                                <span class="text-[10px] text-cp-blue font-extrabold bg-blue-50 px-2 py-0.5 rounded border border-blue-100 shadow-sm" id="lbl-receta-costo-total">Costo Receta (100 Pax): $0</span>
                            </div>
                            <!-- Autocomplete input block -->
                            <div class="p-3 bg-white flex gap-2 border-b relative">
                                <div class="flex-1 relative">
                                    <input type="text" id="inp-ingrediente-search" class="w-full border border-slate-300 rounded-xl px-3 py-2 text-xs outline-none" placeholder="Buscar insumo en Zeus..." onkeyup="window.buscarIngredienteZeusAutocomplete()">
                                    <div id="lst-zeus-autocomplete" class="absolute left-0 right-0 bg-white border border-slate-200 rounded-xl shadow-xl max-h-[150px] overflow-y-auto hidden z-[40] divide-y"></div>
                                </div>
                                <input type="number" id="inp-ingrediente-cant" class="w-20 border border-slate-300 rounded-xl px-2 py-2 text-xs text-center font-bold" placeholder="Cant.">
                                <select id="inp-ingrediente-und" class="w-24 border border-slate-300 rounded-xl px-2 py-2 text-xs bg-white outline-none">
                                    <option value="gr">gramos (gr)</option>
                                    <option value="ml">mililitros (ml)</option>
                                    <option value="unidad">unidades</option>
                                    <option value="KILOS">KILOS</option>
                                    <option value="LITROS">LITROS</option>
                                </select>
                                <button onclick="window.agregarIngredienteAReceta()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 rounded-xl text-xs font-bold shadow-sm transition"><i class="fas fa-plus"></i></button>
                            </div>
                            <div class="overflow-y-auto max-h-[160px] bg-white flex-1 min-h-[120px]">
                                <table class="w-full text-xs text-left border-collapse">
                                    <thead class="bg-slate-50 border-b sticky top-0 z-10 shadow-sm">
                                        <tr><th class="p-2.5 text-slate-500 text-[10px]">Ingrediente</th><th class="p-2.5 text-center text-slate-500 text-[10px] w-24">Cantidad</th><th class="p-2.5 text-center text-slate-500 text-[10px] w-20">Und</th><th class="p-2.5 text-right text-slate-500 text-[10px] w-24">Costo Unit.</th><th class="p-2.5 text-right text-slate-500 text-[10px] w-24">Costo Subt.</th><th class="p-2.5 text-center text-slate-500 text-[10px] w-12">Elim.</th></tr>
                                    </thead>
                                    <tbody id="tbl-receta-ingredientes" class="divide-y divide-slate-100"></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="flex justify-end gap-3 border-t pt-3 flex-shrink-0">
                            <button onclick="window.eliminarRecetaCompletaAdmin()" class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 px-5 py-2.5 rounded-xl text-xs font-bold transition shadow-sm" id="btn-eliminar-receta" style="display: none;"><i class="fas fa-trash mr-1.5"></i> ELIMINAR RECETA</button>
                            <button onclick="window.guardarRecetaCompletaAdmin()" class="bg-cp-blue hover:bg-cp-blue-hover text-white px-6 py-2.5 rounded-xl text-xs font-black shadow-md transition"><i class="fas fa-save mr-1.5"></i> GUARDAR RECETA</button>
                        </div>
                    </div>
                </div>
                
                <!-- PANEL AJUSTES Y AUDITORÃA -->
                <div id="admin-tab-ajustes" class="admin-tab-panel hidden space-y-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Left Column: Manual adjustment -->
                        <div class="bg-slate-50 border border-slate-200 p-5 rounded-2xl flex flex-col gap-4 h-fit shadow-sm">
                            <h4 class="font-black text-slate-800 text-xs uppercase flex items-center gap-1.5"><i class="fas fa-balance-scale text-cp-blue text-sm"></i> Ajuste Operativo Manual</h4>
                            <p class="text-[11px] text-slate-500">Registra un ajuste manual en el kÃ¡rdex con justificaciÃ³n obligatoria.</p>
                            
                            <div>
                                <label class="text-[10px] uppercase font-bold text-slate-500 block mb-1">1. Seleccionar Insumo</label>
                                <div class="relative">
                                    <input type="text" id="inp-ajuste-insumo" class="w-full border border-slate-300 rounded-xl px-3 py-2 text-xs outline-none bg-white font-bold text-slate-800" placeholder="Escribe para buscar..." onkeyup="window.buscarAjusteInsumoAutocomplete()">
                                    <div id="lst-ajuste-autocomplete" class="absolute left-0 right-0 bg-white border border-slate-200 rounded-xl shadow-xl max-h-[150px] overflow-y-auto hidden z-[40] divide-y"></div>
                                </div>
                                <input type="hidden" id="inp-ajuste-id-insumo">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="text-[10px] uppercase font-bold text-slate-500 block mb-1">2. Cantidad (+ o -)</label>
                                    <input type="number" step="0.01" id="inp-ajuste-cantidad" class="w-full border border-slate-300 rounded-xl px-3 py-2 text-xs text-center font-bold text-slate-800 bg-white focus:border-cp-blue shadow-inner" placeholder="Ej: -5.0">
                                </div>
                                <div>
                                    <label class="text-[10px] uppercase font-bold text-slate-500 block mb-1">3. Unidad</label>
                                    <input type="text" id="inp-ajuste-unidad" class="w-full border border-slate-300 rounded-xl px-3 py-2 text-xs text-center font-bold text-slate-400 bg-slate-100" readonly value="UND">
                                </div>
                            </div>
                            <div>
                                <label class="text-[10px] uppercase font-bold text-slate-500 block mb-1">4. Concepto / Motivo de Ajuste</label>
                                <select id="inp-ajuste-concepto" class="w-full border border-slate-300 rounded-xl px-3 py-2 text-xs bg-white outline-none font-bold text-slate-700">
                                    <option value="Merma por daÃ±o o descomposiciÃ³n">Merma por daÃ±o o descomposiciÃ³n</option>
                                    <option value="Ajuste por Diferencia de Conteo FÃ­sico">Ajuste por Conteo FÃ­sico</option>
                                    <option value="Salida a ProducciÃ³n de Cocina">Salida a ProducciÃ³n de Cocina</option>
                                    <option value="Rotura de Menaje o Envase">Rotura o PÃ©rdida</option>
                                    <option value="CortesÃ­a o Consumo Operativo">Consumo Operativo</option>
                                </select>
                            </div>
                            <button onclick="window.aplicarAjusteManual()" class="bg-slate-700 hover:bg-slate-800 text-white text-xs font-bold py-2.5 rounded-xl shadow-md transition flex items-center justify-center gap-1.5"><i class="fas fa-check"></i> APLICAR AJUSTE MANUAL</button>
                        </div>
                        
                        <!-- Right Column: Comparative audit from history -->
                        <div class="lg:col-span-2 bg-white border border-slate-200 rounded-2xl p-5 shadow-sm flex flex-col gap-4 min-h-[350px]">
                            <h4 class="font-black text-slate-800 text-xs uppercase border-b pb-3 flex flex-wrap items-center justify-between gap-3">
                                <span><i class="fas fa-clipboard-check text-emerald-600 mr-1.5"></i> Cruce de Inventario y ConciliaciÃ³n</span>
                                <div class="flex gap-2 items-center">
                                    <select id="sel-historial-formularios" class="border border-slate-300 rounded-xl px-3 py-1.5 text-[11px] bg-white outline-none font-black text-slate-600 shadow-sm" onchange="window.cargarDiferenciasTomaFisica()">
                                        <option value="">Seleccione Conteo FÃ­sico...</option>
                                    </select>
                                    <button onclick="window.recargarHistorialTomasFisicas()" class="text-slate-500 hover:text-cp-blue border p-1.5 rounded-lg transition"><i class="fas fa-sync-alt text-xs"></i></button>
                                </div>
                            </h4>
                            
                            <!-- Audit results summary indicators -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3" id="div-auditoria-resumen" style="display: none;">
                                <div class="bg-slate-50 border border-slate-200 rounded-xl p-3 shadow-inner">
                                    <p class="text-[9px] uppercase tracking-wide text-slate-400 font-bold mb-0.5">Insumos Auditados</p>
                                    <h4 class="text-base font-black text-slate-800" id="lbl-audit-count">0 / 0</h4>
                                </div>
                                <div class="bg-red-50 border border-red-200 rounded-xl p-3 shadow-inner">
                                    <p class="text-[9px] uppercase tracking-wide text-red-500 font-bold mb-0.5">PÃ©rdida en Faltantes</p>
                                    <h4 class="text-base font-black text-red-700" id="lbl-audit-perdida">$0</h4>
                                </div>
                                <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-3 shadow-inner">
                                    <p class="text-[9px] uppercase tracking-wide text-emerald-600 font-bold mb-0.5">Ajuste Neto Estimado</p>
                                    <h4 class="text-base font-black text-emerald-700" id="lbl-audit-neto">$0</h4>
                                </div>
                            </div>
                            
                            <div class="overflow-y-auto max-h-[280px] border border-slate-100 rounded-xl bg-white flex-1" id="div-auditoria-tabla-wrapper" style="display: none;">
                                <table class="w-full text-xs text-left border-collapse">
                                    <thead class="bg-slate-50 sticky top-0 border-b z-10 shadow-sm">
                                        <tr><th class="p-3 text-[10px] text-slate-500 uppercase">Insumo</th><th class="p-3 text-center text-slate-500 text-[10px] w-24">TeÃ³rico (Zeus)</th><th class="p-3 text-center text-slate-500 text-[10px] w-24">FÃ­sico (BOH)</th><th class="p-3 text-center text-slate-500 text-[10px] w-24">Diferencia</th><th class="p-3 text-right text-slate-500 text-[10px] w-28">PÃ©rdida/Ganancia</th></tr>
                                    </thead>
                                    <tbody id="tbl-auditoria-diferencias" class="divide-y divide-slate-100"></tbody>
                                </table>
                            </div>
                            
                            <div class="flex justify-between items-center pt-3 border-t" id="div-auditoria-footer" style="display: none;">
                                <p class="text-[9px] text-slate-400 font-medium"><i class="fas fa-info-circle text-cp-blue"></i> Presionar el ajuste automÃ¡tico cuadrarÃ¡ las existencias e imprimirÃ¡ el acta en bitÃ¡cora.</p>
                                <button onclick="window.aplicarCierreInventarioAutomatico()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-xs font-black shadow-md transition flex items-center gap-1.5"><i class="fas fa-magic"></i> APLICAR CIERRE AUTOMÃTICO</button>
                            </div>
                            
                            <!-- Empty State -->
                            <div class="py-16 text-center text-slate-400 flex flex-col items-center justify-center flex-1" id="div-auditoria-empty">
                                <i class="fas fa-clipboard-check text-5xl mb-4 opacity-30 text-slate-300"></i>
                                <p class="text-sm font-bold text-slate-600">Sin AuditorÃ­a Activa</p>
                                <p class="text-xs text-slate-400 max-w-xs mt-1">Selecciona una Toma FÃ­sica registrada arriba para realizar el cruce contable e informe de diferencias (Sobrantes/Faltantes).</p>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </template>