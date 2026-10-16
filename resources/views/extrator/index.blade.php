@extends('layouts.app')

@section('title', 'Extrator eSocial')

@section('content')
{{-- Aviso se não tiver empresa configurada --}}
@if(!$nrInsc)
    <div class="mb-6 rounded-md bg-yellow-50 border border-yellow-300 p-4 text-yellow-800 text-sm flex items-start gap-3">
        <span class="text-lg">⚠️</span>
        <div>
            <strong>Número de inscrição não configurado.</strong>
            O extrator processará XMLs de <em>qualquer empresa</em> enquanto este campo estiver vazio.
            @if(auth()->user()->isAdmin())
                <a href="{{ route('users.edit', auth()->user()) }}" class="underline ml-1">Configurar agora →</a>
            @else
                Solicite ao administrador que configure seu perfil.
            @endif
        </div>
    </div>
@endif

{{-- O extrator roda 100% no browser via JS/JSZip.
     O nrInsc do usuário logado é injetado via Blade e fica fixo no array empresa[]. --}}
<div id="app-root">

<style>
  *, *::before, *::after { box-sizing: border-box; }
  :root {
    --navy:#1B2A3B; --green:#2C7A3F; --green-l:#E8F5EB;
    --bg:#F0F4F8; --border:#CBD5E0; --text:#1A202C; --muted:#5A6A7A; --white:#FFFFFF;
  }
  .ez-card { background:var(--white); border:1px solid var(--border); border-radius:8px; overflow:hidden; margin-bottom:16px; }
  .ez-head { display:flex; align-items:center; gap:10px; padding:14px 20px;
    background:var(--navy); color:#fff; font-weight:500; font-size:13px; }
  .ez-step { width:22px;height:22px;border-radius:50%;background:rgba(255,255,255,.18);
    display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0; }
  .ez-body { padding:20px; }
  .ez-label { display:block;font-size:12px;font-weight:600;color:var(--muted);
    text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px; }
  .drop-zone { border:2px dashed var(--border);border-radius:6px;padding:28px 20px;
    text-align:center;cursor:pointer;transition:border-color .15s,background .15s;position:relative; }
  .drop-zone:hover,.drop-zone.over { border-color:var(--green);background:var(--green-l); }
  .drop-zone input[type="file"] { position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%; }
  .drop-zone .dz-icon { font-size:28px;margin-bottom:6px; }
  .drop-zone .dz-label { font-size:13px;color:var(--muted); }
  .drop-zone .dz-label strong { color:var(--green); }
  .drop-zone.filled { border-style:solid;border-color:var(--green);background:var(--green-l); }
  .drop-zone.filled .dz-label { color:var(--navy);font-weight:500; }
  .period-row { display:flex;gap:12px;align-items:flex-end; }
  .period-row>div { flex:1; }
  input[type="month"],input[type="text"] { width:100%;border:1px solid var(--border);
    border-radius:6px;padding:9px 12px;font-size:13px;color:var(--text);
    background:var(--white);outline:none;transition:border-color .15s;font-family:inherit; }
  input:focus { border-color:var(--green);box-shadow:0 0 0 3px rgba(44,122,63,.12); }
  .hint { font-size:11px;color:var(--muted);margin-top:5px; }
  .btn { display:inline-flex;align-items:center;gap:7px;padding:10px 22px;
    border:none;border-radius:6px;cursor:pointer;font-family:inherit;font-size:13px;
    font-weight:600;transition:background .15s,opacity .15s; }
  .btn-primary { background:var(--green);color:#fff; }
  .btn-primary:hover { background:#235e31; }
  .btn-primary:disabled { opacity:.45;cursor:not-allowed; }
  .btn-secondary { background:#EBF1F7;color:var(--navy); }
  .action-row { display:flex;justify-content:flex-end;margin-bottom:4px; }
  #stats-bar { display:none;gap:10px;flex-wrap:wrap;margin-bottom:12px; }
  #stats-bar.visible { display:flex; }
  .stat-chip { flex:1;min-width:90px;background:var(--white);border:1px solid var(--border);
    border-radius:8px;padding:12px 16px;text-align:center; }
  .stat-chip .num { font-size:22px;font-weight:600;color:var(--navy); }
  .stat-chip .lbl { font-size:11px;color:var(--muted);margin-top:2px; }
  #progress-wrap { display:none;margin-bottom:8px; }
  #progress-wrap.visible { display:block; }
  #progress-bar-outer { background:var(--border);border-radius:99px;height:6px;overflow:hidden; }
  #progress-bar { height:100%;background:var(--green);width:0%;transition:width .2s;border-radius:99px; }
  #progress-label { font-size:11px;color:var(--muted);margin-top:5px;text-align:right; }
  #log-section { display:none;margin-bottom:12px; }
  #log-section.visible { display:block; }
  .log-head { display:flex;justify-content:space-between;align-items:center;padding:12px 20px;
    background:var(--navy);border-radius:8px 8px 0 0;color:#fff;font-size:13px;font-weight:500; }
  #log-box { background:#0f1d2b;color:#a8d5b5;font-family:'Menlo','Consolas',monospace;
    font-size:12px;padding:16px 20px;height:240px;overflow-y:auto;border-radius:0 0 8px 8px;line-height:1.8; }
  #log-box .ok   { color:#68d391; }
  #log-box .warn { color:#f6c85f; }
  #log-box .err  { color:#fc8181; }
  #log-box .dim  { color:#5a7a6a; }
  #result-section { display:none;margin-bottom:12px; }
  #result-section.visible { display:block; }
  .result-inner { background:var(--green-l);border:1px solid #9bcfab;border-radius:8px;
    padding:20px;display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap; }
  .result-inner .msg { font-weight:500;color:#1a4a27;font-size:14px; }
  .result-inner .sub { font-size:12px;color:#2d6e3e;margin-top:3px; }
  .dl-buttons { display:flex;gap:8px;flex-wrap:wrap; }
  .btn-dl { background:var(--navy);color:#fff;font-size:12px;padding:8px 14px; }
  .btn-dl:hover { background:#0f1d2b; }
  .btn-dl:disabled { opacity:.4;cursor:not-allowed; }

  .empresa-badge {
    display:inline-flex;align-items:center;gap:6px;
    background:#e8f0fe;border:1px solid #c3d4f9;border-radius:6px;
    padding:6px 12px;font-size:12px;color:#1a3a7a;font-weight:500;margin-bottom:12px;
  }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

{{-- Empresa do usuário logado injetada pelo Blade --}}
<script>
  // nrInsc vindo do servidor — imutável pelo usuário
  const empresa = @json($nrInsc ? [$nrInsc] : []);
</script>

@if($nrInsc)
    <div class="empresa-badge">
        🏢 Empresa vinculada: <strong>{{ $nrInsc }}</strong>
        — somente XMLs desta inscrição serão processados
    </div>
@endif

<div class="ez-card">
  <div class="ez-head"><div class="ez-step">1</div> Arquivo ZIP com os XMLs do eSocial</div>
  <div class="ez-body">
    <div class="drop-zone" id="dz-zip">
      <input type="file" id="input-zip" accept=".zip">
      <div class="dz-icon">📦</div>
      <div class="dz-label">Arraste o <strong>.zip</strong> aqui ou clique para selecionar</div>
    </div>
  </div>
</div>

<div class="ez-card">
  <div class="ez-head"><div class="ez-step">2</div> Arquivo CSV com os CPFs do departamento</div>
  <div class="ez-body">
    <div class="drop-zone" id="dz-csv">
      <input type="file" id="input-csv" accept=".csv,.txt">
      <div class="dz-icon">📋</div>
      <div class="dz-label">Arraste o <strong>.csv</strong> aqui ou clique para selecionar</div>
    </div>
    <div class="hint">CPFs na primeira coluna, separados por ponto-e-vírgula. Com ou sem cabeçalho.</div>
    <div class="mt-2 text-end">
    <a href="{{ asset('exemplos/cpf-exemplo.csv') }}"
       download="cpf-exemplo.csv"
       class="btn btn-sm btn-outline-primary">
        ⬇ Baixar CSV de exemplo
    </a>
</div>
  </div>
</div>

<div class="ez-card">
  <div class="ez-head"><div class="ez-step">3</div> Período e departamento</div>
  <div class="ez-body">
    <div class="period-row">
      <div>
        <label class="ez-label" for="input-periodo">Período de apuração</label>
        <input type="month" id="input-periodo">
        <div class="hint">Corresponde à tag &lt;perApur&gt; nos XMLs.</div>
      </div>
      <div>
        <label class="ez-label" for="input-dept">Nome do departamento</label>
        <input type="text" id="input-dept" placeholder="ex: VGR" maxlength="20">
        <div class="hint">Usado para nomear os ZIPs de saída.</div>
      </div>
    </div>
  </div>
</div>

<div class="action-row">
  <button class="btn btn-primary" id="btn-processar" disabled>▶ Processar arquivos</button>
</div>

<div id="progress-wrap">
  <div id="progress-bar-outer"><div id="progress-bar"></div></div>
  <div id="progress-label">Aguardando...</div>
</div>

<div id="stats-bar">
  <div class="stat-chip"><div class="num" id="stat-total">0</div><div class="lbl">XMLs lidos</div></div>
  <div class="stat-chip"><div class="num" id="stat-5001">0</div><div class="lbl">5001 copiados</div></div>
  <div class="stat-chip"><div class="num" id="stat-5011">0</div><div class="lbl">5011 copiados</div></div>
  <div class="stat-chip"><div class="num" id="stat-5003">0</div><div class="lbl">5003 copiados</div></div>
  <div class="stat-chip"><div class="num" id="stat-5013">0</div><div class="lbl">5013 copiados</div></div>
  <div class="stat-chip"><div class="num" id="stat-excluidos">0</div><div class="lbl">Fora do período</div></div>
</div>

<div id="log-section">
  <div class="log-head">
    <span>Log de processamento</span>
    <button class="btn btn-secondary" id="btn-limpar-log" style="padding:4px 10px;font-size:11px;">Limpar</button>
  </div>
  <div id="log-box"></div>
</div>

<div id="result-section">
  <div class="result-inner">
    <div>
      <div class="msg">✅ Processamento concluído!</div>
      <div class="sub" id="result-sub">—</div>
    </div>
    <div class="dl-buttons">
      <button class="btn btn-dl" id="btn-dl-5001">⬇ 5001</button>
      <button class="btn btn-dl" id="btn-dl-5011">⬇ 5011</button>
      <button class="btn btn-dl" id="btn-dl-5003">⬇ 5003</button>
      <button class="btn btn-dl" id="btn-dl-5013">⬇ 5013</button>
    </div>
  </div>
</div>

</div>{{-- #app-root --}}

<script>
const $ = id => document.getElementById(id);
let zipFile = null, csvFile = null;
let zips = { '5001': null, '5011': null, '5003': null, '5013': null };

// ── Log ────────────────────────────────────────────────────────────────
function log(msg, type = '') {
  const box = $('log-box');
  const d = document.createElement('div');
  d.className = type;
  d.textContent = `[${new Date().toLocaleTimeString('pt-BR')}] ${msg}`;
  box.appendChild(d);
  box.scrollTop = box.scrollHeight;
}
function setProgress(pct, label) {
  $('progress-bar').style.width = pct + '%';
  $('progress-label').textContent = label;
}
function checkReady() {
  $('btn-processar').disabled = !(zipFile && csvFile && $('input-periodo').value && $('input-dept').value.trim());
}

// ── Drop zones ─────────────────────────────────────────────────────────
function setupDrop(dzId, inputId, icon, onLoad) {
  const dz = $(dzId), inp = $(inputId);
  const handle = f => {
    if (!f) return;
    dz.classList.add('filled');
    dz.querySelector('.dz-label').textContent = '✔ ' + f.name;
    dz.querySelector('.dz-icon').textContent = icon;
    onLoad(f); checkReady();
  };
  inp.addEventListener('change', () => handle(inp.files[0]));
  dz.addEventListener('dragover', e => { e.preventDefault(); dz.classList.add('over'); });
  dz.addEventListener('dragleave', () => dz.classList.remove('over'));
  dz.addEventListener('drop', e => { e.preventDefault(); dz.classList.remove('over'); handle(e.dataTransfer.files[0]); });
}
setupDrop('dz-zip', 'input-zip', '📦', f => { zipFile = f; });
setupDrop('dz-csv', 'input-csv', '📋', f => { csvFile = f; });
$('input-periodo').addEventListener('input', checkReady);
$('input-dept').addEventListener('input', checkReady);

const now = new Date();
$('input-periodo').value = `${now.getFullYear()}-${String(now.getMonth()+1).padStart(2,'0')}`;

// ── CPF ────────────────────────────────────────────────────────────────
function normalizeCpf(raw) {
  const digits = raw.replace(/\D/g, '');
  if (digits.length === 0 || digits.length > 11) return null;
  return digits.padStart(11, '0');
}
function parseCpfs(text) {
  const set = new Set();
  for (const line of text.split(/\r?\n/)) {
    const raw = line.split(';')[0].trim();
    if (!raw) continue;
    const cpf = normalizeCpf(raw);
    if (cpf) set.add(cpf);
  }
  return set;
}

// ── XML ────────────────────────────────────────────────────────────────
function rxTag(xml, tag) {
  const m = xml.match(new RegExp('<(?:[^:>]+:)?' + tag + '[^>]*>([^<]*)<'));
  return m ? m[1].trim() : null;
}
function eventCode(filename) {
  const base = filename.split('/').pop();
  const m = base.match(/S-(\d{4})/i);
  return m ? m[1] : null;
}

// ── Main ───────────────────────────────────────────────────────────────
$('btn-processar').addEventListener('click', async () => {
  $('btn-processar').disabled = true;
  $('log-section').classList.add('visible');
  $('progress-wrap').classList.add('visible');
  $('stats-bar').classList.add('visible');
  $('result-section').classList.remove('visible');
  $('log-box').innerHTML = '';
  ['stat-total','stat-5001','stat-5011','stat-5003','stat-5013','stat-excluidos']
    .forEach(id => $(id).textContent = '0');

  const periodo = $('input-periodo').value;
  const dept    = $('input-dept').value.trim();

  log(`Início — Período: ${periodo} | Departamento: ${dept}`);
  if (empresa.length > 0)
    log(`Empresa vinculada (nrInsc): ${empresa.join(', ')}`, 'ok');
  else
    log('Sem filtro de empresa — todos os XMLs serão aceitos.', 'warn');

  setProgress(2, 'Lendo CSV...');
  const cpfSet = parseCpfs(await csvFile.text());
  log(`CPFs carregados: ${cpfSet.size}`, 'ok');
  if (cpfSet.size === 0) {
    log('Nenhum CPF encontrado no CSV.', 'err');
    $('btn-processar').disabled = false; return;
  }

  let srcZip;
  try { srcZip = await JSZip.loadAsync(zipFile); }
  catch(e) { log('Erro ao abrir o ZIP: ' + e.message, 'err'); $('btn-processar').disabled = false; return; }

  zips = { '5001': new JSZip(), '5011': new JSZip(), '5003': new JSZip(), '5013': new JSZip() };
  const counters = { total:0, '5001':0, '5011':0, '5003':0, '5013':0, excluidos:0 };

  const files = Object.keys(srcZip.files)
    .filter(n => !srcZip.files[n].dir && n.toLowerCase().endsWith('.xml'));
  log(`XMLs no ZIP: ${files.length}`, 'dim');

  for (let i = 0; i < files.length; i++) {
    const name = files[i];
    const base = name.split('/').pop();
    const evt  = eventCode(base);
    counters.total++;

    setProgress(5 + Math.round((i / files.length) * 88), `${i+1}/${files.length}: ${base}`);

    let xml;
    try { xml = await srcZip.files[name].async('string'); }
    catch(e) { log(`Erro ao ler ${base}: ${e.message}`, 'err'); continue; }

    const perApur  = rxTag(xml, 'perApur');
    const cpfTrab  = normalizeCpf(rxTag(xml, 'cpfTrab') || '');
    const nrInsc   = (rxTag(xml, 'nrInsc') || '').replace(/\D/g, '');

    // ── Filtro de empresa ─────────────────────────────────────────────
    if (empresa.length > 0 && !empresa.includes(nrInsc)) {
      log(`Empresa não listada (${nrInsc}): ${base}`, 'dim');
      continue;
    }

    // ── 5001 ──────────────────────────────────────────────────────────
    if (evt === '5001') {
      if (!cpfTrab) { log(`5001 sem cpfTrab: ${base}`, 'warn'); continue; }
      if (!cpfSet.has(cpfTrab)) { log(`5001 CPF fora da lista (${cpfTrab}): ${base}`, 'dim'); continue; }
      if (perApur && perApur !== periodo) {
        log(`5001 período errado (${perApur}): ${base}`, 'warn');
        counters.excluidos++; $('stat-excluidos').textContent = counters.excluidos; continue;
      }
      zips['5001'].file(base, xml);
      counters['5001']++; $('stat-5001').textContent = counters['5001'];
      log(`5001 ✔ CPF ${cpfTrab}: ${base}`, 'ok');
    }

    // ── 5011 ──────────────────────────────────────────────────────────
    else if (evt === '5011') {
      if (perApur && perApur !== periodo) {
        log(`5011 período errado (${perApur}): ${base}`, 'warn');
        counters.excluidos++; $('stat-excluidos').textContent = counters.excluidos; continue;
      }
      zips['5011'].file(base, xml);
      counters['5011']++; $('stat-5011').textContent = counters['5011'];
      log(`5011 ✔ ${base}`, 'ok');
    }

    // ── 5003 ──────────────────────────────────────────────────────────
    else if (evt === '5003') {
      if (!cpfTrab) { log(`5003 sem cpfTrab: ${base}`, 'warn'); continue; }
      if (!cpfSet.has(cpfTrab)) { log(`5003 CPF fora da lista (${cpfTrab}): ${base}`, 'dim'); continue; }
      if (perApur && perApur !== periodo) {
        log(`5003 período errado (${perApur}): ${base}`, 'warn');
        counters.excluidos++; $('stat-excluidos').textContent = counters.excluidos; continue;
      }
      zips['5003'].file(base, xml);
      counters['5003']++; $('stat-5003').textContent = counters['5003'];
      log(`5003 ✔ CPF ${cpfTrab}: ${base}`, 'ok');
    }

    // ── 5013 ──────────────────────────────────────────────────────────
    else if (evt === '5013') {
      if (perApur && perApur !== periodo) {
        log(`5013 período errado (${perApur}): ${base}`, 'warn');
        counters.excluidos++; $('stat-excluidos').textContent = counters.excluidos; continue;
      }
      zips['5013'].file(base, xml);
      counters['5013']++; $('stat-5013').textContent = counters['5013'];
      log(`5013 ✔ ${base}`, 'ok');
    }

    $('stat-total').textContent = counters.total;
  }

  setProgress(100, 'Concluído.');
  log('─────────────────────────────');
  log(`Total: ${counters.total} | 5001: ${counters['5001']} | 5011: ${counters['5011']} | 5003: ${counters['5003']} | 5013: ${counters['5013']} | Excluídos: ${counters.excluidos}`, 'ok');
  log('Clique nos botões para baixar cada ZIP.', 'ok');

  $('result-sub').textContent =
    `5001: ${counters['5001']} · 5011: ${counters['5011']} · 5003: ${counters['5003']} · 5013: ${counters['5013']} · Fora do período: ${counters.excluidos}`;
  $('result-section').classList.add('visible');

  ['5001','5011','5003','5013'].forEach(e => {
    $('btn-dl-' + e).disabled = counters[e] === 0;
  });
  $('btn-processar').disabled = false;
});

// ── Downloads ──────────────────────────────────────────────────────────
async function downloadZip(evt) {
  const periodo = $('input-periodo').value;
  const dept    = $('input-dept').value.trim();
  const fname   = `${periodo.replace('-','')}${dept}_S-${evt}.zip`;
  const blob    = await zips[evt].generateAsync({ type:'blob', compression:'DEFLATE' });
  const url     = URL.createObjectURL(blob);
  Object.assign(document.createElement('a'), { href:url, download:fname }).click();
  URL.revokeObjectURL(url);
  log(`Download: ${fname}`, 'ok');
}

['5001','5011','5003','5013'].forEach(evt => {
  $('btn-dl-' + evt).addEventListener('click', () => downloadZip(evt));
});
$('btn-limpar-log').addEventListener('click', () => { $('log-box').innerHTML = ''; });
</script>
@endsection
