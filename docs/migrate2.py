import re
import json

with open("/Users/harleyligardp/Downloads/BOH-PHP/public/index.html", "r", encoding="utf-8") as f:
    content = f.read()

# 1. Restore the Recetario menu option. 
# Previously I did: content = re.sub(r'\{\s*t:\s*"Recetario",\s*i:\s*"fa-book-open",\s*f:\s*"vRecetario"\s*\},?', '', content)
# Now I need to add it back to the admin menu and cocinero menu.
# I'll just find the `opt.push(` block for admin and add it back.
admin_push_regex = r"(opt\.push\(\s*\{ t: \"Dashboard\", i: \"fa-chart-pie\", f: \"vDashboard\" \},)"
content = re.sub(admin_push_regex, r'\1\n                    { t: "Recetario", i: "fa-book-open", f: "vRecetario" },', content)

# 2. Change "Recetario Estándar" to "LIBRO RECETARIO LE PLACE" and add code: CODIGO: OAYB-38 V:02 05/02/2026 (RECETARIO)
content = content.replace(
    '<h2 class="text-2xl font-black text-slate-800"><i class="fas fa-book-open text-cp-gold mr-2"></i> Recetario Estándar</h2>',
    '<h2 class="text-2xl font-black text-slate-800"><i class="fas fa-book-open text-cp-gold mr-2"></i> LIBRO RECETARIO LE PLACE</h2>'
)
content = content.replace(
    '<p class="text-slate-500">Consulta de recetas estandarizadas y escandallos.</p>',
    '<p class="text-slate-500 font-bold">CODIGO: OAYB-38 V:02 05/02/2026 (RECETARIO)</p>'
)

# 3. Change "Crear Solicitud de Insumos" to "SOLICITUD DE INSUMOS COCINA" and add code: FAYB-98 V:01 16/10/2025
content = content.replace(
    '<h3 class="font-black text-lg text-slate-800"><i class="fas fa-paper-plane text-cp-gold mr-2"></i> Crear Solicitud de Insumos</h3>',
    '<h3 class="font-black text-lg text-slate-800"><i class="fas fa-paper-plane text-cp-gold mr-2"></i> SOLICITUD DE INSUMOS COCINA</h3>'
)
content = content.replace(
    '<p class="text-xs text-slate-500 font-medium">Sistema de Planificación MRP integrado.</p>',
    '<p class="text-xs text-slate-500 font-bold">CODIGO: FAYB-98 V:01 16/10/2025</p>'
)

# 4. Remove Asistente de Recetas MRP block inside tpl-req-nueva.
# The block is: <div class="p-4 border-b border-emerald-100 bg-gradient-to-r from-emerald-50 to-teal-50 flex flex-col gap-3"> ... </div>
mrp_block = r'<div class="p-4 border-b border-emerald-100 bg-gradient-to-r from-emerald-50 to-teal-50 flex flex-col gap-3">.*?</div>\s*</div>'
content = re.sub(mrp_block, '</div>', content, flags=re.DOTALL) # wait, careful with nested divs.

# Safer replacement for MRP block:
content = re.sub(
    r'<div class="p-4 border-b border-emerald-100 bg-gradient-to-r from-emerald-50 to-teal-50 flex flex-col gap-3">.*?Asistente de Recetas MRP.*?</div>\s*</div>',
    '',
    content,
    flags=re.DOTALL
)

# 5. Formato FAYB-130 -> LISTADO DE INVENTARIO Y PEDIDO
content = content.replace(
    '<h3 class="text-xl font-black text-slate-800 mb-2">Formato FAYB-130</h3>',
    '<h3 class="text-xl font-black text-slate-800 mb-2">LISTADO DE INVENTARIO Y PEDIDO</h3>'
)
# And put code: FAYB-130 V:0 22/10/2025 inside the document (view-detalle)
content = content.replace(
    '<div class="font-black text-base text-slate-800" id="detalle-title">FECHA</div>',
    '<div class="font-black text-base text-slate-800" id="detalle-title">FECHA</div><div class="text-[10px] text-slate-500 font-bold ml-2">codigo: FAYB-130 V:0 22/10/2025</div>'
)

# 6. Change voice dictation back to Gemini API using user's key.
new_ai_logic = """
        window.procesarDictadoConIA = async function(texto) {
            window.setLoader(true, "Chef AI calculando receta y cantidades...");
            try {
                const catMini = window.catalogoGlobal.map(i => ({ id: i.id_insumo, n: i.nombre, u: i.unidad_medida }));
                
                const prompt = `
Eres un asistente de cocina inteligente.
He escuchado el siguiente dictado del chef: "${texto}"
Mi catálogo de insumos es el siguiente (en formato JSON):
${JSON.stringify(catMini)}
Basado en el dictado, empareja las cantidades solicitadas con el id exacto del insumo en el catálogo.
Devuelve tu respuesta EXCLUSIVAMENTE en formato JSON válido con la siguiente estructura:
{
    "insumos": [
        { "id_insumo": "ID_DEL_CATALOGO", "nombre": "NOMBRE_DEL_CATALOGO", "cantidad": NUMERO, "unidad": "UNIDAD" }
    ],
    "razonamiento": "Breve explicación de lo que entendiste"
}
No incluyas markdown como \`\`\`json, solo el JSON raw.`;

                const response = await fetch("https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-goog-api-key': 'AIzaSyB8g9t-Wau1_0J8vDjrWQ3wJgqLZ8oVfHc'
                    },
                    body: JSON.stringify({
                        contents: [{ parts: [{ text: prompt }] }]
                    })
                });

                const res = await response.json();
                if(!response.ok) throw new Error(res.error?.message || "Error en Gemini API");
                
                const responseText = res.candidates[0].content.parts[0].text.replace(/```json/g, '').replace(/```/g, '').trim();
                const aiData = JSON.parse(responseText);
                
                if(!aiData || !Array.isArray(aiData.insumos)) throw new Error("Respuesta IA inválida");
                window.abrirModalIA(aiData);
                window.setLoader(false);
            } catch(e) { window.setLoader(false); window.showToast("Error técnico IA: " + e.message, "error"); console.error(e); }
        };
"""

content = re.sub(
    r'window\.procesarDictadoConIA = async function\(texto\) \{.*?(?=window\.toggleDictation = async function)', 
    new_ai_logic, 
    content, 
    flags=re.DOTALL
)

with open("/Users/harleyligardp/Downloads/BOH-PHP/public/index.html", "w", encoding="utf-8") as f:
    f.write(content)

print("Updates applied.")
