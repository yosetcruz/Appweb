/* Análisis guiado H→ZZ*→4l. Etapa 1: cortes de calidad → Guardar df.
   Etapa 2: Z1/Z2 + ventanas de masa → Guardar df. Etapa 3: histogramas del Higgs.
   Para muones: cambia CFG.masa a 0.10566 y los archivos CSV. */
(function () {
  const CFG = { masa: 0.000511, files: { data: 'csv/data_4el.csv', higgs: 'csv/higgs_4el.csv', zz: 'csv/zz_4el.csv' } };
  const LUMI = 11.46 * 1000;
  const W = { data: 1, higgs: 0.0065 * LUMI / 299973.0, zz: 0.077 * 1.386 * LUMI / 1499093.0 };
  const MZ = 91.1876, KS = ['data', 'higgs', 'zz'], NOM = { data: 'Datos', higgs: 'Higgs MC', zz: 'Fondo ZZ MC' };
  const OPS = { '>': (a, b) => a > b, '<': (a, b) => a < b, '>=': (a, b) => a >= b, '<=': (a, b) => a <= b };
  const VARS = {
    1: {
      pt:  { t: 'pT mínimo de los 4 leptones [GeV]', op: '>', v: 7,   h: 'Típico: pT > 7', g: r => r.minPt },
      eta: { t: '|η| máximo de los 4 leptones',      op: '<', v: 2.5, h: 'Aceptancia del detector: |η| < 2.5', g: r => r.maxEta },
      iso: { t: 'Aislamiento máximo (iso)',          op: '<', v: 0.4, h: 'Típico: iso < 0.40', g: r => r.maxIso },
      sip: { t: 'SIP3D máximo',                      op: '<', v: 4,   h: 'Típico: SIP3D < 4', g: r => r.maxSip },
      dxy: { t: '|dxy| máximo [cm]',                 op: '<', v: 0.5, h: 'Típico: |dxy| < 0.5', g: r => r.maxDxy },
      dz:  { t: '|dz| máximo [cm]',                  op: '<', v: 1.0, h: 'Típico: |dz| < 1.0', g: r => r.maxDz }
    },
    2: {
      mZ1: { t: 'mZ1 [GeV]', op: '>', v: 40, h: 'Ventana típica: 40 < mZ1 < 120 (aplica dos cortes)', g: r => r.mZ1 },
      mZ2: { t: 'mZ2 [GeV]', op: '>', v: 12, h: 'Ventana típica: 12 < mZ2 < 120 (aplica dos cortes)', g: r => r.mZ2 }
    }
  };
  const ST = { etapa: 1, vista: 1, raw: {}, base: { 1: {}, 2: {} }, cortes: { 1: [], 2: [] }, g1: null, g2: null, cargado: false };

  // ---------- Física ----------
  const dR = (e1, f1, e2, f2) => Math.hypot(e1 - e2, Math.atan2(Math.sin(f1 - f2), Math.cos(f1 - f2)));
  function masa(l) {
    let px = 0, py = 0, pz = 0, E = 0;
    l.forEach(p => { px += p[0]; py += p[1]; pz += p[2]; E += p[3]; });
    return Math.sqrt(Math.max(0, E * E - px * px - py * py - pz * pz));
  }
  const mx = a => { let m = -Infinity; for (const x of a) if (x > m) m = x; return m; };
  const mn = a => { let m = Infinity; for (const x of a) if (x < m) m = x; return m; };

  function prep(row) {
    const pt = [], eta = [], phi = [], ch = [], iso = [], dxy = [], dz = [], sip = [], p4 = [];
    for (let i = 1; i <= 4; i++) {
      const v = ['pt', 'eta', 'phi', 'charge', 'iso', 'dxy', 'dz', 'dxyErr', 'dzErr'].map(k => row[k + i]);
      if (v.some(x => typeof x !== 'number' || !isFinite(x)) || v[4] < 0) return null; // quita -999
      const [p, e, f, c, is, x, z, xe, ze] = v;
      pt.push(p); eta.push(e); phi.push(f); ch.push(c); iso.push(is); dxy.push(x); dz.push(z);
      sip.push(Math.hypot(x, z) / Math.hypot(xe, ze));
      const px = p * Math.cos(f), py = p * Math.sin(f), pz = p * Math.sinh(e);
      p4.push([px, py, pz, Math.sqrt(px * px + py * py + pz * pz + CFG.masa ** 2)]);
    }
    const r = { pt, eta, phi, ch, iso, dxy, dz, sip, minPt: mn(pt), maxEta: mx(eta.map(Math.abs)), maxIso: mx(iso),
      maxSip: mx(sip), maxDxy: mx(dxy.map(Math.abs)), maxDz: mx(dz.map(Math.abs)), M: masa(p4), mZ1: NaN, mZ2: NaN, z1: null, z2: null };
    let mejor = Infinity;
    [[[0, 1], [2, 3]], [[0, 2], [1, 3]], [[0, 3], [1, 2]]].forEach(([[a, b], [c, d]]) => {
      if (!(ch[a] + ch[b] === 0 && ch[c] + ch[d] === 0 &&
            dR(eta[a], phi[a], eta[b], phi[b]) > 0.02 && dR(eta[c], phi[c], eta[d], phi[d]) > 0.02)) return;
      const mab = masa([p4[a], p4[b]]), mcd = masa([p4[c], p4[d]]), ab = Math.abs(mab - MZ) < Math.abs(mcd - MZ);
      const m1 = ab ? mab : mcd, diff = Math.abs(m1 - MZ);
      if (diff < mejor) { mejor = diff; r.mZ1 = m1; r.mZ2 = ab ? mcd : mab; r.z1 = ab ? [a, b] : [c, d]; r.z2 = ab ? [c, d] : [a, b]; }
    });
    return r;
  }

  // ---------- Cortes acumulativos ----------
  function aplicar(s, k) {
    let cur = ST.base[s][k]; const n = [cur.length];
    ST.cortes[s].forEach(c => { const g = VARS[s][c.v].g, f = OPS[c.op]; cur = cur.filter(r => f(g(r), c.val)); n.push(cur.length); });
    return { cur, n };
  }
  function invalidar(s) { // editar una etapa ya guardada invalida las siguientes
    if (ST.etapa > s) { ST.etapa = s; if (s === 1) ST.g1 = null; ST.g2 = null; }
  }

  // ---------- UI ----------
  const css = document.createElement('style');
  css.textContent = `
    #modal4el .row4{display:flex;gap:16px;align-items:stretch;flex-wrap:wrap;margin-bottom:12px}
    #modal4el .box4{background:rgba(0,0,0,.6);border-radius:10px;padding:14px;border:1px solid rgba(0,198,255,.2)}
    #modal4el table{border-collapse:collapse;width:100%;font-size:12.5px}
    #modal4el th,#modal4el td{border-bottom:1px solid rgba(0,198,255,.2);padding:5px 8px;text-align:right}
    #modal4el th:first-child,#modal4el td:first-child{text-align:left}
    #modal4el select,#modal4el input[type=number]{padding:5px;font-size:13px}
    #modal4el .paso{opacity:.45;pointer-events:none} #modal4el .paso.ok{opacity:1;pointer-events:auto}
    #modal4el .paso.sel{outline:2px solid #fff}`;
  document.head.appendChild(css);

  const modal4 = document.createElement('div');
  modal4.id = 'modal4el'; modal4.className = 'modal';
  modal4.innerHTML = `
  <div class="modal-content">
    <button class="cerrar" onclick="cerrar4el()">Cerrar</button>
    <p id="txt4el" style="font-size:18px;font-weight:bold;margin:10px 0">Cargando datos...</p>
    <div id="cuerpo4el" style="display:none">
      <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;margin-bottom:10px">
        <button id="p1" class="boton boton-pequeno paso" onclick="ir4el(1)">① Cortes de calidad</button>
        <button id="p2" class="boton boton-pequeno paso" onclick="ir4el(2)">② Z1 / Z2 y masas</button>
        <button id="p3" class="boton boton-pequeno paso" onclick="ir4el(3)">③ Histogramas del Higgs</button>
        <button class="boton boton-peligro boton-pequeno" style="margin-left:auto" onclick="reiniciarTodo4el()">Reiniciar todo</button>
      </div>
      <div class="row4">
        <div class="box4" id="panelCorte4el" style="flex:1;min-width:400px">
          <h3 id="tCorte4el" style="margin:0 0 8px"></h3>
          <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;font-size:13px">
            <select id="var4el"></select>
            <select id="op4el"><option>&gt;</option><option>&lt;</option><option>&gt;=</option><option>&lt;=</option></select>
            <input type="number" id="val4el" step="any" style="width:80px">
            <button class="boton boton-exito boton-pequeno" onclick="corte4el()">Aplicar corte</button>
          </div>
          <div id="hint4el" style="font-size:12px;opacity:.7;margin-top:6px"></div>
        </div>
        <div class="box4" style="flex:1;min-width:380px">
          <h3 style="margin:0 0 8px">Gráfica</h3>
          <div style="display:flex;gap:14px;flex-wrap:wrap;align-items:center;font-size:13px">
            <label id="lblVista4el" style="display:none">Vista:
              <select id="vista4el">
                <option value="m4l">Masa 4 leptones (Datos + Higgs + ZZ)</option>
                <option value="mz">Masas de Z1 y Z2</option>
                <option value="pt">pT de los 4 leptones</option>
                <option value="ptz">pT de leptones de Z1 vs Z2</option>
              </select></label>
            <label id="lblMuestra4el">Muestra:
              <select id="muestra4el"><option value="data">Datos</option><option value="higgs">Higgs MC</option><option value="zz">Fondo ZZ MC</option></select></label>
            <label>Bins: <input type="range" id="bins4el" min="5" max="100" value="30" style="width:110px;accent-color:#00c6ff"> <b id="binsV4el">30</b></label>
            <label><input type="checkbox" id="log4el"> Escala log</label>
          </div>
        </div>
      </div>
      <div id="graf4el" style="width:100%;height:480px"></div>
      <div id="info4el" style="margin:10px 0;font-size:13px;line-height:1.7"></div>
      <div class="lista-cortes" id="boxCortes4el">
        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap">
          <h3 style="margin:0">Cortes aplicados</h3>
          <div>
            <button class="boton boton-peligro boton-pequeno" onclick="reset4el()">Reiniciar cortes</button>
            <button class="boton boton-exito boton-pequeno" onclick="guardar4el()">💾 Guardar DataFrames y continuar</button>
          </div>
        </div>
        <div id="lista4el"></div>
      </div>
      <div class="lista-cortes"><h3 style="margin:0 0 8px">Tabla de flujo de cortes (cutflow)</h3><div id="tabla4el"></div></div>
      <div class="lista-cortes" id="boxDesc4el" style="display:none">
        <h3 style="margin:0 0 8px">DataFrames guardados (equivalente a to_parquet)</h3>
        <button class="boton boton-exito boton-pequeno" onclick="descargar4el('data')">Datos .csv</button>
        <button class="boton boton-exito boton-pequeno" onclick="descargar4el('higgs')">Higgs MC .csv</button>
        <button class="boton boton-exito boton-pequeno" onclick="descargar4el('zz')">ZZ MC .csv</button>
      </div>
    </div>
  </div>`;
  document.body.appendChild(modal4);
  const $ = id => document.getElementById(id);

  function llenarVars(s) {
    $('var4el').innerHTML = Object.keys(VARS[s]).map(k => `<option value="${k}">${VARS[s][k].t}</option>`).join('');
    defaultsVar();
  }
  function defaultsVar() {
    const s = ST.vista; if (s > 2) return;
    const d = VARS[s][$('var4el').value];
    $('op4el').value = d.op; $('val4el').value = d.v; $('hint4el').textContent = d.h;
  }

  function renderPasos() {
    [1, 2, 3].forEach(n => { const b = $('p' + n); b.className = 'boton boton-pequeno paso' + (ST.etapa >= n ? ' ok' : '') + (ST.vista === n ? ' sel' : ''); });
  }

  function actualizar() {
    if (!ST.cargado) return;
    const s = ST.vista; renderPasos();
    $('panelCorte4el').style.display = s < 3 ? 'block' : 'none';
    $('boxCortes4el').style.display = s < 3 ? 'block' : 'none';
    $('lblVista4el').style.display = s === 3 ? 'inline' : 'none';
    $('lblMuestra4el').style.display = (s < 3 || $('vista4el').value !== 'm4l') ? 'inline' : 'none';
    $('boxDesc4el').style.display = ST.g2 ? 'block' : 'none';
    if (s < 3) { lista(s); tabla(s); dibujarCorte(s); } else { tabla(2); dibujarHiggs(); }
  }

  function lista(s) {
    const L = ST.cortes[s], n = aplicar(s, 'data').n;
    $('lista4el').innerHTML = L.length ? L.map((c, i) => `
      <div class="corte-item"><span><strong>Corte ${i + 1}:</strong> ${VARS[s][c.v].t} ${c.op} ${c.val}<br>
      <small>Datos: ${n[i]} → ${n[i + 1]} (${(100 * n[i + 1] / n[i]).toFixed(1)}% retenidos)</small></span>
      <button onclick="del4el(${i})">✖</button></div>`).join('') : "<p style='color:#aaa'>No hay cortes aplicados</p>";
  }

  function tabla(s) {
    const res = {}; KS.forEach(k => res[k] = aplicar(s, k).n);
    let labels = ['Sin filtros (iso ≥ 0)'], cnt = k => res[k];
    if (s === 2) {
      labels = ['Salida etapa 1 (guardada)', 'Z1/Z2 válidos (cargas opuestas, ΔR > 0.02)'];
      cnt = k => [ST.g1[k].length, ...res[k]];
    }
    labels = labels.concat(ST.cortes[s].map(c => `${VARS[s][c.v].t} ${c.op} ${c.val}`));
    const d = cnt('data');
    $('tabla4el').innerHTML = '<table><tr><th>Corte aplicado</th><th>Datos</th><th>Higgs MC</th><th>ZZ MC</th><th>Aceptancia datos</th></tr>' +
      labels.map((l, i) => `<tr><td>${l}</td><td>${d[i]}</td><td>${cnt('higgs')[i]}</td><td>${cnt('zz')[i]}</td>
        <td>${d[0] ? (100 * d[i] / d[0]).toFixed(2) : 0} %</td></tr>`).join('') + '</table>';
  }

  function hist(vals, lo, hi, nb) {
    const c = new Array(nb).fill(0), w = (hi - lo) / nb;
    vals.forEach(x => { if (isFinite(x)) { const b = Math.floor((x - lo) / w); if (b >= 0 && b < nb) c[b]++; } });
    return { c, w, x: c.map((_, i) => lo + (i + 0.5) * w) };
  }
  function plot(traces, titulo, xt, rango, shapes) {
    const ax = t => ({ title: t, gridcolor: 'rgba(255,255,255,0.1)', titlefont: { color: 'white' }, tickfont: { color: 'white' } });
    Plotly.react('graf4el', traces, {
      title: { text: titulo, font: { size: 16, color: 'white' } },
      xaxis: { ...ax(xt), ...(rango ? { range: rango } : {}) }, yaxis: { ...ax('Eventos'), type: $('log4el').checked ? 'log' : 'linear' },
      barmode: 'overlay', plot_bgcolor: 'rgba(0,0,0,0.3)', paper_bgcolor: 'rgba(0,0,0,0)', shapes: shapes || [],
      legend: { x: 0.02, y: 0.98, bgcolor: 'rgba(0,0,0,0.6)', font: { color: 'white' } }
    }, { displaylogo: false });
  }
  const bar = (h, name, color, f = 1) => ({ x: h.x, y: h.c.map(v => v * f), type: 'bar', width: h.w * 0.9, name, marker: { color } });
  const step = (h, name, color) => ({ x: h.x, y: h.c, type: 'scatter', mode: 'lines', line: { shape: 'hv', color, width: 2 }, name });

  // Etapas 1 y 2: variable seleccionada antes (entrada de la etapa) vs después de los cortes
  function dibujarCorte(s) {
    const v = $('var4el').value, g = VARS[s][v].g, k = $('muestra4el').value, nb = +$('bins4el').value;
    const a = ST.base[s][k].map(g).filter(isFinite), b = aplicar(s, k).cur.map(g).filter(isFinite);
    if (!a.length) return;
    let lo = mn(a), hi = mx(a); if (lo === hi) hi = lo + 1;
    plot([bar(hist(a, lo, hi, nb), `Antes (${a.length})`, 'rgba(54,162,235,0.6)'),
          bar(hist(b, lo, hi, nb), `Después de cortes (${b.length})`, 'rgba(255,99,132,0.8)')],
         `${NOM[k]} · ${VARS[s][v].t}`, VARS[s][v].t, [lo - (hi - lo) * 0.05, hi + (hi - lo) * 0.05]);
  }

  // Etapa 3: usa los DataFrames guardados (ST.g2)
  function dibujarHiggs() {
    const vista = $('vista4el').value, nb = +$('bins4el').value, k = $('muestra4el').value, F = ST.g2[k], G = ST.g2;
    let info = '';
    if (vista === 'm4l') {
      const lo = 60, hi = 160, d = hist(G.data.map(r => r.M), lo, hi, nb);
      const h = hist(G.higgs.map(r => r.M), lo, hi, nb), z = hist(G.zz.map(r => r.M), lo, hi, nb);
      plot([bar(z, 'Fondo ZZ MC', 'rgba(54,162,235,0.6)', W.zz), bar(h, 'H→ZZ*→4l (mH = 125 GeV)', 'rgba(255,99,132,0.7)', W.higgs),
            { x: d.x, y: d.c, mode: 'markers', type: 'scatter', name: 'Datos', marker: { color: 'white', size: 7 },
              error_y: { type: 'data', array: d.c.map(Math.sqrt), color: 'white', thickness: 1 } }],
           'H → ZZ* → 4l · DataFrames guardados', 'Masa 4 leptones [GeV]', [lo, hi]);
      const pico = G.higgs.filter(r => r.M >= 120 && r.M <= 130), ms = G.higgs.map(r => r.M).sort((x, y) => x - y);
      const ven = rs => rs.filter(r => r.M >= 120 && r.M <= 130).length;
      info = `<b>Higgs MC:</b> ${G.higgs.length} eventos totales, ${pico.length} en el pico (120–130 GeV) ·
        masa promedio ${(ms.reduce((x, y) => x + y, 0) / ms.length).toFixed(2)} GeV · mediana ${ms[Math.floor(ms.length / 2)].toFixed(2)} GeV<br>
        <b>Ventana 120–130 GeV:</b> Datos = ${ven(G.data)} · Higgs esperado = ${(ven(G.higgs) * W.higgs).toFixed(2)} · ZZ esperado = ${(ven(G.zz) * W.zz).toFixed(2)}<br>
        <small>MC normalizado a L = 11.46 fb⁻¹ (peso Higgs ${W.higgs.toFixed(5)}, ZZ ${W.zz.toExponential(2)}).</small>`;
    } else if (vista === 'mz') {
      plot([bar(hist(F.map(r => r.mZ1), 40, 120, nb), 'Z1 (on-shell)', 'rgba(54,162,235,0.7)'),
            bar(hist(F.map(r => r.mZ2), 12, 120, nb), 'Z2 (off-shell)', 'rgba(255,159,64,0.7)')],
           `${NOM[k]} · masas de Z1 y Z2`, 'Masa invariante del par [GeV]', [0, 125],
           [{ type: 'line', x0: MZ, x1: MZ, y0: 0, y1: 1, yref: 'paper', line: { color: 'gray', dash: 'dash' } }]);
    } else if (vista === 'pt') {
      const cols = ['#36a2eb', '#4bc064', '#ff6384', '#9966ff'];
      plot([0, 1, 2, 3].map(i => step(hist(F.map(r => r.pt[i]), 0, 100, nb), `pT leptón ${i + 1}`, cols[i])), `${NOM[k]} · pT de los 4 leptones`, 'pT [GeV]', [0, 100]);
    } else {
      const z1 = [], z2 = [];
      F.forEach(r => { r.z1.forEach(i => z1.push(r.pt[i])); r.z2.forEach(i => z2.push(r.pt[i])); });
      plot([step(hist(z1, 0, 100, nb), 'pT leptones de Z1', '#36a2eb'), step(hist(z2, 0, 100, nb), 'pT leptones de Z2', '#ff9f40')],
           `${NOM[k]} · pT de leptones de Z1 vs Z2`, 'pT [GeV]', [0, 100]);
    }
    $('info4el').innerHTML = info;
  }

  // ---------- Acciones ----------
  window.corte4el = function () {
    const s = ST.vista, val = parseFloat($('val4el').value);
    if (isNaN(val)) return alert('Ingresa un valor válido');
    const c = { v: $('var4el').value, op: $('op4el').value, val };
    ST.cortes[s].push(c);
    if (!aplicar(s, 'data').cur.length) { ST.cortes[s].pop(); return alert('Este corte eliminaría todos los eventos. No se aplicará.'); }
    invalidar(s); actualizar();
  };
  window.del4el = i => { ST.cortes[ST.vista].splice(i, 1); invalidar(ST.vista); actualizar(); };
  window.reset4el = () => { ST.cortes[ST.vista] = []; invalidar(ST.vista); actualizar(); };

  window.guardar4el = function () {
    const s = ST.vista, out = {};
    KS.forEach(k => out[k] = aplicar(s, k).cur);
    if (KS.some(k => !out[k].length)) return alert('Alguna muestra quedó sin eventos; relaja los cortes antes de guardar.');
    if (s === 1) {
      ST.g1 = out; ST.g2 = null; ST.cortes[2] = [];
      KS.forEach(k => ST.base[2][k] = out[k].filter(r => !isNaN(r.mZ1))); // identificación Z1/Z2 válida
      ST.etapa = 2; ST.vista = 2; llenarVars(2);
    } else { ST.g2 = out; ST.etapa = 3; ST.vista = 3; }
    $('txt4el').textContent = `✔ DataFrames guardados — Datos: ${out.data.length} · Higgs MC: ${out.higgs.length} · ZZ MC: ${out.zz.length}`;
    actualizar();
  };

  window.ir4el = n => { if (n > ST.etapa) return; ST.vista = n; if (n < 3) llenarVars(n); actualizar(); };

  function reiniciarEstado() {
    ST.etapa = 1; ST.vista = 1; ST.cortes = { 1: [], 2: [] }; ST.g1 = ST.g2 = null; ST.base[1] = ST.raw; ST.base[2] = {};
    llenarVars(1);
  }
  window.reiniciarTodo4el = () => { reiniciarEstado(); $('txt4el').textContent = 'Análisis reiniciado'; actualizar(); };

  window.descargar4el = function (k) {
    const F = ST.g2[k], cols = ['pt', 'eta', 'phi', 'charge', 'iso'];
    const head = [...[1, 2, 3, 4].flatMap(i => cols.map(c => c + i)), 'mZ1', 'mZ2', 'M'];
    const rows = F.map(r => [...[0, 1, 2, 3].flatMap(i => [r.pt[i], r.eta[i], r.phi[i], r.ch[i], r.iso[i]]), r.mZ1, r.mZ2, r.M].join(','));
    const a = document.createElement('a');
    a.href = URL.createObjectURL(new Blob([head.join(',') + '\n' + rows.join('\n')], { type: 'text/csv' }));
    a.download = `df_${k}_4l_final.csv`; a.click();
  };

  const cargar = u => new Promise((ok, ko) =>
    Papa.parse(u, { download: true, header: true, dynamicTyping: true, skipEmptyLines: true, complete: r => ok(r.data), error: ko }));

  window.abrir4el = function () {
    if (!habilitado || bloqueado) return;
    bloqueado = true;
    document.querySelectorAll('.muestra').forEach(e => e.classList.remove('activa'));
    document.querySelectorAll('.grupo-header').forEach(e => e.classList.add('bloqueado'));
    titulo.classList.add('arriba');
    modal4.classList.add('activo');
    if (ST.cargado) { bloqueado = false; return; }
    $('txt4el').textContent = 'Cargando datos (Datos, Higgs MC y ZZ MC)...';
    Promise.all(KS.map(k => cargar(CFG.files[k]))).then(arr => {
      KS.forEach((k, i) => ST.raw[k] = arr[i].map(prep).filter(Boolean));
      ST.cargado = true; bloqueado = false; reiniciarEstado();
      $('txt4el').textContent = `Etapa 1 — ${ST.raw.data.length} eventos reales · ${ST.raw.higgs.length} Higgs MC · ${ST.raw.zz.length} ZZ MC`;
      $('cuerpo4el').style.display = 'block'; actualizar();
    }).catch(err => {
      console.error(err); bloqueado = false;
      $('txt4el').textContent = 'Error cargando los CSV (revisa la carpeta csv/ y usa un servidor local)';
    });
  };

  window.cerrar4el = function () {
    modal4.classList.remove('activo'); bloqueado = false; titulo.classList.remove('arriba');
    document.querySelectorAll('.muestra').forEach(e => e.classList.add('activa'));
    document.querySelectorAll('.grupo-header').forEach(e => e.classList.remove('bloqueado'));
    $('btnAyuda').disabled = false; $('btnSimulacion').disabled = false;
  };

  $('var4el').addEventListener('change', () => { defaultsVar(); actualizar(); });
  ['muestra4el', 'vista4el', 'log4el'].forEach(id => $(id).addEventListener('change', actualizar));
  $('bins4el').addEventListener('input', e => { $('binsV4el').textContent = e.target.value; actualizar(); });
})();
