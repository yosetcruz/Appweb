<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Análisis del CMS</title>

<style>
body {
    margin: 0;
    height: 100vh;
    font-family: Arial, Helvetica, sans-serif;
    display: flex;
    overflow: hidden;
}

.fondo {
    position: fixed;
    width: 100%;
    height: 100%;
    z-index: -2;
}

.fondo img {
    position: absolute;
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0;
    animation: fade 16s infinite;
}

.fondo img:nth-child(1) { animation-delay: 0s; }
.fondo img:nth-child(2) { animation-delay: 4s; }
.fondo img:nth-child(3) { animation-delay: 8s; }
.fondo img:nth-child(4) { animation-delay: 12s; }

@keyframes fade {
    0%   { opacity: 0; }
    8%   { opacity: 1; }
    25%  { opacity: 1; }
    33%  { opacity: 0; }
    100% { opacity: 0; }
}

/* ===================== */
/* DEGRADADO ENCIMA */
/* ===================== */
.overlay {
    position: fixed;
    width: 100%;
    height: 100%;
    z-index: -1;
    background: linear-gradient(
        to bottom,
        rgba(135,206,235,0.4),
        rgba(0,31,63,0.95)
    );
}

/* ===================== */
/* UI PRINCIPAL */
/* ===================== */
#layout{
    flex: 1;
    height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    transition: all 0.4s ease;
}

#titulo {
    font-size: 48px;
    color: white;
    text-align: center;
    text-shadow: 2px 2px 6px rgba(0,0,0,0.6);
    margin-bottom: 20px;
    position: relative;
    transition: transform 0.6s ease;
}

#titulo.arriba {
    transform: translateY(-220px);
}

#modalTexto {
    font-size: 18px;
    font-weight: bold;
    padding: 8px 14px;
    margin-right: auto;
}

.boton {
    padding: 14px 22px;
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 17px;
    cursor: pointer;
    margin: 10px;
    background: linear-gradient(to right, #00c6ff, #0072ff);
    transition: 0.3s;
}

.boton:hover:not(:disabled) {
    transform: scale(1.05);
}

.boton:disabled {
    opacity: 0.5;
}

/* SIDEBAR */
.sidebar {
    position: fixed;
    top: 0;
    left: -300px;
    width: 300px;
    height: 100%;
    background: #001f3f;
    color: white;
    padding: 20px;
    transition: 0.3s;
    overflow-y: auto;
    z-index: 10;
}

.sidebar.abierto {
    left: 0;
}

.muestra {
    margin: 10px 0;
    padding: 10px;
    background: #003366;
    border-radius: 6px;
    opacity: 0.4;
    pointer-events: none;
}

.muestra.activa {
    opacity: 1;
    pointer-events: auto;
    cursor: pointer;
}

.muestra:hover {
    background: #005599;
}

/* MODAL */
.modal {
    position: fixed;
    top: 0;
    left: 300px;
    width: calc(100% - 300px);
    height: 100%;
    background: rgba(0,0,0,0.6);
    display: none;
    transform: translateY(60px);
    transition: all 0.4s ease;
    z-index: 20;
}

.modal.activo {
    display: block;
    transform: translateY(0);
}

.modal-content {
   position: relative;
   width: 100%;
   height: 100%;
   display: flex;
   flex-direction: column;
   color: white;
   padding: 10px 40px 40px 40px;
   box-sizing:border-box;
   background: radial-gradient(circle at 30% 30%, rgba(0,198,255,0.4), rgba(0,198,255,0) 40%),
               radial-gradient(circle at 70% 70%, rgba(0,114,255,0.4), rgba(0,114,255,0) 40%),
               linear-gradient(to bottom, #001f3f, #000814);
   overflow-y: auto;
}


.modal-header p {
    margin: 0;
    position: relative;
    flex-shrink: 0;
    width: 100%;
    padding: 0px;
    box-sizing: border-box;
    display: flex;
    justify-content: flex-start;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    z-index: 30;
    border-radius: 10px;
    margin-top: -20px;
    margin-top: 10px; 
}

.cerrar {
    position: fixed;
    top: 1px;
    right: 15px;
    background: red;
    color: white;
    padding: 6px 6px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    z-index: 100;
}

/* Panel de cortes */
.panel-cortes {
    background: rgba(0, 0, 0, 0.7);
    padding: 20px;
    border-radius: 10px;
    margin: 0 20px 0 0;
    box-sizing: border-box;
    flex: 1;
}

.panel-cortes select, .panel-cortes input {
    margin: 0;
    padding: 6px;
    font-size: 13px;
}

.lista-cortes {
    background: rgba(0, 0, 0, 0.5);
    padding: 20px;
    border-radius: 10px;
    margin: 20px 0;
    width: 100%;
    box-sizing: border-box;
    text-align: left;
    border: 1px solid rgba(0, 198, 255, 0.2);
}

.corte-item {
    background: rgba(0, 114, 255, 0.3);
    margin: 5px;
    padding: 8px;
    border-radius: 5px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.corte-item button {
    background: red;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
}

.boton-pequeno {
    padding: 8px 15px;
    font-size: 14px;
    margin: 5px;
}

#grafica {
    width: 100%;
    height: 500px;
    margin-top: 20px;
    cursor: default;
    padding-right: 20px;
    box-sizing: border-box;
}

.boton-peligro {
    background: linear-gradient(to right, #ff416c, #ff4b2b);
}

.boton-exito {
    background: linear-gradient(to right, #00c6ff, #0072ff);
}

body.sidebar-abierto #layout {
    margin-left: 300px;
}

/* Selector de variable para graficar */
.selector-grafica {
    background: rgba(0, 0, 0, 0.7);
    padding: 15px;
    border-radius: 10px;
    margin: 0;
    box-sizing: border-box;
    min-width:260px;
    white-space: nowrap;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.selector-grafica select {
    margin: 10px;
    padding: 8px;
    font-size: 14px;
}

/* ── Nuevos estilos: control de bins y escala ── */
.control-row {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    margin: 8px 0;
}

.control-row label {
    font-size: 14px;
    white-space: nowrap;
}

#numBins {
    flex: 1;
    min-width: 120px;
    max-width: 260px;
    cursor: pointer;
    accent-color: #00c6ff;
}

#binsValDisplay {
    font-weight: bold;
    min-width: 36px;
    text-align: right;
}

.escala-group {
    display: flex;
    gap: 6px;
    margin: 8px 0;
}

.escala-btn {
    padding: 6px 18px;
    font-size: 14px;
    border: 1px solid rgba(255,255,255,0.3);
    border-radius: 8px;
    background: transparent;
    color: rgba(255,255,255,0.6);
    cursor: pointer;
    transition: 0.2s;
}

.escala-btn.activo {
    background: rgba(0,198,255,0.25);
    border-color: #00c6ff;
    color: #fff;
    font-weight: bold;
}

.escala-btn:hover:not(.activo) {
    background: rgba(255,255,255,0.1);
    color: #fff;
}

.js-plotly-plot .plotly .drag {
    cursor: default !important;
}

.js-plotly-plot:hover .plotly .drag {
    cursor: crosshair;
}

.grupo-header {
    background: rgba(0, 198, 255, 0.15);
    border: 1px solid rgba(0, 198, 255, 0.4);
    border-radius: 8px;
    padding: 10px 14px;
    margin: 10px 0 4px;
    cursor: pointer;
    font-size: 15px;
    font-weight: bold;
    color: #00c6ff;
    display: flex;
    justify-content: space-between;
    align-items: center;
    user-select: none;
}

.grupo-header:hover {
    background: rgba(0, 198, 255, 0.25);
}

.grupo-body {
    display: none;
    padding-left: 8px;
}

.grupo-body.abierto {
    display: block;
}

.grupo-header.bloqueado {
    opacity: 0.4;
    pointer-events: none;
}

.contenedor-central {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    width: 100%;
    max-width: 900px;
    margin: 0 auto;
    box-sizing: border-box;
    padding: 0;
}

#btnAyuda {
    position: fixed;
    bottom: 24px;
    right: 24px;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(to right, #00c6ff, #0072ff);
    color: white;
    font-size: 18px;
    font-weight: bold;
    border: none;
    cursor: pointer;
    z-index: 150;
    box-shadow: 0 4px 15px rgba(0,198,255,0.5);
    transition: transform 0.2s;
}

#btnAyuda:hover {
    transform: scale(1.1);
}

#btnAyuda:disabled {
    opacity: 0.3;
    cursor: default;
    transform: none;
    box-shadow: none;
}
</style>
</head>

