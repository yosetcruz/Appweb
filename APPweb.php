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

/* ===================== */
/* SLIDER DE FONDO */
/* ===================== */
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

/* cada imagen entra en su tiempo */
.fondo img:nth-child(1) { animation-delay: 0s; }
.fondo img:nth-child(2) { animation-delay: 4s; }
.fondo img:nth-child(3) { animation-delay: 8s; }
.fondo img:nth-child(4) { animation-delay: 12s; }

/* animación */
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
/* TU UI (igual que antes) */
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
    font-size: 22px;
    font-weight: bold;

    backdrop-filter: blur(6px);
    background: rgba(0, 20, 40, 0.6);
    padding: 8px 14px;
    border-radius: 8px;

    border: 1px solid rgba(255,255,255,0.2);
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
    opacity: 0;
    pointer-events: none;
    transform: translateY(60px);
    transition: all 0.4s ease;
}

.modal.activo {
    opacity: 1;
    pointer-events: auto;
    transform: translateY(0);
}


.modal-content {
   position: relative;
   width: 100%;
   height: 100%;
   display: flex;
   flex-direction: column;
   justify-content: center;
   align-items: center;
   text-align: center;
   color: white;
   padding: 40px;
   box-sizing: border-box;

   background:
   radial-gradient(circle at 30% 30%, rgba(0,198,255,0.4), rgba(0,198,255,0) 40%),
   radial-gradient(circle at 70% 70%, rgba(0,114,255,0.4), rgba(0,114,255,0) 40%),
   linear-gradient(to bottom, #001f3f, #000814);
}

.modal-header {
    position: absolute;
    top: 15px;
    left: 0;
    width: 100%;
    padding: 0 20px;

    box-sizing: border-box;

    display: flex;
    justify-content: space-between;
    align-items: center;
}

.cerrar {
    background: red;
    color: white;
    padding: 8px 12px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.2s;
}

/* sidebar shift */
body.sidebar-abierto #layout {
    margin-left: 300px;
}
</style>
</head>

<body>

<!--  SLIDER -->
<div class="fondo">
    <img src="fondo/fondo1.jpeg">
    <img src="fondo/fondo2.jpeg">
    <img src="fondo/fondo3.jpeg">
    <img src="fondo/fondo4.jpeg">
</div>

<!--  DEGRADADO -->
<div class="overlay"></div>

<!-- TU CONTENIDO -->
<div id="layout"> 
    <h1 id="titulo">Análisis del CMS</h1>
    
    <button id="btnMuestras" class="boton" onclick="habilitarMuestras()">
        Comenzar
    </button>
</div>

<div id="sidebar" class="sidebar">
    <h2>Selecciona tu muestra</h2>

    <div class="muestra" data-file="csv/Jpsimumu.csv" onclick="seleccionar(this)">Jpsimumu.csv</div>
    <div class="muestra" data-file="csv/Dimuon_DoubleMu.csv" onclick="seleccionar(this)">Dimuon_DoubleMu.csv</div>
    <div class="muestra" data-file="csv/muestra3.csv" onclick="seleccionar(this)">muestra3.csv</div>
</div>

<div id="modal" class="modal">
    <div class="modal-content">

        <div class="modal-header"> 
            <p id="modalTexto"></p>
            <button class="cerrar" onclick="cerrarModal()">Cerrar</button>
        </div>

        <!--  AQUÍ VA -->
        <div id="panelCortes" style="margin-top: 60px;">
            <label>Variable:</label>
            <select id="variable">
                <option value="mu1_pt">pt1</option>
                <option value="mu2_pt">pt2</option>
                <option value="mu1_eta">eta1</option>
                <option value="mu2_eta">eta2</option>
            </select>

            <label>Valor:</label>
            <input type="number" id="valor" value="20">

            <button class="boton" onclick="aplicarCorte()">Aplicar corte</button>
        </div>

        <div id="grafica" style="width:80%; height:400px;"></div>

    </div>    
</div>
<script src="https://cdn.jsdelivr.net/npm/papaparse@5.4.1/papaparse.min.js"></script>
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

