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
 
#btnSimulacion {
    position: fixed;
    bottom: 24px;
    right: 76px;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(to right, #ff8a1e, #ff3b3b);
    color: white;
    font-size: 18px;
    font-weight: bold;
    border: none;
    cursor: pointer;
    z-index: 150;
    box-shadow: 0 4px 15px rgba(255,90,30,0.5);
    transition: transform 0.2s;
}
 
#btnSimulacion:hover {
    transform: scale(1.1);
}
 
#btnSimulacion:disabled {
    opacity: 0.3;
    cursor: default;
    transform: none;
    box-shadow: none;
}
 
#modalSimulacion {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,10,30,1);
    z-index: 200;
    justify-content: center;
    align-items: center;
}
 
#modalSimulacion > div {
    width: 100% !important;
    height: 100% !important;
    max-width: 100% !important;
    max-height: 100% !important;
    display: flex !important;
    flex-direction: column !important;
}
 
#modalSimulacion .modal-sim-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    min-height: 0;
}
#contenidoSimSimulacion {
    flex: 1;
    display: flex;
    flex-direction: column;
    padding: 10px !important;
    overflow: hidden !important;
    min-height: 0;
}
#cms3-root{
    flex: 1;
    display: flex;
    flex-direction: column;
    min-height: 0;
}
#cms3-bar{
    display:flex;
    align-items:center;
    gap:6px;
    flex-wrap:wrap;
    padding:8px 12px;
    background:#02040a;
    border-bottom:1px solid #0d1f33
}
.c3-btn{
    padding:5px 12px;
    font-size:11px;
    font-family:monospace;
    background:transparent;
    border:1px solid #123050;
    color:#5590b8;
    border-radius:4px;
    cursor:pointer;
    transition:.15s
}
.c3-btn:hover{
    border-color:#1d4d80;
    color:#7fbbe0
}
.c3-btn.active{
    background:#0a2540;
    border-color:#2d8fd6;
    color:#5fc8ff
}
#cms3-canvas-wrap{
    flex: 1;
    min-height: 0;
    position: relative;
}
#cms3-canvas-wrap canvas{
    display:block;
    width:100% !important;
    height:100% !important;
}
#cms3-leg{
    display:flex;
    flex-wrap:wrap;
    gap:10px;
    padding:7px 12px;
    background:#02040a;
    border-top:1px solid #0d1f33
}
.c3-leg{
    display:flex;
    align-items:center;
    gap:5px;
    font-size:10px;
    color:#4a7494
}
.c3-sw{
    width:18px;
    height:3px;
    border-radius:1px
}
#cms3-stats{
    display:flex;
    gap:14px;
    flex-wrap:wrap;
    padding:6px 12px;
    background:#01030a;
    border-top:1px solid #0d1f33
}
.c3-st{
    font-size:10px;
    color:#28526e
}
.c3-st b{
    color:#3fb6e0;
    font-weight:normal
}
#cms3-loading{
    position:absolute;
    inset:0;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#3fb6e0;
    font-size:12px;
    background:#020509
}
 
</style>
</head>
 
<body>
 
<div class="fondo">
    <img src="fondo/fondo1.jpeg">
    <img src="fondo/fondo2.jpeg">
    <img src="fondo/fondo3.jpeg">
    <img src="fondo/fondo4.jpeg">
</div>
 
<div class="overlay"></div>
 
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
                        <select id="operador" style="max-width: 130px;">
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
                <div style="display:flex; align-items:center; gap:6px;">
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
 
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/papaparse@5.4.1/papaparse.min.js"></script>
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
 
<script>
const sidebar = document.getElementById("sidebar");
const btnMuestras = document.getElementById("btnMuestras");
const titulo = document.getElementById("titulo");
const modal = document.getElementById("modal");
modal.addEventListener("transitionend", ()=>{
    if(!modal.classList.contains("activo")){modal.style.pointerEvents = "none";}
});
const modalTexto = document.getElementById("modalTexto");
 
let bloqueado = false;
let habilitado = false;
let datosOriginales = [];
let datosActuales = [];
let listaCortes = [];
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
    document.getElementById("btnSimulacion").disabled = true;
}
 
function procesarDatos(data) {
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
 
    if (data.length > 0) {
        columnasDisponibles = Object.keys(data[0]).filter(col => {
            return typeof data[0][col] === 'number' &&
                   (col.includes('pt') || col.includes('eta') || col.includes('phi') || col === 'M');
        });
 
        console.log("Columnas detectadas:", columnasDisponibles);
 
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
    
    let nuevosDatos = datosActuales.filter(row => filtroFunc(row));
    
    if (nuevosDatos.length === 0) {
        alert("Este corte eliminaría todos los eventos. No se aplicará.");
        return;
    }
    
    listaCortes.push({
        variable: variable,
        operador: operador,
        valor: valor,
        descripcion: `${variable} ${operador == 'abs_lt' ? '|x| <' : operador} ${valor}`,
        eventosAntes: datosActuales.length,
        eventosDespues: nuevosDatos.length
    });
    
    datosActuales = nuevosDatos;
    
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
    
    let variableMostrar = document.getElementById("variableGrafica").value;
    
    let datosAntes = datosOriginales.map(r => r[variableMostrar]).filter(x => typeof x === "number" && !isNaN(x));
    let datosDespues = datosActuales.map(r => r[variableMostrar]).filter(x => typeof x === "number" && !isNaN(x));
    
    if (datosAntes.length === 0) {
        console.log("No hay datos para graficar");
        return;
    }
    
    let minValor = Math.min(...datosAntes);
    let maxValor = Math.max(...datosAntes);
    
    let rango = maxValor - minValor;
    let rangoMin = minValor - rango * 0.05;
    let rangoMax = maxValor + rango * 0.05;
    
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
    
    let maxAntes = Math.max(...histAntes);
    let maxDespues = Math.max(...histDespues);
    let yMax = Math.max(maxAntes, maxDespues) * 1.1;
    
    let isAngular = variableMostrar.includes('phi');
    
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
            range: [rangoMin, rangoMax]
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
    document.getElementById("btnSimulacion").disabled = false;
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
         document.getElementById("btnSimulacion").disabled = false;
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
    const tabs = ['guia', 'analisis'];
    tabs.forEach(t => {
        const btn = document.getElementById('tab' + t.charAt(0).toUpperCase() + t.slice(1));
        const contenido = document.getElementById('contenido' + t.charAt(0).toUpperCase() + t.slice(1));
        if (!btn || !contenido) return;
        const activo = t === tab;
        contenido.style.display = activo ? 'block' : 'none';
        btn.style.background = activo ? 'rgba(0,198,255,0.2)' : 'transparent';
        btn.style.color = activo ? '#00c6ff' : 'rgba(255,255,255,0.5)';
        btn.style.borderBottom = activo ? '3px solid #00c6ff' : '3px solid transparent';
    });
}
 
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
 
        const bg = ctx.createRadialGradient(cx, cy, 0, cx, cy, R);
        bg.addColorStop(0, '#000d1a');
        bg.addColorStop(1, '#000508');
        ctx.beginPath();
        ctx.arc(cx, cy, R, 0, Math.PI * 2);
        ctx.fillStyle = bg;
        ctx.fill();
 
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
 
            ctx.fillStyle = 'rgba(0,198,255,0.35)';
            ctx.font = '10px Arial';
            ctx.fillText(c.label, cx + c.r * 0.72, cy - 4);
        });
 
        for (let i = 0; i < 24; i++) {
            const ang = (i / 24) * Math.PI * 2;
            ctx.beginPath();
            ctx.moveTo(cx, cy);
            ctx.lineTo(cx + Math.cos(ang) * R * 0.97, cy + Math.sin(ang) * R * 0.97);
            ctx.strokeStyle = 'rgba(0,198,255,0.04)';
            ctx.lineWidth = 1;
            ctx.stroke();
        }
 
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
 