<body>

<!-- SLIDER -->
<div class="fondo">
    <img src="fondo/fondo1.jpeg">
    <img src="fondo/fondo2.jpeg">
    <img src="fondo/fondo3.jpeg">
    <img src="fondo/fondo4.jpeg">
</div>

<!-- DEGRADADO -->
<div class="overlay"></div>

<!-- CONTENIDO PRINCIPAL -->
<div id="layout"> 
    <h1 id="titulo">Análisis del CMS</h1>
    
    <button id="btnMuestras" class="boton" onclick="habilitarMuestras()">
        Comenzar
    </button>
</div>

<div id="sidebar" class="sidebar">
    <h2>Muestras CMS</h2>

    <div class="grupo-header bloqueado" onclick="toggleGrupo('g2muones')">
        2 Muones <span id="flecha-g2muones">▶</span>
    </div>
    <div class="grupo-body" id="g2muones">
        <div class="muestra" data-file="csv/Jpsimumu.csv" onclick="seleccionar(this)">Muestra 1</div>
        <div class="muestra" data-file="csv/Dimuon_DoubleMu.csv" onclick="seleccionar(this)">Muestra 2</div>
        
    </div>


    <div class="grupo-header bloqueado" onclick="toggleGrupo('g4muones')">
        4 Muones <span id="flecha-g4muones">▶</span> 
    </div>
    <div class="grupo-body" id="g4muones">

    </div>    
    

</div>

<div id="modal" class="modal">
    <div class="modal-content">

        <button class="cerrar" onclick="cerrarModal()">Cerrar</button>

        <div class="modal-body" style="width:100%; box-sizing:border-box;">
            <div class="modal-header">
                <p id="modalTexto"></p>
            </div>
            <div class="contenedor-central">
                <div style="display:flex; gap:16px; align-items:stretch; width:100%; box-sizing:border-box; margin-left:-30px;">
                <div class="selector-grafica">
                    <h3>Opciones de visualización</h3>
                    <div class="control-row">
                        <label>Variable:</label>
                        <select id="variableGrafica" onchange="resetVista()"></select>
                    </div>
                    <button class="boton boton-exito boton-pequeno" onclick="confirmarVariable()">Ver histograma</button>
                </div>

                <div class="panel-cortes" id="panelCortes" style="display:none">
                    <h3>Aplicar Nuevo Corte</h3>
                    <div style="display:flex; align-items:center; gap:10px; flex-wrap:nowrap;">
                        <label>Variable:</label>
                        <select id="variable" disabled></select>
                        <label>Operador:</label>
                        <select id="operador" style="max-width: 130px;>
                            <option value=">">&gt; (mayor que)</option>
                            <option value="<">&lt; (menor que)</option>
                            <option value=">=">&gt;= (mayor o igual)</option>
                            <option value="<=">&lt;= (menor o igual)</option>
                            <option value="abs_lt">|x| &lt; (valor absoluto)</option>
                        </select>
                        <label>Valor:</label>
                        <input type="number" id="valor" value="20" step="any" style="width:80px;">
                        <button class="boton boton-exito" onclick="aplicarCorteAcumulativo()">Aplicar corte</button>
                    </div>
                </div>
            </div>

            <div id="contenedorBins" style="display:none; align-items:center; gap:16px; flex-wrap:wrap; justify-content:center; margin:10px 0;">
                <button class="boton boton-exito boton-pequeno" onclick="actualizarGrafica()">Actualizar gráfica</button>
                <div style="display:flex; align-items:center; gap:8px;">
                    <label style="font-size:13px; white-space:nowrap;">Bins:</label>
                    <input type="range" id="numBins" min="5" max="200" value="50" step="1"
                           style="width:110px; accent-color:#00c6ff;"
                           oninput="document.getElementById('binsValDisplay').textContent = this.value">
                    <span id="binsValDisplay" style="font-size:13px; font-weight:bold; min-width:28px;">50</span>
                </div>
                <div style="display:flex; align-items:center; gap:6px;">   <!-- ✅ escala DENTRO de contenedorBins -->
                    <label style="font-size:13px;">Escala:</label>
                    <button class="escala-btn activo" id="btnLin" onclick="setEscala('lin')">Lineal</button>
                    <button class="escala-btn" id="btnLog" onclick="setEscala('log')">Logarítmica</button>
                </div>
            </div>
            
            <div id="grafica" style="display:none"></div>
                
            </div>

                <div class="lista-cortes" id="listaCortes-container" style="display:none">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <h3 style="margin:0;">Cortes Aplicados</h3>
                        <button class="boton boton-peligro boton-pequeno" onclick="reiniciarCortes()">Reiniciar todos los cortes</button>
                    </div>
                    <div id="listaCortes"></div>
                    <div id="infoEventos" style="margin-top: 10px; padding: 10px; border-radius: 5px;"></div>
                </div>
            </div>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/papaparse@5.4.1/papaparse.min.js"></script>
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

