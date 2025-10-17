<?php
// Identoo Dashboard v2.1 Glass UX Build
// Based on: "Identoo Dashboard v2 Stable Base"
// Notes: No backend dependencies required. LocalStorage persisted.
session_start();
$user_id = $_SESSION['user_id'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Identoo — Dashboard v2.1 Connected</title>

<!-- Google Fonts (live switchable) -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Poppins:wght@400;600;700&family=Roboto:wght@400;500;700&family=Playfair+Display:wght@500;700&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">

<style>
:root{
  --primary:#1e3a8a;
  --primary-2:#0ea5e9;
  --surface:#ffffff;
  --bg:#f4f7fb;
  --text:#0f172a;
  --muted:#64748b;
  --border:#e2e8f0;
  --radius:16px;
  --shadow:0 14px 40px rgba(15,23,42,0.12);
  --shadow-soft:0 8px 22px rgba(15,23,42,0.08);
}
*{box-sizing:border-box}
html,body{height:100%}
body{
  margin:0;
  font-family:Inter, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji";
  color:var(--text);
  background:var(--bg);
}

/* Header */
.header{
  position:sticky; top:0; z-index:10;
  background:linear-gradient(180deg, rgba(255,255,255,0.85), rgba(255,255,255,0.6));
  backdrop-filter: blur(8px);
  border-bottom:1px solid var(--border);
}
.header__inner{
  max-width:1200px; margin:0 auto; padding:10px 16px;
  display:flex; align-items:center; justify-content:space-between;
}
.header__brand{display:flex; align-items:center; gap:10px; font-weight:700; color:var(--primary); letter-spacing:.2px}
.header__brand svg{width:24px;height:24px}
.header__cta a{text-decoration:none; color:var(--primary); font-weight:600}
.header__cta a:hover{opacity:.85}

/* Layout */
.shell{max-width:1200px; margin:16px auto; padding:0 16px;}
.grid{
  display:grid;
  grid-template-columns: 1.1fr 1fr;
  gap:18px;
}
@media (max-width: 980px){
  .grid{grid-template-columns:1fr;}
}

/* Panels */
.panel{
  background:var(--surface);
  border:1px solid var(--border);
  border-radius:var(--radius);
  box-shadow:var(--shadow);
}
.panel__title{padding:12px 14px;border-bottom:1px solid var(--border);font-weight:700;color:var(--primary);font-size:.98rem}
.panel__body{padding:12px}

/* Sticky Preview (UX choice #2) */
.panel--sticky{
  position:sticky;
  top:16px;
  align-self:start;
  height:fit-content;
}

/* Preview toolbar */
.preview-wrap{position:relative;}
.preview-toolbar{
  display:flex; gap:8px; align-items:center; justify-content:space-between;
  margin-bottom:8px; flex-wrap:wrap;
}
.btn, .segmented button{
  background:var(--primary);
  color:#fff; border:none; border-radius:10px;
  padding:8px 12px; font-weight:600; cursor:pointer;
  box-shadow:var(--shadow-soft);
  transition:transform .08s ease, opacity .15s ease, background .15s ease;
  line-height:1;
}
.btn--ghost{
  background:#fff; color:var(--primary); border:1px solid var(--border);
}
.btn:hover{opacity:.95}
.btn:active{transform:scale(.98)}
.segmented{display:flex; background:#f1f5f9; padding:3px; border-radius:999px; border:1px solid var(--border)}
.segmented button{
  background:transparent; color:#0f172a; padding:6px 10px; border-radius:999px;
}
.segmented button.active{background:#fff; border:1px solid var(--border);}

/* Preview device frame */
.device{
  display:flex; align-items:center; justify-content:center;
  background:linear-gradient(180deg,#f8fbff,#eef3fb);
  border:1px dashed var(--border);
  border-radius:14px;
  padding:12px; height:min(72vh,560px);
}
@media (max-width: 420px){ .device{height:460px;} }
.canvas{
  position:relative;
  width:360px; max-width:90%;
  transform-origin: top center;
  transition: transform .2s ease;
}
.canvas--sm{width:320px}
.canvas--lg{width:440px}

/* THE CARD */
.card{
  position:relative;
  border-radius:18px;
  overflow:hidden;
  box-shadow:var(--shadow-soft);
  background:#fff;
  transition:background .2s ease, border-color .2s ease, box-shadow .2s ease;
}

/* Theme variants */
.card.theme-glass{
  background:rgba(255,255,255,0.55);
  border:1px solid rgba(255,255,255,0.45);
  backdrop-filter: blur(14px);
  box-shadow:0 18px 44px rgba(2,6,23,.18);
}
.card.theme-minimal{
  background:#ffffff;
  border:1px solid var(--border);
  box-shadow:var(--shadow-soft);
}
.card.theme-dark{
  background:#0b1220; color:#e5e7eb;
  border:1px solid rgba(255,255,255,0.06);
  box-shadow:0 18px 44px rgba(0,0,0,.5);
}
.card.theme-gradient{
  background:linear-gradient(180deg, rgba(255,255,255,.92), rgba(255,255,255,.72));
  border:1px solid rgba(255,255,255,.6);
}

/* Cover area */
.card__cover{
  --cover-height: 160px;
  height: var(--cover-height);
  background:#e2e8f0;
  background-size:cover;
  background-position:center;
  position:relative;
}
.card__cover::after{
  content:"";
  position:absolute; inset:0;
  background:linear-gradient(to bottom, rgba(0,0,0,0) 55%, rgba(0,0,0,0.25) 100%);
}
.card.theme-dark .card__cover::after{
  background:linear-gradient(to bottom, rgba(0,0,0,0.05) 40%, rgba(0,0,0,0.45) 100%);
}

/* Avatar + Logo overlap row */
.card__overlap{
  position:relative;
  height:120px;
  margin-top:-60px; /* float effect (half of overlap band) */
}
.badges{position:absolute; top:10px; right:10px; display:flex; gap:6px; z-index:3}
.badge{font-size:12px; padding:4px 8px; background:rgba(255,255,255,.85); backdrop-filter:blur(6px); border:1px solid var(--border); border-radius:999px}
.card.theme-dark .badge{background:rgba(16,24,40,.75); color:#e5e7eb; border-color:#1f2937}

.handle{
  --w: 122px; --h: 122px; --border: 4px;
  position:absolute; top:-61px; /* 50% overlap of 122px */
  transform: translateX(-50%);
  width:var(--w); height:var(--h);
  border:var(--border) solid #fff; border-radius:24px;
  overflow:hidden; background:#cbd5e1; box-shadow:0 10px 24px rgba(0,0,0,.12);
  cursor:grab; touch-action:none; user-select:none; z-index:2;
}
.card.theme-dark .handle{border-color:#0b1220; box-shadow:0 14px 32px rgba(0,0,0,.5);}
.handle img{width:100%; height:100%; object-fit:cover;}
.handle--avatar{ left:25%; }
.handle--logo  { left:75%; --w: 102px; --h: 102px; top:-51px; }
.handle.is-dragging{cursor:grabbing;}

/* Shapes */
.shape-rounded{border-radius:24px}
.shape-circle{border-radius:999px}
.shape-squircle{border-radius:28%}

/* Card text */
.card__body{padding:14px 14px 16px; text-align:center; position:relative; z-index:1}
.card__title{font-size:1.1rem; font-weight:700; letter-spacing:.2px; margin:0 0 4px}
.card__subtitle{color:#475569; font-size:.95rem; margin-bottom:6px}
.card.theme-dark .card__subtitle{color:#cbd5e1}

/* Social icons — above QR */
.socials{display:flex;justify-content:center;gap:.55rem;flex-wrap:wrap;margin:8px auto 6px}
.socials .social{
  width:32px;height:32px;display:flex;align-items:center;justify-content:center;
  border-radius:50%; background:#fff; border:1px solid var(--border);
  box-shadow:0 2px 5px rgba(0,0,0,.08);
  transition:transform .12s ease, background .2s ease, border-color .2s ease;
}
.socials .social:hover{transform:scale(1.07); background:#fff}
.card.theme-dark .socials .social{background:#0f172a;border-color:#1f2937}
.socials svg{width:18px;height:18px;display:block;}

/* QR */
.card__qr{
  width:96px; height:96px; background:#e2e8f0; border-radius:10px; margin:8px auto 2px;
}

/* ===== COMPACT EDITOR LAYOUT ===== */
aside.panel .panel__body{padding:10px}
.form{
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:10px 12px;
}
.form .full{grid-column:1 / -1}
.group{
  background:var(--surface); border:1px solid var(--border); border-radius:12px; padding:10px;
}
.group h4{margin:0 0 6px; color:var(--primary); font-size:.95rem}
.row{display:grid; grid-template-columns:140px 1fr; align-items:center; gap:8px; margin:6px 0}
.row label{font-weight:600; color:#0f172a; font-size:.9rem}
input[type="text"], input[type="url"], input[type="color"], select, input[type="file"], textarea{
  padding:8px 10px; border:1px solid var(--border); border-radius:10px; width:100%; font-size:.95rem; background:#fff;
}
textarea{min-height:84px; resize:vertical}
input[type="range"]{width:100%}
.switch{display:inline-flex; align-items:center; gap:8px}
.switch input{transform:scale(1.15)}

/* Palettes & Theme packs */
.palette{display:flex; gap:8px; flex-wrap:wrap}
.swatch{width:26px; height:26px; border-radius:50%; border:2px solid #fff; box-shadow:0 0 0 2px #e2e8f0; cursor:pointer}
.swatch:focus{outline:2px solid var(--primary)}
.theme-packs{display:flex;gap:.4rem;flex-wrap:wrap;margin-top:.2rem}
.theme-packs button{
  background:#fff;color:#1e3a8a;border:1px solid #ddd;padding:.35rem .65rem;border-radius:6px;font-size:.82rem;cursor:pointer;transition:background .2s,color .2s;
}
.theme-packs button:hover{background:#1e3a8a;color:#fff}

/* Toast */
.toast{
  position:fixed; right:16px; bottom:16px; z-index:20;
  background:#0ea5e9; color:#fff; font-weight:600;
  padding:10px 12px; border-radius:12px; box-shadow:var(--shadow);
  opacity:0; transform:translateY(8px); pointer-events:none; transition:all .2s;
  font-size:.92rem;
}
.toast.show{opacity:1; transform:translateY(0); pointer-events:auto}

/* Utility */
hr{border:none; border-top:1px solid var(--border); margin:8px 0}
.mono{font-family:"JetBrains Mono", ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace; font-size:.86rem}
.small{font-size:.84rem; color:var(--muted)}

/* Disable sticky on small screens for better flow */
@media (max-width: 980px){
  .panel--sticky{position:static; top:auto}
  .form{grid-template-columns:1fr}
  .row{grid-template-columns:1fr; gap:6px}
}
</style>
</head>
<body>

<header class="header">
  <div class="header__inner">
    <div class="header__brand">
      <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 1 0 10 10A10.012 10.012 0 0 0 12 2Zm1 14.93V20h-2v-3.07A8.016 8.016 0 0 1 4.07 13H1v-2h3.07A8.016 8.016 0 0 1 11 4.07V1h2v3.07A8.016 8.016 0 0 1 19.93 11H23v2h-3.07A8.016 8.016 0 0 1 13 16.93Z"/></svg>
      Identoo
    </div>
    <div class="header__cta">
      <a href="#" id="resetBtn">Reset</a>
    </div>
  </div>
</header>

<div class="shell">
  <div class="grid">

    <!-- ============ PREVIEW PANEL (Sticky) ============ -->
    <section class="panel panel--sticky">
      <div class="panel__title">Live preview</div>
      <div class="panel__body">
        <div class="preview-wrap">

          <div class="preview-toolbar">
            <div class="segmented" role="tablist" aria-label="Device size">
              <button class="active" data-size="sm" aria-selected="true">Mobile</button>
              <button data-size="md">Tablet</button>
              <button data-size="lg">Desktop</button>
            </div>

            <div style="display:flex; gap:8px; align-items:center;">
              <button class="btn btn--ghost" id="snapToggle">Snap: On</button>
              <button class="btn btn--ghost" id="boundsToggle">Bounds: On</button>
              <button class="btn" id="saveBtn">Save</button>
            </div>
          </div>

          <div class="device" id="device">
            <div class="canvas canvas--sm" id="canvas">

              <article class="card theme-glass" id="card">
                <div class="card__cover" id="cover"></div>

                <div class="card__overlap" id="overlap">
                  <div class="badges">
                    <div class="badge" id="modeBadge">Colour</div>
                    <div class="badge" id="layoutBadge">Centered</div>
                  </div>

                  <!-- AVATAR + LOGO -->
                  <div class="handle handle--avatar shape-rounded" id="avatarHandle" style="left:25%;">
                    <img id="avatarImg" src="https://images.unsplash.com/photo-1527980965255-d3b416303d12?q=80&w=300&auto=format&fit=crop" alt="Avatar">
                  </div>
                  <div class="handle handle--logo shape-rounded" id="logoHandle" style="left:75%;">
                    <img id="logoImg" src="https://images.unsplash.com/photo-1611162618071-b39a2ec2e5f0?q=80&w=300&auto=format&fit=crop" alt="Logo">
                  </div>
                </div>

                <div class="card__body">
                  <div class="card__title" id="namePreview">Jane Doe</div>
                  <div class="card__subtitle" id="titlePreview">Product Manager at Identoo</div>

                  <!-- Socials above QR -->
                  <div class="socials" id="socials"></div>

                  <div class="card__qr" id="qr"></div>
                </div>
              </article>

            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- ============ CONTROLS PANEL (Compacted) ============ -->
    <aside class="panel">
      <div class="panel__title">Editor</div>
      <div class="panel__body">
        <form class="form" id="editorForm" autocomplete="off">

          <!-- Theme -->
          <div class="group">
            <h4>Theme</h4>
            <div class="row"><label>Preset</label>
              <div class="segmented" id="themeMode">
                <button type="button" class="active" data-theme="glass">Glass</button>
                <button type="button" data-theme="minimal">Minimal</button>
                <button type="button" data-theme="dark">Dark</button>
                <button type="button" data-theme="gradient">Gradient</button>
              </div>
            </div>
          </div>

          <!-- Identity -->
          <div class="group">
            <h4>Identity</h4>
            <div class="row"><label for="first">First name</label><input id="first" type="text" placeholder="Jane"></div>
            <div class="row"><label for="last">Last name</label><input id="last" type="text" placeholder="Doe"></div>
            <div class="row"><label for="job">Job title</label><input id="job" type="text" placeholder="Product Manager"></div>
            <div class="row"><label for="biz">Business</label><input id="biz" type="text" placeholder="Identoo"></div>
            <div class="row full"><label for="bio">About</label><textarea id="bio" placeholder="Short bio (optional)"></textarea></div>
          </div>

          <!-- Typography -->
          <div class="group">
            <h4>Typography</h4>
            <div class="row"><label for="font">Font</label>
              <select id="font">
                <option value="Inter">Inter</option>
                <option value="Poppins">Poppins</option>
                <option value="Roboto">Roboto</option>
                <option value="Playfair Display">Playfair Display</option>
                <option value="JetBrains Mono">JetBrains Mono</option>
              </select>
            </div>
            <div class="row"><label for="titleSize">Title size</label><input id="titleSize" type="range" min="16" max="30" value="20"></div>
            <div class="row"><label for="subtitleSize">Subtitle size</label><input id="subtitleSize" type="range" min="12" max="22" value="15"></div>
            <div class="row"><label for="fontColor">Text colour</label><input id="fontColor" type="color" value="#0f172a"></div>
            <div class="small">Auto-contrast ensures readability.</div>
          </div>

          <!-- Cover -->
          <div class="group">
            <h4>Cover</h4>
            <div class="row"><label>Mode</label>
              <div class="segmented" id="coverMode">
                <button type="button" class="active" data-mode="color">Colour</button>
                <button type="button" data-mode="gradient">Gradient</button>
                <button type="button" data-mode="image">Image</button>
              </div>
            </div>
            <div class="row" id="colorRow"><label for="coverColor">Colour</label><input id="coverColor" type="color" value="#1e3a8a"></div>
            <div class="row" id="gradientRow" style="display:none;">
              <label>Gradient</label>
              <div style="display:flex;gap:8px;width:100%"><input id="gradA" type="color" value="#1e3a8a" /><input id="gradB" type="color" value="#0ea5e9" /></div>
            </div>
            <div class="row" id="imageRow" style="display:none;">
              <label>Image</label><input id="coverUpload" type="file" accept="image/*" />
            </div>
            <div class="row"><label>Palettes</label>
              <div class="palette" id="palette">
                <button type="button" class="swatch" style="background:#1e3a8a" data-a="#1e3a8a" data-b="#0ea5e9" aria-label="Blue"></button>
                <button type="button" class="swatch" style="background:#10b981" data-a="#0ea5e9" data-b="#10b981" aria-label="Teal"></button>
                <button type="button" class="swatch" style="background:#ef4444" data-a="#ef4444" data-b="#f97316" aria-label="Red"></button>
                <button type="button" class="swatch" style="background:#a855f7" data-a="#a855f7" data-b="#06b6d4" aria-label="Purple"></button>
                <button type="button" class="swatch" style="background:#111827" data-a="#111827" data-b="#374151" aria-label="Dark"></button>
              </div>
            </div>
            <div class="row"><label>Pick from Pexels</label><button type="button" class="btn btn--ghost" id="pexelsBtn">Open library</button></div>
          </div>

          <!-- Avatars -->
          <div class="group">
            <h4>Avatar & logo</h4>
            <div class="row"><label for="avatarSize">Avatar size</label><input id="avatarSize" type="range" min="80" max="160" value="122"></div>
            <div class="row"><label for="logoSize">Logo size</label><input id="logoSize" type="range" min="64" max="140" value="102"></div>
            <div class="row"><label>Shape</label>
              <div class="segmented" id="shapeMode">
                <button type="button" class="active" data-shape="rounded">Rounded</button>
                <button type="button" data-shape="circle">Circle</button>
                <button type="button" data-shape="squircle">Squircle</button>
              </div>
            </div>
            <div class="row"><label>Shadows</label><label class="switch"><input id="shadowToggle" type="checkbox" checked> Enable</label></div>
            <div class="row"><label>Swap positions</label><button type="button" class="btn btn--ghost" id="swapBtn">Swap</button></div>
            <div class="row"><label>Upload avatar</label><input id="avatarUpload" type="file" accept="image/*" /></div>
            <div class="row"><label>Upload logo</label><input id="logoUpload" type="file" accept="image/*" /></div>
          </div>

          <!-- Social links (Smart Socials) -->
          <div class="group full">
            <h4>Social & Actions</h4>
            <div class="row"><label for="website">Website</label><input id="website" type="url" placeholder="yourdomain.com or https://..."></div>
            <div class="row"><label for="email">Email</label><input id="email" type="text" placeholder="you@company.com"></div>
            <div class="row"><label for="whatsapp">WhatsApp</label><input id="whatsapp" type="text" placeholder="+27123456789"></div>
            <div class="row"><label for="linkedin">LinkedIn</label><input id="linkedin" type="url" placeholder="linkedin.com/in/username"></div>
            <div class="row"><label for="instagram">Instagram</label><input id="instagram" type="url" placeholder="instagram.com/username"></div>
            <div class="row"><label for="twitter">X (Twitter)</label><input id="twitter" type="url" placeholder="x.com/username"></div>
            <div class="row"><label for="calendly">Calendly</label><input id="calendly" type="url" placeholder="calendly.com/username"></div>
          </div>

          <!-- Layout presets -->
          <div class="group">
            <h4>Layout</h4>
            <div class="row"><label>Preset</label>
              <div class="segmented" id="layoutMode">
                <button type="button" class="active" data-layout="centered">Centered</button>
                <button type="button" data-layout="split">Split</button>
                <button type="button" data-layout="compact">Compact</button>
                <button type="button" data-layout="hero">Hero</button>
              </div>
            </div>
          </div>

          <!-- Theme packs -->
          <div class="group full">
            <h4>Theme packs</h4>
            <div class="theme-packs" id="themePacks">
              <button type="button" data-pack="corporate">Corporate</button>
              <button type="button" data-pack="creative">Creative</button>
              <button type="button" data-pack="tech">Tech</button>
              <button type="button" data-pack="luxury">Luxury</button>
            </div>
          </div>

          <!-- System -->
          <div class="group full">
            <h4>System</h4>
            <div class="row"><label>Autosave</label><span class="small">Your edits are saved to this browser. DB sync can be wired later.</span></div>
            <div class="row"><label>Debug JSON</label><textarea id="debug" class="mono" readonly></textarea></div>
          </div>

        </form>
      </div>
    </aside>

  </div>
</div>

<!-- Toast -->
<div class="toast" id="toast">Saved</div>

<!-- Pexels Modal (simple) -->
<div id="pexelsModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,.55); z-index:50; align-items:center; justify-content:center;">
  <div style="background:#fff; width:min(1000px,92vw); height:80vh; border-radius:16px; box-shadow:var(--shadow); display:flex; flex-direction:column; overflow:hidden;">
    <div style="display:flex; align-items:center; justify-content:space-between; padding:12px 14px; border-bottom:1px solid var(--border);">
      <strong>Pexels</strong>
      <button class="btn btn--ghost" id="pexelsClose">Close</button>
    </div>
    <div style="display:flex; gap:8px; padding:10px 12px;">
      <input id="pexelsQuery" type="text" placeholder="Search images..." style="flex:1; padding:10px; border:1px solid var(--border); border-radius:10px" />
      <button class="btn" id="pexelsSearch">Search</button>
    </div>
    <div id="pexelsGrid" style="flex:1; overflow:auto; padding:12px; display:grid; grid-template-columns:repeat(auto-fill, minmax(160px, 1fr)); gap:10px;"></div>
  </div>
</div>

<script>
/* =============== STATE & HELPERS =============== */
const $ = (sel, root=document)=>root.querySelector(sel);
const $$ = (sel, root=document)=>Array.from(root.querySelectorAll(sel));
const clamp=(v,min,max)=>Math.min(max,Math.max(min,v));
const debounce=(fn,ms=400)=>{let t;return (...a)=>{clearTimeout(t);t=setTimeout(()=>fn(...a),ms)};}
const toast=(msg)=>{const t=$("#toast"); t.textContent=msg; t.classList.add("show"); setTimeout(()=>t.classList.remove("show"),1200);}

const stateDefaults={
  device:"sm",
  theme:"glass",
  cover:{ mode:"color", color:"#1e3a8a", gradA:"#1e3a8a", gradB:"#0ea5e9", image:null },
  name:"Jane Doe",
  title:"Product Manager",
  biz:"Identoo",
  fontFamily:"Inter", titleSize:20, subtitleSize:15, fontColor:"#0f172a",
  avatar:{ src:null, size:122, shape:"rounded", xPercent:25 },
  logo:{ src:null, size:102, shape:"rounded", xPercent:75 },
  snap:true, bounds:true,
  layout:"centered",
  socials:{ website:"", email:"", whatsapp:"", linkedin:"", instagram:"", twitter:"", calendly:"" }
};
let state = JSON.parse(localStorage.getItem("identoo_v2_state") || "null") || structuredClone(stateDefaults);

/* =============== ELEMENTS =============== */
const device=$("#device"), canvas=$("#canvas"), card=$("#card"), cover=$("#cover");
const avatarHandle=$("#avatarHandle"), avatarImg=$("#avatarImg");
const logoHandle=$("#logoHandle"), logoImg=$("#logoImg");
const namePreview=$("#namePreview"), titlePreview=$("#titlePreview");
const modeBadge=$("#modeBadge"), layoutBadge=$("#layoutBadge");
const socialsWrap=$("#socials");

/* =============== DEVICE SIZE =============== */
const deviceButtons=$$(".segmented[role='tablist'] button");
deviceButtons.forEach(b=>{
  b.addEventListener("click", ()=>{
    deviceButtons.forEach(x=>x.classList.remove("active"));
    b.classList.add("active");
    state.device=b.dataset.size;
    canvas.classList.remove("canvas--sm","canvas--lg");
    if(state.device==="sm") canvas.classList.add("canvas--sm");
    if(state.device==="lg") canvas.classList.add("canvas--lg");
    save();
  });
});
function initDevice(){
  deviceButtons.forEach(b=>{ if(b.dataset.size===state.device) b.classList.add("active"); });
  canvas.classList.toggle("canvas--sm", state.device==="sm");
  canvas.classList.toggle("canvas--lg", state.device==="lg");
}

/* =============== THEME ENGINE =============== */
const themeBtns=$$("#themeMode button");
function applyTheme(){
  card.classList.remove("theme-glass","theme-minimal","theme-dark","theme-gradient");
  card.classList.add(`theme-${state.theme}`);
}
themeBtns.forEach(b=>b.addEventListener("click",()=>{
  themeBtns.forEach(x=>x.classList.remove("active"));
  b.classList.add("active");
  state.theme=b.dataset.theme;
  applyTheme();
  save();
}));

/* =============== TEXT / TYPOGRAPHY =============== */
const first=$("#first"), last=$("#last"), job=$("#job"), biz=$("#biz"), bio=$("#bio");
const font=$("#font"), titleSize=$("#titleSize"), subtitleSize=$("#subtitleSize"), fontColor=$("#fontColor");

function applyText(){
  const fallback = state.name.split(" ");
  const full=( (first.value || fallback[0] || "") + " " + (last.value || fallback.slice(1).join(" ") || "") ).trim();
  namePreview.textContent = full || "Your Name";
  titlePreview.textContent = (job.value || state.title) + " at " + (biz.value || state.biz);
  card.style.fontFamily = state.fontFamily;
  namePreview.style.fontSize = (state.titleSize)+"px";
  titlePreview.style.fontSize = (state.subtitleSize)+"px";
  namePreview.style.color = state.fontColor;
  titlePreview.style.color = state.theme==="dark" ? "#e5e7eb" : state.fontColor;
}
/* Bind text inputs */
[first,last,job,biz,font,titleSize,subtitleSize,fontColor].forEach(el=>el.addEventListener("input",debounce(()=>{
  state.name = ( (first.value||"") + " " + (last.value||"") ).trim() || stateDefaults.name;
  state.title = job.value || stateDefaults.title;
  state.biz   = biz.value || stateDefaults.biz;
  state.fontFamily = font.value;
  state.titleSize = +titleSize.value;
  state.subtitleSize = +subtitleSize.value;
  state.fontColor = fontColor.value;
  applyText(); save();
},160)));

/* =============== COVER MODES =============== */
const coverModeBtns=$$("#coverMode button");
const colorRow=$("#colorRow"), gradientRow=$("#gradientRow"), imageRow=$("#imageRow");
const coverColor=$("#coverColor"), gradA=$("#gradA"), gradB=$("#gradB"), coverUpload=$("#coverUpload");

function renderCover(){
  modeBadge.textContent = state.cover.mode.charAt(0).toUpperCase() + state.cover.mode.slice(1);
  if(state.cover.mode==="color"){
    cover.style.background = state.cover.color;
    cover.style.backgroundImage="none";
  }else if(state.cover.mode==="gradient"){
    cover.style.background = `linear-gradient(135deg, ${state.cover.gradA}, ${state.cover.gradB})`;
    cover.style.backgroundImage="none";
  }else{
    cover.style.backgroundImage = state.cover.image ? `url('${state.cover.image}')` : "none";
    cover.style.backgroundSize = "cover"; cover.style.backgroundPosition="center";
    if(!state.cover.image) cover.style.background = "#e2e8f0";
  }
}
coverModeBtns.forEach(btn=>{
  btn.addEventListener("click", ()=>{
    coverModeBtns.forEach(b=>b.classList.remove("active"));
    btn.classList.add("active");
    state.cover.mode = btn.dataset.mode;
    colorRow.style.display = state.cover.mode==="color" ? "" : "none";
    gradientRow.style.display = state.cover.mode==="gradient" ? "" : "none";
    imageRow.style.display = state.cover.mode==="image" ? "" : "none";
    renderCover(); save();
  });
});
coverColor.addEventListener("input", ()=>{ state.cover.color = coverColor.value; renderCover(); save(); });
[gradA,gradB].forEach(el=>el.addEventListener("input", ()=>{ state.cover.gradA=gradA.value; state.cover.gradB=gradB.value; renderCover(); save(); }));
coverUpload.addEventListener("change", e=>{
  const f=e.target.files?.[0]; if(!f) return;
  const url=URL.createObjectURL(f); state.cover.image=url; state.cover.mode="image";
  coverModeBtns.forEach(b=>b.classList.toggle("active", b.dataset.mode==="image"));
  colorRow.style.display="none"; gradientRow.style.display="none"; imageRow.style.display="";
  renderCover(); save();
});
$("#palette").addEventListener("click", e=>{
  const sw=e.target.closest(".swatch"); if(!sw) return;
  state.cover.gradA=sw.dataset.a; state.cover.gradB=sw.dataset.b; gradA.value=state.cover.gradA; gradB.value=state.cover.gradB;
  state.cover.color=sw.dataset.a; coverColor.value=state.cover.color;
  renderCover(); save();
});

/* =============== AVATAR & LOGO =============== */
const avatarSize=$("#avatarSize"), logoSize=$("#logoSize"), shapeButtons=$$("#shapeMode button"), shadowToggle=$("#shadowToggle"), swapBtn=$("#swapBtn"), layoutButtons=$$("#layoutMode button");
function applyHandle(el, s){ el.style.setProperty("--w", s+"px"); el.style.setProperty("--h", s+"px"); el.style.top = -(s/2)+"px"; }
function applyShapes(){
  [avatarHandle, logoHandle].forEach(h=>{
    h.classList.remove("shape-rounded","shape-circle","shape-squircle");
    h.classList.add(`shape-${state.avatar.shape}`);
  });
}
function applyShadows(){
  const shadow = shadowToggle.checked ? "0 10px 24px rgba(0,0,0,.12)" : "none";
  [avatarHandle,logoHandle].forEach(h=>h.style.boxShadow = shadow);
}
function applySizes(){
  applyHandle(avatarHandle, state.avatar.size);
  applyHandle(logoHandle, state.logo.size);
}
function applyPositions(){
  avatarHandle.style.left = state.avatar.xPercent + "%";
  logoHandle.style.left   = state.logo.xPercent + "%";
}
avatarSize.addEventListener("input", ()=>{ state.avatar.size=+avatarSize.value; applySizes(); save(); });
logoSize.addEventListener("input",   ()=>{ state.logo.size=+logoSize.value; applySizes(); save(); });
shapeButtons.forEach(b=>b.addEventListener("click", ()=>{
  shapeButtons.forEach(x=>x.classList.remove("active"));
  b.classList.add("active");
  state.avatar.shape = b.dataset.shape;
  applyShapes(); save();
}));
shadowToggle.addEventListener("change", ()=>{ applyShadows(); save(); });
swapBtn.addEventListener("click", ()=>{
  const tmp = state.avatar.xPercent;
  state.avatar.xPercent = state.logo.xPercent;
  state.logo.xPercent = tmp;
  applyPositions(); save();
});
$("#avatarUpload").addEventListener("change", e=>{
  const f=e.target.files?.[0]; if(!f) return; const url=URL.createObjectURL(f); avatarImg.src=url; state.avatar.src=url; save();
});
$("#logoUpload").addEventListener("change", e=>{
  const f=e.target.files?.[0]; if(!f) return; const url=URL.createObjectURL(f); logoImg.src=url; state.logo.src=url; save();
});

/* Drag logic with snap + bounds (X-axis) */
let snapOn = state.snap, boundsOn = state.bounds;
const snapToggle=$("#snapToggle"), boundsToggle=$("#boundsToggle");
function setSnapUI(){ snapToggle.textContent = `Snap: ${snapOn?'On':'Off'}`; }
function setBoundsUI(){ boundsToggle.textContent = `Bounds: ${boundsOn?'On':'Off'}`; }
snapToggle.addEventListener("click", ()=>{ snapOn=!snapOn; setSnapUI(); });
boundsToggle.addEventListener("click", ()=>{ boundsOn=!boundsOn; setBoundsUI(); });

function makeAxisDragX(handle, getSetter){
  let dragging=false, startX=0, baseX=0;
  const onDown=(e)=>{
    dragging=true; handle.classList.add("is-dragging");
    startX=(e.touches?e.touches[0].clientX:e.clientX);
    baseX = handle.getBoundingClientRect().left;
    e.preventDefault();
  };
  const onMove=(e)=>{
    if(!dragging) return;
    const clientX=(e.touches?e.touches[0].clientX:e.clientX);
    const dx = clientX - startX;
    const pr = $("#card").getBoundingClientRect();
    const w = pr.width;
    let centerPx = baseX + dx + handle.offsetWidth/2 - pr.left; // center within card
    if(boundsOn){
      const margin = 20;
      centerPx = clamp(centerPx, margin, w - margin);
    }
    let percent = (centerPx / w) * 100;
    if(snapOn){
      const snaps = [15,25,33.333,50,66.666,75,85];
      let closest=snaps[0], min=999;
      snaps.forEach(s=>{ const d=Math.abs(s-percent); if(d<min){min=d;closest=s;} });
      if(min<2.4) percent = closest;
    }
    getSetter(percent);
  };
  const onUp=()=>{ if(!dragging) return; dragging=false; handle.classList.remove("is-dragging"); save(); };

  handle.addEventListener("mousedown", onDown);
  handle.addEventListener("touchstart", onDown, {passive:false});
  window.addEventListener("mousemove", onMove);
  window.addEventListener("touchmove", onMove, {passive:false});
  window.addEventListener("mouseup", onUp);
  window.addEventListener("touchend", onUp);
}
makeAxisDragX(avatarHandle, (p)=>{ state.avatar.xPercent=clamp(p,5,95); avatarHandle.style.left=state.avatar.xPercent+"%"; });
makeAxisDragX(logoHandle,   (p)=>{ state.logo.xPercent=clamp(p,5,95);   logoHandle.style.left=state.logo.xPercent+"%"; });

/* Layout presets */
layoutButtons.forEach(b=>b.addEventListener("click", ()=>{
  layoutButtons.forEach(x=>x.classList.remove("active"));
  b.classList.add("active");
  state.layout = b.dataset.layout;
  layoutBadge.textContent = b.textContent;
  if(state.layout==="centered"){
    state.avatar.xPercent = 25; state.logo.xPercent = 75; state.avatar.size=122; state.logo.size=102;
  }else if(state.layout==="split"){
    state.avatar.xPercent = 20; state.logo.xPercent = 80;
  }else if(state.layout==="compact"){
    state.avatar.size = 110; state.logo.size = 90; state.avatar.xPercent=30; state.logo.xPercent=70;
  }else if(state.layout==="hero"){
    state.avatar.size = 150; state.logo.size = 120; state.avatar.xPercent=22; state.logo.xPercent=78;
  }
  avatarSize.value = state.avatar.size; logoSize.value=state.logo.size;
  applySizes(); applyPositions(); save();
}));

/* =============== SMART SOCIALS (FIXED) =============== */
const socialInputs = {
  website: $("#website"),
  email: $("#email"),
  whatsapp: $("#whatsapp"),
  linkedin: $("#linkedin"),
  instagram: $("#instagram"),
  twitter: $("#twitter"),
  calendly: $("#calendly"),
};
const ICONS = {
  website:`<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 1 0 .001 20.001A10 10 0 0 0 12 2Zm0 2c1.1 0 2.127.312 3 .85A9.97 9.97 0 0 0 12 20a9.97 9.97 0 0 1-3-17.15A5.98 5.98 0 0 1 12 4z"/></svg>`,
  email:`<svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4a2 2 0 0 0-2 2v1.2l10 5.6 10-5.6V6a2 2 0 0 0-2-2Zm0 5.4-8 4.4-8-4.4V18a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9.4Z"/></svg>`,
  whatsapp:`<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a9.99 9.99 0 0 0-8.55 15.12L2 22l4.99-1.31A10 10 0 1 0 12 2Zm5.2 14.2c-.22.63-1.28 1.2-1.82 1.27-.47.06-1.06.09-1.71-.1-.39-.12-.9-.29-1.54-.57-2.71-1.17-4.47-3.9-4.6-4.09-.13-.18-1.1-1.47-1.1-2.8 0-1.33.7-1.98.95-2.25.25-.27.55-.34.73-.34.18 0 .36 0 .52.01.16.01.39-.06.61.47.22.54.75 1.86.82 2 .07.13.11.29.02.47-.09.18-.13.29-.26.44-.13.15-.27.34-.38.46-.13.13-.26.27-.11.52.15.25.66 1.09 1.43 1.77 1 0.9 1.84 1.19 2.09 1.33.25.13.41.12.57-.08.16-.2.65-.76.82-1.02.18-.25.34-.21.57-.12.23.09 1.45.68 1.7.8.25.12.41.18.47.28.06.1.06.58-.16 1.21Z"/></svg>`,
  linkedin:`<svg viewBox="0 0 24 24" fill="currentColor"><path d="M4.98 3.5C4.98 4.88 3.86 6 2.5 6S0 4.88 0 3.5 1.12 1 2.5 1 5 2.12 5 3.5zM.5 8h4v15h-4zM9 8h3.7v2.05h.05c.52-.98 1.8-2.05 3.7-2.05 3.96 0 4.7 2.6 4.7 6V23h-4v-7.5c0-1.8-.03-4.12-2.5-4.12-2.5 0-2.88 1.95-2.88 3.98V23H9z"/></svg>`,
  instagram:`<svg viewBox="0 0 24 24" fill="currentColor"><path d="M7 2C4.24 2 2 4.24 2 7v10c0 2.76 2.24 5 5 5h10c2.76 0 5-2.24 5-5V7c0-2.76-2.24-5-5-5H7zm10 2c1.65 0 3 1.35 3 3v10c0 1.65-1.35 3-3 3H7c-1.65 0-3-1.35-3-3V7c0-1.65 1.35-3 3-3h10zm-5 3a5 5 0 110 10 5 5 0 010-10zm6-2a1 1 0 110 2 1 1 0 010-2z"/></svg>`,
  twitter:`<svg viewBox="0 0 24 24" fill="currentColor"><path d="M21 5.5a8.38 8.38 0 0 1-2.4.66A4.19 4.19 0 0 0 20.43 4a8.39 8.39 0 0 1-2.66 1.02A4.18 4.18 0 0 0 12 9.18c0 .33.04.65.1.96A11.86 11.86 0 0 1 3 5.16a4.18 4.18 0 0 0 1.29 5.58 4.15 4.15 0 0 1-1.9-.52v.05A4.18 4.18 0 0 0 6.18 14a4.2 4.2 0 0 1-1.89.07 4.18 4.18 0 0 0 3.9 2.9A8.4 8.4 0 0 1 2 19.54 11.86 11.86 0 0 0 8.29 21c7.55 0 11.68-6.26 11.68-11.68l-.01-.53A8.36 8.36 0 0 0 21 5.5z"/></svg>`,
  calendly:`<svg viewBox="0 0 24 24" fill="currentColor"><path d="M6 2h12a4 4 0 0 1 4 4v12a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V6a4 4 0 0 1 4-4Zm2 4h2v2H8V6Zm0 4h8v2H8v-2Zm0 4h6v2H8v-2Z"/></svg>`
};
function normUrl(u){
  if(!u) return "";
  const s = u.trim();
  // email
  if(/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(s)) return `mailto:${s}`;
  // tel for whatsapp if pure number starts with + or digits
  if(/^(\+?\d[\d\s-]*)$/.test(s)) return s;
  // add protocol if missing
  if(!/^https?:\/\//i.test(s) && !s.startsWith("mailto:") && !s.startsWith("tel:")) return "https://"+s;
  return s;
}
function buildSocialMap(vals){
  const out=[];
  for(const [k,v] of Object.entries(vals)){
    if(!v) continue;
    let url = v;
    if(k==="email") url = `mailto:${v.replace(/^mailto:/i,"")}`;
    if(k==="whatsapp"){
      const digits = v.replace(/[^\d]/g,"");
      if(digits) url = `https://wa.me/${digits}`;
      else continue;
    }
    if(k!=="email" && k!=="whatsapp") url = normUrl(v);
    out.push([k,url]);
  }
  return out;
}
function renderSocials(){
  socialsWrap.innerHTML="";
  const vals = state.socials || {};
  const items = buildSocialMap(vals);
  if(items.length===0) return;
  for(const [name,url] of items){
    const a=document.createElement("a");
    a.href=url; a.target="_blank"; a.rel="noopener"; a.className="social";
    a.innerHTML = ICONS[name] || ICONS.website;
    socialsWrap.appendChild(a);
  }
}
// Bind inputs to state + live render
Object.entries(socialInputs).forEach(([key,el])=>{
  const onChange = ()=>{
    state.socials[key]=el.value.trim();
    renderSocials();
    save();
  };
  el.addEventListener("input", debounce(onChange, 150));
  el.addEventListener("blur", onChange);
});

/* =============== THEME PACKS =============== */
$("#themePacks").addEventListener("click",(e)=>{
  const pack = e.target?.dataset?.pack;
  if(!pack) return;
  if(pack==="corporate"){
    state.theme="glass";
    state.cover.mode="gradient"; state.cover.gradA="#1e3a8a"; state.cover.gradB="#0ea5e9";
    state.fontFamily="Inter"; state.titleSize=20; state.subtitleSize=15; state.fontColor="#0f172a";
    state.avatar.shape="rounded";
  }else if(pack==="creative"){
    state.theme="gradient";
    state.cover.mode="gradient"; state.cover.gradA="#ec4899"; state.cover.gradB="#f59e0b";
    state.fontFamily="Poppins"; state.titleSize=22; state.subtitleSize=16; state.fontColor="#111827";
    state.avatar.shape="squircle";
  }else if(pack==="tech"){
    state.theme="dark";
    state.cover.mode="gradient"; state.cover.gradA="#0f172a"; state.cover.gradB="#1e3a8a";
    state.fontFamily="Roboto"; state.titleSize=20; state.subtitleSize=15; state.fontColor="#e5e7eb";
    state.avatar.shape="circle";
  }else if(pack==="luxury"){
    state.theme="minimal";
    state.cover.mode="gradient"; state.cover.gradA="#000000"; state.cover.gradB="#a27100";
    state.fontFamily="Playfair Display"; state.titleSize=22; state.subtitleSize=16; state.fontColor="#111111";
    state.avatar.shape="rounded";
  }
  // Apply visuals
  themeBtns.forEach(b=>b.classList.toggle("active", b.dataset.theme===state.theme));
  coverModeBtns.forEach(b=>b.classList.toggle("active", b.dataset.mode===state.cover.mode));
  $("#font").value=state.fontFamily; $("#titleSize").value=state.titleSize; $("#subtitleSize").value=state.subtitleSize; $("#fontColor").value=state.fontColor;
  $("#gradA").value=state.cover.gradA; $("#gradB").value=state.cover.gradB; $("#coverColor").value=state.cover.gradA;
  shapeButtons.forEach(b=>b.classList.toggle("active", b.dataset.shape===state.avatar.shape));
  applyTheme(); renderCover(); applyText(); applyShapes();
  save();
});

/* =============== PEXELS (simple) =============== */
const pexelsKey = 'oG8xugivxttnpFhJp4svbTeTdODajt60cm9SPD9xSba9SdjyKWUpBUEW';
const pexelsBtn=$("#pexelsBtn"), pexelsModal=$("#pexelsModal"), pexelsClose=$("#pexelsClose"), pexelsSearch=$("#pexelsSearch"), pexelsQuery=$("#pexelsQuery"), pexelsGrid=$("#pexelsGrid");
pexelsBtn.addEventListener("click", async ()=>{
  pexelsModal.style.display="flex";
  pexelsGrid.innerHTML="Loading...";
  const res = await fetch("https://api.pexels.com/v1/curated?per_page=24", {headers:{Authorization:pexelsKey}});
  const data = await res.json();
  renderPexels(data.photos||[]);
});
pexelsClose.addEventListener("click", ()=> pexelsModal.style.display="none");
pexelsSearch.addEventListener("click", async ()=>{
  pexelsGrid.innerHTML="Loading...";
  const q = pexelsQuery.value || "gradient texture";
  const res = await fetch(`https://api.pexels.com/v1/search?per_page=24&query=${encodeURIComponent(q)}`, {headers:{Authorization:pexelsKey}});
  const data = await res.json();
  renderPexels(data.photos||[]);
});
function renderPexels(photos){
  pexelsGrid.innerHTML="";
  photos.forEach(p=>{
    const img = document.createElement("img");
    img.src = p.src.medium; img.style.width="100%"; img.style.height="120px"; img.style.objectFit="cover"; img.style.borderRadius="10px"; img.style.cursor="pointer";
    img.addEventListener("click", ()=>{
      state.cover.image = p.src.large || p.src.original || p.src.medium;
      state.cover.mode = "image";
      coverModeBtns.forEach(b=>b.classList.toggle("active", b.dataset.mode==="image"));
      colorRow.style.display="none"; gradientRow.style.display="none"; imageRow.style.display="";
      renderCover(); pexelsModal.style.display="none"; save();
    });
    pexelsGrid.appendChild(img);
  });
}

/* =============== SAVE / RESET / INIT =============== */
const debug=$("#debug");
const saveBtn=$("#saveBtn"), resetBtn=$("#resetBtn");
const doSave=()=>{ localStorage.setItem("identoo_v2_state", JSON.stringify(state)); debug.value = JSON.stringify(state,null,2); toast("Saved"); };
const save = debounce(doSave, 320);

resetBtn.addEventListener("click",(e)=>{ e.preventDefault(); state=structuredClone(stateDefaults); hydrate(); doSave(); toast("Reset"); });
saveBtn.addEventListener("click",(e)=>{ e.preventDefault(); doSave(); });

function hydrate(){
  // Device
  deviceButtons.forEach(b=>b.classList.toggle("active", b.dataset.size===state.device));
  canvas.classList.toggle("canvas--sm", state.device==="sm");
  canvas.classList.toggle("canvas--lg", state.device==="lg");

  // Theme
  themeBtns.forEach(b=>b.classList.toggle("active", b.dataset.theme===state.theme));
  applyTheme();

  // Text/Font
  const nameParts = (state.name||"").split(" ");
  first.value = nameParts[0] || "";
  last.value  = nameParts.slice(1).join(" ");
  job.value   = state.title || "";
  biz.value   = state.biz || "";
  font.value  = state.fontFamily || "Inter";
  titleSize.value = state.titleSize; subtitleSize.value=state.subtitleSize; fontColor.value=state.fontColor;

  // Cover
  coverModeBtns.forEach(b=>b.classList.toggle("active", b.dataset.mode===state.cover.mode));
  colorRow.style.display = state.cover.mode==="color" ? "" : "none";
  gradientRow.style.display = state.cover.mode==="gradient" ? "" : "none";
  imageRow.style.display = state.cover.mode==="image" ? "" : "none";
  coverColor.value = state.cover.color; gradA.value=state.cover.gradA; gradB.value=state.cover.gradB;
  renderCover();

  // Avatars
  avatarSize.value = state.avatar.size; logoSize.value=state.logo.size;
  shapeButtons.forEach(b=>b.classList.toggle("active", b.dataset.shape===state.avatar.shape));
  shadowToggle.checked = true;
  if(state.avatar.src) avatarImg.src = state.avatar.src;
  if(state.logo.src)   logoImg.src   = state.logo.src;
  applyText(); applyShapes(); applyShadows(); applySizes(); applyPositions();

  // Socials (inputs + render)
  Object.entries(socialInputs).forEach(([k,el])=>{ el.value = state.socials?.[k] || ""; });
  renderSocials();

  // Layout
  layoutButtons.forEach(b=>b.classList.toggle("active", b.dataset.layout===state.layout));
  layoutBadge.textContent = state.layout.charAt(0).toUpperCase()+state.layout.slice(1);

  // Toggles
  snapOn = state.snap; setSnapUI();
  boundsOn = state.bounds; setBoundsUI();

  // Debug
  debug.value = JSON.stringify(state,null,2);
}

hydrate();
initDevice();
</script>
</body>
</html>