<script>
const sidebar = document.getElementById("sidebar");
const btnMuestras = document.getElementById("btnMuestras");
const titulo = document.getElementById("titulo");
const modal = document.getElementById("modal");
const modalTexto = document.getElementById("modalTexto");

let bloqueado = false;
let habilitado = false;
let datosGlobales = [];

function procesarDatos(data) {

    let df = data.filter(row =>
        row.mu1_pt != null &&
        row.mu2_pt != null &&
        !isNaN(row.mu1_pt) &&
        !isNaN(row.mu2_pt)
    );

    df.forEach(row => {

        let deta = row.mu1_eta - row.mu2_eta;
        let dphi = row.mu1_phi - row.mu2_phi;

        let M2 = 2 * row.mu1_pt * row.mu2_pt *
            (Math.cosh(deta) - Math.cos(dphi));

        row.M = Math.sqrt(Math.max(M2, 0));
    });

    datosGlobales = df;

    modalTexto.innerText = "Datos listos — aplica un corte";

    console.log("Eventos:", df.length);

    // ❌ QUITA ESTO
    // aplicarCorte();
}

function habilitarMuestras() {
    habilitado = true;
    sidebar.classList.add("abierto");
    btnMuestras.disabled = true;
    document.body.classList.add("sidebar-abierto");

    document.querySelectorAll(".muestra").forEach(el => el.classList.add("activa"));
}

function seleccionar(el) {
    if (!habilitado || bloqueado) return;

    bloqueado = true;

    document.querySelectorAll(".muestra").forEach(e => e.classList.remove("activa"));
    titulo.classList.add("arriba");

    const archivo = el.dataset.file;
    
    modalTexto.innerText = "Cargando datos...";
    modal.classList.add("activo");

    Papa.parse(archivo, {
        download: true,
        header: true,
        dynamicTyping: true,
        complete: function(results){
           modalTexto.innerText = "⏳ Cargando CSV..."; 
           procesarDatos(results.data);
           modalTexto.innerText = "✔ Datos listos";
        }
    });
}

function cerrarModal() {
    modal.classList.remove("activo");
    bloqueado = false;
    titulo.classList.remove("arriba");

    if (habilitado) {
        document.querySelectorAll(".muestra").forEach(e => e.classList.add("activa"));
    }
}

function aplicarCorte() {

    let variable = document.getElementById("variable").value;
    let valor = parseFloat(document.getElementById("valor").value);

    let df = datosGlobales;

    let variables_validas = ["mu1_pt", "mu2_pt", "mu1_eta", "mu2_eta"];

    if (!variables_validas.includes(variable)) {
        alert("Variable no válida");
        return;
    }

    let cut;

    if (variable.includes("pt")) {
        cut = df.filter(row => row[variable] > valor);
    } else {
        cut = df.filter(row => Math.abs(row[variable]) < valor);
    }

    console.log("datosGlobales:", datosGlobales.length);
    console.log("primer elemento:", datosGlobales[0]);
    console.log("Eventos después del corte:", cut.length);
    console.log("DF total:", df.length);
    console.log("Ejemplo:", df[0]);
    console.log("Variable:", variable);
    console.log("Valor:", valor);
    dibujarHistograma(variable, df, cut);
}

function dibujarHistograma(variable, df, cut) {

    let antes = df
        .map(r => r[variable])
        .filter(x => typeof x === "number" && !isNaN(x));

    let despues = cut
        .map(r => r[variable])
        .filter(x => typeof x === "number" && !isNaN(x));

    Plotly.newPlot("grafica", [
        {
            x: antes,
            type: "histogram",
            opacity: 0.5,
            name: "Antes"
        },
        {
            x: despues,
            type: "histogram",
            opacity: 0.7,
            name: "Después"
        }
    ], {
        title: `Histograma de ${variable}`,
        barmode: "overlay",
        xaxis: { title: variable },
        yaxis: { title: "Eventos" }
    });
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
    }
});
</script>

</body>
</html>

