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
    flex-direction: column;
    align-items: center;
    justify-content: center;

    background: linear-gradient(to bottom, #87CEEB, #001f3f);
}

/* TÍTULO */
h1 {
    font-size: 48px;
    color: white;
    text-align: center;
    text-shadow: 2px 2px 6px rgba(0,0,0,0.5);
    margin-bottom: 20px;
}

/* BOTÓN PRINCIPAL */
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

.boton:hover {
    transform: scale(1.05);
}

.boton:disabled {
    opacity: 0.5;
    cursor: auto;
    transform: none; 
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

/* MUESTRAS (BLOQUEADAS POR DEFECTO) */
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

/* MUESTRAS ACTIVADAS */
.muestra.activa {
    cursor: pointer;
    opacity: 1;
    pointer-events: auto;
}

.muestra:hover {
    background: #005599;
}

/* MODAL FULLSCREEN */
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.85);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 999;
}

.modal-content {
    background: white;
    padding: 40px;
    border-radius: 12px;
    text-align: center;
    width: 60%;
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

<h1>Análisis del CMS</h1>

<button id="btnMuestras" class="boton" onclick="habilitarMuestras()">
    Seleccionar muestra
</button>

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

<!-- MODAL FULLSCREEN -->
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

/* ACTIVAR MUESTRAS */
function habilitarMuestras() {

    habilitado = true;

    document.getElementById("sidebar").classList.add("abierto");
    document.getElementById("btnMuestras").disabled = true;

    let todas = document.querySelectorAll(".muestra");
    todas.forEach(el => el.classList.add("activa"));
}

/* SELECCIONAR MUESTRA */
function seleccionar(elemento) {

    // ❌ si no está habilitado o ya bloqueado
    if (!habilitado || bloqueado) return;

    let archivo = elemento.getAttribute("data-file");

    bloqueado = true;

    // ✅ YA NO SE CIERRA EL SIDEBAR

    document.getElementById("modalTexto").innerText =
        "Has seleccionado: " + archivo;

    document.getElementById("modal").style.display = "flex";
}

/* CERRAR MODAL */
function cerrarModal() {
    document.getElementById("modal").style.display = "none";

    bloqueado = false;
}

/* CERRAR SIDEBAR CON CLIC DERECHO */
document.addEventListener("contextmenu", function(e) {
    e.preventDefault();

    let modal = document.getElementById("modal");

    if (modal.style.display !=="flex"){ 
        document.getElementById("sidebar").classList.remove("abierto");

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