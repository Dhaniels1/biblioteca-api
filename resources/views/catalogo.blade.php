<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#111a2c">
  <meta name="description" content="Explore livros, autores e categorias do catálogo da Biblioteca API.">
  <title>Biblioteca | Catálogo Digital</title>
  <style>
    :root{color-scheme:light;--ink:#192238;--muted:#717a8c;--border:#e8eaf0;--navy:#121d35;--blue:#4258b8;--pale:#f5f6fa;--card:#fff;--gold:#ceab64;--shadow:0 18px 50px rgba(25,34,56,.055)}
    *{box-sizing:border-box}html{scroll-behavior:smooth}body{margin:0;min-height:100vh;background:#f7f8fb;color:var(--ink);font-family:Inter,"Segoe UI",Arial,sans-serif}button,input,select{font:inherit}button{cursor:pointer}a{color:inherit;text-decoration:none}button:focus-visible,a:focus-visible,input:focus-visible,select:focus-visible{outline:3px solid #9aaffb;outline-offset:3px}
    .app{display:grid;grid-template-columns:248px minmax(0,1fr);min-height:100vh}
    .side{background:var(--navy);color:#eef2fa;display:flex;flex-direction:column;padding:31px 19px;gap:36px}
    .identity{display:flex;align-items:center;gap:12px;padding:1px 10px}.logo{display:grid;place-items:center;width:42px;height:42px;border:1px solid #62709a;border-radius:12px;background:#263758;color:#f0c877;flex-shrink:0}
    .identity strong{display:block;font-family:Georgia,serif;font-size:23px;letter-spacing:-.6px;line-height:1}.identity small{display:block;margin-top:6px;font-size:10px;letter-spacing:2.4px;text-transform:uppercase;color:#9ca9c0}
    .nav-label{font-size:10px;letter-spacing:2.2px;text-transform:uppercase;color:#8998b2;font-weight:800;padding:0 13px;margin:2px 0 12px}
    .nav{display:grid;gap:5px}.nav-btn{background:transparent;border:0;display:flex;align-items:center;text-align:left;gap:12px;width:100%;padding:12px 13px;color:#b5c0d4;font-weight:650;border-radius:11px;font-size:13px}.nav-btn svg{width:18px;height:18px}.nav-btn:hover{background:#263653;color:#fff}.nav-btn.active{background:#354b78;color:white;box-shadow:inset 3px 0 0 #e8be75}
    .side-bottom{margin-top:auto;border-top:1px solid #293750;padding:22px 11px 0;color:#a7b3ca;font-size:12px;line-height:1.55}.status-dot{display:inline-block;width:7px;height:7px;background:#8fdaa5;border-radius:50%;margin-right:7px}
    .main{min-width:0}.top{height:89px;background:#fff;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;padding:0 49px;gap:14px}.breadcrumb{color:#8a93a5;font-size:12px}.breadcrumb b{color:#32415b;font-weight:700}.top-links{display:flex;align-items:center;gap:13px;font-size:12px}.top-links a{font-weight:700;color:#53649c;border:1px solid #e2e6f2;border-radius:9px;padding:11px 13px}.top-links a:hover{background:#f1f4ff}
    .content{max-width:1430px;padding:43px 49px 72px;margin:0 auto}
    .heading{display:flex;align-items:flex-start;justify-content:space-between;gap:20px;margin-bottom:30px}.eyebrow{color:#5066ba;text-transform:uppercase;letter-spacing:2.4px;font-size:11px;font-weight:800;margin:0 0 12px}.heading h1{margin:0;color:#18233d;font:normal 42px/1.08 Georgia,"Times New Roman",serif;letter-spacing:-1.3px}.subtitle{margin:13px 0 0;color:#7f899b;font-size:14px;line-height:1.6}
    .label-right{display:flex;align-items:center;gap:7px;padding:10px 14px;background:#eaf3ef;color:#337358;border-radius:30px;font-size:11px;font-weight:750;white-space:nowrap;margin-top:28px}
    .summary{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:17px;margin-bottom:33px}
    .stat{background:#fff;padding:24px 26px;border:1px solid #e9ebf3;box-shadow:var(--shadow);border-radius:16px;display:flex;align-items:center;justify-content:space-between;min-height:119px}.stat-value{display:block;font:normal 34px/1 Georgia,serif;letter-spacing:-1px;color:#24304b}.stat-label{display:block;color:#8791a4;font-size:12px;margin-top:11px;font-weight:550}.stat-icon{width:48px;height:48px;border-radius:13px;display:grid;place-items:center;background:#e9edfd;color:#536bc4}.stat:nth-child(2) .stat-icon{background:#e8f4f0;color:#418e75}.stat:nth-child(3) .stat-icon{background:#faf0df;color:#b48d4c}.stat-icon svg{width:23px;height:23px}
    .section-header{display:flex;justify-content:space-between;align-items:end;gap:15px;margin:13px 0 18px}.section-header h2{font:normal 26px Georgia,serif;letter-spacing:-.4px;margin:0}.section-header p{color:#8993a4;font-size:12px;margin:6px 0 0}
    .filters{background:#fff;border:1px solid var(--border);border-radius:14px;padding:15px;display:flex;align-items:center;gap:11px;margin-bottom:22px}.search{display:flex;align-items:center;gap:10px;flex:1;min-width:100px;background:#f7f8fb;border:1px solid #edf0f4;border-radius:10px;padding:0 14px}.search svg{color:#8996ab;flex-shrink:0}.search input{height:43px;min-width:0;width:100%;background:transparent;border:0;outline:none;font-size:13px;color:#25324c}.search input::placeholder{color:#9ba4b3}.filters select{max-width:210px;min-width:127px;height:45px;border:1px solid #e6e9f0;border-radius:10px;padding:0 12px;background:#fff;color:#4f5b70;font-size:12px;outline:none}
    .count{color:#8a93a2;font-size:12px;font-weight:650;margin-left:auto;white-space:nowrap}
    .books{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:20px}.book{background:#fff;border-radius:16px;overflow:hidden;border:1px solid #e9ebf2;box-shadow:var(--shadow);transition:transform .18s,box-shadow .18s;display:flex;flex-direction:column;min-width:0}.book:hover{transform:translateY(-4px);box-shadow:0 23px 45px rgba(25,34,56,.11)}
    .cover-area{padding:28px 27px 17px;display:flex;justify-content:center;background:#f6f6f5;height:226px;position:relative;overflow:hidden}.cover-area:before{content:"";position:absolute;width:225px;height:225px;border:1px solid #e5e7ed;border-radius:50%;top:40px;right:-105px}.cover{width:137px;min-height:180px;max-height:180px;border-radius:3px 8px 8px 3px;color:white;position:relative;box-shadow:11px 13px 18px rgba(19,25,37,.19),inset 8px 0 10px rgba(0,0,0,.2);padding:21px 14px 13px 19px;display:flex;flex-direction:column;justify-content:space-between;overflow:hidden}.cover:before{content:"";position:absolute;inset:11px;border:1px solid rgba(255,255,255,.23);pointer-events:none}.cover:after{content:"";position:absolute;width:112px;height:112px;border:1px solid rgba(255,255,255,.23);border-radius:50%;bottom:-55px;right:-44px}.cover-label{font-size:8px;letter-spacing:1.8px;opacity:.77;text-transform:uppercase;z-index:1}.cover-title{font:normal 18px/1.11 Georgia,serif;z-index:1;word-break:break-word;max-height:91px;overflow:hidden}.cover-author{font-size:8px;line-height:1.25;letter-spacing:.7px;text-transform:uppercase;opacity:.82;z-index:1}
    .book-body{padding:19px 22px 21px;flex:1;display:flex;flex-direction:column}.chip{display:inline-flex;align-self:flex-start;padding:6px 10px;background:#edf0fb;border-radius:30px;color:#5068b2;font-size:10px;font-weight:750}.book h3{font:normal 21px/1.23 Georgia,serif;margin:13px 0 7px;min-height:51px;letter-spacing:-.25px}.by{font-size:12px;color:#818b9c;margin:0 0 15px}.line{border-top:1px solid #edf0f4;margin-top:auto;padding-top:15px;display:flex;align-items:center;justify-content:space-between;gap:7px}.meta{color:#8791a1;font-size:11px}.detail-button{background:none;border:0;color:#4259a8;font-size:11px;font-weight:800;padding:4px 0}.detail-button:hover{text-decoration:underline}
    .people{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px}.person{background:#fff;border:1px solid var(--border);border-radius:14px;padding:25px;display:flex;gap:16px;align-items:flex-start}.avatar{width:53px;height:53px;border-radius:13px;background:#edf0fb;display:grid;place-items:center;color:#536ab2;font:normal 24px Georgia,serif;flex-shrink:0}.person h3{font:normal 23px Georgia,serif;margin:2px 0 9px}.person .description{font-size:12px;color:#81899b;line-height:1.65;margin:0 0 9px}.person small{font-size:11px;color:#5468b6;font-weight:700}
    .empty{grid-column:1/-1;border:1px dashed #d7dce8;padding:54px 18px;text-align:center;background:#fff;border-radius:15px;color:#8792a3}.empty h3{font:normal 23px Georgia,serif;color:#293650;margin:0 0 9px}.empty p{font-size:13px;margin:0}.hidden{display:none!important}
    .footer{margin-top:46px;color:#a0a8b5;font-size:11px;display:flex;justify-content:space-between;gap:20px}
    dialog{border:0;border-radius:20px;width:min(660px,calc(100vw - 30px));padding:0;box-shadow:0 30px 100px rgba(9,17,37,.32);color:#1e2b43}dialog::backdrop{background:rgba(15,24,44,.62);backdrop-filter:blur(3px)}.modal-header{padding:28px 31px;background:#f3f5fa;border-bottom:1px solid #e5e9f1;display:flex;justify-content:space-between;align-items:center;gap:12px}.modal-header h2{margin:0;font:normal 29px Georgia,serif}.close{border:1px solid #dde2ec;background:#fff;color:#6e7890;width:34px;height:34px;border-radius:10px;font-size:21px;display:grid;place-items:center}.modal-content{padding:28px 31px 33px}.detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:19px}.detail-grid div{padding:13px 0;border-bottom:1px solid #edf0f4}.detail-grid label{display:block;text-transform:uppercase;letter-spacing:1.2px;color:#8b96a8;font-size:10px;font-weight:800;margin-bottom:9px}.detail-grid strong{font-size:13px;font-weight:650;color:#273550}.modal-desc{color:#647187;line-height:1.7;font-size:14px}
    @@media(max-width:1170px){.app{grid-template-columns:210px minmax(0,1fr)}.content{padding:36px 27px 60px}.top{padding:0 27px}.books{grid-template-columns:repeat(2,minmax(0,1fr))}.heading h1{font-size:37px}}
    @@media(max-width:700px){.app{display:block}.side{padding:12px 16px;gap:12px}.identity{padding:0}.logo{width:35px;height:35px}.identity strong{font-size:20px}.identity small{margin-top:3px}.nav-label,.side-bottom{display:none}.nav{display:flex;gap:5px;overflow-x:auto}.nav-btn{justify-content:center;padding:9px 10px;white-space:nowrap;font-size:11px}.nav-btn svg{width:15px;height:15px}.top{height:61px;padding:0 18px}.top-links{gap:6px}.top-links a{font-size:10px;padding:8px}.content{padding:27px 17px 45px}.heading{margin-bottom:23px}.heading h1{font-size:34px}.label-right{display:none}.summary{gap:8px}.stat{min-height:93px;padding:14px 11px;gap:5px}.stat-value{font-size:29px}.stat-label{font-size:10px;margin-top:8px}.stat-icon{height:32px;width:32px;border-radius:9px}.stat-icon svg{width:17px;height:17px}.section-header h2{font-size:24px}.filters{flex-wrap:wrap;padding:10px}.search{flex:1 0 100%}.filters select{max-width:none;flex:1}.books{grid-template-columns:repeat(2,minmax(0,1fr));gap:10px}.cover-area{height:182px;padding:19px 14px}.cover{width:110px;min-height:146px;max-height:146px;padding:16px 12px}.cover-title{font-size:15px}.cover-label,.cover-author{font-size:7px}.book-body{padding:14px 13px 16px}.book h3{font-size:17px;min-height:42px}.by{font-size:11px}.meta{font-size:10px}.people{grid-template-columns:1fr}.footer{flex-wrap:wrap}}
    @@media(max-width:400px){.books{grid-template-columns:1fr}.cover-area{height:220px}.cover{width:137px;min-height:180px;max-height:180px}.book h3{min-height:auto}.top-links a:last-child{display:none}}
    @@media(prefers-reduced-motion:reduce){*,*:before,*:after{transition:none!important;scroll-behavior:auto!important}}

    /* Guia contextual para visitantes da demonstração */
    .project-overview{border:1px solid #dbe3f4;border-radius:18px;background:linear-gradient(125deg,#edf3ff,#f8fbff 65%);padding:23px 25px 20px;margin:-7px 0 31px}
    .overview-head{display:flex;align-items:flex-start;justify-content:space-between;gap:15px}
    .overview-label{font-size:10px;color:#4c67a5;letter-spacing:1.5px;font-weight:800;margin:0 0 9px}
    .overview-head h2{font:normal 24px/1.25 Georgia,serif;color:#203153;margin:0 0 8px}
    .overview-head p{color:#596981;font-size:12px;line-height:1.65;margin:0 0 13px;max-width:730px}
    .overview-guide{white-space:nowrap;color:#334f9e;font-size:11px;font-weight:800;border:1px solid #bfcde9;border-radius:9px;padding:11px 13px;background:#fff}
    .overview-guide:hover{background:#e9f0ff}
    .tour-steps{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:10px;margin-top:6px}
    .tour-step{background:#fff;border:1px solid #dce5f4;border-radius:12px;padding:13px 13px 14px;display:flex;gap:11px;align-items:flex-start;min-width:0}
    .tour-step:hover{border-color:#95addf;background:#f5f8ff}
    .tour-step .num{font-size:10px;font-weight:900;color:#3a5aaa;background:#eaf0ff;border-radius:8px;padding:7px;flex-shrink:0}
    .tour-step strong{display:block;font-size:12px;color:#26395c;margin-bottom:4px}
    .tour-step small{display:block;font-size:11px;line-height:1.5;color:#6a7990}
    .api-reference{margin-top:13px;color:#566784;font-size:12px}
    .api-reference summary{cursor:pointer;font-weight:800;color:#35529e;padding:7px 2px}
    .api-reference p{margin:8px 0 9px;line-height:1.65}
    .api-reference code{display:inline-block;background:#dce6fa;color:#233f86;border-radius:5px;padding:3px 6px;margin:2px 4px 2px 0;font:600 11px ui-monospace,Consolas,monospace}
    @@media(max-width:900px){.tour-steps{grid-template-columns:1fr}.overview-head{flex-wrap:wrap}}
    @@media(max-width:600px){.project-overview{padding:17px 15px;margin-bottom:25px}.overview-head h2{font-size:22px}.overview-guide{white-space:normal}.tour-step{padding:11px}}
  </style>
</head>
<body>
<div class="app">
  <aside class="side" aria-label="Menu da biblioteca">
    <a class="identity" href="/" aria-label="Biblioteca Digital - início">
      <span class="logo" aria-hidden="true"><svg width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M12 5.5c-3.1-2-6.1-2-9-1v13c3-1 6-.9 9 1 3-1.9 6-2 9-1v-13c-3-1-6-.9-9 1Z"/><path d="M12 5.5v13"/></svg></span>
      <span><strong>biblioteca.</strong><small>Acervo digital</small></span>
    </a>
    <div>
      <div class="nav-label">Explorar</div>
      <nav class="nav" aria-label="Explorar">
        <button class="nav-btn active" data-view="livros" type="button"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="7" height="16" rx="1"/><rect x="12" y="6" width="8" height="14" rx="1"/><path d="M6 8v8M15 10v6"/></svg> Livros</button>
        <button class="nav-btn" data-view="autores" type="button"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-5 3-8 8-8s8 3 8 8"/></svg> Autores</button>
        <button class="nav-btn" data-view="categorias" type="button"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 12V4a1 1 0 0 1 1-1h8l9 9-9 9-9-9Z"/><circle cx="8" cy="8" r="1"/></svg> Categorias</button>
        <a class="nav-btn" href="/api/livros" target="_blank" rel="noopener noreferrer"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="m8 8-4 4 4 4m8-8 4 4-4 4m-3-11-2 18"/></svg> Dados JSON</a>
      </nav>
    </div>
    <div class="side-bottom"><span class="status-dot"></span> API REST · Laravel 12<br>Projeto acadêmico — Web III</div>
  </aside>

  <div class="main">
    <header class="top">
      <div class="breadcrumb">Acervo <span aria-hidden="true"> / </span> <b id="breadcrumb">Livros</b></div>
      <div class="top-links"><a href="/api/livros" target="_blank" rel="noopener noreferrer">Ver JSON ↗</a><a href="https://github.com/Dhaniels1/biblioteca-api" target="_blank" rel="noopener noreferrer">GitHub ↗</a></div>
    </header>

    <main class="content">
      <div class="heading">
        <div><p class="eyebrow">Seu universo de histórias</p><h1>Explore nossa biblioteca</h1><p class="subtitle">Descubra obras, conheça os autores e navegue pelo catálogo.</p></div>
        <div class="label-right"><span class="status-dot"></span> Catálogo conectado</div>
      </div>

      <section class="project-overview" aria-labelledby="overview-title">
        <div class="overview-head">
          <div>
            <p class="overview-label">DEMONSTRAÇÃO ACADÊMICA · LARAVEL 12</p>
            <h2 id="overview-title">O que você pode explorar aqui?</h2>
            <p>Este catálogo é a interface pública de uma API REST: livros, autores e categorias são consultados diretamente pelo Laravel. Você pode navegar sem criar conta ou fornecer informações pessoais.</p>
          </div>
          <a class="overview-guide" href="https://github.com/Dhaniels1/biblioteca-api/blob/main/docs/GUIA_DEMONSTRACAO.md" target="_blank" rel="noopener noreferrer">Guia técnico ↗</a>
        </div>
        <div class="tour-steps" aria-label="Sugestões para explorar o projeto">
          <a class="tour-step" href="#section-title"><span class="num">01</span><span><strong>Pesquise o acervo</strong><small>Experimente filtros, autores, categorias e detalhes dos livros.</small></span></a>
          <a class="tour-step" href="/api/livros" target="_blank" rel="noopener noreferrer"><span class="num">02</span><span><strong>Veja os dados JSON ↗</strong><small>Compare a interface visual com a resposta real da API.</small></span></a>
          <a class="tour-step" href="https://github.com/Dhaniels1/biblioteca-api" target="_blank" rel="noopener noreferrer"><span class="num">03</span><span><strong>Conheça a implementação ↗</strong><small>Explore Controllers, Eloquent, autenticação e testes no GitHub.</small></span></a>
        </div>
        <details class="api-reference">
          <summary>Quais endpoints estão disponíveis?</summary>
          <p>Leituras públicas do catálogo:</p>
          <code>GET /api/livros</code><code>GET /api/autores</code><code>GET /api/categorias</code>
          <p>Criação, edição e exclusão exigem autenticação por token com Laravel Sanctum. Esta página é somente para consulta.</p>
        </details>
      </section>

      <section class="summary" aria-label="Indicadores do acervo">
        <div class="stat"><div><span class="stat-value" id="total-livros">—</span><span class="stat-label">Livros cadastrados</span></div><span class="stat-icon"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="7" height="16" rx="1"/><rect x="12" y="6" width="8" height="14" rx="1"/></svg></span></div>
        <div class="stat"><div><span class="stat-value" id="total-autores">—</span><span class="stat-label">Autores disponíveis</span></div><span class="stat-icon"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-5 3-8 8-8s8 3 8 8"/></svg></span></div>
        <div class="stat"><div><span class="stat-value" id="total-categorias">—</span><span class="stat-label">Categorias literárias</span></div><span class="stat-icon"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 12V4a1 1 0 0 1 1-1h8l9 9-9 9-9-9Z"/></svg></span></div>
      </section>

      <section aria-labelledby="section-title">
        <div class="section-header"><div><h2 id="section-title">Todos os livros</h2><p id="section-subtitle">Obras presentes no acervo</p></div><span class="count" id="result-count" aria-live="polite"></span></div>
        <div class="filters" id="filters">
          <label class="search" for="search"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="11" cy="11" r="7"/><path d="m16 16 5 5"/></svg><input id="search" type="search" placeholder="Buscar título, autor ou ISBN…" autocomplete="off"></label>
          <select id="category" aria-label="Filtrar por categoria"><option value="">Todas as categorias</option></select>
          <select id="sort" aria-label="Ordenação"><option value="titulo">Título (A–Z)</option><option value="ano-desc">Mais recentes</option><option value="ano-asc">Mais antigos</option></select>
        </div>
        <div class="books" id="results" aria-live="polite" aria-busy="true"><div class="empty"><h3>Carregando acervo…</h3><p>Consultando a Biblioteca API.</p></div></div>
      </section>

      <footer class="footer"><span>Biblioteca Digital · Projeto Web III</span><span>Dados consultados em tempo real pela API Laravel</span></footer>
    </main>
  </div>
</div>

<dialog id="details" aria-labelledby="details-title">
  <div class="modal-header"><h2 id="details-title">Detalhes do livro</h2><button class="close" id="close-details" type="button" aria-label="Fechar detalhes">×</button></div>
  <div class="modal-content"><div id="details-content"></div></div>
</dialog>

<script>
(function(){
  "use strict";
  const $ = function(id){return document.getElementById(id);};
  const state={livros:[],autores:[],categorias:[],view:"livros",ready:false,failed:false};
  const covers=["#344967","#3f584f","#81513d","#404e73","#765b50","#514b70","#555d47"];
  const input=$("search"),category=$("category"),sort=$("sort"),results=$("results");
  function node(tag,cls,text){const e=document.createElement(tag);if(cls)e.className=cls;if(text!==undefined)e.textContent=String(text);return e;}
  function empty(title,subtitle){const el=node("div","empty");el.append(node("h3","",title),node("p","",subtitle));return el;}
  function clear(el){while(el.firstChild)el.removeChild(el.firstChild);}
  function pretty(t){return String(t===null||t===undefined?"—":t);}
  function norm(t){return pretty(t).normalize("NFD").replace(/[\u0300-\u036f]/g,"").toLocaleLowerCase("pt-BR");}
  function card(l,i){
    const card=node("article","book"),area=node("div","cover-area"),cover=node("div","cover");
    cover.style.background=covers[i%covers.length];
    cover.append(node("span","cover-label","Biblioteca digital"),node("strong","cover-title",l.titulo||"Sem título"),node("span","cover-author",l.autor&&l.autor.nome||"Autor não informado"));
    area.append(cover);card.append(area);
    const body=node("div","book-body");
    body.append(node("span","chip",l.categoria&&l.categoria.nome||"Sem categoria"),node("h3","",l.titulo||"Sem título"),node("p","by",l.autor&&l.autor.nome||"Autor não informado"));
    const line=node("div","line"),meta=node("span","meta",pretty(l.anopublicacao)+" · "+pretty(l.paginas)+" págs."),btn=node("button","detail-button","Ver detalhes →");
    btn.type="button";btn.setAttribute("aria-label","Ver detalhes de "+pretty(l.titulo));btn.addEventListener("click",function(){detail(l);});
    line.append(meta,btn);body.append(line);card.append(body);return card;
  }
  function detail(l){
    $("details-title").textContent=pretty(l.titulo);const area=$("details-content");clear(area);
    area.append(node("p","modal-desc",l.descricao||"Descrição não informada."));
    const grid=node("div","detail-grid");
    [
      ["Autor",l.autor&&l.autor.nome],
      ["Categoria",l.categoria&&l.categoria.nome],
      ["Publicação",l.anopublicacao],
      ["Páginas",l.paginas],
      ["ISBN",l.isbn],
      ["Nacionalidade",l.autor&&l.autor.nacionalidade]
    ].forEach(function(item){const d=node("div");d.append(node("label","",item[0]),node("strong","",pretty(item[1])));grid.append(d);});
    area.append(grid);$("details").showModal();
  }
  function person(item,type){
    const el=node("article","person"),avatar=node("div","avatar",(item.nome||"?").slice(0,1));
    const inner=node("div");
    inner.append(node("h3","",item.nome||"Sem nome"),node("p","description",type==="autores"?(item.biografia||"Biografia não disponível."):(item.descricao||"Descrição não disponível.")));
    const count=state.livros.filter(function(l){return type==="autores"?l.idautor==item.idautor:l.idcategoria==item.idcategoria;}).length;
    inner.append(node("small","",count+" "+(count===1?"livro relacionado":"livros relacionados")));el.append(avatar,inner);return el;
  }
  function render(){
    clear(results);
    if(state.failed){results.append(empty("Não foi possível carregar o catálogo.","Tente atualizar a página em instantes."));return;}
    if(!state.ready){results.append(empty("Carregando acervo…","Consultando a Biblioteca API."));return;}
    const q=norm(input.value.trim());
    const cat=category.value;
    let all=[],view=state.view;
    if(view==="livros"){
      all=state.livros.filter(function(l){
        const text=norm([l.titulo,l.isbn,l.autor&&l.autor.nome,l.categoria&&l.categoria.nome].join(" "));
        return (!q||text.includes(q))&&(!cat||String(l.idcategoria)===cat);
      });
      all.sort(function(a,b){if(sort.value==="ano-desc")return (+b.anopublicacao)-(+a.anopublicacao);if(sort.value==="ano-asc")return (+a.anopublicacao)-(+b.anopublicacao);return pretty(a.titulo).localeCompare(pretty(b.titulo),"pt-BR");});
      all.forEach(function(l,i){results.append(card(l,i));});
    } else {
      const entries=view==="autores"?state.autores:state.categorias;
      all=entries.filter(function(x){return norm([x.nome,x.biografia,x.descricao].join(" ")).includes(q);}).sort(function(a,b){return pretty(a.nome).localeCompare(pretty(b.nome),"pt-BR");});
      all.forEach(function(x){results.append(person(x,view));});
    }
    if(!all.length)results.append(empty("Nenhum resultado encontrado","Tente outra palavra-chave ou ajuste os filtros."));
    $("result-count").textContent=all.length+" "+(all.length===1?"resultado":"resultados");
    results.setAttribute("aria-busy","false");
  }
  function view(name){
    state.view=name;
    const labels={livros:["Livros","Todos os livros","Obras presentes no acervo"],autores:["Autores","Nossos autores","Conheça os escritores do acervo"],categorias:["Categorias","Gêneros e categorias","Explore as classificações disponíveis"]};
    $("breadcrumb").textContent=labels[name][0];$("section-title").textContent=labels[name][1];$("section-subtitle").textContent=labels[name][2];
    results.classList.toggle("people",name!=="livros");results.classList.toggle("books",name==="livros");
    category.classList.toggle("hidden",name!=="livros");sort.classList.toggle("hidden",name!=="livros");
    input.placeholder=name==="livros"?"Buscar título, autor ou ISBN…":name==="autores"?"Buscar autores…":"Buscar categorias…";
    input.value="";
    document.querySelectorAll("[data-view]").forEach(function(b){const active=b.dataset.view===name;b.classList.toggle("active",active);b.setAttribute("aria-current",active?"page":"false");});
    render();
  }
  document.querySelectorAll("[data-view]").forEach(function(btn){btn.addEventListener("click",function(){view(btn.dataset.view);});});
  [input,category,sort].forEach(function(el){el.addEventListener(el===input?"input":"change",render);});
  $("close-details").addEventListener("click",function(){$("details").close();});
  $("details").addEventListener("click",function(e){if(e.target===$("details"))$("details").close();});
  async function load(){
    try{
      const response=await Promise.all(["/api/livros","/api/autores","/api/categorias"].map(function(path){return fetch(path,{headers:{"Accept":"application/json"}});}));
      if(response.some(function(x){return !x.ok;}))throw Error("Erro HTTP ao buscar dados");
      const payload=await Promise.all(response.map(function(x){return x.json();}));
      if(payload.some(function(x){return !Array.isArray(x);}))throw Error("Formato JSON inesperado");
      state.livros=payload[0];state.autores=payload[1];state.categorias=payload[2];state.ready=true;
      $("total-livros").textContent=state.livros.length;$("total-autores").textContent=state.autores.length;$("total-categorias").textContent=state.categorias.length;
      state.categorias.slice().sort(function(a,b){return pretty(a.nome).localeCompare(pretty(b.nome),"pt-BR");}).forEach(function(c){const opt=node("option","",c.nome);opt.value=String(c.idcategoria);category.append(opt);});
      render();
    }catch(err){console.error("Erro ao consultar a Biblioteca API:",err);state.failed=true;render();}
  }
  load();
})();
</script>
</body>
</html>