(function(){
 
var cms3Booted = false;
var cms3RAF = null; 
var cms3HandleResize = null;
 
function cms3Boot(){
  if (typeof THREE === 'undefined') { setTimeout(cms3Boot, 60); return; }
 
  var wrap = document.getElementById('cms3-canvas-wrap');
  if (!wrap) return;
  var loadingEl = document.getElementById('cms3-loading');
  var W = wrap.clientWidth || 680;
  var H = wrap.clientHeight || Math.round(W*10/16);
 
  var scene = new THREE.Scene();
  scene.background = new THREE.Color(0x020509);
  scene.fog = new THREE.FogExp2(0x020509, 0.0009);
 
  var camera = new THREE.PerspectiveCamera(42, W/H, 1, 5000);
 
  var renderer = new THREE.WebGLRenderer({ antialias:true, alpha:false });
  renderer.setPixelRatio(Math.min(window.devicePixelRatio||1, 2));
  renderer.setSize(W, H);
  renderer.outputEncoding = THREE.sRGBEncoding;
  wrap.appendChild(renderer.domElement);
  if (loadingEl) loadingEl.style.display = 'none';
 
  scene.add(new THREE.AmbientLight(0x40556a, 0.55));
  var key = new THREE.DirectionalLight(0xbfe0ff, 0.9);
  key.position.set(300, 400, 200);
  scene.add(key);
  var rim = new THREE.PointLight(0x3fb6ff, 1.1, 2000);
  rim.position.set(-200, 100, -300);
  scene.add(rim);
  var ipLight = new THREE.PointLight(0xffffff, 0, 600);
  scene.add(ipLight);
 
  var SCALE = 90;
  var R = { pipe:.055, tracker:.28, ecal:.44, hcal:.60, sol:.68, m1:.78, m2:.88, m3:.975 };
  var ZF = { pipe:.97, tracker:.90, ecal:.82, hcal:.74, sol:.66, m1:.59, m2:.52, m3:.44 };
  var HZ = 1.35;
 
  var group = new THREE.Group();
  scene.add(group);
 
  var wireMode = false;
  var meshes = [];
 
  function addCylinderLayer(rIn, rOut, halfLen, color, opacity, isMuon, radialSegs){
    radialSegs = radialSegs || 56;
    var geo = new THREE.CylinderGeometry(rOut*SCALE, rOut*SCALE, halfLen*2*SCALE, radialSegs, 1, true);
    geo.rotateX(Math.PI/2);
    var mat = new THREE.MeshPhysicalMaterial({
      color: color,
      transparent: true,
      opacity: opacity,
      metalness: isMuon ? 0.35 : 0.15,
      roughness: isMuon ? 0.55 : 0.35,
      side: THREE.DoubleSide,
      emissive: color,
      emissiveIntensity: 0.10
    });
    var mesh = new THREE.Mesh(geo, mat);
    group.add(mesh);
    meshes.push(mesh);
 
    var edges = new THREE.EdgesGeometry(geo, 1);
    var lineMat = new THREE.LineBasicMaterial({ color: color, transparent:true, opacity: Math.min(1, opacity*2.2) });
    var lines = new THREE.LineSegments(edges, lineMat);
    group.add(lines);
    meshes.push(lines);
 
    return mesh;
  }
 
  addCylinderLayer(0, R.m3,      HZ*ZF.m3,      0xff3333, 0.07, true, 48);
  addCylinderLayer(0, R.m2,      HZ*ZF.m2,      0xff5555, 0.08, true, 48);
  addCylinderLayer(0, R.m1,      HZ*ZF.m1,      0xff7777, 0.09, true, 48);
  addCylinderLayer(0, R.sol,     HZ*ZF.sol,     0xffd24a, 0.16, false, 56);
  addCylinderLayer(0, R.hcal,    HZ*ZF.hcal,    0xff8c1a, 0.14, false, 48);
  addCylinderLayer(0, R.ecal,    HZ*ZF.ecal,    0x36d27a, 0.16, false, 48);
  addCylinderLayer(0, R.tracker, HZ*ZF.tracker, 0x3fa0e8, 0.13, false, 40);
  addCylinderLayer(0, R.pipe,    HZ*ZF.pipe,    0xcfcfcf, 0.45, false, 24);
 
  (function(){
    var ringGroup = new THREE.Group();
    var segs = 18;
    for (var i=0;i<segs;i++){
      var a0 = (i/segs)*Math.PI*2, a1 = ((i+0.55)/segs)*Math.PI*2;
      var shape = new THREE.Shape();
      var rO = R.m3*SCALE, rI = R.m1*SCALE;
      shape.moveTo(Math.cos(a0)*rO, Math.sin(a0)*rO);
      shape.absarc(0,0,rO,a0,a1,false);
      shape.lineTo(Math.cos(a1)*rI, Math.sin(a1)*rI);
      shape.absarc(0,0,rI,a1,a0,true);
      var geo = new THREE.ShapeGeometry(shape);
      var mat = new THREE.MeshBasicMaterial({
        color: i%2===0 ? 0xe6e6e6 : 0xb33322,
        transparent:true, opacity:0.05, side:THREE.DoubleSide
      });
      var capF = new THREE.Mesh(geo, mat);
      capF.position.z = HZ*ZF.m3*SCALE;
      ringGroup.add(capF);
      var capB = capF.clone();
      capB.position.z = -HZ*ZF.m3*SCALE;
      ringGroup.add(capB);
    }
    group.add(ringGroup);
  })();
 
  var ipGeo = new THREE.SphereGeometry(2.4, 16, 16);
  var ipMat = new THREE.MeshBasicMaterial({ color:0xffffff });
  var ipMesh = new THREE.Mesh(ipGeo, ipMat);
  group.add(ipMesh);
 
  function makeGlowTexture(){
    var c = document.createElement('canvas'); c.width=c.height=128;
    var ctx = c.getContext('2d');
    var g = ctx.createRadialGradient(64,64,0,64,64,64);
    g.addColorStop(0,'rgba(255,255,255,1)');
    g.addColorStop(0.3,'rgba(160,220,255,0.7)');
    g.addColorStop(1,'rgba(0,0,0,0)');
    ctx.fillStyle = g; ctx.fillRect(0,0,128,128);
    return new THREE.CanvasTexture(c);
  }
 
  var haloMat = new THREE.SpriteMaterial({
    map: makeGlowTexture(), color: 0x9fd9ff, transparent:true, opacity:0.0, depthWrite:false, blending:THREE.AdditiveBlending
  });
  var halo = new THREE.Sprite(haloMat);
  halo.scale.set(40,40,1);
  group.add(halo);
 
  var gridGeo = new THREE.BufferGeometry();
  var gridPts = [];
  for (var gi=-6; gi<=6; gi++){
    gridPts.push(gi*30,0,-HZ*1.1*SCALE, gi*30,0,HZ*1.1*SCALE);
    gridPts.push(-R.m3*1.1*SCALE,0,gi*30, R.m3*1.1*SCALE,0,gi*30);
  }
  gridGeo.setAttribute('position', new THREE.Float32BufferAttribute(gridPts,3));
  var gridMat = new THREE.LineBasicMaterial({ color:0x0e3050, transparent:true, opacity:0.35 });
  var grid = new THREE.LineSegments(gridGeo, gridMat);
  scene.add(grid);
 
  var axesHelper = new THREE.AxesHelper(70);
  axesHelper.material.transparent = true;
  axesHelper.material.opacity = 0.45;
  scene.add(axesHelper);
 
  var camTheta = 0.7, camPhi = 0.42, camDist = 330;
  var autoOn = false, dragging = false, lastX=0, lastY=0;
 
  var PRESETS = {
    front:{ theta:0, phi:0.001, dist:300 },
    side: { theta:Math.PI/2, phi:0.001, dist:300 },
    top:  { theta:0.001, phi:Math.PI/2-0.05, dist:330 },
    iso:  { theta:0.7, phi:0.42, dist:330 }
  };
 
  function applyCamera(){
    var x = camDist*Math.sin(camTheta)*Math.cos(camPhi);
    var y = camDist*Math.sin(camPhi);
    var z = camDist*Math.cos(camTheta)*Math.cos(camPhi);
    camera.position.set(x,y,z);
    camera.lookAt(0,0,0);
  }
  applyCamera();
 
  window.cms3SetView = function(k){
    var p = PRESETS[k];
    camTheta = p.theta; camPhi = p.phi; camDist = p.dist;
    document.querySelectorAll('.c3-btn[data-v]').forEach(function(b){ b.classList.remove('active'); });
    var btn = document.querySelector('.c3-btn[data-v="'+k+'"]');
    if (btn) btn.classList.add('active');
  };
 
  window.cms3ToggleAuto = function(){
    autoOn = !autoOn;
    document.getElementById('cms3-auto').classList.toggle('active', autoOn);
  };
 
  window.cms3ToggleWire = function(){
    wireMode = !wireMode;
    document.getElementById('cms3-wire').classList.toggle('active', wireMode);
    meshes.forEach(function(m){
      if (m.material && m.material.opacity !== undefined && m.type === 'Mesh'){
        m.visible = !wireMode;
      }
    });
  };
 
  var canvas = renderer.domElement;
  canvas.style.cursor = 'grab';
 
  canvas.addEventListener('mousedown', function(e){
    dragging = true; lastX = e.clientX; lastY = e.clientY;
    canvas.style.cursor = 'grabbing';
  });
  window.addEventListener('mouseup', function(){ dragging=false; canvas.style.cursor='grab'; });
  window.addEventListener('mousemove', function(e){
    if (!dragging) return;
    var dx = e.clientX-lastX, dy = e.clientY-lastY;
    camTheta += dx*0.006;
    camPhi = Math.max(-1.45, Math.min(1.45, camPhi - dy*0.006));
    lastX = e.clientX; lastY = e.clientY;
    document.querySelectorAll('.c3-btn[data-v]').forEach(function(b){ b.classList.remove('active'); });
  });
  canvas.addEventListener('wheel', function(e){
    e.preventDefault();
    camDist = Math.max(80, Math.min(900, camDist + e.deltaY*0.4));
  }, { passive:false });
 
  var touch0 = null;
  canvas.addEventListener('touchstart', function(e){ e.preventDefault(); touch0 = e.touches[0]; }, {passive:false});
  canvas.addEventListener('touchmove', function(e){
    e.preventDefault();
    if (!touch0) return;
    var t = e.touches[0];
    camTheta += (t.clientX-touch0.clientX)*0.008;
    camPhi = Math.max(-1.45, Math.min(1.45, camPhi - (t.clientY-touch0.clientY)*0.008));
    touch0 = t;
  }, {passive:false});
 
  canvas.addEventListener('click', function(){ if(!dragging) spawnCollision(); });
 
  var activeTracks = [];
  var cols=0, mus=0, jts=0, trks=0;
 
  function rndDir(){
    var th = Math.random()*Math.PI*2;
    var ph = (Math.random()-0.5)*Math.PI*0.85;
    return new THREE.Vector3(Math.cos(ph)*Math.cos(th), Math.sin(ph), Math.cos(ph)*Math.sin(th));
  }
 
  function buildHelixPoints(dir, curv, maxLen, steps){
    var pts = [];
    var pos = new THREE.Vector3(0,0,0);
    var vel = dir.clone();
    var stepLen = maxLen/steps;
    for (var i=0;i<steps;i++){
      pts.push(pos.clone());
      var perp = new THREE.Vector3(-vel.z, 0, vel.x).normalize();
      vel.addScaledVector(perp, curv*stepLen*0.02).normalize();
      pos.addScaledVector(vel, stepLen);
      var rxy = Math.sqrt(pos.x*pos.x + pos.y*pos.y);
      if (rxy > R.tracker*SCALE*1.02 || Math.abs(pos.z) > HZ*SCALE*1.05) break;
    }
    return pts;
  }
 
  function buildStraightPoints(dir, maxRxy, maxZ, steps){
    var pts = [];
    var pos = new THREE.Vector3(0,0,0);
    var stepLen = 6;
    for (var i=0;i<steps;i++){
      pts.push(pos.clone());
      pos.addScaledVector(dir, stepLen);
      var rxy = Math.sqrt(pos.x*pos.x + pos.y*pos.y);
      if (rxy > maxRxy*SCALE || Math.abs(pos.z) > maxZ*SCALE) break;
    }
    return pts;
  }
 
  function makeTrackMesh(pts, color, lw){
    if (pts.length < 2) return null;
    var curve = new THREE.CatmullRomCurve3(pts);
    var tubeGeo = new THREE.TubeGeometry(curve, Math.max(8,pts.length), lw, 6, false);
    var mat = new THREE.MeshBasicMaterial({ color: color, transparent:true, opacity:1 });
    var mesh = new THREE.Mesh(tubeGeo, mat);
    group.add(mesh);
    return { mesh: mesh, life:1, decay: 0.012 + Math.random()*0.01 };
  }
 
  function makeJetBar(dir, energy){
    var rIn = R.ecal*SCALE, rOut = rIn + energy*R.hcal*SCALE*0.7;
    var p0 = dir.clone().multiplyScalar(rIn);
    var p1 = dir.clone().multiplyScalar(rOut);
    var geo = new THREE.CylinderGeometry(2.2, 2.2, p0.distanceTo(p1), 8);
    geo.translate(0, p0.distanceTo(p1)/2, 0);
    geo.rotateX(Math.PI/2);
    var mat = new THREE.MeshBasicMaterial({ color:0xffcc22, transparent:true, opacity:0.9 });
    var mesh = new THREE.Mesh(geo, mat);
    mesh.position.copy(p0);
    mesh.quaternion.setFromUnitVectors(new THREE.Vector3(0,0,1), dir);
    group.add(mesh);
    return { mesh: mesh, life:1, decay: 0.006 };
  }
 
  function spawnCollision(){
    cols++;
    var elCol = document.getElementById('c3-col'); if (elCol) elCol.textContent = cols;
 
    ipLight.intensity = 6;
    haloMat.opacity = 0.95;
    halo.scale.set(50,50,1);
 
    var nT = 10 + Math.floor(Math.random()*12);
    trks += nT; var elTrk = document.getElementById('c3-trk'); if (elTrk) elTrk.textContent = trks;
    for (var i=0;i<nT;i++){
      var d = rndDir();
      var curv = (Math.random()>0.5?1:-1)*(0.3+Math.random()*0.9);
      var pts = buildHelixPoints(d, curv, R.tracker*SCALE*1.3, 50);
      var t = makeTrackMesh(pts, 0x3fb6ff, 0.45);
      if (t) activeTracks.push(t);
    }
 
    var nMu = Math.random()<0.4 ? 2 : 0;
    mus += nMu; var elMu = document.getElementById('c3-mu'); if (elMu) elMu.textContent = mus;
    for (i=0;i<nMu;i++){
      d = rndDir();
      pts = buildStraightPoints(d, R.m3*1.01, HZ*1.02, 60);
      t = makeTrackMesh(pts, 0xff3333, 0.7);
      if (t){ t.decay = 0.007; activeTracks.push(t); }
    }
 
    var nEM = 3 + Math.floor(Math.random()*5);
    for (i=0;i<nEM;i++){
      d = rndDir();
      pts = buildStraightPoints(d, R.ecal, HZ*ZF.ecal, 40);
      t = makeTrackMesh(pts, 0x33ff8c, 0.5);
      if (t){ t.decay = 0.018; activeTracks.push(t); }
    }
 
    var nJet = 2 + Math.floor(Math.random()*4);
    jts += nJet; var elJet = document.getElementById('c3-jet'); if (elJet) elJet.textContent = jts;
    for (var j=0;j<nJet;j++){
      d = rndDir();
      var E = 0.3 + Math.random()*0.7;
      var nH = 5 + Math.floor(E*8);
      for (var k=0;k<nH;k++){
        var spread = 0.12 + Math.random()*0.1;
        var dd = d.clone().add(new THREE.Vector3(
          (Math.random()-0.5)*spread, (Math.random()-0.5)*spread, (Math.random()-0.5)*spread
        )).normalize();
        pts = buildStraightPoints(dd, R.hcal*0.62, HZ*0.74, 30);
        var col = Math.random()>0.4 ? 0xffcc22 : 0xff8a1e;
        t = makeTrackMesh(pts, col, 0.4);
        if (t){ t.decay = 0.02; activeTracks.push(t); }
      }
      activeTracks.push(makeJetBar(d, E));
    }
 
    var nH2 = 3 + Math.floor(Math.random()*5);
    for (i=0;i<nH2;i++){
      d = rndDir();
      pts = buildStraightPoints(d, R.hcal*0.63, HZ*0.74, 30);
      t = makeTrackMesh(pts, 0xff8a1e, 0.35);
      if (t){ t.decay = 0.022; activeTracks.push(t); }
    }
  }
  window.cms3SpawnCollision = spawnCollision;
 
  var tick = 0;
  function animate(){
    cms3RAF = requestAnimationFrame(animate);
 
    if (autoOn) camTheta += 0.0035;
    applyCamera();
 
    ipLight.intensity *= 0.90;
    haloMat.opacity *= 0.90;
    halo.scale.multiplyScalar(0.96);
 
    for (var i=activeTracks.length-1;i>=0;i--){
      var tr = activeTracks[i];
      tr.life -= tr.decay;
      if (tr.life <= 0){
        group.remove(tr.mesh);
        tr.mesh.geometry.dispose();
        tr.mesh.material.dispose();
        activeTracks.splice(i,1);
      } else {
        tr.mesh.material.opacity = Math.max(0, tr.life);
      }
    }
 
    tick++;
    if (tick % 95 === 0) spawnCollision();
 
    renderer.render(scene, camera);
  }
 
  function handleResize(){
    var w = wrap.clientWidth;
    var h = wrap.clientHeight;
    if (!w || !h) return;
    camera.aspect = w/h;
    camera.updateProjectionMatrix();
    renderer.setSize(w,h);
  }
  window.addEventListener('resize', handleResize);
  cms3HandleResize = handleResize;
 
  spawnCollision();
  animate();
}
 
 
var originalCambiarTab = window.cambiarTab;
window.abrirSimulacionModal = function(){
    document.getElementById('modalSimulacion').style.display = 'flex';
    cambiarTabSim('cms');
    if (!cms3Booted){
        cms3Booted = true;
        setTimeout(function() {
            cms3Boot();
            setTimeout(function(){ cms3HandleResize && cms3HandleResize(); }, 100);
        }, 50);
    } else {
        setTimeout(function(){ cms3HandleResize && cms3HandleResize(); }, 100);
    }
};
window.cerrarSimulacionModal = function(){
    document.getElementById('modalSimulacion').style.display = 'none';
};
 
window.cambiarTabSim = function(tab){
    const tabs = ['cms', 'fisica', 'simulacion', 'guiasim'];
    const idMap = { cms:'Cms', fisica:'Fisica', simulacion:'Simulacion', guiasim:'Guiasim' };
    const displayMap = { cms:'flex', fisica:'block', simulacion:'flex', guiasim:'block' };
    tabs.forEach(t => {
        const suf = idMap[t];
        const btn = document.getElementById('tabSim' + suf);
        const contenido = document.getElementById('contenidoSim' + suf);
        if (!contenido) return;
        const activo = t === tab;
        contenido.style.display = activo ? displayMap[t] : 'none';
        if (btn) {
            btn.style.background = activo ? 'rgba(0,198,255,0.2)' : 'transparent';
            btn.style.color = activo ? '#00c6ff' : 'rgba(255,255,255,0.5)';
            btn.style.borderBottom = activo ? '3px solid #00c6ff' : '3px solid transparent';
        }
    });
    if (tab === 'simulacion') {
        setTimeout(function(){ cms3HandleResize && cms3HandleResize(); }, 50);
    }
};
 
})();