<script>
const sidebar = document.getElementById("sidebar");
const btnMuestras = document.getElementById("btnMuestras");
const titulo = document.getElementById("titulo");
const modal = document.getElementById("modal");
modal.addEventListener("transitioned", ()=>{
    if(!modal.classList.contains("activo")){modal.style.pointerEvents = "none";}
});
const modalTexto = document.getElementById("modalTexto");

let bloqueado = false;
let habilitado = false;
let datosOriginales = [];      // Datos originales sin cortes
let datosActuales = [];        // Datos después de aplicar cortes acumulativos
let listaCortes = [];          // Lista de cortes aplicados
let columnasDisponibles = [];
let escalaLog = false;

function habilitarMuestras() {
    habilitado = true;
    sidebar.classList.add("abierto");
    btnMuestras.disabled = true;
    document.body.classList.add("sidebar-abierto");
    document.querySelectorAll(".muestra").forEach(el => el.classList.add("activa"));
    document.querySelectorAll(".grupo-header").forEach(el => el.classList.remove("bloqueado"));
    document.getElementById("btnAyuda").disabled = true;
}


function procesarDatos(data) {
    // PASO 1: Calcular masa invariante primero
    const tieneNomenclaturaA = data[0].hasOwnProperty('mu1_pt') && data[0].hasOwnProperty('mu2_pt');
    const tieneNomenclaturaB = data[0].hasOwnProperty('pt1') && data[0].hasOwnProperty('pt2');

    if (tieneNomenclaturaA) {
        data.forEach(row => {
            let deta = (row.mu1_eta || 0) - (row.mu2_eta || 0);
            let dphi = (row.mu1_phi || 0) - (row.mu2_phi || 0);
            let M2 = 2 * row.mu1_pt * row.mu2_pt * (Math.cosh(deta) - Math.cos(dphi));
            row.M = Math.sqrt(Math.max(M2, 0));
        });
    } else if (tieneNomenclaturaB) {
        data.forEach(row => {
            let deta = (row.eta1 || 0) - (row.eta2 || 0);
            let dphi = (row.phi1 || 0) - (row.phi2 || 0);
            let M2 = 2 * row.pt1 * row.pt2 * (Math.cosh(deta) - Math.cos(dphi));
            row.M = Math.sqrt(Math.max(M2, 0));
        });
    }

    // PASO 2: Detectar columnas (ahora M ya existe en los datos)
    if (data.length > 0) {
        columnasDisponibles = Object.keys(data[0]).filter(col => {
            return typeof data[0][col] === 'number' &&
                   (col.includes('pt') || col.includes('eta') || col.includes('phi') || col === 'M');
        });

        console.log("Columnas detectadas:", columnasDisponibles);

        // PASO 3: Llenar selectores (M ya está en columnasDisponibles)
        const selectCorte = document.getElementById("variable");
        const selectGrafica = document.getElementById("variableGrafica");

        selectCorte.innerHTML = "";
        selectGrafica.innerHTML = "";

        columnasDisponibles.forEach(col => {
            const option1 = document.createElement("option");
            option1.value = col;
            option1.textContent = col;
            selectCorte.appendChild(option1);

            const option2 = document.createElement("option");
            option2.value = col;
            option2.textContent = col;
            selectGrafica.appendChild(option2);
        });
    }

    datosOriginales = [...data];
    datosActuales = [...data];
    listaCortes = [];
}

function confirmarVariable() {
    if (!datosOriginales || datosOriginales.length === 0) {
        alert("Primero selecciona una muestra");
        return;
    }

    const varSeleccionada = document.getElementById("variableGrafica").value;
    const selectCorte = document.getElementById("variable");

    selectCorte.innerHTML = "";
    columnasDisponibles.filter(c => c !== "M").forEach(col => {
        const opt = document.createElement("option");
        opt.value = col;
        opt.textContent = col; 
        selectCorte.appendChild(opt);
    });

    if (varSeleccionada !== "M") {
        selectCorte.value = varSeleccionada; 
        selectCorte.disabled = true;
    } else {
        selectCorte.disabled = false;
    }
    
    document.getElementById("panelCortes").style.display = "block"; 
    document.getElementById("contenedorBins").style.display = "flex";
    document.getElementById("grafica").style.display = "block";
    document.getElementById("listaCortes-container").style.display = "block";
    actualizarListaCortes();
    dibujarHistogramaCompleto();
}

function aplicarCorteAcumulativo() {
    if (!datosOriginales || datosOriginales.length === 0) {
        alert("Primero carga los datos");
        return;
    }
    
    let variable = document.getElementById("variable").value;
    let operador = document.getElementById("operador").value;
    let valor = parseFloat(document.getElementById("valor").value);
    
    if (isNaN(valor)) {
        alert("Por favor, ingresa un valor válido");
        return;
    }
    
    if (datosOriginales.length > 0 && !datosOriginales[0].hasOwnProperty(variable)) {
        alert(`La variable '${variable}' no existe. Columnas disponibles: ${Object.keys(datosOriginales[0]).join(', ')}`);
        return;
    }
    
    // Crear función de filtro según el operador
    let filtroFunc;
    switch(operador) {
        case '>':
            filtroFunc = row => row[variable] > valor;
            break;
        case '<':
            filtroFunc = row => row[variable] < valor;
            break;
        case '>=':
            filtroFunc = row => row[variable] >= valor;
            break;
        case '<=':
            filtroFunc = row => row[variable] <= valor;
            break;
        case 'abs_lt':
            filtroFunc = row => Math.abs(row[variable]) < valor;
            break;
        default:
            filtroFunc = row => row[variable] > valor;
    }
    
    // Aplicar filtro a los datos actuales
    let nuevosDatos = datosActuales.filter(row => filtroFunc(row));
    
    if (nuevosDatos.length === 0) {
        alert("Este corte eliminaría todos los eventos. No se aplicará.");
        return;
    }
    
    // Guardar el corte
    listaCortes.push({
        variable: variable,
        operador: operador,
        valor: valor,
        descripcion: `${variable} ${operador == 'abs_lt' ? '|x| <' : operador} ${valor}`,
        eventosAntes: datosActuales.length,
        eventosDespues: nuevosDatos.length
    });
    
    // Actualizar datos
    datosActuales = nuevosDatos;
    
    // Actualizar UI
    actualizarListaCortes();
    dibujarHistogramaCompleto();
}

function reiniciarCortes() {
    if (!datosOriginales || datosOriginales.length === 0) {
        alert("No hay datos cargados"); 
        return;
    }
    
    datosActuales = [...datosOriginales];
    listaCortes = [];
    actualizarListaCortes();
    dibujarHistogramaCompleto();
}

