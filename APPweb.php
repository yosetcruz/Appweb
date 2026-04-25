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

/* ===================== */
/* LAYOUT */
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

/* ===================== */
/* BOTÓN */
/* ===================== */
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

    width: auto;
    display: inline-block;
}

.boton:hover:not(:disabled) {
    transform: scale(1.05);
}

.boton:disabled {
    opacity: 0.5;
    cursor: default;
}

/* ===================== */
/* SIDEBAR */
/* ===================== */
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

/* ===================== */
/* MODAL */
/* ===================== */
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

    z-index: 500;
}

.modal.activo {
    opacity: 1;
    pointer-events: auto;
    transform: translateY(0);
}

/* CONTENIDO */
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

    background: radial-gradient(circle at 30% 30%, #00c6ff, transparent 40%),
                radial-gradient(circle at 70% 70%, #0072ff, transparent 40%),
                linear-gradient(to bottom, #001f3f, #000814);
}

/* BOTÓN CERRAR */
.cerrar {
    position: absolute;
    top: 15px;
    right: 15px;

    background: red;
    color: white;
    padding: 8px 14px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
}


/* cuando el sidebar está abierto */
body.sidebar-abierto #layout {
    margin-left: 300px;
    width: calc(100% - 300px);
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

<!-- MODAL -->
<div id="modal" class="modal">
    <div class="modal-content">
        <h2>Archivo seleccionado</h2>
        <p id="modalTexto"></p>

        <button class="cerrar" onclick="cerrarModal()">Cerrar</button>
    </div>
</div>

<script>

let bloqueado = false;
let habilitado = false;

/* ACTIVAR SIDEBAR */
function habilitarMuestras() {
    habilitado = true;

    document.getElementById("sidebar").classList.add("abierto");
    document.getElementById("btnMuestras").disabled = true;
    document.body.classList.add("sidebar-abierto");
    document.querySelectorAll(".muestra").forEach(el => {
        el.classList.add("activa");
    });
}

/* SELECCIONAR MUESTRA */
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

    document.getElementById("modal").classList.add("activo");
}

/* CERRAR MODAL */
function cerrarModal() {

    document.getElementById("modal").classList.remove("activo");

    bloqueado = false;

    document.getElementById("titulo").classList.remove("arriba");

    if (habilitado) {
        document.querySelectorAll(".muestra").forEach(el => {
            el.classList.add("activa");
        });
    }
}

/* CLICK DERECHO (RESET) */
document.addEventListener("contextmenu", function(e) {
    e.preventDefault();

    let modal = document.getElementById("modal");

    if (!modal.classList.contains("activo")) {

        document.getElementById("sidebar").classList.remove("abierto"); 
        
        document.getElementById("btnMuestras").disabled = false;
        document.body.classList.remove("sidebar-abierto");

        habilitado = false;
        bloqueado = false;

        document.querySelectorAll(".muestra").forEach(el => {
            el.classList.remove("activa");
        });
    }
});


</script>

</body>
</html>