// Variables globales para el explorador CMS
var cmsExplorer = null;

function initCmsExplorer() {
    if (cmsExplorer) return; // ya inicializado

    var wrap = document.getElementById('cms-explorer-wrap');
    if (!wrap) return;
    var loadingEl = document.getElementById('cms-explorer-loading');
    var W = wrap.clientWidth || 600;
    var H = wrap.clientHeight || 400;

    var scene = new THREE.Scene();
    scene.background = new THREE.Color(0x020509);

    var camera = new THREE.PerspectiveCamera(42, W/H, 1, 5000);

    var renderer = new THREE.WebGLRenderer({ antialias: true, alpha: false });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
    renderer.setSize(W, H);
    renderer.outputEncoding = THREE.sRGBEncoding;
    wrap.appendChild(renderer.domElement);
    if (loadingEl) loadingEl.style.display = 'none';

    // Luces
    scene.add(new THREE.AmbientLight(0x40556a, 0.55));
    var key = new THREE.DirectionalLight(0xbfe0ff, 0.9);
    key.position.set(300, 400, 200);
    scene.add(key);
    var rim = new THREE.PointLight(0x3fb6ff, 1.1, 2000);
    rim.position.set(-200, 100, -300);
    scene.add(rim);

    var SCALE = 90;
    var R = { pipe: 0.055, tracker: 0.28, ecal: 0.44, hcal: 0.60, sol: 0.68, m1: 0.78, m2: 0.88, m3: 0.975 };
    var ZF = { pipe: 0.97, tracker: 0.90, ecal: 0.82, hcal: 0.74, sol: 0.66, m1: 0.59, m2: 0.52, m3: 0.44 };
    var HZ = 1.35;

    var group = new THREE.Group();
    scene.add(group);

    // Definición de capas (se usará para los checkboxes)
    var layerDefs = [
        { name: 'Tubo de haz', rOut: R.pipe, color: 0xcfcfcf, opacity: 0.45, halfLen: HZ * ZF.pipe, radialSegs: 24,
          info: {
            subtitulo: 'El corazón del acelerador',
            material: 'Berilio de alta pureza.',
            funcion: 'Es el tubo por donde circulan, en vacío casi perfecto, los dos haces de protones que viajan en direcciones opuestas cerca de la velocidad de la luz.',
            proposito: 'El berilio se eligió porque tiene muy pocos electrones por átomo, así que las partículas que salen de la colisión lo atraviesan casi sin desviarse ni perder energía, permitiendo que las mediciones del resto del detector sean lo más limpias posible.'
          }
        },
        { name: 'Tracker', rOut: R.tracker, color: 0x3fa0e8, opacity: 0.13, halfLen: HZ * ZF.tracker, radialSegs: 40,
          info: {
            subtitulo: 'Rastreador de trayectorias (Silicon Tracker)',
            material: 'Millones de sensores de silicio, organizados en píxeles (cerca del punto de colisión) y tiras de silicio (más alejadas).',
            funcion: 'Registra puntos exactos por donde pasa cada partícula cargada, permitiendo reconstruir su trayectoria curva dentro del campo magnético del solenoide.',
            proposito: 'La curvatura de la trayectoria indica el momento (pt) y la carga eléctrica de la partícula. También permite ubicar con precisión el punto donde ocurrió la colisión (vértice primario) y posibles decaimientos secundarios.'
          }
        },
        { name: 'ECAL', rOut: R.ecal, color: 0x36d27a, opacity: 0.16, halfLen: HZ * ZF.ecal, radialSegs: 48,
          info: {
            subtitulo: 'Calorímetro electromagnético',
            material: 'Cristales centelladores de tungstenato de plomo (PbWO4), muy densos y transparentes.',
            funcion: 'Detiene por completo a electrones y fotones, que depositan toda su energía en los cristales y producen destellos de luz proporcionales a esa energía.',
            proposito: 'Permite medir con gran precisión la energía de electrones y fotones, clave para identificar procesos como la desintegración del bosón de Higgs en dos fotones.'
          }
        },
        { name: 'HCAL', rOut: R.hcal, color: 0xff8c1a, opacity: 0.14, halfLen: HZ * ZF.hcal, radialSegs: 48,
          info: {
            subtitulo: 'Calorímetro hadrónico',
            material: 'Capas alternadas de latón (o acero) como material absorbente y centelladores plásticos como material activo.',
            funcion: 'Detiene y mide la energía de los hadrones (protones, neutrones, piones) que atraviesan el ECAL sin ser absorbidos por completo, generando "lluvias" de partículas secundarias.',
            proposito: 'Es esencial para reconstruir jets (chorros de hadrones) y para estimar la energía transversa faltante, una señal indirecta de partículas que escapan sin ser detectadas, como los neutrinos.'
          }
        },
        { name: 'Solenoide', rOut: R.sol, color: 0xffd24a, opacity: 0.16, halfLen: HZ * ZF.sol, radialSegs: 56,
          info: {
            subtitulo: 'Imán solenoide superconductor',
            material: 'Bobina superconductora de niobio-titanio, enfriada a temperaturas criogénicas (~4 K).',
            funcion: 'Genera un campo magnético intenso y muy uniforme de unos 3.8 Tesla (cerca de 100,000 veces el campo magnético terrestre) dentro del volumen del tracker y los calorímetros.',
            proposito: 'El campo magnético curva la trayectoria de las partículas cargadas; midiendo esa curvatura en el tracker se calcula su momento. De hecho, "CMS" significa Compact Muon Solenoid, en honor a este imán.'
          }
        },
        { name: 'Muón 1', rOut: R.m1, color: 0xff7777, opacity: 0.09, halfLen: HZ * ZF.m1, radialSegs: 48,
          info: {
            subtitulo: 'Cámaras de muones — primera estación',
            material: 'Cámaras de gas (tubos de deriva y cámaras de placas resistivas) intercaladas con el yugo de hierro que retorna el flujo magnético.',
            funcion: 'Detecta el paso de muones, las únicas partículas cargadas capaces de atravesar el tubo de haz, el tracker y ambos calorímetros sin ser absorbidas.',
            proposito: 'Esta primera estación, la más cercana al centro, empieza a registrar la posición del muón para reconstruir su trayectoria fuera del solenoide.'
          }
        },
        { name: 'Muón 2', rOut: R.m2, color: 0xff5555, opacity: 0.08, halfLen: HZ * ZF.m2, radialSegs: 48,
          info: {
            subtitulo: 'Cámaras de muones — segunda estación',
            material: 'Mismo tipo de cámaras de gas, separadas de la anterior por más hierro del yugo magnético.',
            funcion: 'Aporta un segundo punto de medición de la posición del muón, más alejado del centro.',
            proposito: 'Al combinar varias estaciones se reconstruye con precisión la curva del muón fuera del solenoide, lo que permite calcular su momento de forma independiente al tracker, como verificación cruzada.'
          }
        },
        { name: 'Muón 3', rOut: R.m3, color: 0xff3333, opacity: 0.07, halfLen: HZ * ZF.m3, radialSegs: 48,
          info: {
            subtitulo: 'Cámaras de muones — estación exterior',
            material: 'Cámaras de gas, en la capa más externa del detector, justo antes del límite del propio CMS.',
            funcion: 'Es la última estación que registra la posición del muón antes de que abandone el detector.',
            proposito: 'Confirma que la partícula detectada es realmente un muón (y no ruido) y cierra la reconstrucción de su trayectoria. Los muones son la firma clave de procesos como la desintegración del Higgs en cuatro muones.'
          }
        }
    ];

    var layerGroups = [];

    function addLayer(def) {
        var groupLayer = new THREE.Group();
        var geo = new THREE.CylinderGeometry(def.rOut * SCALE, def.rOut * SCALE, def.halfLen * 2 * SCALE, def.radialSegs, 1, true);
        geo.rotateX(Math.PI / 2);
        var mat = new THREE.MeshPhysicalMaterial({
            color: def.color,
            transparent: true,
            opacity: def.opacity,
            metalness: 0.15,
            roughness: 0.35,
            side: THREE.DoubleSide,
            emissive: def.color,
            emissiveIntensity: 0.10
        });
        var mesh = new THREE.Mesh(geo, mat);
        groupLayer.add(mesh);

        var edges = new THREE.EdgesGeometry(geo, 1);
        var lineMat = new THREE.LineBasicMaterial({ color: def.color, transparent: true, opacity: Math.min(1, def.opacity * 2.2) });
        var lines = new THREE.LineSegments(edges, lineMat);
        groupLayer.add(lines);

        group.add(groupLayer);
        layerGroups.push(groupLayer);
        return groupLayer;
    }

    // Crear capas
    layerDefs.forEach(function(def) { addLayer(def); });

    // Punto de interacción (IP)
    var ipGeo = new THREE.SphereGeometry(2.4, 16, 16);
    var ipMat = new THREE.MeshBasicMaterial({ color: 0xffffff });
    var ipMesh = new THREE.Mesh(ipGeo, ipMat);
    group.add(ipMesh);

    // Grid
    var gridGeo = new THREE.BufferGeometry();
    var gridPts = [];
    for (var gi = -6; gi <= 6; gi++) {
        gridPts.push(gi * 30, 0, -HZ * 1.1 * SCALE, gi * 30, 0, HZ * 1.1 * SCALE);
        gridPts.push(-R.m3 * 1.1 * SCALE, 0, gi * 30, R.m3 * 1.1 * SCALE, 0, gi * 30);
    }
    gridGeo.setAttribute('position', new THREE.Float32BufferAttribute(gridPts, 3));
    var gridMat = new THREE.LineBasicMaterial({ color: 0x0e3050, transparent: true, opacity: 0.35 });
    var grid = new THREE.LineSegments(gridGeo, gridMat);
    scene.add(grid);

    // Ejes
    var axesHelper = new THREE.AxesHelper(70);
    axesHelper.material.transparent = true;
    axesHelper.material.opacity = 0.45;
    scene.add(axesHelper);

    // Controles de cámara (igual que en la simulación)
    var camTheta = 0.7, camPhi = 0.42, camDist = 330;
    var dragging = false, lastX = 0, lastY = 0;

    function applyCamera() {
        var x = camDist * Math.sin(camTheta) * Math.cos(camPhi);
        var y = camDist * Math.sin(camPhi);
        var z = camDist * Math.cos(camTheta) * Math.cos(camPhi);
        camera.position.set(x, y, z);
        camera.lookAt(0, 0, 0);
    }
    applyCamera();

    var canvas = renderer.domElement;
    canvas.style.cursor = 'grab';

    canvas.addEventListener('mousedown', function(e) {
        dragging = true;
        lastX = e.clientX;
        lastY = e.clientY;
        canvas.style.cursor = 'grabbing';
    });
    window.addEventListener('mouseup', function() {
        dragging = false;
        canvas.style.cursor = 'grab';
    });
    window.addEventListener('mousemove', function(e) {
        if (!dragging) return;
        var dx = e.clientX - lastX;
        var dy = e.clientY - lastY;
        camTheta += dx * 0.006;
        camPhi = Math.max(-1.45, Math.min(1.45, camPhi - dy * 0.006));
        lastX = e.clientX;
        lastY = e.clientY;
    });
    canvas.addEventListener('wheel', function(e) {
        e.preventDefault();
        camDist = Math.max(80, Math.min(900, camDist + e.deltaY * 0.4));
    }, { passive: false });

    // Touch events
    var touch0 = null;
    canvas.addEventListener('touchstart', function(e) {
        e.preventDefault();
        touch0 = e.touches[0];
    }, { passive: false });
    canvas.addEventListener('touchmove', function(e) {
        e.preventDefault();
        if (!touch0) return;
        var t = e.touches[0];
        camTheta += (t.clientX - touch0.clientX) * 0.008;
        camPhi = Math.max(-1.45, Math.min(1.45, camPhi - (t.clientY - touch0.clientY) * 0.008));
        touch0 = t;
    }, { passive: false });

    // Función para resetear vista
    window.cmsExplorerResetView = function() {
        camTheta = 0.7;
        camPhi = 0.42;
        camDist = 330;
        applyCamera();
    };

    // Animación
    function animate() {
        requestAnimationFrame(animate);
        applyCamera();
        renderer.render(scene, camera);
    }
    animate();

    // Manejo de resize
    function handleResize() {
        var w = wrap.clientWidth;
        var h = wrap.clientHeight;
        if (!w || !h) return;
        camera.aspect = w / h;
        camera.updateProjectionMatrix();
        renderer.setSize(w, h);
    }
    window.addEventListener('resize', handleResize);

    // Almacenar referencias
    cmsExplorer = {
        scene: scene,
        camera: camera,
        renderer: renderer,
        group: group,
        layerGroups: layerGroups,
        grid: grid,
        axes: axesHelper,
        handleResize: handleResize,
        setLayerVisible: function(index, visible) {
            if (layerGroups[index]) layerGroups[index].visible = visible;
        },
        setGridVisible: function(visible) {
            grid.visible = visible;
        },
        setAxesVisible: function(visible) {
            axesHelper.visible = visible;
        }
    };

        // 📋 GENERAR FILAS INTERACTIVAS (checkbox + nombre clicable) EN EL PANEL LATERAL
    var listContainer = document.getElementById('cms-layer-list');
    var infoPanel = document.getElementById('cms-layer-info');
    var layerRows = [];
    var highlightTimers = [];
    var idxActivo = -1;

    function hexColor(intColor) {
        return '#' + intColor.toString(16).padStart(6, '0');
    }

    function mostrarInfoCapa(idx) {
        var def = layerDefs[idx];
        if (!def || !infoPanel) return;

        idxActivo = idx;
        layerRows.forEach(function(row, i) {
            row.style.background = (i === idx) ? 'rgba(0,198,255,0.14)' : 'transparent';
            row.style.borderColor = (i === idx) ? 'rgba(0,198,255,0.4)' : 'transparent';
        });

        var info = def.info || {};
        infoPanel.innerHTML =
            '<div style="display:flex; align-items:center; gap:6px; margin-bottom:6px;">' +
                '<span style="width:12px; height:12px; border-radius:3px; background:' + hexColor(def.color) + '; flex-shrink:0;"></span>' +
                '<strong style="color:#5fc8ff; font-size:13px;">' + def.name + '</strong>' +
            '</div>' +
            (info.subtitulo ? '<div style="color:#7fbbe0; font-size:11px; font-style:italic; margin-bottom:6px;">' + info.subtitulo + '</div>' : '') +
            (info.material ? '<div style="margin-bottom:6px;"><strong style="color:#4a7494;">¿De qué está hecha?</strong><br>' + info.material + '</div>' : '') +
            (info.funcion ? '<div style="margin-bottom:6px;"><strong style="color:#4a7494;">¿Qué hace?</strong><br>' + info.funcion + '</div>' : '') +
            (info.proposito ? '<div><strong style="color:#4a7494;">¿Para qué sirve?</strong><br>' + info.proposito + '</div>' : '');

        // Resaltado temporal de la capa en el visor 3D para conectar la fila con el objeto
        var grupo = layerGroups[idx];
        if (grupo) {
            clearTimeout(highlightTimers[idx]);
            grupo.traverse(function(obj) {
                if (obj.material && obj.material.emissiveIntensity !== undefined) {
                    obj.material.emissiveIntensity = 0.9;
                } else if (obj.material && obj.material.opacity !== undefined && obj.type === 'LineSegments') {
                    obj.material.opacity = Math.min(1, obj.material.opacity * 1.8);
                }
            });
            highlightTimers[idx] = setTimeout(function() {
                grupo.traverse(function(obj) {
                    if (obj.material && obj.material.emissiveIntensity !== undefined) {
                        obj.material.emissiveIntensity = 0.10;
                    }
                });
            }, 900);
        }
    }

    if (listContainer) {
        listContainer.innerHTML = '';
        layerDefs.forEach(function(def, idx) {
            var row = document.createElement('div');
            row.style.cssText = 'display:flex; align-items:center; gap:6px; padding:4px 6px; border-radius:6px; border:1px solid transparent; transition:.15s;';

            var cb = document.createElement('input');
            cb.type = 'checkbox';
            cb.checked = true;
            cb.style.cssText = 'flex-shrink:0; cursor:pointer;';
            cb.addEventListener('click', function(e) { e.stopPropagation(); });
            cb.addEventListener('change', function() {
                cmsExplorer.setLayerVisible(idx, this.checked);
            });

            var swatch = document.createElement('span');
            swatch.style.cssText = 'width:10px; height:10px; border-radius:2px; flex-shrink:0; background:' + hexColor(def.color) + ';';

            var nombre = document.createElement('span');
            nombre.textContent = def.name;
            nombre.style.cssText = 'color:#bcd8ea; font-size:12px; cursor:pointer; flex:1;';
            nombre.title = 'Clic para ver información de esta capa';

            row.appendChild(cb);
            row.appendChild(swatch);
            row.appendChild(nombre);
            row.addEventListener('click', function() { mostrarInfoCapa(idx); });
            row.addEventListener('mouseenter', function() {
                if (idxActivo !== idx) row.style.background = 'rgba(255,255,255,0.05)';
            });
            row.addEventListener('mouseleave', function() {
                if (idxActivo !== idx) row.style.background = 'transparent';
            });

            listContainer.appendChild(row);
            layerRows.push(row);
        });
    }
    // Checkboxes de grid y ejes
    var gridCb = document.getElementById('cms-show-grid');
    if (gridCb) {
        gridCb.checked = true;
        gridCb.addEventListener('change', function() {
            cmsExplorer.setGridVisible(this.checked);
        });
    }
    var axesCb = document.getElementById('cms-show-axes');
    if (axesCb) {
        axesCb.checked = true;
        axesCb.addEventListener('change', function() {
            cmsExplorer.setAxesVisible(this.checked);
        });
    }

    // Forzar resize inicial
    setTimeout(handleResize, 50);
}