function eliminarCorte(indice) {
    if (indice < 0 || indice >= listaCortes.length) return;
    
    // Reaplicar todos los cortes excepto el seleccionado
    let datosTemp = [...datosOriginales];
    
    for (let i = 0; i < listaCortes.length; i++) {
        if (i === indice) continue;
        
        let corte = listaCortes[i];
        let filtroFunc;
        
        switch(corte.operador) {
            case '>':
                filtroFunc = row => row[corte.variable] > corte.valor;
                break;
            case '<':
                filtroFunc = row => row[corte.variable] < corte.valor;
                break;
            case '>=':
                filtroFunc = row => row[corte.variable] >= corte.valor;
                break;
            case '<=':
                filtroFunc = row => row[corte.variable] <= corte.valor;
                break;
            case 'abs_lt':
                filtroFunc = row => Math.abs(row[corte.variable]) < corte.valor;
                break;
        }
        
        datosTemp = datosTemp.filter(row => filtroFunc(row));
    }
    
    // Eliminar el corte de la lista
    listaCortes.splice(indice, 1);
    datosActuales = datosTemp;
    
    actualizarListaCortes();
    dibujarHistogramaCompleto();
}

function actualizarListaCortes() {
    const container = document.getElementById("listaCortes");
    const infoContainer = document.getElementById("infoEventos");
    
    if (listaCortes.length === 0) {
        container.innerHTML = "<p style='color: #aaa;'>No hay cortes aplicados</p>";
    } else {
        container.innerHTML = listaCortes.map((corte, idx) => `
            <div class="corte-item">
                <span>
                    <strong>Corte ${idx + 1}:</strong> ${corte.descripcion}<br>
                    <small style="font-size: 12px;">Eventos: ${corte.eventosAntes} → ${corte.eventosDespues} (${((corte.eventosDespues/corte.eventosAntes)*100).toFixed(1)}% retenidos)</small>
                </span>
                <button onclick="eliminarCorte(${idx})">✖</button>
            </div>
        `).join('');
    }
    
    const eficiencia = ((datosActuales.length / datosOriginales.length) * 100).toFixed(2);
    infoContainer.innerHTML = `
        <strong>Cutflow:</strong><br>
        ▸ Eventos originales: ${datosOriginales.length}<br>
        ▸ Eventos después de cortes: ${datosActuales.length}<br>
        <strong>▸ Eficiencia total: ${eficiencia}%</strong><br>
        <small style="font-size: 12px;">(Los histogramas muestran el rango completo de los datos)</small>
    `;
}

function setEscala(modo) {
    escalaLog = (modo === 'log');
    document.getElementById('btnLin').classList.toggle('activo', !escalaLog);
    document.getElementById('btnLog').classList.toggle('activo', escalaLog);
    dibujarHistogramaCompleto();
}

function dibujarHistogramaCompleto() {
    if (!datosOriginales || datosOriginales.length === 0) {
        return;
    }
    
    // Obtener la variable seleccionada para graficar
    let variableMostrar = document.getElementById("variableGrafica").value;
    
    // Obtener datos para el histograma (rango completo)
    let datosAntes = datosOriginales.map(r => r[variableMostrar]).filter(x => typeof x === "number" && !isNaN(x));
    let datosDespues = datosActuales.map(r => r[variableMostrar]).filter(x => typeof x === "number" && !isNaN(x));
    
    if (datosAntes.length === 0) {
        console.log("No hay datos para graficar");
        return;
    }
    
    // Calcular rango COMPLETO de los datos (sin zoom)
    let minValor = Math.min(...datosAntes);
    let maxValor = Math.max(...datosAntes);
    
    // Añadir un pequeño margen del 5% para mejor visualización
    let rango = maxValor - minValor;
    let rangoMin = minValor - rango * 0.05;
    let rangoMax = maxValor + rango * 0.05;
    
    // Número de bins (usando regla de Freedman-Diaconis para mejor resolución)
    let numBins = parseInt(document.getElementById("numBins").value);
    let binWidth = (maxValor - minValor) / numBins;
    
   
    let binCenters = [];
    let histAntes = new Array(numBins).fill(0);
    let histDespues = new Array(numBins).fill(0);
    
    for (let i = 0; i < numBins; i++) {
        binCenters.push(minValor + (i + 0.5) * binWidth);
    }
    
    datosAntes.forEach(valor => {
        let binIndex = Math.floor((valor - minValor) / binWidth);
        if (binIndex >= 0 && binIndex < numBins) histAntes[binIndex]++;
    });
    
    datosDespues.forEach(valor => {
        let binIndex = Math.floor((valor - minValor) / binWidth);
        if (binIndex >= 0 && binIndex < numBins) histDespues[binIndex]++;
    });
    
    // Normalizar los histogramas para comparación justa (opcional)
    let maxAntes = Math.max(...histAntes);
    let maxDespues = Math.max(...histDespues);
    let yMax = Math.max(maxAntes, maxDespues) * 1.1;
    
    // Determinar si es una variable angular (phi) o no
    let isAngular = variableMostrar.includes('phi');
    
    // Crear gráfica con rango COMPLETO
    let layout = {
        title: {
            text: `Distribución COMPLETA de ${variableMostrar} - Antes vs Después de cortes acumulativos`,
            font: { size: 16, color: 'white' }
        },
        xaxis: { 
            title: variableMostrar,
            gridcolor: 'rgba(255, 255, 255, 0.1)',
            zerolinecolor: 'rgba(255, 255, 255, 0.3)',
            titlefont: { color: 'white' },
            tickfont: { color: 'white' },
            range: [rangoMin, rangoMax]  // Rango COMPLETO sin zoom
        },
        yaxis: { 
            title: "Número de eventos",
            gridcolor: 'rgba(255, 255, 255, 0.1)',
            titlefont: { color: 'white' },
            tickfont: { color: 'white' },
            type: escalaLog ? 'log' : 'linear',
            ...(escalaLog ? {} : { range: [0, yMax]})
        },

        plot_bgcolor: 'rgba(0, 0, 0, 0.3)',
        paper_bgcolor: 'rgba(0, 0, 0, 0)',
        legend: {
            x: 0.02,
            y: 0.98,
            bgcolor: 'rgba(0, 0, 0, 0.6)',
            font: { color: 'white', size: 12 }
        },
        barmode: 'overlay',
        bargap: 0.1
    };
    
    // Para variables eta, añadir líneas en |eta| = 2.4 (typical acceptance)
    let shapes = [];
    if (variableMostrar.includes('eta')) {
        shapes.push({
            type: 'line',
            x0: -2.4,
            x1: -2.4,
            y0: 0,
            y1: 1,
            yref: 'paper',
            line: { color: 'rgba(255, 255, 255, 0.3)', width: 1, dash: 'dash' },
            name: 'Aceptación típica'
        });
        shapes.push({
            type: 'line',
            x0: 2.4,
            x1: 2.4,
            y0: 0,
            y1: 1,
            yref: 'paper',
            line: { color: 'rgba(255, 255, 255, 0.3)', width: 1, dash: 'dash' },
            name: 'Aceptación típica'
        });
        layout.shapes = shapes;
    }
    
    Plotly.newPlot("grafica", [
        {
            x: binCenters,
            y: histAntes,
            type: "bar",
            name: `Antes de cortes (${datosAntes.length} eventos) - Rango completo`,
            marker: { color: 'rgba(54, 162, 235, 0.6)' },
            width: binWidth * 0.85,
            opacity: 0.7
        },
        {
            x: binCenters,
            y: histDespues,
            type: "bar",
            name: `Después de cortes (${datosDespues.length} eventos)`,
            marker: { color: 'rgba(255, 99, 132, 0.8)' },
            width: binWidth * 0.85,
            opacity: 0.9
        }
    ], layout, {
        modeBarButtonsToRemove:[
            'pan2d','select2d','lasso2d','autoScale2d',
            'hoverClosestCartesian','hoverCompareCartesian',
            'togglrSpikelines', 'resetScale2d'
        ],
        scrollZoom: false,
        displaylogo: false
    });
}

