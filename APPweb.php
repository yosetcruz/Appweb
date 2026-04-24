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
    background: linear-gradient(to bottom, #87CEEB, #001f3f);
}

#layout{
    flex: 1;
    height: 100vh;

    display: flex;
    flex-direction: column;
    aling-items: center;
    justify-content: center;
    transition: all 0.4s ease;
}
#contenido {
    transition: transform 0.5s ease; 
}

.sidebar.abierto ~ #contenido {
    transform: translateX(150px);
} 
/* ===================== */
/* TÍTULO */
/* ===================== */
#titulo {
    font-size: 48px;
    color: white;
    text-align: center;
    text-shadow: 2px 2px 6px rgba(0,0,0,0.5);
    margin-bottom: 20px;

    position: relative;
    transition: transform 0.6s ease;
}

#titulo.arriba {
    transform: translateY(-220px);
}

/* BOTÓN */
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

    width: auto;          /* 👈 clave */
    display: inline-block; /* 👈 evita que se estire */
    align-self: center;
}

.boton:hover:not(:disabled) {
    transform: scale(1.05);
}

.boton:disabled {
    opacity: 0.5;
    cursor: default;
}

body.sidebar-abierto #layout {
    margin-left: 300px;
    width: calc(100% - 300px);
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

/* MUESTRAS */
.muestra {
    margin: 10px 0;
    padding: 10px;
    background: #003366;
    border-radius: 6px;

    cursor: not-allowed;
    opacity: 0.4;
    pointer-events: none;
    transition: 0.2s;
}

.muestra.activa {
    cursor: pointer;
    opacity: 1;
    pointer-events: auto;
}

.muestra:hover {
    background: #005599;
}

/* PANEL DERECHO */
.modal {
    position: fixed;
    top: 0;
    left: 300px;
    width: calc(100% - 300px);
    height: 100%;

    background: rgba(0,0,0,0.6);
    display: none;

    z-index: 500;
}

/* SOLO visible si sidebar está abierto */
.sidebar:not(.abierto) ~ .modal {
    display: none !important;
}

.modal-content {
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

    /* 🌌 FONDO DE PARTÍCULAS SOLO AQUÍ */
    background: radial-gradient(circle at 30% 30%, #00c6ff, transparent 40%),
                radial-gradient(circle at 70% 70%, #0072ff, transparent 40%),
                linear-gradient(to bottom, #001f3f, #000814);

   
}

.cerrar {
    margin-top: 20px;
    background: red;
    color: white;
    padding: 10px 18px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
}
</style>

</head>

<body>
<div id="layout"> 
    <h1 id="titulo">Análisis del CMS</h1>
    
    <button id="btnMuestras" class="boton" onclick="habilitarMuestras()">
    Seleccionar muestra
    </button>
</div>

<!-- SIDEBAR -->
<div id="sidebar" class="sidebar">
    <h2>Selecciona tu muestra</h2>

    <div class="muestra" data-file="csv/Jpsimumu.csv" onclick="seleccionar(this)">
        Jpsimumu.csv
    </div>

    <div class="muestra" data-file="csv/Dimuon_DoubleMu.csv" onclick="seleccionar(this)">
        Dimuon_DoubleMu.csv
    </div>

    <div class="muestra" data-file="csv/muestra3.csv" onclick="seleccionar(this)">
        muestra3.csv
    </div>
</div>

<!-- PANEL DERECHO -->
<div id="modal" class="modal">
    <div class="modal-content">
        <h2>Archivo seleccionado</h2>
        <p id="modalTexto"></p>

        <button class="cerrar" onclick="cerrarModal()">
            Cerrar
        </button>
    </div>
</div>

<script>

let bloqueado = false;
let habilitado = false;

/* ACTIVAR */
function habilitarMuestras() {

    habilitado = true;

    document.getElementById("sidebar").classList.add("abierto");
    document.getElementById("btnMuestras").disabled = true;
    
    document.body.classList.add("sidebar-abierto"); 

    document.querySelectorAll(".muestra").forEach(el => {
        el.classList.add("activa");
    });
}

/* SELECCIONAR */
function seleccionar(elemento) {

    if (!habilitado || bloqueado) return;

    let archivo = elemento.getAttribute("data-file");

    bloqueado = true;

    document.querySelectorAll(".muestra").forEach(el => {
        el.classList.remove("activa");
    });

    document.getElementById("titulo").classList.add("arriba");

    document.getElementById("modalTexto").innerText =
        "Has seleccionado: " + archivo;

    document.getElementById("modal").style.display = "flex";
}

/* CERRAR PANEL */
function cerrarModal() {

    document.getElementById("modal").style.display = "none";

    bloqueado = false;

    document.getElementById("titulo").classList.remove("arriba");

    if (habilitado) {
        document.querySelectorAll(".muestra").forEach(el => {
            el.classList.add("activa");
        });
    }
}

/* CLIC DERECHO */
document.addEventListener("contextmenu", function(e) {
    e.preventDefault();

    let modal = document.getElementById("modal");

    if (modal.style.display !== "flex") {

        document.getElementById("sidebar").classList.remove("abierto"); 
        
        document.body.classList.remove("sidebar-abierto");

        habilitado = false;
        document.getElementById("btnMuestras").disabled = false;

        document.querySelectorAll(".muestra").forEach(el => {
            el.classList.remove("activa");
        });
    }
});

</script>

</body>
</html>