// Modificar cambiarTabSim para inicializar CMS al activar la pestaña
var originalCambiarTabSim = window.cambiarTabSim;
window.cambiarTabSim = function(tab) {
    // Llamar a la función original si existe
    if (typeof originalCambiarTabSim === 'function') {
        originalCambiarTabSim(tab);
    } else {
        // Si no existe, implementar la lógica básica
        var tabs = ['cms', 'fisica', 'simulacion', 'guiasim'];
        var idMap = { cms: 'Cms', fisica: 'Fisica', simulacion: 'Simulacion', guiasim: 'Guiasim' };
        var displayMap = { cms: 'flex', fisica: 'block', simulacion: 'flex', guiasim: 'block' };
        tabs.forEach(function(t) {
            var suf = idMap[t];
            var btn = document.getElementById('tabSim' + suf);
            var contenido = document.getElementById('contenidoSim' + suf);
            if (!contenido) return;
            var activo = (t === tab);
            contenido.style.display = activo ? displayMap[t] : 'none';
            if (btn) {
                btn.style.background = activo ? 'rgba(0,198,255,0.2)' : 'transparent';
                btn.style.color = activo ? '#00c6ff' : 'rgba(255,255,255,0.5)';
                btn.style.borderBottom = activo ? '3px solid #00c6ff' : '3px solid transparent';
            }
        });
        if (tab === 'simulacion') {
            setTimeout(function() {
                if (typeof cms3HandleResize === 'function') cms3HandleResize();
            }, 50);
        }
    }

    // Si se activa la pestaña CMS, inicializar el explorador
    if (tab === 'cms') {
        if (!cmsExplorer) {
            setTimeout(initCmsExplorer, 50);
        } else {
            setTimeout(function() {
                if (cmsExplorer && cmsExplorer.handleResize) cmsExplorer.handleResize();
            }, 100);
        }
    }
};
</script>
<button id="btnAyuda" onclick="abrirAyuda()" title="Ayuda">?</button>
 