function actualizarGrafica() {
    dibujarHistogramaCompleto();
}

function seleccionar(el) {
    if (!habilitado || bloqueado) return;

    const nombreMuestra = el.textContent.trim();

    bloqueado = true;
    document.querySelectorAll(".muestra").forEach(e => e.classList.remove("activa"));
    document.querySelectorAll(".grupo-header").forEach(e => e.classList.add("bloqueado"));
    titulo.classList.add("arriba");

    const archivo = el.dataset.file;
    limpiarVistaCargando();
    modalTexto.innerText = "Cargando datos...";
    modal.style.pointerEvents = "auto";
    modal.classList.add("activo");

    Papa.parse(archivo, {
        download: true,
        header: true,
        dynamicTyping: true,
        complete: function(results) {
            procesarDatos(results.data);
            modalTexto.innerText = `${nombreMuestra} — Datos listos`;
            bloqueado = false;
        },
        error: function(error) {
            console.error("Error cargando CSV:", error);
            modalTexto.innerText = "Error cargando el archivo";
            bloqueado = false;
        }
    });
}

function resetVista() {
    datosActuales = [...datosOriginales];
    listaCortes = [];
    escalaLog = false;
    document.getElementById('btnLin').classList.add('activo');
    document.getElementById('btnLog').classList.remove('activo');
    document.getElementById('numBins').value = 50;
    document.getElementById('binsValDisplay').textContent = '50';
    document.getElementById("panelCortes").style.display = "none";
    document.getElementById("contenedorBins").style.display = "none";
    document.getElementById("grafica").style.display = "none";
    document.getElementById("listaCortes-container").style.display = "none";
}

function cerrarModal() {
    modal.classList.remove("activo");
    modal.style.pointerEvents = "none";
    bloqueado = false;
    titulo.classList.remove("arriba");
    document.querySelectorAll(".muestra").forEach(e => e.classList.add("activa")); 
    document.querySelectorAll(".grupo-header").forEach(e => e.classList.remove("bloqueado"));
    document.getElementById("btnAyuda").disabled = false;
    // habilitado sigue siendo true → sidebar permanece activo
}

document.addEventListener("contextmenu", e => {
    e.preventDefault();
    if (!modal.classList.contains("activo")) {
        sidebar.classList.remove("abierto");
        btnMuestras.disabled = false;
        document.body.classList.remove("sidebar-abierto");
        habilitado = false;
        bloqueado = false;
        document.querySelectorAll(".muestra").forEach(e => e.classList.remove("activa"));
        document.querySelectorAll(".grupo-header").forEach(el => el.classList.add("bloqueado"));
        document.querySelectorAll(".grupo-body.abierto").forEach(body => {
            body.classList.remove("abierto");
            const flecha = document.getElementById("flecha-" + body.id);
            if (flecha) flecha.textContent = "▶";
        });
         document.getElementById("btnAyuda").disabled = false;
    }
});

const graficaDiv = document.getElementById("grafica");
graficaDiv.addEventListener("mouseenter", () => {
    Plotly.relayout("grafica", { scrollZoom: true });
});
graficaDiv.addEventListener("mouseleave", () => {
    Plotly.relayout("grafica", { scrollZoom: false });
});

function limpiarVistaCargando() {
    datosOriginales = [];
    datosActuales = [];
    listaCortes = [];
    columnasDisponibles = [];
    escalaLog = false;

    document.getElementById('btnLin').classList.add('activo');
    document.getElementById('btnLog').classList.remove('activo');
    document.getElementById('numBins').value = 50;
    document.getElementById('binsValDisplay').textContent = '50';

    document.getElementById("variableGrafica").innerHTML = "";
    document.getElementById("variable").innerHTML = "";

    document.getElementById("panelCortes").style.display = "none";
    document.getElementById("contenedorBins").style.display = "none";
    document.getElementById("grafica").style.display = "none";
    document.getElementById("listaCortes-container").style.display = "none";

    if (document.getElementById("grafica")._fullLayout) {
        Plotly.purge("grafica");
    }

    document.getElementById("listaCortes").innerHTML = "";
    document.getElementById("infoEventos").innerHTML = "";
}

function toggleGrupo(id) {
    const body = document.getElementById(id);
    const flecha = document.getElementById("flecha-" + id);
    const abierto = body.classList.toggle("abierto");
    flecha.textContent = abierto ? "▼" : "▶";
}

function abrirAyuda() {
    document.getElementById("modalAyuda").style.display = "flex";
}

function cerrarAyuda() {
    document.getElementById("modalAyuda").style.display = "none";
}

function cambiarTab(tab) {
    const tabs = ['guia', 'fisica', 'analisis', 'simulacion'];
    tabs.forEach(t => {
        const btn = document.getElementById('tab' + t.charAt(0).toUpperCase() + t.slice(1));
        const contenido = document.getElementById('contenido' + t.charAt(0).toUpperCase() + t.slice(1));
        const activo = t === tab;
        contenido.style.display = activo ? 'block' : 'none';
        btn.style.background = activo ? 'rgba(0,198,255,0.2)' : 'transparent';
        btn.style.color = activo ? '#00c6ff' : 'rgba(255,255,255,0.5)';
        btn.style.borderBottom = activo ? '3px solid #00c6ff' : '3px solid transparent';
    });
    if (tab === 'simulacion') iniciarSimulacion();
    else detenerSimulacion();
}

// ── Simulación CMS ──
let animCMS = null;
let particulasCMS = [];