<div id="modalAyuda" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
     background:rgba(0,10,30,1); z-index:200; justify-content:center; align-items:center;">
     <div style="display:flex; flex-direction:column; width:700px; max-width:90%; max-height:90vh;">
 
        <div style="display:flex; justify-content:flex-end; margin-bottom:8px;">
            <button onclick="cerrarAyuda()"
                style="background:red; color:white; border:none; border-radius:6px;
                       padding:5px 12px; cursor:pointer; font-size:12px; font-weight:bold;">
                ✕ Cerrar
            </button>
        </div>
 
         <div style="background:linear-gradient(to bottom, #001f3f, #000814); color:white;
            border-radius:14px; overflow:hidden;
            border:1px solid rgba(0,198,255,0.3);">
 
            <div style="display:flex; border-bottom:1px solid rgba(0,198,255,0.3);">
                <button id="tabGuia" onclick="cambiarTab('guia')"
                    style="flex:1; padding:14px; background:rgba(0,198,255,0.2); color:#00c6ff;
                           border:none; font-size:15px; font-weight:bold; cursor:pointer;
                           border-bottom:3px solid #00c6ff;">
                    ¿Cómo usar la aplicación?
                </button>
                <button id="tabAnalisis" onclick="cambiarTab('analisis')"
                style="flex:1; padding:14px; background:transparent; color:rgba(255,255,255,0.5);
                border:none; font-size:15px; font-weight:bold; cursor:pointer;
                border-bottom:3px solid transparent;">
                    Acerca del análisis
                </button>
            </div>
 
            <div id="contenidoGuia" style="padding:28px; overflow-y:auto; max-height:65vh; line-height:1.8;">
                <h2 style="color:#00c6ff; margin-top:0;">¿Cómo se usa?</h2>
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
 
             <div id="contenidoAnalisis" style="display:none; padding:28px; overflow-y:auto; max-height:65vh; line-height:1.8;">
                <h2 style="color:#00c6ff; margin-top:0;">Acerca del análisis</h2>
                <p style="color:rgba(255,255,255,0.7); font-size:14px; margin-bottom:20px;">
                    Esta aplicación reproduce, de forma simplificada, el flujo de trabajo real que usan los científicos  del CERN para identificar partículas subatómicas a partir de datos del detector CMS.
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
 
        </div>
    </div>
</div>
 
<button id="btnSimulacion" onclick="window.abrirSimulacionModal()" title="Simulación del detector CMS">⚛</button>
 
<div id="modalSimulacion" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
     background:rgba(0,10,30,1); z-index:200; justify-content:center; align-items:center;">
     <div style="display:flex; flex-direction:column; width:100%; height:100%;">
 
        <div style="display:flex; justify-content:flex-end; margin-bottom:8px;">
            <button onclick="cerrarSimulacionModal()"
                style="background:red; color:white; border:none; border-radius:6px;
                       padding:5px 12px; cursor:pointer; font-size:12px; font-weight:bold;">
                ✕ Cerrar
            </button>
        </div>
 
        <div class="modal-sim-content" style="background:linear-gradient(to bottom, #001f3f, #000814); color:white;
                    border-radius:14px; overflow:hidden;
                    border:1px solid rgba(0,198,255,0.3);">
 
            <div style="display:flex; border-bottom:1px solid rgba(0,198,255,0.3);">
                <button id="tabSimCms" onclick="cambiarTabSim('cms')"
                    style="flex:1; padding:14px; background:rgba(0,198,255,0.2); color:#00c6ff;
                           border:none; font-size:15px; font-weight:bold; cursor:pointer;
                           border-bottom:3px solid #00c6ff;">
                    CMS
                </button>
                <button id="tabSimFisica" onclick="cambiarTabSim('fisica')"
                    style="flex:1; padding:14px; background:transparent; color:rgba(255,255,255,0.5);
                           border:none; font-size:15px; font-weight:bold; cursor:pointer;
                           border-bottom:3px solid transparent;">
                    Conceptos físicos
                </button>
                <button id="tabSimSimulacion" onclick="cambiarTabSim('simulacion')"
                    style="flex:1; padding:14px; background:transparent; color:rgba(255,255,255,0.5);
                           border:none; font-size:15px; font-weight:bold; cursor:pointer;
                           border-bottom:3px solid transparent;">
                    Simulación
                </button>
            </div>

            <div id="contenidoSimCms" style="display:flex; flex-direction:row; align-items:stretch; padding:10px; height:100%; min-height:0; overflow:hidden; gap:10px;">
    <!-- Visor 3D (ocupa el espacio restante) -->
    <div id="cms-explorer-wrap" style="flex:1; position:relative; min-height:0; background:#020509; border-radius:8px; overflow:hidden;">
        <div id="cms-explorer-loading" style="position:absolute; inset:0; display:flex; align-items:center; justify-content:center; color:#3fb6e0; font-size:12px; background:#020509;">Cargando detector...</div>
        <div id="cms-explorer-hint" style="position:absolute; left:10px; bottom:10px; font-size:10px; color:#194161; letter-spacing:.05em; pointer-events:none;">arrastra para orbitar · scroll zoom</div>
    </div>
    <!-- Panel lateral de controles (arriba a la derecha, debajo de las pestañas) -->
    <div id="cms-controls" style="width:260px; min-height:0; background:rgba(10,26,42,0.9); border-radius:8px; padding:12px; overflow-y:auto; border:1px solid rgba(0,198,255,0.15); flex-shrink:0; display:flex; flex-direction:column; gap:8px;">
        <h4 style="color:#00c6ff; margin:0 0 2px 0; font-size:14px; border-bottom:1px solid rgba(0,198,255,0.2); padding-bottom:6px;">Capas del detector</h4>
        <p style="margin:0 0 4px 0; font-size:11px; color:#4a7494; line-height:1.4;">Haz clic en el nombre de una capa para ver de qué está hecha y para qué sirve. Usa la casilla para mostrarla u ocultarla.</p>
        <div id="cms-layer-list" style="display:flex; flex-direction:column; gap:4px; flex-shrink:0;"></div>
        <div id="cms-layer-info" style="margin-top:4px; padding:10px; border-radius:8px; background:rgba(0,198,255,0.06); border:1px solid rgba(0,198,255,0.18); font-size:11.5px; line-height:1.6; color:#bcd8ea; min-height:56px; max-height:200px; overflow-y:auto; flex-shrink:0;">
            <em style="color:#4a7494;">Selecciona una capa arriba para ver su descripción: material, función y para qué sirve dentro del detector.</em>
        </div>
        <hr style="border-color:rgba(0,198,255,0.15); margin:6px 0; flex-shrink:0;">
        <div style="display:flex; flex-direction:column; gap:4px; flex-shrink:0;">
            <label style="color:#4a7494; font-size:12px; display:flex; align-items:center; gap:6px;">
                <input type="checkbox" id="cms-show-grid" checked> Mostrar grid
            </label>
            <label style="color:#4a7494; font-size:12px; display:flex; align-items:center; gap:6px;">
                <input type="checkbox" id="cms-show-axes" checked> Mostrar ejes
            </label>
        </div>
        <button class="c3-btn" style="margin-top:6px; width:100%; flex-shrink:0;" onclick="cmsExplorerResetView()">Resetear vista</button>
    </div>