function iniciarSimulacion() {
    const canvas = document.getElementById('canvasCMS');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    const cx = canvas.width / 2;
    const cy = canvas.height / 2;
    const R = canvas.width / 2 - 4;

    canvas.onclick = () => dispararColision(cx, cy);

    function dispararColision(x, y) {
        const nMuones = 2 + Math.floor(Math.random() * 3);
        const nOtras  = 4 + Math.floor(Math.random() * 8);
        for (let i = 0; i < nMuones; i++) {
            const ang = Math.random() * Math.PI * 2;
            particulasCMS.push({ x, y, vx: Math.cos(ang) * 3.5, vy: Math.sin(ang) * 3.5,
                color: '#ff4466', ancho: 2.2, life: 1, decay: 0.008, tipo: 'muon' });
            particulasCMS.push({ x, y, vx: -Math.cos(ang) * 3.5, vy: -Math.sin(ang) * 3.5,
                color: '#ff4466', ancho: 2.2, life: 1, decay: 0.008, tipo: 'muon' });
        }
        for (let i = 0; i < nOtras; i++) {
            const ang = Math.random() * Math.PI * 2;
            const vel = 1.5 + Math.random() * 2.5;
            particulasCMS.push({ x, y, vx: Math.cos(ang) * vel, vy: Math.sin(ang) * vel,
                color: `hsl(${180 + Math.random()*60},80%,65%)`, ancho: 1.2,
                life: 1, decay: 0.006 + Math.random() * 0.006, tipo: 'otra' });
        }
    }

    function dibujarDetector(ctx) {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // Fondo
        const bg = ctx.createRadialGradient(cx, cy, 0, cx, cy, R);
        bg.addColorStop(0, '#000d1a');
        bg.addColorStop(1, '#000508');
        ctx.beginPath();
        ctx.arc(cx, cy, R, 0, Math.PI * 2);
        ctx.fillStyle = bg;
        ctx.fill();

        // Capas del detector
        const capas = [
            { r: R * 0.18, color: 'rgba(0,198,255,0.15)', label: 'Tracker' },
            { r: R * 0.38, color: 'rgba(0,198,255,0.10)', label: 'ECAL' },
            { r: R * 0.58, color: 'rgba(0,198,255,0.08)', label: 'HCAL' },
            { r: R * 0.80, color: 'rgba(0,198,255,0.06)', label: 'Solenoide' },
            { r: R * 0.97, color: 'rgba(0,198,255,0.05)', label: 'Muon' },
        ];

        capas.forEach(c => {
            ctx.beginPath();
            ctx.arc(cx, cy, c.r, 0, Math.PI * 2);
            ctx.strokeStyle = c.color.replace(')', ', 0.6)').replace('rgba', 'rgba');
            ctx.lineWidth = 1;
            ctx.stroke();
            ctx.fillStyle = c.color;
            ctx.fill();

            // Etiqueta
            ctx.fillStyle = 'rgba(0,198,255,0.35)';
            ctx.font = '10px Arial';
            ctx.fillText(c.label, cx + c.r * 0.72, cy - 4);
        });

        // Líneas radiales de referencia
        for (let i = 0; i < 24; i++) {
            const ang = (i / 24) * Math.PI * 2;
            ctx.beginPath();
            ctx.moveTo(cx, cy);
            ctx.lineTo(cx + Math.cos(ang) * R * 0.97, cy + Math.sin(ang) * R * 0.97);
            ctx.strokeStyle = 'rgba(0,198,255,0.04)';
            ctx.lineWidth = 1;
            ctx.stroke();
        }

        // Punto central (IP)
        ctx.beginPath();
        ctx.arc(cx, cy, 4, 0, Math.PI * 2);
        ctx.fillStyle = 'rgba(255,255,255,0.9)';
        ctx.fill();
    }

    function dibujarParticulas(ctx) {
        particulasCMS = particulasCMS.filter(p => p.life > 0);
        particulasCMS.forEach(p => {
            ctx.beginPath();
            ctx.moveTo(p.x - p.vx * 3, p.y - p.vy * 3);
            ctx.lineTo(p.x, p.y);
            ctx.strokeStyle = p.color.includes('hsl')
                ? p.color.replace(')', `, ${p.life})` ).replace('hsl', 'hsla')
                : p.color + Math.floor(p.life * 255).toString(16).padStart(2,'0');
            ctx.lineWidth = p.ancho * p.life;
            ctx.stroke();
            p.x += p.vx;
            p.y += p.vy;
            p.life -= p.decay;
            const dist = Math.hypot(p.x - cx, p.y - cy);
            if (dist > R) p.life = 0;
        });
    }

    // Colisión automática periódica
    let timer = 0;
    function loop() {
        dibujarDetector(ctx);
        dibujarParticulas(ctx);
        timer++;
        if (timer % 90 === 0) dispararColision(cx, cy);
        animCMS = requestAnimationFrame(loop);
    }

    if (animCMS) cancelAnimationFrame(animCMS);
    particulasCMS = [];
    dispararColision(cx, cy);
    loop();
}

function detenerSimulacion() {
    if (animCMS) {
        cancelAnimationFrame(animCMS);
        animCMS = null;
    }
    particulasCMS = [];
}

</script>
<button id="btnAyuda" onclick="abrirAyuda()" title="Ayuda">?</button>