</div>    
 
             <div id="contenidoSimSimulacion" style="display:none; flex-direction:column; padding:10px; overflow:hidden; text-align:center; flex:1; min-height:0;">
                <h2 style="color:#00c6ff; margin-top:0;">Simulación del Detector CMS</h2>
               <p style="color:rgba(255,255,255,0.7); font-size:14px; margin-bottom:10px;">
                     Esta simulación permite explorar cómo se registran los muones en el detector CMS durante colisiones protón-protón en el LHC.
                </p>
 
                <div id="cms3-root">
                  <div id="cms3-bar">
                    <button class="c3-btn" data-v="front" onclick="cms3SetView('front')">Frontal</button>
                    <button class="c3-btn" data-v="side" onclick="cms3SetView('side')">Lateral</button>
                    <button class="c3-btn" data-v="top" onclick="cms3SetView('top')">Superior</button>
                    <button class="c3-btn active" data-v="iso" onclick="cms3SetView('iso')">Isométrica</button>
                    <button class="c3-btn" id="cms3-auto" onclick="cms3ToggleAuto()">Auto-rotar</button>
                    <button class="c3-btn" id="cms3-wire" onclick="cms3ToggleWire()">Solo estructura</button> 
                    <span style="margin-left:auto;font-size:9px;color:#194161;letter-spacing:.1em">CMS · LHC · CERN</span>
                  </div>
                  <div id="cms3-canvas-wrap">
                    <div id="cms3-loading">Cargando …</div>
                  </div>
                  <div id="cms3-leg">
                    <div class="c3-leg"><div class="c3-sw" style="background:#ff3b3b"></div>Muones</div>
                    <div class="c3-leg"><div class="c3-sw" style="background:#3fb6ff"></div>Trazas (tracker)</div>
                    <div class="c3-leg"><div class="c3-sw" style="background:#33ff8c"></div>Electrones / fotones</div>
                    <div class="c3-leg"><div class="c3-sw" style="background:#ffcc22"></div>Jets hadrónicos</div>
                    <div class="c3-leg"><div class="c3-sw" style="background:#ff8a1e"></div>Hadrones cargados</div>
                  </div>
                  <div id="cms3-stats">
                    <div class="c3-st">Colisiones <b id="c3-col">0</b></div>
                    <div class="c3-st">Muones <b id="c3-mu">0</b></div>
                    <div class="c3-st">Jets <b id="c3-jet">0</b></div>
                    <div class="c3-st">Trazas <b id="c3-trk">0</b></div>
                    <button class="c3-btn" id="cms3-btn-guia" style="margin-left:auto;" onclick="cambiarTabSim('guiasim')" >Guía de uso</button>
                  </div>
                </div>
            </div>
 
            <div id="contenidoSimFisica" style="display:none; padding:28px; overflow-y:auto; max-height:65vh; line-height:1.8;">
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
 
            <div id="contenidoSimGuiasim" style="display:none; padding:28px; overflow-y:auto; max-height:65vh; line-height:1.8;">
                <h2 style="color:#00c6ff; margin-top:0;">Guía de uso de la simulación</h2>
                <p style="color:rgba(255,255,255,0.7); font-size:14px; margin-bottom:20px;">
                    Esta simulación reconstruye en 3D la geometría del detector CMS y muestra colisiones de partículas generadas de forma simplificada.
                </p>
                <ol style="padding-left:20px;">
                    <li style="margin-bottom:14px;">
                        <strong>Vistas rápidas</strong><br>
                        Usa los botones <em>Frontal</em>, <em>Lateral</em>, <em>Superior</em> e <em>Isométrica</em> para saltar directamente a un ángulo de cámara predefinido, igual que en los displays oficiales del CERN.
                    </li>
                    <li style="margin-bottom:14px;">
                        <strong>Orbitar libremente</strong><br>
                        Arrastra con el clic izquierdo (o desliza con el dedo en móvil) para rotar la cámara alrededor del detector desde cualquier ángulo.
                    </li>
                    <li style="margin-bottom:14px;">
                        <strong>Zoom</strong><br>
                        Usa la rueda del mouse (o pellizca en pantallas táctiles) para acercar o alejar la vista.
                    </li>
                    <li style="margin-bottom:14px;">
                        <strong>Disparar una colisión</strong><br>
                        Haz clic sobre el detector para generar una nueva colisión manual en cualquier momento. El simulador también dispara colisiones automáticas de forma periódica.
                    </li>
                    <li style="margin-bottom:14px;">
                        <strong>Solo estructura</strong><br>
                        Oculta los volúmenes sólidos de las capas y deja visible solo el armazón (wireframe), útil para ver las trazas de las partículas sin obstrucciones.
                    </li>
                    <li style="margin-bottom:14px;">
                        <strong>Auto-rotar</strong><br>
                        Activa una rotación automática y continua de la cámara, ideal para presentaciones o para apreciar el detector desde todos los ángulos sin interactuar manualmente.
                    </li>
                    <li style="margin-bottom:14px;">
                        <strong>Leyenda de colores</strong><br>
                        Cada color de traza representa un tipo de partícula: rojo para muones (atraviesan todo el detector), azul para trazas del tracker, verde para electrones/fotones detenidos en el ECAL, amarillo/naranja para jets hadrónicos y hadrones cargados detenidos en el HCAL.
                    </li>
                </ol>
            </div>
 
        </div>
    </div>
</div>
 
</body>
</html>