<div id="modalAyuda" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
     background:rgba(0,10,30,1); z-index:200; justify-content:center; align-items:center;">
     <div style="display:flex; flex-direction:column; width:700px; max-width:90%; max-height:90vh;">

        <!-- Botón cerrar FUERA de la tarjeta -->
        <div style="display:flex; justify-content:flex-end; margin-bottom:8px;">
            <button onclick="cerrarAyuda()"
                style="background:red; color:white; border:none; border-radius:6px;
                       padding:5px 12px; cursor:pointer; font-size:12px; font-weight:bold;">
                ✕ Cerrar
            </button>
        </div>

        <!-- Tarjeta principal -->
        <div style="background:linear-gradient(to bottom, #001f3f, #000814); color:white;
                    border-radius:14px; overflow:hidden;
                    border:1px solid rgba(0,198,255,0.3);">

            <!-- Pestañas -->
            <div style="display:flex; border-bottom:1px solid rgba(0,198,255,0.3);">
                <button id="tabGuia" onclick="cambiarTab('guia')"
                    style="flex:1; padding:14px; background:rgba(0,198,255,0.2); color:#00c6ff;
                           border:none; font-size:15px; font-weight:bold; cursor:pointer;
                           border-bottom:3px solid #00c6ff;">
                    Guía de uso
                </button>
                <button id="tabFisica" onclick="cambiarTab('fisica')"
                    style="flex:1; padding:14px; background:transparent; color:rgba(255,255,255,0.5);
                           border:none; font-size:15px; font-weight:bold; cursor:pointer;
                           border-bottom:3px solid transparent;">
                    Conceptos físicos
                </button>
                    
                <button id="tabAnalisis" onclick="cambiarTab('analisis')"
                style="flex:1; padding:14px; background:transparent; color:rgba(255,255,255,0.5);
                border:none; font-size:15px; font-weight:bold; cursor:pointer;
                border-bottom:3px solid transparent;">
                    Acerca del análisis
                </button>
                
                <button id="tabSimulacion" onclick="cambiarTab('simulacion')"
                style="flex:1; padding:14px; background:transparent; color:rgba(255,255,255,0.5);
                border:none; font-size:15px; font-weight:bold; cursor:pointer;
                border-bottom:3px solid transparent;">
                Simulación
                </button>

            </div>

            <!-- Contenido pestaña Guía -->
            <div id="contenidoGuia" style="padding:28px; overflow-y:auto; max-height:65vh; line-height:1.8;">
                <h2 style="color:#00c6ff; margin-top:0;">¿Cómo usar la aplicación?</h2>
                <p style="color:rgba(255,255,255,0.7); font-size:14px; margin-bottom:20px;">
                    Esta aplicación te permite explorar datos reales del detector CMS del CERN, analizando colisiones de partículas subatómicas mediante histogramas y filtros interactivos.
                </p>
                <ol style="padding-left:20px;">
                    <li style="margin-bottom:14px;">
                        <strong>Comenzar</strong><br>
                        Haz clic en el botón <em>"Comenzar"</em> en el centro de la pantalla. Esto abre el panel lateral izquierdo con las muestras disponibles.
                    </li>
                    <li style="margin-bottom:14px;">
                        <strong>Seleccionar muestra</strong><br>
                        En el panel lateral verás dos grupos: <em>"2 Muones"</em> y <em>"4 Muones"</em>. Haz clic en un grupo para desplegarlo y luego selecciona una muestra. Cada muestra es un conjunto de miles de eventos registrados por el detector CMS. Los datos se cargarán automáticamente.
                    </li>
                    <li style="margin-bottom:14px;">
                        <strong>Elegir variable a graficar</strong><br>
                        Una vez cargados los datos, aparecerá el panel <em>"Opciones de visualización"</em>. Elige la variable que deseas explorar en el menú desplegable y haz clic en <em>"Ver histograma"</em>. Las variables disponibles son propiedades cinemáticas de los muones (pt, eta, phi) o la masa invariante calculada (M).
                    </li>
                    <li style="margin-bottom:14px;">
                        <strong>Aplicar cortes de selección</strong><br>
                        El panel <em>"Aplicar Nuevo Corte"</em> te permite filtrar los eventos. Selecciona una variable, un operador de comparación (mayor que, menor que, etc.) y un valor numérico, luego haz clic en <em>"Aplicar corte"</em>. Los cortes son acumulativos: cada uno se aplica sobre los eventos que sobrevivieron el anterior, permitiéndote refinar progresivamente tu selección.
                    </li>
                    <li style="margin-bottom:14px;">
                        <strong>Ajustar bins y escala</strong><br>
                        El deslizador de <em>"Bins"</em> controla cuántas divisiones tiene el histograma: más bins = más detalle pero más ruido; menos bins = más suavizado. La escala <em>Lineal</em> es útil para ver la forma general; la <em>Logarítmica</em> permite visualizar estructuras en rangos de valores muy diferentes.
                    </li>
                    <li style="margin-bottom:14px;">
                        <strong>Gestionar cortes aplicados</strong><br>
                        El panel <em>"Cortes Aplicados"</em> muestra todos los filtros activos con el número de eventos antes y después de cada uno. Puedes eliminar un corte individual con el botón ✖, o reiniciar todos con <em>"Reiniciar todos los cortes"</em>. El histograma siempre muestra en azul los datos originales y en rojo los datos filtrados.
                    </li>
                    <li style="margin-bottom:14px;">
                        <strong>Volver al inicio</strong><br>
                        Haz clic en el botón <em>"✕ Cerrar"</em> para regresar al panel de selección de muestras, o haz <em>clic derecho</em> en cualquier parte fuera del análisis para volver a la pantalla principal.
                    </li>
                </ol>
            </div>

            <!-- Contenido pestaña Física -->
            <div id="contenidoFisica" style="display:none; padding:28px; overflow-y:auto; max-height:65vh; line-height:1.8;">
                <h2 style="color:#00c6ff; margin-top:0;">Conceptos físicos</h2>
                <p style="color:rgba(255,255,255,0.7); font-size:14px; margin-bottom:20px;">
                    Entender estos conceptos te ayudará a interpretar mejor los resultados.
                </p>

                <h3 style="color:#00c6ff;">¿Qué es el CMS y el LHC?</h3>
                <p>El <strong>LHC</strong> (Large Hadron Collider) es el acelerador de partículas más grande del mundo, ubicado en el CERN (Ginebra, Suiza). Acelera protones a velocidades cercanas a la de la luz y los hace colisionar. El <strong>CMS</strong> (Compact Muon Solenoid) es uno de los detectores que registra los productos de esas colisiones, incluyendo los muones.</p>

                <h3 style="color:#00c6ff;">¿Qué es un muón?</h3>
                <p>El muón es una partícula elemental de la misma familia que el electrón, pero con una masa ~207 veces mayor. Es estable el tiempo suficiente para atravesar el detector completo, lo que lo hace muy útil para el análisis. Cada evento contiene uno o más muones con propiedades medidas:</p>
                <ul style="padding-left:20px;">
                    <li style="margin-bottom:8px;"><strong>pt — Momento transverso</strong> (GeV/c): Es la componente del momento perpendicular al haz. Muones con alto pt provienen típicamente de decaimientos de partículas pesadas.</li>
                    <li style="margin-bottom:8px;"><strong>η — Pseudorapidez</strong>: Describe el ángulo de emisión respecto al haz. Valores cercanos a 0 son perpendiculares al haz; valores altos (|η| > 2) son más paralelos. El CMS detecta muones hasta |η| ≈ 2.4.</li>
                    <li style="margin-bottom:8px;"><strong>φ — Ángulo azimutal</strong> (radianes): Es el ángulo alrededor del eje del haz. En colisiones sin sesgo, los muones se distribuyen uniformemente en φ.</li>
                </ul>

                <h3 style="color:#00c6ff;">Masa invariante</h3>
                <p>Cuando dos muones provienen del decaimiento de una misma partícula, podemos reconstruir la masa de esa partícula original. Esta cantidad se llama <strong>masa invariante M</strong> y se calcula como:</p>
                <p style="background:rgba(0,198,255,0.1); padding:12px 16px; border-radius:8px; font-family:monospace; font-size:15px;">
                    M² = 2 · pt₁ · pt₂ · (cosh(η₁ − η₂) − cos(φ₁ − φ₂))
                </p>
                <p>Un <strong>pico en el histograma de M</strong> indica que muchos pares de muones tienen esa masa, revelando la existencia de una partícula conocida:</p>
                <ul style="padding-left:20px;">
                    <li style="margin-bottom:6px;"><strong>J/ψ (~3.1 GeV)</strong>: mesón compuesto por un quark charm y su antiquark.</li>
                    <li style="margin-bottom:6px;"><strong>Υ (Upsilon, ~9.5 GeV)</strong>: mesón compuesto por un quark bottom y su antiquark.</li>
                    <li style="margin-bottom:6px;"><strong>Z (~91 GeV)</strong>: bosón mediador de la fuerza débil, una de las partículas más importantes del Modelo Estándar.</li>
                </ul>

                <h3 style="color:#00c6ff;">Cortes de selección</h3>
                <p>Los <strong>cortes</strong> son criterios de filtrado para mejorar la calidad de los datos o aislar una señal eliminando el "ruido de fondo":</p>
                <ul style="padding-left:20px;">
                    <li style="margin-bottom:8px;"><strong>pt &gt; valor</strong>: Elimina muones de baja energía que suelen provenir de procesos de fondo.</li>
                    <li style="margin-bottom:8px;"><strong>|η| &lt; 2.4</strong>: Restringe los eventos a la región geométrica donde el CMS mide con buena precisión.</li>
                    <li style="margin-bottom:8px;"><strong>φ uniforme</strong>: Si la distribución en φ no es uniforme tras los cortes, puede indicar ineficiencias del detector.</li>
                </ul>
                <p style="color:rgba(255,255,255,0.6); font-size:13px; margin-top:16px;">
                     <em>Tip: Aplica primero cortes en pt y η, y luego observa cómo cambia el histograma de masa invariante. ¡Así es exactamente como trabajan los científicos del CERN!</em>
                </p>
            </div>
            <!-- Contenido pestaña Análisis -->
             <div id="contenidoAnalisis" style="display:none; padding:28px; overflow-y:auto; max-height:65vh; line-height:1.8;">
                <h2 style="color:#00c6ff; margin-top:0;">Acerca del análisis</h2>
                <p style="color:rgba(255,255,255,0.7); font-size:14px; margin-bottom:20px;">
                    Esta aplicación reproduce, de forma simplificada, el flujo de trabajo real que usan los físicos del CERN para identificar partículas subatómicas a partir de datos del detector CMS.
                </p>

                <h3 style="color:#00c6ff;">¿Qué tipo de datos se analizan?</h3>
                <p>Los datos provienen de colisiones protón-protón registradas por el detector CMS durante operaciones del LHC. Cada <strong>evento</strong> representa una colisión individual y contiene las propiedades cinemáticas de los muones producidos: momento transverso (pt), pseudorapidez (η) y ángulo azimutal (φ).</p>

                <h3 style="color:#00c6ff;">Flujo del análisis</h3>
                <ol style="padding-left:20px;">
                    <li style="margin-bottom:12px;">
                        <strong>Carga de datos</strong><br>
                        Se leen archivos CSV con miles de eventos reales del CMS. Cada fila es un evento con las variables cinemáticas de los muones detectados.
                    </li>
                    <li style="margin-bottom:12px;">
                        <strong>Cálculo de la masa invariante</strong><br>
                        A partir de pt, η y φ de cada par de muones, la aplicación calcula automáticamente la masa invariante M usando la fórmula relativista. Esta es la variable clave para identificar partículas.
                    </li>
                    <li style="margin-bottom:12px;">
                        <strong>Exploración cinemática</strong><br>
                        Antes de buscar señales, se estudian las distribuciones de pt, η y φ para entender la calidad de los datos y la cobertura del detector. Esto permite identificar regiones donde el detector es menos eficiente.
                    </li>
                    <li style="margin-bottom:12px;">
                        <strong>Aplicación de cortes</strong><br>
                        Se aplican filtros (cortes) sobre las variables cinemáticas para seleccionar muones de buena calidad y reducir el ruido de fondo. Típicamente se requiere pt mínimo y |η| dentro de la aceptancia del detector.
                    </li>
                    <li style="margin-bottom:12px;">
                        <strong>Reconstrucción de resonancias</strong><br>
                        Con los cortes aplicados, se analiza el histograma de masa invariante M. Los picos que emergen corresponden a partículas reales que decayeron en dos muones: J/ψ (~3.1 GeV), Υ (~9.5 GeV) o Z (~91 GeV).
                    </li>
                    <li style="margin-bottom:12px;">
                        <strong>Cutflow y eficiencia</strong><br>
                        La aplicación lleva un registro del número de eventos que sobreviven cada corte. Esta tabla, llamada <em>cutflow</em>, permite evaluar cuánta señal se conserva y cuánto fondo se elimina con cada criterio de selección.
                    </li>
                </ol>
                <h3 style="color:#00c6ff;">¿Por qué dos histogramas superpuestos?</h3>
                <p>El histograma azul muestra siempre los datos <strong>originales sin cortes</strong>, mientras que el rojo muestra los datos <strong>después de los cortes aplicados</strong>. Esta superposición permite ver de forma inmediata el impacto de cada filtro sobre la distribución completa, facilitando la optimización de los criterios de selección.</p>
                <h3 style="color:#00c6ff;">Conexión con la física real</h3>
                <p>Este flujo de trabajo es una versión simplificada del análisis que llevó al descubrimiento del <strong>bosón de Higgs en 2012</strong> en el CERN. En ese análisis, los físicos buscaron picos en distribuciones de masa invariante de pares de bosones Z (cada uno decayendo en dos muones), exactamente como se hace aquí.</p>
                
                <p style="color:rgba(255,255,255,0.6); font-size:13px; margin-top:16px; border-top:1px solid rgba(0,198,255,0.2); padding-top:14px;">
                    <em>Los datos utilizados en esta aplicación son datos abiertos (Open Data) publicados oficialmente por el CERN a través del portal <strong>CERN Open Data</strong>, disponibles para uso educativo y de investigación.</em>
                </p>
            </div>
             <!-- Contenido pestaña Simulación -->
              <div id="contenidoSimulacion" style="display:none; padding:20px; overflow-y:auto; max-height:65vh; line-height:1.8; text-align:center;">
                <h2 style="color:#00c6ff; margin-top:0;">Detector CMS</h2>
                <p style="color:rgba(255,255,255,0.7); font-size:14px; margin-bottom:16px;">
                    Vista frontal del detector CMS. Cada colisión produce pares de muones (trazas rojas) y otras partículas (trazas azules) que se alejan del punto de colisión central.
                </p>
                <canvas id="canvasCMS" width="500" height="500"
                style="border-radius:50%; border:2px solid rgba(0,198,255,0.4);
                box-shadow:0 0 30px rgba(0,198,255,0.3); cursor:pointer;"
                title="Clic para disparar una colisión manual">
            </canvas>
            <p style="color:rgba(255,255,255,0.4); font-size:12px; margin-top:10px;">
                Haz clic en el detector para disparar una colisión 
            </p>
        </div>  
    </div>
</div>
</div>

</body>
</html>