<?php
$successMsg = '';
$errorMsg   = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_submit'])) {
    $name    = htmlspecialchars(strip_tags(trim($_POST['name']    ?? '')));
    $email   = filter_var(trim($_POST['email']   ?? ''), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(strip_tags(trim($_POST['subject'] ?? '')));
    $message = htmlspecialchars(strip_tags(trim($_POST['message'] ?? '')));
    if ($name && filter_var($email, FILTER_VALIDATE_EMAIL) && $subject && $message) {
        $headers = "From: $email\r\nReply-To: $email\r\nContent-Type: text/plain; charset=UTF-8\r\n";
        $body    = "Name: $name\nEmail: $email\nSubject: $subject\n\nMessage:\n$message";
        if (mail('powergenyt@gmail.com', "TaskBridge: $subject", $body, $headers))
            $successMsg = 'Message sent! I\'ll reply within a few hours.';
        else
            $errorMsg = 'Mail failed — email me directly at powergenyt@gmail.com';
    } else {
        $errorMsg = 'Please fill all fields correctly.';
    }
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<title>Yasir Arafat — WordPress & PHP Expert | TaskBridge Tools</title>
<meta name="description" content="Expert WordPress Plugin & Theme Developer. Custom PHP, JavaScript, AJAX, AI Integration. Hire on Upwork or Fiverr."/>
<link rel="icon" type="image/svg+xml" href="assets/favicon.svg"/>
<link rel="shortcut icon" href="assets/favicon.svg"/>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;600;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
<style>
/* ═══════════════════════════════════════════════════════════════
   THEME VARIABLES
   ═══════════════════════════════════════════════════════════════ */
:root {
  --primary:  #7c3aed;
  --primary2: #a855f7;
  --accent:   #06b6d4;
  --accent2:  #3b82f6;
  --amber:    #f59e0b;
  --teal:     #4ec9b0;

  /* Dark theme defaults */
  --bg:       #07070e;
  --bg2:      #0e0e1a;
  --bg3:      #13131e;
  --card:     rgba(255,255,255,.042);
  --card2:    rgba(255,255,255,.07);
  --border:   rgba(255,255,255,.09);
  --text:     #e2e8f0;
  --muted:    #94a3b8;
  --nav-bg:   rgba(7,7,14,.88);
  --input-bg: rgba(255,255,255,.05);
  --shadow:   rgba(0,0,0,.55);
  --grid-op:  .045;
  --orb-op:   .62;
}
[data-theme="light"] {
  --bg:       #f4f4f8;
  --bg2:      #ffffff;
  --bg3:      #eeeef5;
  --card:     rgba(255,255,255,.92);
  --card2:    rgba(255,255,255,1);
  --border:   rgba(0,0,0,.09);
  --text:     #1e1b2e;
  --muted:    #64748b;
  --nav-bg:   rgba(244,244,248,.88);
  --input-bg: #f1f0f8;
  --shadow:   rgba(0,0,0,.12);
  --grid-op:  .06;
  --orb-op:   .25;
}

/* ── Reset ─────────────────────────────────────────────────── */
*, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
html { scroll-behavior:smooth; }
body {
  font-family:'Inter',sans-serif;
  background:var(--bg); color:var(--text);
  overflow-x:hidden; overflow-x:clip; line-height:1.7;
  transition:background .35s, color .35s;
}
::-webkit-scrollbar { width:5px; }
::-webkit-scrollbar-track { background:var(--bg2); }
::-webkit-scrollbar-thumb { background:var(--primary); border-radius:99px; }

/* ── Dot grid bg (VS Code style) ────────────────────────────── */
body::after {
  content:''; position:fixed; inset:0; z-index:0; pointer-events:none;
  background-image: radial-gradient(circle, rgba(124,58,237,var(--grid-op)) 1px, transparent 1px);
  background-size:30px 30px;
  transition:opacity .35s;
}

/* ── Particle canvas ───────────────────────────────────────── */
#particles-canvas {
  position:fixed; inset:0; z-index:0; pointer-events:none;
  opacity:var(--orb-op); transition:opacity .35s;
}

/* ── Gradient Orbs ─────────────────────────────────────────── */
.orb {
  position:fixed; border-radius:50%;
  filter:blur(90px); pointer-events:none; z-index:0;
  transition:opacity .35s;
  opacity:var(--orb-op);
}
.orb1 { width:640px;height:640px;background:rgba(124,58,237,.28);top:-220px;left:-220px;animation:floatOrb 13s ease-in-out infinite; }
.orb2 { width:480px;height:480px;background:rgba(6,182,212,.17);bottom:-150px;right:-150px;animation:floatOrb 16s ease-in-out infinite reverse; }
.orb3 { width:360px;height:360px;background:rgba(168,85,247,.13);top:42%;left:50%;animation:floatOrb 11s ease-in-out infinite 2s; }
.orb4 { width:280px;height:280px;background:rgba(245,158,11,.08);top:20%;right:6%;filter:blur(100px);animation:floatOrb 18s ease-in-out infinite 5s; }
@keyframes floatOrb {
  0%,100%{transform:translate(0,0) scale(1)}
  33%{transform:translate(40px,-30px) scale(1.06)}
  66%{transform:translate(-25px,20px) scale(.96)}
}

/* ── Wrapper ───────────────────────────────────────────────── */
.wrapper { position:relative; z-index:1; }

/* ═══════════════════════════════════════════════════════════════
   LOGO  (reusable SVG mark used throughout)
   ═══════════════════════════════════════════════════════════════ */
.logo-mark svg { display:block; }
.logo-wrap {
  display:inline-flex; align-items:center; gap:10px;
  text-decoration:none;
}
.logo-wordmark {
  font-family:'Space Grotesk',sans-serif;
  font-size:1.18rem; font-weight:800; line-height:1;
  color:var(--text); transition:color .3s;
}
.logo-wordmark em {
  font-style:normal;
  background:linear-gradient(135deg,var(--primary2),var(--accent));
  -webkit-background-clip:text; -webkit-text-fill-color:transparent;
}

/* ═══════════════════════════════════════════════════════════════
   NAVBAR
   ═══════════════════════════════════════════════════════════════ */
nav {
  position:fixed; top:0; width:100%; z-index:100;
  padding:0 4%; height:62px;
  display:flex; align-items:center; gap:0;
  background:var(--nav-bg);
  backdrop-filter:blur(24px) saturate(160%);
  border-bottom:1px solid var(--border);
  transition:background .3s, border-color .3s;
}
.logo-wrap { flex-shrink:0; }

/* ── Nav links — truly centered in the middle ───────────────── */
.nav-links {
  flex:1; display:flex; gap:2px; list-style:none;
  justify-content:center; align-items:center;
}
.nav-links a {
  color:var(--muted); text-decoration:none;
  font-size:.82rem; font-weight:500;
  padding:6px 12px; border-radius:8px;
  transition:color .2s, background .2s;
  white-space:nowrap; position:relative;
}
.nav-links a:hover {
  color:var(--text);
  background:rgba(124,58,237,.1);
}
/* Pricing link in center menu — amber */
.nav-links a[href="#pricing"] { color:var(--amber); }
.nav-links a[href="#pricing"]:hover { background:rgba(245,158,11,.1); }
/* Kill old underline */
.nav-links a::after { display:none !important; }

/* ── Active nav link — capsule border only ───────────────────── */
.nav-links a.nav-active {
  color:var(--text);
  border:1.5px solid rgba(124,58,237,.7);
  border-radius:50px;
  padding:5px 11px;
}

/* ── Nav right cluster ──────────────────────────────────────── */
.nav-right { flex-shrink:0; display:flex; align-items:center; gap:15px; }

/* Pricing CTA button in nav-right */
.nav-pricing-btn {
  padding:7px 16px; border-radius:50px;
  border:1.5px solid rgba(245,158,11,.45);
  background:rgba(245,158,11,.08);
  color:var(--amber) !important; font-weight:700; font-size:.78rem;
  text-decoration:none; white-space:nowrap;
  transition:all .25s;
}
.nav-pricing-btn:hover {
  background:rgba(245,158,11,.18);
  border-color:rgba(245,158,11,.8);
  transform:translateY(-1px);
  box-shadow:0 4px 18px rgba(245,158,11,.2);
}
.nav-pricing-btn::after { display:none !important; }

/* Theme toggle */
#theme-toggle {
  width:36px; height:36px; border-radius:50%;
  border:1px solid var(--border);
  background:var(--card); cursor:pointer;
  display:flex; align-items:center; justify-content:center;
  font-size:.88rem; transition:all .3s; color:var(--text);
  backdrop-filter:blur(10px); flex-shrink:0;
  margin-left: 10px;
}
#theme-toggle:hover {
  border-color:var(--primary2);
  background:rgba(124,58,237,.15);
  transform:rotate(20deg) scale(1.1);
}

/* Hire Me — shine-sweep CTA */
.nav-cta {
  padding:8px 22px; border-radius:50px;
  background:linear-gradient(135deg,var(--primary),var(--accent2));
  color:#fff !important; font-weight:700; font-size:.82rem;
  text-decoration:none;
  box-shadow:0 4px 18px rgba(124,58,237,.35);
  transition:transform .2s, box-shadow .2s;
  position:relative; overflow:hidden; white-space:nowrap;
}
/* shine sweep */
.nav-cta::before {
  content:''; position:absolute; top:0; left:-80%;
  width:55%; height:100%;
  background:linear-gradient(90deg,transparent,rgba(255,255,255,.28),transparent);
  transform:skewX(-15deg);
  transition:left .55s ease;
}
.nav-cta:hover::before { left:145%; }
.nav-cta:hover { transform:translateY(-2px); box-shadow:0 8px 30px rgba(124,58,237,.58); }
.nav-cta::after { display:none !important; }

.hamburger { display:none; flex-direction:column; gap:5px; cursor:pointer; flex-shrink:0; }
.hamburger span { width:22px;height:2px;background:var(--text);border-radius:99px;transition:.3s; }

/* ═══════════════════════════════════════════════════════════════
   HERO
   ═══════════════════════════════════════════════════════════════ */
.hero {
  min-height:100vh;
  min-height:100svh;
  display:flex; align-items:center;
  padding:120px 4% 80px;
  gap:60px;
}
.hero-text { flex:1; max-width:640px; }
.hero-badge {
  display:inline-flex; align-items:center; gap:8px;
  padding:6px 16px; border-radius:50px;
  border:1px solid rgba(124,58,237,.4);
  background:rgba(124,58,237,.1);
  font-size:.78rem; font-weight:700; color:var(--primary2);
  margin-bottom:22px;
  animation:fadeUp .6s ease both;
}
.hero-badge .dot {
  width:7px;height:7px;border-radius:50%;
  background:var(--primary2);
  box-shadow:0 0 8px var(--primary2);
  animation:pulse 1.5s ease-in-out infinite;
}
@keyframes pulse{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.5;transform:scale(.8)}}
.hero h1 {
  font-family:'Space Grotesk',sans-serif;
  font-size:clamp(2.4rem,5vw,4.2rem);
  font-weight:800; line-height:1.15;
  animation:fadeUp .7s ease .1s both;
}
.hero h1 .name {
  background:linear-gradient(135deg,var(--text) 20%,var(--primary2) 55%,var(--accent));
  -webkit-background-clip:text; -webkit-text-fill-color:transparent;
}
.hero-role {
  font-size:1.1rem; font-weight:500; color:var(--muted);
  margin-top:8px; min-height:1.8em;
  animation:fadeUp .7s ease .2s both;
}
#typed-text {
  color:var(--accent);
  border-right:2px solid var(--accent);
  padding-right:4px;
  animation:blink .75s step-end infinite;
}
@keyframes blink{50%{border-color:transparent}}
.hero-desc {
  margin-top:18px; font-size:.98rem; color:var(--muted); max-width:500px;
  animation:fadeUp .7s ease .3s both;
}
.hero-actions {
  margin-top:32px; display:flex; gap:12px; flex-wrap:wrap;
  animation:fadeUp .7s ease .4s both;
}
.btn-primary {
  display:inline-flex; align-items:center; gap:8px;
  padding:13px 26px; border-radius:50px;
  background:linear-gradient(135deg,var(--primary),var(--accent2));
  color:#fff; font-weight:700; font-size:.92rem; text-decoration:none;
  box-shadow:0 6px 28px rgba(124,58,237,.4);
  transition:transform .2s,box-shadow .2s;
}
.btn-primary:hover{transform:translateY(-3px);box-shadow:0 12px 40px rgba(124,58,237,.6);}
.btn-outline {
  display:inline-flex; align-items:center; gap:8px;
  padding:13px 26px; border-radius:50px;
  border:1.5px solid var(--border);
  background:var(--card);
  color:var(--text); font-weight:600; font-size:.92rem; text-decoration:none;
  backdrop-filter:blur(10px); transition:all .25s;
}
.btn-outline:hover{border-color:var(--primary2);background:rgba(124,58,237,.12);transform:translateY(-3px);}
.hero-stats {
  margin-top:38px; display:flex; gap:28px; flex-wrap:wrap;
  animation:fadeUp .7s ease .5s both;
}
.stat-num {
  font-family:'Space Grotesk',sans-serif;
  font-size:2rem; font-weight:800;
  background:linear-gradient(135deg,var(--text),var(--primary2));
  -webkit-background-clip:text; -webkit-text-fill-color:transparent;
}
.stat-label{font-size:.75rem;color:var(--muted);font-weight:500;margin-top:2px;}

/* ═══════════════════════════════════════════════════════════════
   HERO VISUAL — ORBIT SYSTEM
   ═══════════════════════════════════════════════════════════════ */
.hero-visual {
  flex-shrink:0;
  position:relative;
  width:560px; height:560px;
  animation:fadeUp .9s ease .15s both;
}

/* Decorative dashed rings */
.ring-deco {
  position:absolute; top:50%; left:50%;
  border-radius:50%; border-style:dashed;
  transform:translate(-50%,-50%);
  pointer-events:none;
  animation:spinSlow var(--sp) linear infinite;
}
.ring-deco.r1{
  width:325px;height:325px;
  border:1px dashed rgba(124,58,237,.25);
  --sp:25s;
}
.ring-deco.r2{
  width:510px;height:510px;
  border:1px dashed rgba(6,182,212,.18);
  --sp:40s; animation-direction:reverse;
}
@keyframes spinSlow{to{transform:translate(-50%,-50%) rotate(360deg);}}

/* Center orb */
.orbit-center {
  position:absolute;
  top:50%;left:50%;
  width:158px;height:158px;
  transform:translate(-50%,-50%);
  border-radius:50%;
  z-index:5;
}
.orbit-center-inner {
  width:100%;height:100%;border-radius:50%;
  background:linear-gradient(135deg,var(--primary),var(--accent2),var(--accent));
  display:flex;align-items:center;justify-content:center;
  box-shadow:0 0 50px rgba(124,58,237,.5),0 0 100px rgba(124,58,237,.2);
  overflow:hidden;
  animation:glowPulse 3s ease-in-out infinite;
}
.orbit-center-inner img{width:100%;height:100%;object-fit:cover;object-position:top;}
.orbit-center-inner .avatar-ph{
  font-size:3.8rem; color:rgba(255,255,255,.35);
}
@keyframes glowPulse{
  0%,100%{box-shadow:0 0 50px rgba(124,58,237,.5),0 0 100px rgba(124,58,237,.2);}
  50%{box-shadow:0 0 70px rgba(124,58,237,.7),0 0 140px rgba(124,58,237,.3);}
}
/* ping ring */
.orbit-ping {
  position:absolute;inset:-8px;border-radius:50%;
  border:2px solid rgba(124,58,237,.4);
  animation:pingRing 2s ease-out infinite;
}
@keyframes pingRing{0%{transform:scale(1);opacity:.7}100%{transform:scale(1.5);opacity:0;}}

/* Orbit icons — inner ring (r=162px, 18s, 5 icons) */
.orb-icon {
  position:absolute; top:50%; left:50%;
  width:52px;height:52px; margin:-26px;
  border-radius:13px;
  background:var(--card2);
  border:1px solid var(--border);
  display:flex;align-items:center;justify-content:center;
  font-size:1.2rem;
  backdrop-filter:blur(12px);
  box-shadow:0 4px 20px var(--shadow);
  transition:background .35s,border-color .35s;
}
.orb-icon i { pointer-events:none; }

/* Inner ring */
@keyframes orbit-i{
  from{transform:rotate(0deg) translateX(162px) rotate(0deg);}
  to  {transform:rotate(360deg) translateX(162px) rotate(-360deg);}
}
.oi1{animation:orbit-i 18s linear infinite 0s;}
.oi2{animation:orbit-i 18s linear infinite -3.6s;}
.oi3{animation:orbit-i 18s linear infinite -7.2s;}
.oi4{animation:orbit-i 18s linear infinite -10.8s;}
.oi5{animation:orbit-i 18s linear infinite -14.4s;}

/* Outer ring (r=256px, 32s, 6 icons) */
@keyframes orbit-o{
  from{transform:rotate(0deg) translateX(256px) rotate(0deg);}
  to  {transform:rotate(360deg) translateX(256px) rotate(-360deg);}
}
.oo1{animation:orbit-o 32s linear infinite 0s;}
.oo2{animation:orbit-o 32s linear infinite -5.33s;}
.oo3{animation:orbit-o 32s linear infinite -10.66s;}
.oo4{animation:orbit-o 32s linear infinite -16s;}
.oo5{animation:orbit-o 32s linear infinite -21.33s;}
.oo6{animation:orbit-o 32s linear infinite -26.66s;}

/* Orbit icon colors */
.oi1 i{color:#8892bf;} /* PHP */
.oi2 i{color:#21759b;} /* WP */
.oi3 i{color:#f7df1e;} /* JS */
.oi4 i{color:#00758f;} /* MySQL */
.oi5 i{color:#10a37f;} /* AI */
.oo1 i{color:#e34f26;} /* HTML5 */
.oo2 i{color:#1572b6;} /* CSS3 */
.oo3 i{color:#f05032;} /* Git */
.oo4 i{color:#a855f7;} /* API */
.oo5 i{color:#fff;}    /* GitHub */
[data-theme="light"] .oo5 i{color:#24292e;}
.oo6 i{color:#0769ad;} /* jQuery */

/* ── Floating Code Card ─────────────────────────────────────── */
.code-card-float {
  position:absolute;
  bottom:-10px; left:-40px;
  width:240px;
  border-radius:16px;
  background:var(--bg3);
  border:1px solid var(--border);
  overflow:hidden;
  box-shadow:0 16px 48px var(--shadow);
  animation:floatCard 4s ease-in-out infinite;
  backdrop-filter:blur(12px);
  z-index:10;
  transition:background .35s,border-color .35s;
}
@keyframes floatCard{0%,100%{transform:translateY(0)}50%{transform:translateY(-10px);}}
.cc-header {
  display:flex; align-items:center; gap:6px;
  padding:10px 14px;
  background:rgba(0,0,0,.15);
  border-bottom:1px solid var(--border);
}
[data-theme="light"] .cc-header{background:rgba(0,0,0,.05);}
.cc-dot{width:10px;height:10px;border-radius:50%;flex-shrink:0;}
.cc-filename{
  font-family:'Fira Code',monospace;
  font-size:.68rem; color:var(--muted); margin-left:4px;
}
.cc-body{
  padding:14px 16px;
  font-family:'Fira Code',monospace;
  font-size:.7rem; line-height:1.8;
}
.cl { display:block; white-space:nowrap; }
.kw  { color:#c792ea; }
.cls { color:#82aaff; }
.str { color:#c3e88d; }
.fn  { color:#82aaff; }
.cm  { color:#546e7a; font-style:italic; }
.op  { color:#89ddff; }
[data-theme="light"] .kw  { color:#7c3aed; }
[data-theme="light"] .cls { color:#2563eb; }
[data-theme="light"] .str { color:#16a34a; }
[data-theme="light"] .fn  { color:#0284c7; }
[data-theme="light"] .cm  { color:#94a3b8; }

/* ── Floating Achievement Card ──────────────────────────────── */
.ach-card {
  position:absolute;
  top:20px; right:-30px;
  padding:14px 18px; border-radius:16px;
  background:var(--card2);
  border:1px solid var(--border);
  box-shadow:0 12px 36px var(--shadow);
  animation:floatCard 3.5s ease-in-out infinite .8s;
  z-index:10;
  transition:background .35s,border-color .35s;
}
.ach-stars { color:#fbbf24; font-size:.85rem; letter-spacing:2px; margin-bottom:4px; }
.ach-label { font-size:.75rem; font-weight:700; color:var(--text); }
.ach-sub   { font-size:.65rem; color:var(--muted); margin-top:1px; }

/* ── Floating Avail Card ────────────────────────────────────── */
.avail-card {
  position:absolute;
  bottom:80px; right:-50px;
  display:flex; align-items:center; gap:10px;
  padding:11px 16px; border-radius:50px;
  background:var(--card2);
  border:1px solid rgba(52,211,153,.3);
  box-shadow:0 8px 28px var(--shadow);
  animation:floatCard 5s ease-in-out infinite 1.5s;
  z-index:10;
  transition:background .35s;
}
.avail-dot {
  width:9px;height:9px;border-radius:50%;
  background:#34d399;
  box-shadow:0 0 8px #34d399;
  animation:pulse 1.5s ease-in-out infinite;
}
.avail-text { font-size:.72rem; font-weight:700; color:var(--text); white-space:nowrap; }

/* ═══════════════════════════════════════════════════════════════
   SECTION BASE
   ═══════════════════════════════════════════════════════════════ */
section { padding:64px 5%; position:relative; }
.section-label {
  display:inline-block;
  font-size:.73rem; font-weight:800; letter-spacing:.13em; text-transform:uppercase;
  color:var(--primary2); margin-bottom:10px;
}
.section-title {
  font-family:'Space Grotesk',sans-serif;
  font-size:clamp(1.8rem,3.5vw,2.7rem);
  font-weight:800; line-height:1.2; margin-bottom:14px;
  color:var(--text);
}
.section-sub { color:var(--muted); max-width:520px; font-size:.97rem; }
.section-header { margin-bottom:36px; }

/* ═══════════════════════════════════════════════════════════════
   ABOUT
   ═══════════════════════════════════════════════════════════════ */
.about-grid{display:grid;grid-template-columns:1fr 1fr;gap:42px;align-items:center;max-width:1160px;margin:0 auto;}
.about-img-wrap{
  position:relative;border-radius:24px;overflow:hidden;
  background:linear-gradient(135deg,var(--primary),var(--accent2));
  padding:3px;
}
.about-img-inner{border-radius:22px;overflow:hidden;background:var(--bg3);}
.about-img-inner img{width:100%;height:auto;display:block;}
.about-img-placeholder{
  height:360px;
  background:linear-gradient(135deg,var(--bg3),var(--bg2));
  display:flex;flex-direction:column;align-items:center;justify-content:center;
  gap:12px;color:var(--muted);
}
.about-img-placeholder i{font-size:4rem;color:var(--primary2);}
.about-text h3{font-family:'Space Grotesk',sans-serif;font-size:1.45rem;font-weight:700;margin-bottom:14px;}
.about-text p{color:var(--muted);margin-bottom:12px;}
.about-info{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-top:26px;}
.info-item{display:flex;flex-direction:column;gap:3px;}
.info-item .lbl{font-size:.72rem;color:var(--primary2);font-weight:800;text-transform:uppercase;letter-spacing:.09em;}
.info-item .val{font-size:.88rem;font-weight:600;color:var(--text);}
.platforms-row{display:flex;gap:10px;flex-wrap:wrap;margin-top:26px;}
.platform-chip{
  display:inline-flex;align-items:center;gap:8px;
  padding:8px 16px;border-radius:50px;
  border:1px solid var(--border);background:var(--card);
  font-size:.82rem;font-weight:700;text-decoration:none;color:var(--text);
  transition:all .25s;
}
.platform-chip:hover{border-color:var(--primary2);background:rgba(124,58,237,.12);transform:translateY(-2px);}
.upwork-chip i{color:#6fda44;}
.fiverr-chip i{color:#1dbf73;}
.github-chip i{color:var(--text);}

/* ═══════════════════════════════════════════════════════════════
   SKILLS
   ═══════════════════════════════════════════════════════════════ */
#skills{background:linear-gradient(180deg,transparent,rgba(124,58,237,.04),transparent);}
.skills-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;max-width:1160px;margin:0 auto;}
.skill-card{
  padding:26px;border-radius:18px;
  background:var(--card);border:1px solid var(--border);
  transition:all .3s;position:relative;overflow:hidden;
}
.skill-card:hover{border-color:rgba(124,58,237,.4);transform:translateY(-4px);box-shadow:0 12px 40px rgba(124,58,237,.15);}
.skill-icon{
  width:46px;height:46px;border-radius:12px;
  background:linear-gradient(135deg,var(--primary),var(--accent2));
  display:flex;align-items:center;justify-content:center;
  font-size:1.2rem;margin-bottom:14px;
  box-shadow:0 4px 16px rgba(124,58,237,.3);
}
.skill-name{font-weight:700;font-size:.95rem;margin-bottom:10px;color:var(--text);}
.skill-bar-wrap{height:5px;background:rgba(124,58,237,.12);border-radius:99px;overflow:hidden;}
.skill-bar{
  height:100%;border-radius:99px;
  background:linear-gradient(90deg,var(--primary),var(--accent));
  width:0;transition:width 1.3s cubic-bezier(.25,.46,.45,.94);
}
.skill-pct{font-size:.75rem;color:var(--muted);margin-top:6px;font-weight:500;}

/* ═══════════════════════════════════════════════════════════════
   SERVICES
   ═══════════════════════════════════════════════════════════════ */
.services-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;max-width:1160px;margin:0 auto;}
.service-card{
  padding:32px 26px;border-radius:20px;
  background:var(--card);border:1px solid var(--border);
  position:relative;overflow:hidden;transition:all .35s;cursor:default;
}
.service-card::after{
  content:'';position:absolute;bottom:0;left:0;right:0;height:2px;
  background:linear-gradient(90deg,var(--primary),var(--accent));
  transform:scaleX(0);transition:transform .35s;
}
.service-card:hover{border-color:rgba(124,58,237,.3);transform:translateY(-6px);box-shadow:0 20px 50px rgba(124,58,237,.15);}
.service-card:hover::after{transform:scaleX(1);}
.service-icon{
  width:58px;height:58px;border-radius:15px;
  background:linear-gradient(135deg,rgba(124,58,237,.15),rgba(59,130,246,.15));
  border:1px solid rgba(124,58,237,.2);
  display:flex;align-items:center;justify-content:center;
  font-size:1.5rem;margin-bottom:20px;transition:all .3s;
}
.service-card:hover .service-icon{
  background:linear-gradient(135deg,var(--primary),var(--accent2));
  border-color:transparent;
  box-shadow:0 8px 28px rgba(124,58,237,.4);
}
.service-title{font-family:'Space Grotesk',sans-serif;font-size:1.1rem;font-weight:700;margin-bottom:10px;color:var(--text);}
.service-desc{color:var(--muted);font-size:.88rem;line-height:1.7;}
.service-tags{display:flex;gap:7px;flex-wrap:wrap;margin-top:16px;}
.tag{
  padding:4px 11px;border-radius:50px;
  font-size:.7rem;font-weight:700;
  background:rgba(124,58,237,.1);border:1px solid rgba(124,58,237,.22);
  color:var(--primary2);
}

/* ═══════════════════════════════════════════════════════════════
   WHY HIRE ME
   ═══════════════════════════════════════════════════════════════ */
#why{background:linear-gradient(180deg,transparent,rgba(6,182,212,.04),transparent);}
.why-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;max-width:900px;margin:0 auto;}
.why-card{
  padding:26px 20px;border-radius:16px;
  background:var(--card);border:1px solid var(--border);
  text-align:center;transition:all .3s;
}
.why-card:hover{transform:translateY(-5px);border-color:rgba(6,182,212,.3);box-shadow:0 12px 36px rgba(6,182,212,.1);}
.why-num{
  font-family:'Space Grotesk',sans-serif;font-size:2.3rem;font-weight:800;
  background:linear-gradient(135deg,var(--accent),var(--primary2));
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;
  display:block;margin-bottom:4px;
}
.why-label{font-size:.82rem;font-weight:600;color:var(--muted);}
.why-features{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-top:32px;max-width:1160px;margin-left:auto;margin-right:auto;}
.why-feat{
  display:flex;align-items:flex-start;gap:14px;
  padding:18px;border-radius:13px;
  background:var(--card);border:1px solid var(--border);
}
.why-feat-icon{
  width:36px;height:36px;border-radius:10px;flex-shrink:0;
  background:linear-gradient(135deg,var(--primary),var(--accent2));
  display:flex;align-items:center;justify-content:center;font-size:.9rem;
}
.why-feat-text h4{font-size:.92rem;font-weight:700;margin-bottom:3px;color:var(--text);}
.why-feat-text p{font-size:.8rem;color:var(--muted);}

/* ═══════════════════════════════════════════════════════════════
   TECH STACK
   ═══════════════════════════════════════════════════════════════ */
.tech-wrap{display:flex;flex-wrap:wrap;gap:10px;max-width:1160px;margin:0 auto;}
.tech-badge{
  display:inline-flex;align-items:center;gap:8px;
  padding:9px 16px;border-radius:11px;
  background:var(--card);border:1px solid var(--border);
  font-size:.83rem;font-weight:600;color:var(--text);
  transition:all .25s;cursor:default;
}
.tech-badge:hover{transform:translateY(-3px);border-color:var(--primary2);box-shadow:0 8px 24px rgba(124,58,237,.18);}

/* ═══════════════════════════════════════════════════════════════
   PROCESS
   ═══════════════════════════════════════════════════════════════ */
.process-steps{display:flex;gap:0;position:relative;flex-wrap:wrap;}
.process-steps::before{
  content:'';position:absolute;top:36px;left:0;right:0;height:2px;
  background:linear-gradient(90deg,var(--primary),var(--accent));
  opacity:.18;
}
.step{flex:1;min-width:160px;text-align:center;padding:18px 14px;}
.step-num{
  width:68px;height:68px;border-radius:50%;margin:0 auto 14px;
  background:linear-gradient(135deg,var(--primary),var(--accent2));
  display:flex;align-items:center;justify-content:center;
  font-family:'Space Grotesk',sans-serif;font-size:1.25rem;font-weight:800;
  box-shadow:0 6px 26px rgba(124,58,237,.4);position:relative;z-index:1;
}
.step h4{font-weight:700;margin-bottom:6px;color:var(--text);}
.step p{font-size:.8rem;color:var(--muted);}

/* ═══════════════════════════════════════════════════════════════
   CONTACT
   ═══════════════════════════════════════════════════════════════ */
#contact{background:linear-gradient(180deg,transparent,rgba(124,58,237,.05),transparent);}
.contact-grid{display:grid;grid-template-columns:1fr 1.4fr;gap:40px;align-items:start;max-width:1100px;margin:0 auto;}
.contact-info h3{font-family:'Space Grotesk',sans-serif;font-size:1.35rem;font-weight:700;margin-bottom:18px;color:var(--text);}
.contact-info p{color:var(--muted);margin-bottom:26px;}
.contact-links{display:flex;flex-direction:column;gap:12px;}
.contact-link{
  display:flex;align-items:center;gap:14px;
  padding:13px 16px;border-radius:13px;
  background:var(--card);border:1px solid var(--border);
  text-decoration:none;color:var(--text);transition:all .25s;
}
.contact-link:hover{border-color:var(--primary2);background:rgba(124,58,237,.08);transform:translateX(4px);}
.contact-link-icon{
  width:38px;height:38px;border-radius:10px;flex-shrink:0;
  background:linear-gradient(135deg,var(--primary),var(--accent2));
  display:flex;align-items:center;justify-content:center;font-size:.95rem;
}
.contact-link-text .lt{font-size:.7rem;color:var(--muted);font-weight:700;text-transform:uppercase;letter-spacing:.06em;}
.contact-link-text .lv{font-size:.88rem;font-weight:600;margin-top:1px;color:var(--text);}
.contact-form{
  padding:36px;border-radius:22px;
  background:var(--card2);border:1px solid var(--border);
  box-shadow:0 16px 60px var(--shadow);
  transition:background .35s,border-color .35s;
}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
.form-group{margin-bottom:16px;}
.form-group label{display:block;font-size:.75rem;font-weight:800;color:var(--muted);text-transform:uppercase;letter-spacing:.07em;margin-bottom:7px;}
.form-group input,
.form-group textarea,
.form-group select{
  width:100%;padding:12px 15px;border-radius:11px;
  background:var(--input-bg);border:1px solid var(--border);
  color:var(--text);font-size:.88rem;font-family:inherit;
  transition:border-color .25s,box-shadow .25s;outline:none;
}
.form-group input:focus,
.form-group textarea:focus,
.form-group select:focus{border-color:var(--primary2);box-shadow:0 0 0 3px rgba(168,85,247,.15);}
.form-group textarea{resize:vertical;min-height:125px;}
.form-group select option{background:var(--bg2);color:var(--text);}
.btn-submit{
  width:100%;padding:13px;border-radius:50px;
  background:linear-gradient(135deg,var(--primary),var(--accent2));
  color:#fff;font-size:.95rem;font-weight:800;border:none;cursor:pointer;
  box-shadow:0 6px 28px rgba(124,58,237,.4);
  transition:transform .2s,box-shadow .2s;
  display:flex;align-items:center;justify-content:center;gap:8px;
}
.btn-submit:hover{transform:translateY(-2px);box-shadow:0 12px 40px rgba(124,58,237,.6);}
.alert{padding:13px 16px;border-radius:11px;margin-bottom:16px;font-size:.88rem;font-weight:500;}
.alert-success{background:rgba(16,185,129,.12);border:1px solid rgba(16,185,129,.3);color:#6ee7b7;}
.alert-error{background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.28);color:#fca5a5;}

/* ═══════════════════════════════════════════════════════════════
   FOOTER
   ═══════════════════════════════════════════════════════════════ */
footer{
  padding:56px 5% 32px;
  border-top:1px solid var(--border);
  text-align:center;
  background:var(--bg2);
  transition:background .35s;
}
.footer-tagline{color:var(--muted);font-size:.86rem;margin-top:6px;margin-bottom:28px;}
.social-row{display:flex;justify-content:center;gap:12px;margin-bottom:30px;}
.social-btn{
  width:42px;height:42px;border-radius:50%;
  background:var(--card);border:1px solid var(--border);
  display:flex;align-items:center;justify-content:center;
  text-decoration:none;color:var(--muted);font-size:1rem;
  transition:all .25s;
}
.social-btn:hover{background:var(--primary);border-color:var(--primary);color:#fff;transform:translateY(-3px);box-shadow:0 8px 24px rgba(124,58,237,.4);}
.footer-copy{color:var(--muted);font-size:.76rem;}
.footer-copy span{color:var(--primary2);}

/* ═══════════════════════════════════════════════════════════════
   ANIMATIONS & REVEAL
   ═══════════════════════════════════════════════════════════════ */
@keyframes fadeUp{
  from{opacity:0;transform:translateY(28px);}
  to{opacity:1;transform:translateY(0);}
}
.reveal{opacity:0;transform:translateY(38px);transition:opacity .7s ease,transform .7s ease;}
.reveal.visible{opacity:1;transform:none;}

/* ═══════════════════════════════════════════════════════════════
   RESPONSIVE
   ═══════════════════════════════════════════════════════════════ */

/* ── Large desktop (≤1280px) ────────────────────────────────── */
@media(max-width:1280px){
  .skills-grid   { grid-template-columns:repeat(3,1fr); }
}

/* ── Tablet landscape (≤1024px) ─────────────────────────────── */
@media(max-width:1024px){
  section { padding:56px 4%; }
  .hero-visual{width:460px;height:460px;}
  .ring-deco.r2{width:420px;height:420px;}
  @keyframes orbit-o{
    from{transform:rotate(0deg) translateX(210px) rotate(0deg);}
    to  {transform:rotate(360deg) translateX(210px) rotate(-360deg);}
  }
  .code-card-float{left:-10px;}
  .skills-grid   { grid-template-columns:repeat(3,1fr); }
  .services-grid { grid-template-columns:repeat(2,1fr); }
  .why-features  { grid-template-columns:repeat(2,1fr); }
  .about-grid    { gap:30px; }
  .contact-grid  { gap:30px; }
}

/* ── Tablet portrait (≤860px) ───────────────────────────────── */
@media(max-width:860px){
  section { padding:52px 4%; }
  .section-header { margin-bottom:28px; }
  /* Hero — don't touch */
  .hero{flex-direction:column-reverse;text-align:center;padding-top:100px;gap:24px;}
  .hero-text{max-width:100%;}
  .hero-desc{max-width:100%;}
  .hero-actions,.hero-stats{justify-content:center;}
  .hero-visual{width:340px;height:340px;margin:0 auto;}
  .ring-deco.r2{width:300px;height:300px;}
  .ring-deco.r1{width:220px;height:220px;}
  .orbit-center{width:100px;height:100px;}
  @keyframes orbit-i{
    from{transform:rotate(0deg) translateX(110px) rotate(0deg);}
    to  {transform:rotate(360deg) translateX(110px) rotate(-360deg);}
  }
  @keyframes orbit-o{
    from{transform:rotate(0deg) translateX(150px) rotate(0deg);}
    to  {transform:rotate(360deg) translateX(150px) rotate(-360deg);}
  }
  .orb-icon{width:38px;height:38px;margin:-19px;border-radius:10px;font-size:1rem;}
  .code-card-float{display:none;}
  /* Grids */
  .skills-grid   { grid-template-columns:repeat(2,1fr); gap:14px; }
  .services-grid { grid-template-columns:repeat(2,1fr); gap:16px; }
  .why-grid      { grid-template-columns:repeat(2,1fr); }
  .why-features  { grid-template-columns:repeat(2,1fr); }
  .about-grid,.contact-grid { grid-template-columns:1fr; gap:24px; }
  .form-row      { grid-template-columns:1fr 1fr; }
  .process-steps::before { display:none; }
  .pricing-grid  { flex-direction:column; align-items:center; }
  .pricing-card  { max-width:480px; width:100%; }
}

/* ── Mobile (≤600px) ────────────────────────────────────────── */
@media(max-width:600px){
  html,body{overflow-x:hidden;overflow-x:clip;}
  nav{padding:12px 4%;}
  .nav-links{display:none;}
  .hamburger{display:flex;margin-left:20px;}
  section { padding:44px 4%; }
  .section-header { margin-bottom:24px; }
  .contact-form{padding:20px;}
  .hero{min-height:100svh;}
  .hero-visual{width:min(280px,calc(100vw - 32px));height:min(280px,calc(100vw - 32px));}
  .ring-deco.r1{width:190px;height:190px;}
  .ring-deco.r2{width:260px;height:260px;}
  .orbit-center{width:92px;height:92px;}
  @keyframes orbit-i{
    from{transform:rotate(0deg) translateX(88px) rotate(0deg);}
    to  {transform:rotate(360deg) translateX(88px) rotate(-360deg);}
  }
  @keyframes orbit-o{
    from{transform:rotate(0deg) translateX(120px) rotate(0deg);}
    to  {transform:rotate(360deg) translateX(120px) rotate(-360deg);}
  }
  .orb-icon{width:34px;height:34px;margin:-17px;border-radius:9px;font-size:.92rem;}
  .skills-grid   { grid-template-columns:repeat(2,1fr); gap:12px; }
  .services-grid { grid-template-columns:1fr; }
  .why-grid      { grid-template-columns:repeat(2,1fr); }
  .why-features  { grid-template-columns:1fr; }
  .form-row      { grid-template-columns:1fr; }
  .step { min-width:140px; padding:14px 10px; }
  .theme-hint{
    max-width:calc(100vw - 24px);
    white-space:normal;
    text-align:center;
    justify-content:center;
    bottom:20px;
    border-radius:24px;
  }
}

/* ── Small mobile (≤420px) ──────────────────────────────────── */
@media(max-width:420px){
  .skills-grid { grid-template-columns:1fr; }
  .why-grid    { grid-template-columns:1fr; }
  .hero-stats  { gap:18px; }
}

/* ── First-visit light-mode hint toast ──────────────────────── */
.theme-hint{
  position:fixed; bottom:64px; left:50%;
  transform:translateX(-50%) translateY(calc(100% + 24px));
  opacity:0;
  z-index:9998;
  display:flex; align-items:center; gap:10px;
  background:rgba(15,12,30,.92);
  backdrop-filter:blur(20px) saturate(1.6);
  border:1px solid rgba(124,58,237,.45);
  border-radius:50px;
  padding:11px 22px 14px;
  cursor:pointer;
  font-family:'Inter',sans-serif; font-size:.88rem; color:var(--text);
  box-shadow:0 8px 40px rgba(124,58,237,.28), 0 2px 8px rgba(0,0,0,.5);
  white-space:nowrap; overflow:hidden;
  transition:transform .55s cubic-bezier(.34,1.56,.64,1), opacity .45s ease;
}
.theme-hint.th-show{
  transform:translateX(-50%) translateY(0);
  opacity:1;
}
.theme-hint.th-hide{
  transform:translateX(-50%) translateY(calc(100% + 24px));
  opacity:0;
  transition:transform .45s ease, opacity .4s ease;
}
.theme-hint-icon{ font-size:1.1rem; line-height:1; }
.theme-hint-text strong{ color:var(--primary2); }
.theme-hint-bar{
  position:absolute; bottom:0; left:0;
  height:3px; width:100%;
  background:linear-gradient(90deg,var(--primary),var(--accent));
  border-radius:0 0 50px 50px;
  transform-origin:left;
  transform:scaleX(1);
}
.theme-hint.th-show .theme-hint-bar{
  animation:hintBar 7s linear forwards;
}
@keyframes hintBar{from{transform:scaleX(1);}to{transform:scaleX(0);}}
@media(max-width:600px){
  .theme-hint{font-size:.8rem;padding:10px 16px 13px;}
  .theme-hint-text{line-height:1.45;}
}

/* ═══════════════════════════════════════════════════════════════
   VS CODE / CURSOR / CLAUDE — DYNAMIC ENHANCEMENTS
   ═══════════════════════════════════════════════════════════════ */

/* ── Scan-line sweep ────────────────────────────────────────── */
.scan-line {
  position:fixed; left:0; right:0; height:1px; z-index:1; pointer-events:none;
  background:linear-gradient(90deg,
    transparent 0%, rgba(124,58,237,0) 12%,
    rgba(99,102,241,.6) 38%, rgba(6,182,212,.8) 50%,
    rgba(99,102,241,.6) 62%, rgba(124,58,237,0) 88%,
    transparent 100%
  );
  box-shadow:0 0 10px rgba(6,182,212,.5), 0 0 30px rgba(124,58,237,.25);
  animation:scanDown 9s linear infinite;
}
@keyframes scanDown {
  0%  { top:-2px; opacity:0; }
  4%  { opacity:1; }
  88% { opacity:.7; }
  100%{ top:100vh; opacity:0; }
}
[data-theme="light"] .scan-line { opacity:.35; }

/* ── VS Code–style floating code card ───────────────────────── */
@keyframes cardGlow{
  0%,100%{box-shadow:0 24px 64px rgba(0,0,0,.8),0 0 0 1px rgba(99,102,241,.1),inset 0 1px 0 rgba(255,255,255,.04),0 0 32px rgba(124,58,237,.08);}
  50%    {box-shadow:0 24px 64px rgba(0,0,0,.8),0 0 0 1px rgba(99,102,241,.22),inset 0 1px 0 rgba(255,255,255,.06),0 0 56px rgba(124,58,237,.2);}
}
.code-card-float {
  position:absolute; bottom:-10px; left:-40px;
  width:292px; border-radius:10px;
  background:rgba(11,11,20,.98);
  border:1px solid rgba(99,102,241,.32);
  overflow:hidden;
  box-shadow:0 24px 64px rgba(0,0,0,.8), 0 0 0 1px rgba(99,102,241,.1),
             inset 0 1px 0 rgba(255,255,255,.04),
             0 0 40px rgba(124,58,237,.08);
  animation:cardGlow 4s ease-in-out infinite;
  backdrop-filter:blur(14px); z-index:10;
}
.cc-tabs {
  display:flex; background:rgba(0,0,0,.4);
  border-bottom:1px solid rgba(255,255,255,.06); padding:0;
}
.cc-tab {
  display:flex; align-items:center; gap:5px;
  padding:7px 12px; font-family:'Fira Code',monospace;
  font-size:.58rem; color:rgba(255,255,255,.35);
  border-right:1px solid rgba(255,255,255,.05); white-space:nowrap;
}
.cc-tab.active {
  color:#9cdcfe; background:rgba(11,11,20,.98);
  box-shadow:inset 0 1.5px 0 #7c3aed;
}
.cc-editor { display:flex; }
.cc-gutter {
  padding:10px 6px 10px 8px; text-align:right;
  font-family:'Fira Code',monospace; font-size:.57rem;
  color:rgba(255,255,255,.16); line-height:1.9;
  min-width:28px; border-right:1px solid rgba(255,255,255,.04);
  user-select:none; position:relative;
}
.cc-gutter .ln { display:block; position:relative; }
.cc-gutter .ln.git-add { color:rgba(52,211,153,.7); }
.cc-gutter .ln.git-mod { color:rgba(100,184,255,.6); }
.cc-gutter .ln.git-add::before {
  content:''; position:absolute; left:-7px; top:18%; width:3px; height:64%;
  border-radius:0 2px 2px 0; background:rgba(52,211,153,.75);
}
.cc-gutter .ln.git-mod::before {
  content:''; position:absolute; left:-7px; top:18%; width:3px; height:64%;
  border-radius:0 2px 2px 0; background:rgba(100,184,255,.7);
}
.cc-code-body {
  padding:10px 10px 10px 8px; font-family:'Fira Code',monospace;
  font-size:.62rem; line-height:1.9; flex:1; overflow:hidden;
}
.cc-line { display:block; white-space:nowrap; }
.cc-line.active-ln {
  background:rgba(255,255,255,.04);
  border-left:1.5px solid rgba(168,85,247,.5);
  padding-left:4px; margin-left:-4px;
}
.cc-cursor {
  display:inline-block; width:1.5px; height:.83em;
  background:#aeafad; margin-left:.5px;
  animation:blink .9s step-end infinite; vertical-align:middle;
}

/* ── Cursor / Claude AI autocomplete widget ──────────────────── */
.ai-suggest-card {
  position:absolute; top:20px; right:-30px;
  width:222px; border-radius:10px;
  background:rgba(12,10,22,.98);
  border:1px solid rgba(168,85,247,.4);
  box-shadow:0 14px 48px rgba(0,0,0,.7), 0 0 32px rgba(124,58,237,.12),
             0 0 0 1px rgba(168,85,247,.1);
  animation:floatCard 3.5s ease-in-out infinite .8s;
  z-index:10; overflow:hidden;
}
.ai-suggest-hdr {
  padding:7px 10px;
  background:linear-gradient(90deg,rgba(124,58,237,.24),rgba(6,182,212,.14));
  border-bottom:1px solid rgba(168,85,247,.22);
  display:flex; align-items:center; gap:6px;
  font-size:.59rem; font-weight:700; color:#a855f7;
  font-family:'Fira Code',monospace;
}
.ai-suggest-row {
  padding:7px 10px; display:flex; align-items:center;
  justify-content:space-between;
  font-family:'Fira Code',monospace; font-size:.62rem; color:#9cdcfe;
  border-bottom:1px solid rgba(255,255,255,.04); cursor:default;
}
.ai-suggest-row.sel { background:rgba(99,102,241,.26); color:#fff; }
.ai-stype {
  font-size:.53rem; padding:1px 5px; border-radius:3px;
  background:rgba(78,201,176,.1); border:1px solid rgba(78,201,176,.22);
  color:#4ec9b0; flex-shrink:0;
}
.ai-suggest-footer {
  padding:5px 9px; font-family:'Fira Code',monospace;
  font-size:.54rem; color:rgba(255,255,255,.3);
  display:flex; align-items:center; gap:4px;
}
.ai-spark { color:#a855f7; animation:pulse 1.5s ease-in-out infinite; }

/* ── Terminal mini widget ────────────────────────────────────── */
.terminal-mini {
  position:absolute; bottom:80px; right:-50px;
  width:238px; border-radius:10px;
  background:rgba(6,6,13,.98);
  border:1px solid rgba(6,182,212,.3);
  box-shadow:0 14px 44px rgba(0,0,0,.7), 0 0 24px rgba(6,182,212,.07);
  animation:floatCard 4.5s ease-in-out infinite 2s; z-index:10; overflow:hidden;
}
.terminal-header {
  display:flex; align-items:center; gap:6px; padding:7px 11px;
  background:rgba(255,255,255,.03);
  border-bottom:1px solid rgba(6,182,212,.13);
}
.terminal-title {
  font-family:'Fira Code',monospace; font-size:.57rem;
  color:rgba(255,255,255,.32); margin-left:4px;
}
.terminal-body {
  padding:9px 11px; font-family:'Fira Code',monospace;
  font-size:.61rem; line-height:2;
  overflow:hidden;
}
.t-prompt { color:#4ec9b0; }
.t-cmd { color:#9cdcfe; white-space:nowrap; }
.t-output { color:rgba(255,255,255,.44); min-height:2em; white-space:nowrap; overflow:hidden; }
.t-cursor-block {
  display:inline-block; width:6px; height:.75em;
  background:#4ec9b0; margin-left:2px;
  animation:blink .9s step-end infinite; vertical-align:middle;
}

/* ── VS Code status bar (page bottom) ───────────────────────── */
.vscode-statusbar {
  position:fixed; bottom:0; left:0; right:0; height:22px; z-index:300;
  background:linear-gradient(90deg,rgba(110,47,216,.92),rgba(59,130,246,.82),rgba(6,182,212,.78));
  backdrop-filter:blur(18px);
  display:flex; align-items:center; justify-content:space-between;
  padding:0 14px;
  font-family:'Fira Code',monospace; font-size:.61rem;
  color:rgba(255,255,255,.9);
  border-top:1px solid rgba(255,255,255,.1);
  user-select:none;
}
.sb-left,.sb-right { display:flex; align-items:center; }
.sb-item {
  display:flex; align-items:center; gap:4px;
  padding:0 8px; height:22px; cursor:default;
  transition:background .18s; white-space:nowrap;
}
.sb-item:hover { background:rgba(255,255,255,.15); }
.sb-sep { width:1px; height:14px; background:rgba(255,255,255,.14); margin:0 2px; }
.sb-dot { width:6px;height:6px;border-radius:50%;background:#34d399;
  box-shadow:0 0 6px #34d399;animation:pulse 1.5s ease-in-out infinite; }
[data-theme="light"] .vscode-statusbar {
  background:linear-gradient(90deg,rgba(110,47,216,.94),rgba(59,130,246,.9));
}

/* ── Section header max-width constraint ─────────────────────── */
.section-header { max-width:1160px; margin-left:auto; margin-right:auto; }

/* ── Process section alignment fix ─────────────────────────── */
#process .section-header { text-align:center; }
#process .section-header .section-sub { margin:0 auto; }
#pricing .section-header .section-sub { margin:0 auto; }
.process-steps { justify-content:center; max-width:1160px; margin:0 auto; }
/* Connector line — height corrected to pass through circle centers */
/* step padding-top(18) + circle-half(34) = 52px */
.process-steps::before { top:52px; }

/* ═══════════════════════════════════════════════════════════════
   PRICING
   ═══════════════════════════════════════════════════════════════ */
#pricing { background:linear-gradient(180deg,transparent,rgba(124,58,237,.05),transparent); }
#pricing .section-header { text-align:center; }
#pricing .section-header .section-sub { margin:0 auto; }
.pricing-grid {
  display:flex; gap:22px; justify-content:center; align-items:stretch;
  flex-wrap:wrap; max-width:980px; margin:0 auto;
}
.pricing-card {
  flex:1; min-width:255px; max-width:310px;
  padding:32px 24px; border-radius:22px;
  background:var(--card); border:1px solid var(--border);
  display:flex; flex-direction:column;
  position:relative; overflow:hidden; transition:all .35s;
}
.pricing-card:hover { transform:translateY(-6px); box-shadow:0 20px 50px rgba(124,58,237,.15); border-color:rgba(124,58,237,.3); }
.pricing-card.featured {
  background:var(--card2);
  border:1px solid rgba(124,58,237,.45);
  box-shadow:0 12px 50px rgba(124,58,237,.22), 0 0 0 1px rgba(124,58,237,.14);
}
.pricing-card.featured::after {
  content:''; position:absolute; top:0; left:0; right:0; height:2px;
  background:linear-gradient(90deg,var(--primary),var(--accent));
}
.pricing-badge {
  position:absolute; top:16px; right:16px;
  padding:3px 11px; border-radius:50px;
  background:linear-gradient(135deg,var(--primary),var(--accent2));
  font-size:.65rem; font-weight:800; color:#fff;
  box-shadow:0 4px 14px rgba(124,58,237,.35);
}
.pricing-plan {
  font-size:.7rem; font-weight:800; text-transform:uppercase;
  letter-spacing:.12em; color:var(--primary2); margin-bottom:16px;
}
.pricing-price { display:flex; align-items:flex-end; gap:3px; margin-bottom:4px; }
.pricing-cur { font-size:1.3rem; font-weight:700; color:var(--text); line-height:1.9; }
.pricing-amount {
  font-family:'Space Grotesk',sans-serif;
  font-size:3rem; font-weight:900; line-height:1;
  background:linear-gradient(135deg,var(--text),var(--primary2));
  -webkit-background-clip:text; -webkit-text-fill-color:transparent;
}
.pricing-period { font-size:.78rem; color:var(--muted); margin-bottom:4px; }
.pricing-desc { font-size:.84rem; color:var(--muted); margin-bottom:22px; }
.pricing-hr { height:1px; background:var(--border); margin-bottom:18px; }
.pricing-feats { list-style:none; display:flex; flex-direction:column; gap:10px; margin-bottom:26px; flex:1; }
.pricing-feats li { display:flex; align-items:center; gap:9px; font-size:.84rem; color:var(--text); }
.pricing-feats li i { color:#34d399; font-size:.78rem; flex-shrink:0; }
.pricing-feats li.muted i { color:var(--muted); }
.pricing-feats li.muted { color:var(--muted); }
.pricing-note {
  font-size:.7rem; color:var(--muted); text-align:center;
  margin-top:14px; padding-top:12px; border-top:1px solid var(--border);
  line-height:1.6;
}
.pricing-note strong { color:var(--primary2); }
/* Custom quote display */
.pricing-custom {
  font-family:'Space Grotesk',sans-serif;
  font-size:2.4rem; font-weight:900; line-height:1.1;
  background:linear-gradient(135deg,var(--primary2),var(--accent));
  -webkit-background-clip:text; -webkit-text-fill-color:transparent;
  margin-bottom:6px;
}
/* Price range suffix ($10–40) */
.pricing-range {
  font-family:'Space Grotesk',sans-serif;
  font-size:1.4rem; font-weight:700; color:var(--muted);
  line-height:1.7; margin-bottom:3px;
}
@media(max-width:860px){ .pricing-card { max-width:100%; } }

/* Body padding for status bar */
body { padding-bottom:22px; }
footer { padding-bottom:54px !important; }

/* Responsive: hide extra floating cards on small screens */
@media(max-width:860px){
  .ai-suggest-card { display:none; }
  .terminal-mini { right:-10px; }
  .nav-pricing-btn { display:none; } /* nav links handle pricing on tablet */
}
@media(max-width:640px){
  .terminal-mini { display:none; }
  .scan-line { display:none; }
  .vscode-statusbar { display:none; }
}
</style>
</head>
<body>

<canvas id="particles-canvas"></canvas>
<div class="orb orb1"></div>
<div class="orb orb2"></div>
<div class="orb orb3"></div>
<div class="orb orb4"></div>
<div class="scan-line"></div>

<div class="wrapper">

<!-- ═══ NAVBAR ═══════════════════════════════════════════════ -->
<nav id="navbar">

  <!-- LOGO (used everywhere) -->
  <a href="#home" class="logo-wrap">
    <div class="logo-mark">
      <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
        <defs>
          <linearGradient id="lg-nav" x1="0" y1="0" x2="38" y2="38" gradientUnits="userSpaceOnUse">
            <stop offset="0%" stop-color="#7c3aed"/>
            <stop offset="100%" stop-color="#06b6d4"/>
          </linearGradient>
        </defs>
        <!-- Bridge deck -->
        <line x1="3" y1="29" x2="35" y2="29" stroke="url(#lg-nav)" stroke-width="2.8" stroke-linecap="round"/>
        <!-- Left tower -->
        <line x1="10" y1="29" x2="10" y2="13" stroke="url(#lg-nav)" stroke-width="2.8" stroke-linecap="round"/>
        <!-- Right tower -->
        <line x1="28" y1="29" x2="28" y2="13" stroke="url(#lg-nav)" stroke-width="2.8" stroke-linecap="round"/>
        <!-- Arch -->
        <path d="M10 13 Q19 5 28 13" stroke="url(#lg-nav)" stroke-width="2.8" stroke-linecap="round" fill="none"/>
        <!-- Suspender 1 -->
        <line x1="15" y1="29" x2="13.5" y2="18" stroke="url(#lg-nav)" stroke-width="1.6" stroke-linecap="round" opacity=".75"/>
        <!-- Suspender 2 -->
        <line x1="19" y1="29" x2="19" y2="14.5" stroke="url(#lg-nav)" stroke-width="1.6" stroke-linecap="round" opacity=".75"/>
        <!-- Suspender 3 -->
        <line x1="23" y1="29" x2="24.5" y2="18" stroke="url(#lg-nav)" stroke-width="1.6" stroke-linecap="round" opacity=".75"/>
        <!-- Glow dots on towers -->
        <circle cx="10" cy="13" r="3" fill="url(#lg-nav)" opacity=".9"/>
        <circle cx="28" cy="13" r="3" fill="url(#lg-nav)" opacity=".9"/>
      </svg>
    </div>
    <div class="logo-wordmark">Task<em>Bridge</em></div>
  </a>

  <ul class="nav-links">
    <li><a href="#skills">Skills</a></li>
    <li><a href="#services">Services</a></li>
    <li><a href="#why">Why Me</a></li>
    <li><a href="#contact">Contact</a></li>
    <li><a href="#about">About</a></li>
  </ul>

  <div class="nav-right">
    <a href="#pricing" class="nav-pricing-btn">$ Pricing</a>
    <button id="theme-toggle" title="Toggle light/dark mode">🌙</button>
    <a href="#contact" class="nav-cta">✦ Hire Me</a>
  </div>

  <div class="hamburger" id="hamburger">
    <span></span><span></span><span></span>
  </div>
</nav>

<!-- ═══ HERO ══════════════════════════════════════════════════ -->
<section class="hero" id="home">
  <div class="hero-text">
    <div class="hero-badge">
      <span class="dot"></span>
      Available for Freelance Work
    </div>
    <h1>Hi, I'm <span class="name">Yasir Arafat</span></h1>
    <div class="hero-role"><span id="typed-text"></span></div>
    <p class="hero-desc">
      I craft high-performance WordPress solutions — custom plugins, themes, full-stack PHP apps and AI integrations. On time, every time.
    </p>
    <div class="hero-actions">
      <a href="#contact" class="btn-primary"><i class="fa-solid fa-rocket"></i> Hire Me Now</a>
      <a href="#services" class="btn-outline"><i class="fa-solid fa-eye"></i> View Services</a>
    </div>
    <div class="hero-stats">
      <div class="stat"><div class="stat-num counter" data-target="50">0</div><div class="stat-label">Projects Done</div></div>
      <div class="stat"><div class="stat-num counter" data-target="30">0</div><div class="stat-label">Happy Clients</div></div>
      <div class="stat"><div class="stat-num counter" data-target="5">0</div><div class="stat-label">Years Experience</div></div>
      <div class="stat"><div class="stat-num">100%</div><div class="stat-label">Satisfaction</div></div>
    </div>
  </div>

  <!-- ── Hero Visual: Orbit System ─────────────────────────── -->
  <div class="hero-visual">

    <!-- Decorative spinning rings -->
    <div class="ring-deco r1"></div>
    <div class="ring-deco r2"></div>

    <!-- Center avatar -->
    <div class="orbit-center">
      <div class="orbit-ping"></div>
      <div class="orbit-center-inner">
        <img src="assets/photo.jpg" alt="Yasir Arafat" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"/>
        <i class="fa-solid fa-user avatar-ph" style="display:none"></i>
      </div>
    </div>

    <!-- Inner orbit — 5 icons, r=145px -->
    <div class="orb-icon oi1"><i class="fa-brands fa-php"></i></div>
    <div class="orb-icon oi2"><i class="fa-brands fa-wordpress"></i></div>
    <div class="orb-icon oi3"><i class="fa-brands fa-js"></i></div>
    <div class="orb-icon oi4"><i class="fa-solid fa-database"></i></div>
    <div class="orb-icon oi5"><i class="fa-solid fa-robot"></i></div>

    <!-- Outer orbit — 6 icons, r=225px -->
    <div class="orb-icon oo1"><i class="fa-brands fa-html5"></i></div>
    <div class="orb-icon oo2"><i class="fa-brands fa-css3-alt"></i></div>
    <div class="orb-icon oo3"><i class="fa-brands fa-git-alt"></i></div>
    <div class="orb-icon oo4"><i class="fa-solid fa-server"></i></div>
    <div class="orb-icon oo5"><i class="fa-brands fa-github"></i></div>
    <div class="orb-icon oo6"><i class="fa-solid fa-bolt"></i></div>

    <!-- VS Code–style code card -->
    <div class="code-card-float">
      <div class="cc-tabs">
        <div class="cc-tab active">
          <i class="fa-brands fa-php" style="color:#8892bf;font-size:.56rem"></i>
          portfolio.php
        </div>
      </div>
      <div class="cc-editor">
        <div class="cc-gutter">
          <span class="ln git-add">1</span>
          <span class="ln git-add">2</span>
          <span class="ln git-mod">3</span>
          <span class="ln">4</span>
          <span class="ln git-add">5</span>
          <span class="ln">6</span>
          <span class="ln">7</span>
          <span class="ln">8</span>
        </div>
        <div class="cc-code-body">
          <span class="cc-line"><span class="kw">class</span> <span class="cls">Developer</span> <span class="op">{</span></span>
          <span class="cc-line active-ln">&nbsp; <span class="kw">public</span> $name <span class="op">=</span> <span class="str">"Yasir"</span><span class="op">;</span></span>
          <span class="cc-line">&nbsp; <span class="kw">public</span> $exp &nbsp;<span class="op">=</span> <span class="str">"5yrs"</span><span class="op">;</span></span>
          <span class="cc-line">&nbsp;</span>
          <span class="cc-line">&nbsp; <span class="kw">function</span> <span class="fn">build</span><span class="op">(</span>$p<span class="op">)</span> <span class="op">{</span></span>
          <span class="cc-line">&nbsp;&nbsp;&nbsp; <span class="cm">// magic ✨</span></span>
          <span class="cc-line">&nbsp;&nbsp;&nbsp; <span class="kw">return</span> <span class="str">"🚀"</span><span class="op">;</span><span class="cc-cursor"></span></span>
          <span class="cc-line">&nbsp; <span class="op">}</span></span>
        </div>
      </div>
    </div>

    <!-- Cursor / Claude AI autocomplete widget -->
    <div class="ai-suggest-card">
      <div class="ai-suggest-hdr">
        <i class="fa-solid fa-wand-magic-sparkles"></i> AI Suggest
      </div>
      <div class="ai-suggest-row sel">
        <span>buildPlugin()</span><span class="ai-stype">fn</span>
      </div>
      <div class="ai-suggest-row">
        <span>deployTheme()</span><span class="ai-stype">fn</span>
      </div>
      <div class="ai-suggest-row">
        <span>$apiClient</span><span class="ai-stype">var</span>
      </div>
      <div class="ai-suggest-footer">
        <i class="fa-solid fa-bolt ai-spark"></i>
        ★ Top Rated · 5yr exp
      </div>
    </div>

    <!-- Terminal mini widget -->
    <div class="terminal-mini">
      <div class="terminal-header">
        <span class="cc-dot" style="background:#ff5f57"></span>
        <span class="cc-dot" style="background:#febc2e"></span>
        <span class="cc-dot" style="background:#28c840"></span>
        <span class="terminal-title">zsh — taskbridge</span>
      </div>
      <div class="terminal-body">
        <div style="white-space:nowrap;overflow:hidden;"><span class="t-prompt">➜</span> <span class="t-cmd" id="t-cmd"></span><span class="t-cursor-block"></span></div>
        <div class="t-output" id="t-output"></div>
        <div style="color:#34d399;margin-top:5px;font-size:.58rem;font-family:'Fira Code',monospace">● Open to Work</div>
      </div>
    </div>

  </div><!-- /hero-visual -->
</section>

<!-- ═══ ABOUT ════════════════════════════════════════════════ -->
<section id="about">
  <div class="section-header reveal">
    <span class="section-label">Who I Am</span>
    <h2 class="section-title">Passionate Developer<br/>Delivering Results</h2>
    <p class="section-sub">I turn complex ideas into elegant, scalable web solutions — clean code, pixel-perfect execution.</p>
  </div>
  <div class="about-grid">
    <div class="about-img-wrap reveal">
      <div class="about-img-inner">
        <img src="assets/photo.jpg" alt="Yasir Arafat" style="width:100%;height:auto;display:block;" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"/>
        <div class="about-img-placeholder" style="display:none">
          <i class="fa-solid fa-user" style="font-size:4rem;color:var(--primary2)"></i>
          <span style="font-size:.95rem;font-weight:700;color:var(--text);">Yasir Arafat</span>
          <span style="font-size:.8rem;">WordPress & PHP Developer</span>
        </div>
      </div>
    </div>
    <div class="about-text reveal">
      <h3>Your Go-To WordPress & PHP Expert</h3>
      <p>I'm a dedicated developer specializing in WordPress plugin & theme development, custom PHP applications, and AI integrations. 5+ years of real-world experience building fast, secure, and scalable solutions.</p>
      <p>Whether you need a custom plugin from scratch, a theme debugged, an API integrated, or an automation built — I deliver on time, every time.</p>
      <div class="about-info">
        <div class="info-item"><span class="lbl">Name</span><span class="val">Yasir Arafat</span></div>
        <div class="info-item"><span class="lbl">Location</span><span class="val">Bangladesh 🇧🇩</span></div>
        <div class="info-item"><span class="lbl">Phone</span><span class="val">+880 1850 490200</span></div>
        <div class="info-item"><span class="lbl">Email</span><span class="val">powergenyt@gmail.com</span></div>
        <div class="info-item"><span class="lbl">GitHub</span><span class="val">Arafat-plugins</span></div>
        <div class="info-item"><span class="lbl">Status</span><span class="val" style="color:#34d399;">● Open to Work</span></div>
      </div>
      <div class="platforms-row">
        <a href="#contact" class="platform-chip upwork-chip"><i class="fa-brands fa-upwork"></i> Hire on Upwork</a>
        <a href="#contact" class="platform-chip fiverr-chip"><i class="fa-brands fa-fiverr"></i> Order on Fiverr</a>
        <a href="https://github.com/Arafat-plugins" target="_blank" class="platform-chip github-chip"><i class="fa-brands fa-github"></i> GitHub</a>
      </div>
    </div>
  </div>
</section>

<!-- ═══ SKILLS ════════════════════════════════════════════════ -->
<section id="skills">
  <div class="section-header reveal">
    <span class="section-label">Expertise</span>
    <h2 class="section-title">Skills & Proficiency</h2>
    <p class="section-sub">A battle-tested stack built through real-world projects and continuous learning.</p>
  </div>
  <div class="skills-grid">
    <?php
    $skills = [
      ['WooCommerce',      'fa-solid fa-store',         94],
      ['AI Agent Dev',     'fa-solid fa-brain',          87],
      ['Claude / OpenAI',  'fa-solid fa-microchip',      85],
      ['n8n Automation',   'fa-solid fa-diagram-project',82],
      ['PHP',              'fa-brands fa-php',           92],
      ['WordPress',        'fa-brands fa-wordpress',     95],
      ['MySQL',            'fa-solid fa-database',      88],
      ['JavaScript',       'fa-brands fa-js',           80],
      ['jQuery / AJAX',    'fa-solid fa-bolt',          85],
      ['HTML5 / CSS3',     'fa-brands fa-html5',        90],
      ['Plugin Dev',       'fa-solid fa-puzzle-piece',  93],
      ['Theme Dev',        'fa-solid fa-paint-brush',   88],
      ['REST API',         'fa-solid fa-server',         80],
      ['AI Integration',   'fa-solid fa-robot',          72],
      ['Git / GitHub',     'fa-brands fa-git-alt',       78],
      ['WP Debug',         'fa-solid fa-bug',            90],
    ];
    foreach($skills as $s): ?>
    <div class="skill-card reveal">
      <div class="skill-icon"><i class="<?= $s[1] ?>"></i></div>
      <div class="skill-name"><?= $s[0] ?></div>
      <div class="skill-bar-wrap"><div class="skill-bar" data-width="<?= $s[2] ?>"></div></div>
      <div class="skill-pct"><?= $s[2] ?>% Proficiency</div>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- ═══ SERVICES ══════════════════════════════════════════════ -->
<section id="services">
  <div class="section-header reveal">
    <span class="section-label">What I Do</span>
    <h2 class="section-title">Services I Offer</h2>
    <p class="section-sub">End-to-end development services built to solve real business problems.</p>
  </div>
  <div class="services-grid">
    <?php
    $services = [
      ['fa-solid fa-puzzle-piece','WordPress Plugin Development','Custom plugins from scratch — admin panels, payment gateways, automations, REST APIs, shortcodes. Clean, documented, scalable.',['Custom Hooks','Admin UI','WP REST API','OOP PHP']],
      ['fa-solid fa-paint-brush','WordPress Theme Development','Pixel-perfect themes, child themes, Gutenberg blocks, and WooCommerce customizations — fast, responsive, SEO-ready.',['Child Themes','Gutenberg','WooCommerce','Responsive']],
      ['fa-solid fa-code','Custom PHP Development','Standalone PHP apps, REST APIs, database portals, and SaaS micro-features built with clean MVC architecture.',['OOP PHP','MySQL','REST API','MVC']],
      ['fa-solid fa-bolt','JavaScript & AJAX Interfaces','Dynamic UIs with jQuery and AJAX — live search, infinite scroll, real-time forms, interactive dashboards.',['jQuery','AJAX','Live UX','Async PHP']],
      ['fa-solid fa-bug','WordPress Debugging & Fixes','Rapid diagnosis of plugin conflicts, white screens, slow queries, security issues. No problem too complex.',['Conflict Fix','Performance','Security','WP Debug']],
      ['fa-solid fa-robot','AI & Automation Integration','Integrate OpenAI / Claude API into your WP site — chatbots, content generators, workflow automations.',['OpenAI','Claude API','Zapier','Make.com']],
    ];
    foreach($services as $s): ?>
    <div class="service-card reveal">
      <div class="service-icon"><i class="<?= $s[0] ?>"></i></div>
      <div class="service-title"><?= $s[1] ?></div>
      <p class="service-desc"><?= $s[2] ?></p>
      <div class="service-tags"><?php foreach($s[3] as $t): ?><span class="tag"><?= $t ?></span><?php endforeach; ?></div>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- ═══ WHY HIRE ME ═══════════════════════════════════════════ -->
<section id="why">
  <div class="section-header reveal">
    <span class="section-label">Why Choose Me</span>
    <h2 class="section-title">The TaskBridge Advantage</h2>
    <p class="section-sub">What sets my work apart.</p>
  </div>
  <div class="why-grid reveal">
    <div class="why-card"><span class="why-num counter" data-target="50">0</span><span class="why-label">Projects Completed</span></div>
    <div class="why-card"><span class="why-num counter" data-target="30">0</span><span class="why-label">Happy Clients</span></div>
    <div class="why-card"><span class="why-num counter" data-target="100">0</span><span class="why-label">% On-Time Delivery</span></div>
    <div class="why-card"><span class="why-num counter" data-target="5">0</span><span class="why-label">Years Experience</span></div>
  </div>
  <div class="why-features">
    <?php
    $feats=[
      ['fa-solid fa-clock','On-Time Delivery','I respect deadlines and communicate proactively whenever something changes.'],
      ['fa-solid fa-shield-halved','Clean & Secure Code','Security-first approach — no shortcuts, no vulnerabilities.'],
      ['fa-solid fa-comments','24/7 Communication','Always reachable. Fast responses across all platforms.'],
      ['fa-solid fa-arrows-rotate','Unlimited Revisions','Your satisfaction is guaranteed. I iterate until it\'s perfect.'],
      ['fa-solid fa-graduation-cap','Deep WordPress Mastery','5+ years of production WordPress development experience.'],
      ['fa-solid fa-handshake','Long-Term Partnership','Invested in your project\'s success, not just a quick gig.'],
    ];
    foreach($feats as $f): ?>
    <div class="why-feat reveal">
      <div class="why-feat-icon"><i class="<?= $f[0] ?>"></i></div>
      <div class="why-feat-text"><h4><?= $f[1] ?></h4><p><?= $f[2] ?></p></div>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- ═══ TECH STACK ════════════════════════════════════════════ -->
<section id="tech">
  <div class="section-header reveal">
    <span class="section-label">Technologies</span>
    <h2 class="section-title">My Tech Stack</h2>
  </div>
  <div class="tech-wrap reveal">
    <?php
    $techs=[
      ['PHP','fa-brands fa-php','#8892bf'],
      ['MySQL','fa-solid fa-database','#00758f'],
      ['WordPress','fa-brands fa-wordpress','#21759b'],
      ['JavaScript','fa-brands fa-js','#f7df1e'],
      ['jQuery','fa-solid fa-bolt','#0769ad'],
      ['AJAX','fa-solid fa-arrow-rotate-right','#06b6d4'],
      ['HTML5','fa-brands fa-html5','#e34f26'],
      ['CSS3','fa-brands fa-css3-alt','#1572b6'],
      ['Git','fa-brands fa-git-alt','#f05032'],
      ['GitHub','fa-brands fa-github','var(--text)'],
      ['REST API','fa-solid fa-server','#a855f7'],
      ['OpenAI API','fa-solid fa-robot','#10a37f'],
      ['WooCommerce','fa-brands fa-shopify','#96588a'],
      ['cPanel / Linux','fa-brands fa-linux','#fcc624'],
    ];
    foreach($techs as $t): ?>
    <span class="tech-badge">
      <i class="<?= $t[1] ?>" style="color:<?= $t[2] ?>"></i><?= $t[0] ?>
    </span>
    <?php endforeach; ?>
  </div>
</section>

<!-- ═══ PROCESS ═══════════════════════════════════════════════ -->
<section id="process" style="background:linear-gradient(180deg,transparent,rgba(6,182,212,.04),transparent)">
  <div class="section-header reveal">
    <span class="section-label">How I Work</span>
    <h2 class="section-title">My Process</h2>
    <p class="section-sub">Simple, transparent workflow — you stay in control at every step.</p>
  </div>
  <div class="process-steps reveal">
    <?php
    $steps=[
      ['01','Discovery','We discuss your requirements, goals, and timeline.'],
      ['02','Planning','I create a clear roadmap and technical approach.'],
      ['03','Development','Clean, tested code built to your specifications.'],
      ['04','Review','You test and request any revisions needed.'],
      ['05','Delivery','Final handoff with documentation and support.'],
    ];
    foreach($steps as $s): ?>
    <div class="step">
      <div class="step-num"><?= $s[0] ?></div>
      <h4><?= $s[1] ?></h4>
      <p><?= $s[2] ?></p>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- ═══ PRICING ═══════════════════════════════════════════════ -->
<section id="pricing">
  <div class="section-header reveal">
    <span class="section-label">Pricing</span>
    <h2 class="section-title">Simple, Transparent Rates</h2>
    <p class="section-sub">No hidden fees. You pay only for actual hours worked — tracked and reported clearly.</p>
  </div>

  <div class="pricing-grid reveal">

    <!-- Quick Fix -->
    <div class="pricing-card">
      <div class="pricing-plan">Quick Fix</div>
      <div class="pricing-price" style="align-items:flex-end;gap:2px">
        <span class="pricing-cur">$</span>
        <span class="pricing-amount">15</span>
        <span class="pricing-range">–40</span>
      </div>
      <div class="pricing-period">flat estimate &nbsp;·&nbsp; small tasks</div>
      <p class="pricing-desc">Bug fixes and minor tweaks at a flat agreed rate — no surprise bills.</p>
      <div class="pricing-hr"></div>
      <ul class="pricing-feats">
        <li><i class="fa-solid fa-check"></i> WordPress bug fixes</li>
        <li><i class="fa-solid fa-check"></i> Theme tweaks & CSS fixes</li>
        <li><i class="fa-solid fa-check"></i> Plugin configuration</li>
        <li><i class="fa-solid fa-check"></i> Speed / error diagnosis</li>
        <li class="muted"><i class="fa-solid fa-minus"></i> Large builds</li>
      </ul>
      <a href="#contact" class="btn-outline" style="justify-content:center">Get a Quote</a>
    </div>

    <!-- Hourly — Featured -->
    <div class="pricing-card featured">
      <span class="pricing-badge">Best Value</span>
      <div class="pricing-plan">Hourly Rate</div>
      <div class="pricing-price">
        <span class="pricing-cur">$</span>
        <span class="pricing-amount">10</span>
      </div>
      <div class="pricing-period">/ hour &nbsp;·&nbsp; any project size</div>
      <p class="pricing-desc">Pay only for hours worked — full transparency, zero waste.</p>
      <div class="pricing-hr"></div>
      <ul class="pricing-feats">
        <li><i class="fa-solid fa-check"></i> Custom plugin development</li>
        <li><i class="fa-solid fa-check"></i> WordPress theme from scratch</li>
        <li><i class="fa-solid fa-check"></i> PHP & REST API work</li>
        <li><i class="fa-solid fa-check"></i> AI & automation integration</li>
        <li><i class="fa-solid fa-check"></i> Direct chat (WhatsApp / Email)</li>
        <li><i class="fa-solid fa-check"></i> Revisions included</li>
      </ul>
      <a href="#contact" class="btn-primary" style="justify-content:center">Hire Me Now</a>
      <div class="pricing-note">Hours tracked & reported. You only pay for <strong>real work done</strong>.</div>
    </div>

    <!-- Full Project — Custom Quote -->
    <div class="pricing-card">
      <div class="pricing-plan">Full Project</div>
      <div class="pricing-custom">Custom<br>Quote</div>
      <div class="pricing-period">Scope discussed first — no upfront price</div>
      <p class="pricing-desc">Full website builds, multilingual sites, hosting management — price depends on complexity.</p>
      <div class="pricing-hr"></div>
      <ul class="pricing-feats">
        <li><i class="fa-solid fa-check"></i> Full website / plugin build</li>
        <li><i class="fa-solid fa-check"></i> Multilingual (WPML / Polylang)</li>
        <li><i class="fa-solid fa-check"></i> Hosting setup & management</li>
        <li><i class="fa-solid fa-check"></i> WooCommerce & payment setup</li>
        <li><i class="fa-solid fa-check"></i> Price agreed before work starts</li>
      </ul>
      <a href="#contact" class="btn-outline" style="justify-content:center">Let's Discuss</a>
      <div class="pricing-note"><strong>No fixed price</strong> — we discuss scope and agree on a fair rate together.</div>
    </div>

  </div>
</section>

<!-- ═══ CONTACT ═══════════════════════════════════════════════ -->
<section id="contact">
  <div class="section-header reveal">
    <span class="section-label">Let's Talk</span>
    <h2 class="section-title">Ready to Start<br/>Your Project?</h2>
    <p class="section-sub">Drop a message — I reply within a few hours.</p>
  </div>
  <div class="contact-grid">
    <div class="contact-info reveal">
      <h3>Get In Touch</h3>
      <p>Whether you have a clear project or just an idea — let's talk. I'll help you figure out the best path forward.</p>
      <div class="contact-links">
        <a href="mailto:powergenyt@gmail.com" class="contact-link">
          <div class="contact-link-icon"><i class="fa-solid fa-envelope"></i></div>
          <div class="contact-link-text"><div class="lt">Email</div><div class="lv">powergenyt@gmail.com</div></div>
        </a>
        <a href="tel:+8801850490200" class="contact-link">
          <div class="contact-link-icon"><i class="fa-solid fa-phone"></i></div>
          <div class="contact-link-text"><div class="lt">Phone</div><div class="lv">+880 1850 490200</div></div>
        </a>
        <a href="https://wa.me/8801850490200" target="_blank" class="contact-link">
          <div class="contact-link-icon" style="background:linear-gradient(135deg,#25d366,#128c7e)"><i class="fa-brands fa-whatsapp"></i></div>
          <div class="contact-link-text"><div class="lt">WhatsApp</div><div class="lv">Chat Now on WhatsApp</div></div>
        </a>
        <a href="https://github.com/Arafat-plugins" target="_blank" class="contact-link">
          <div class="contact-link-icon" style="background:linear-gradient(135deg,#24292e,#57606a)"><i class="fa-brands fa-github"></i></div>
          <div class="contact-link-text"><div class="lt">GitHub</div><div class="lv">Arafat-plugins</div></div>
        </a>
      </div>
    </div>
    <div class="contact-form reveal">
      <?php if($successMsg): ?>
        <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> <?= $successMsg ?></div>
      <?php elseif($errorMsg): ?>
        <div class="alert alert-error"><i class="fa-solid fa-circle-exclamation"></i> <?= $errorMsg ?></div>
      <?php endif; ?>
      <form method="POST" action="#contact">
        <div class="form-row">
          <div class="form-group"><label>Your Name</label><input type="text" name="name" placeholder="John Smith" required/></div>
          <div class="form-group"><label>Email Address</label><input type="email" name="email" placeholder="john@example.com" required/></div>
        </div>
        <div class="form-group">
          <label>Service Needed</label>
          <select name="subject">
            <option value="">— Select a Service —</option>
            <option>WordPress Plugin Development</option>
            <option>WordPress Theme Development</option>
            <option>Custom PHP Development</option>
            <option>JavaScript / AJAX Work</option>
            <option>WordPress Bug Fix / Debugging</option>
            <option>AI & Automation Integration</option>
            <option>Other / General Inquiry</option>
          </select>
        </div>
        <div class="form-group">
          <label>Project Details</label>
          <textarea name="message" placeholder="Describe your project, requirements, timeline, and budget..." required></textarea>
        </div>
        <button type="submit" name="contact_submit" class="btn-submit">
          <i class="fa-solid fa-paper-plane"></i> Send Message
        </button>
      </form>
    </div>
  </div>
</section>

<!-- ═══ FOOTER ════════════════════════════════════════════════ -->
<footer>
  <!-- Reuse the same bridge logo in footer -->
  <div style="display:flex;align-items:center;justify-content:center;gap:12px;margin-bottom:8px;">
    <svg width="44" height="44" viewBox="0 0 38 38" fill="none">
      <defs><linearGradient id="lg-footer" x1="0" y1="0" x2="38" y2="38" gradientUnits="userSpaceOnUse"><stop offset="0%" stop-color="#7c3aed"/><stop offset="100%" stop-color="#06b6d4"/></linearGradient></defs>
      <line x1="3" y1="29" x2="35" y2="29" stroke="url(#lg-footer)" stroke-width="2.8" stroke-linecap="round"/>
      <line x1="10" y1="29" x2="10" y2="13" stroke="url(#lg-footer)" stroke-width="2.8" stroke-linecap="round"/>
      <line x1="28" y1="29" x2="28" y2="13" stroke="url(#lg-footer)" stroke-width="2.8" stroke-linecap="round"/>
      <path d="M10 13 Q19 5 28 13" stroke="url(#lg-footer)" stroke-width="2.8" stroke-linecap="round" fill="none"/>
      <line x1="15" y1="29" x2="13.5" y2="18" stroke="url(#lg-footer)" stroke-width="1.6" stroke-linecap="round" opacity=".75"/>
      <line x1="19" y1="29" x2="19" y2="14.5" stroke="url(#lg-footer)" stroke-width="1.6" stroke-linecap="round" opacity=".75"/>
      <line x1="23" y1="29" x2="24.5" y2="18" stroke="url(#lg-footer)" stroke-width="1.6" stroke-linecap="round" opacity=".75"/>
      <circle cx="10" cy="13" r="3" fill="url(#lg-footer)" opacity=".9"/>
      <circle cx="28" cy="13" r="3" fill="url(#lg-footer)" opacity=".9"/>
    </svg>
    <div style="font-family:'Space Grotesk',sans-serif;font-size:1.6rem;font-weight:800;background:linear-gradient(135deg,#a855f7,#06b6d4);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">TaskBridge Tools</div>
  </div>
  <div class="footer-tagline">WordPress & PHP Expert — Turning Your Vision Into Reality</div>
  <div class="social-row">
    <a href="mailto:powergenyt@gmail.com" class="social-btn" title="Email"><i class="fa-solid fa-envelope"></i></a>
    <a href="https://wa.me/8801850490200" target="_blank" class="social-btn" title="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
    <a href="https://github.com/Arafat-plugins" target="_blank" class="social-btn" title="GitHub"><i class="fa-brands fa-github"></i></a>
    <a href="tel:+8801850490200" class="social-btn" title="Call"><i class="fa-solid fa-phone"></i></a>
  </div>
  <div class="footer-copy">© <?= date('Y') ?> <span>Yasir Arafat</span> · TaskBridge Tools · All Rights Reserved</div>
</footer>

</div><!-- /wrapper -->

<!-- VS Code Status Bar -->
<div class="vscode-statusbar" id="vscode-statusbar">
  <div class="sb-left">
    <div class="sb-item"><i class="fa-brands fa-git-alt"></i>&nbsp;main</div>
    <div class="sb-sep"></div>
    <div class="sb-item"><i class="fa-solid fa-circle-check" style="color:#34d399"></i>&nbsp;0 errors</div>
    <div class="sb-item"><i class="fa-solid fa-triangle-exclamation" style="color:#fbbf24"></i>&nbsp;0 warnings</div>
  </div>
  <div class="sb-right">
    <div class="sb-item"><span class="sb-dot"></span>&nbsp;Open to Work</div>
    <div class="sb-sep"></div>
    <div class="sb-item">PHP 8.2</div>
    <div class="sb-item">UTF-8</div>
    <div class="sb-item">TaskBridge</div>
  </div>
</div>

<script>
/* ══════════════════════════════════════════════════════════════
   CODE-CHARACTER PARTICLES  (VS Code / Cursor aesthetic)
   ══════════════════════════════════════════════════════════════ */
(function(){
  const canvas = document.getElementById('particles-canvas');
  const ctx    = canvas.getContext('2d');
  let W, H, particles = [];

  const TOKENS = [
    '$', '{}', '()', '=>', ';', '//', '[]', '&&',
    '??', '::', '++', 'fn', 'AI', '@', '!=',
    'PHP', 'API', '</>','var','let',
  ];
  const PALETTES = [
    [168,85,247],   // purple
    [6,182,212],    // cyan
    [99,102,241],   // indigo
    [78,201,176],   // teal
    [156,220,254],  // vscode blue
    [245,158,11],   // amber (Claude)
  ];

  function resize(){
    W = canvas.width  = innerWidth;
    H = canvas.height = innerHeight;
  }
  resize();
  let lastViewportWidth = innerWidth;
  let lastViewportHeight = innerHeight;
  window.addEventListener('resize', ()=>{
    const widthChanged = Math.abs(innerWidth - lastViewportWidth) > 2;
    const heightChanged = Math.abs(innerHeight - lastViewportHeight) > 120;
    if(!widthChanged && !heightChanged) return;
    lastViewportWidth = innerWidth;
    lastViewportHeight = innerHeight;
    resize();
    initParticles();
  }, { passive:true });

  class Particle {
    constructor(init){ this.reset(init); }
    reset(init){
      this.x     = Math.random()*W;
      this.y     = init ? Math.random()*H : H + 16;
      this.token = TOKENS[Math.floor(Math.random()*TOKENS.length)];
      this.rgb   = PALETTES[Math.floor(Math.random()*PALETTES.length)];
      this.speed = Math.random()*.35 + .06;
      this.drift = (Math.random()-.5)*.14;
      this.alpha = Math.random()*.2 + .05;
      this.size  = Math.random()*2.5 + 8;
    }
    update(){
      this.y -= this.speed;
      this.x += this.drift;
      if(this.x < -30)  this.x = W + 20;
      if(this.x > W+30) this.x = -20;
      if(this.y < -20)  this.reset(false);
    }
    draw(){
      ctx.save();
      ctx.globalAlpha = this.alpha;
      ctx.fillStyle   = `rgba(${this.rgb[0]},${this.rgb[1]},${this.rgb[2]},1)`;
      ctx.font        = `${this.size}px 'Fira Code',monospace`;
      ctx.fillText(this.token, this.x, this.y);
      ctx.restore();
    }
  }

  function initParticles(){
    const compactViewport = window.matchMedia('(max-width:600px)').matches;
    const density = compactViewport ? 22000 : 14000;
    const ceiling = compactViewport ? 30 : 75;
    const count = Math.min(ceiling, Math.floor(W*H/density));
    particles = [];
    for(let i=0; i<count; i++) particles.push(new Particle(true));
  }
  initParticles();

  function drawConnections(){
    for(let i=0; i<particles.length; i++){
      for(let j=i+1; j<particles.length; j++){
        const dx = particles[i].x - particles[j].x;
        const dy = particles[i].y - particles[j].y;
        const d  = Math.sqrt(dx*dx + dy*dy);
        if(d < 120){
          const a = (1 - d/120) * .08;
          ctx.save();
          ctx.globalAlpha = a;
          ctx.strokeStyle = 'rgba(124,58,237,1)';
          ctx.lineWidth   = .6;
          ctx.beginPath();
          ctx.moveTo(particles[i].x, particles[i].y);
          ctx.lineTo(particles[j].x, particles[j].y);
          ctx.stroke();
          ctx.restore();
        }
      }
    }
  }

  function animate(){
    ctx.clearRect(0,0,W,H);
    drawConnections();
    particles.forEach(p=>{ p.update(); p.draw(); });
    requestAnimationFrame(animate);
  }
  animate();
})();

/* ══════════════════════════════════════════════════════════════
   DARK / LIGHT THEME TOGGLE
   ══════════════════════════════════════════════════════════════ */
(function(){
  const html    = document.documentElement;
  const btn     = document.getElementById('theme-toggle');
  const saved   = localStorage.getItem('tb-theme') || 'dark';
  html.setAttribute('data-theme', saved);
  btn.textContent = saved === 'dark' ? '🌙' : '☀️';

  btn.addEventListener('click', ()=>{
    const next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
    html.setAttribute('data-theme', next);
    btn.textContent = next === 'dark' ? '🌙' : '☀️';
    localStorage.setItem('tb-theme', next);
  });
})();

/* ══════════════════════════════════════════════════════════════
   TYPED TEXT
   ══════════════════════════════════════════════════════════════ */
(function(){
  const el = document.getElementById('typed-text');
  const phrases = [
    'WordPress Plugin Developer',
    'Custom PHP Expert',
    'Theme Developer',
    'AJAX & JS Specialist',
    'AI Integration Developer',
    'WordPress Debugger',
  ];
  let pi=0, ci=0, del=false;
  function type(){
    const p = phrases[pi];
    if(!del){ el.textContent = p.slice(0,++ci); if(ci===p.length){ del=true; setTimeout(type,2000); return; } }
    else     { el.textContent = p.slice(0,--ci); if(ci===0){ del=false; pi=(pi+1)%phrases.length; } }
    setTimeout(type, del ? 45 : 80);
  }
  type();
})();

/* ══════════════════════════════════════════════════════════════
   SCROLL REVEAL
   ══════════════════════════════════════════════════════════════ */
(function(){
  const io = new IntersectionObserver(entries=>{
    entries.forEach(e=>{ if(e.isIntersecting) e.target.classList.add('visible'); });
  },{threshold:.1});
  document.querySelectorAll('.reveal').forEach(el=>io.observe(el));
})();

/* ══════════════════════════════════════════════════════════════
   SKILL BARS
   ══════════════════════════════════════════════════════════════ */
(function(){
  const io = new IntersectionObserver(entries=>{
    entries.forEach(e=>{
      if(e.isIntersecting){
        const bar = e.target.querySelector('.skill-bar');
        if(bar) bar.style.width = bar.dataset.width+'%';
        io.unobserve(e.target);
      }
    });
  },{threshold:.3});
  document.querySelectorAll('.skill-card').forEach(c=>io.observe(c));
})();

/* ══════════════════════════════════════════════════════════════
   COUNTER ANIMATION
   ══════════════════════════════════════════════════════════════ */
(function(){
  const io = new IntersectionObserver(entries=>{
    entries.forEach(e=>{
      if(e.isIntersecting){
        e.target.querySelectorAll('.counter').forEach(el=>{
          const target = +el.dataset.target;
          let current = 0;
          const timer = setInterval(()=>{
            current = Math.min(current + target/60, target);
            el.textContent = Math.floor(current) + (target===100 ? '%' : '+');
            if(current>=target) clearInterval(timer);
          }, 22);
        });
        io.unobserve(e.target);
      }
    });
  },{threshold:.3});
  document.querySelectorAll('.hero-stats,.why-grid').forEach(el=>io.observe(el));
})();

/* ══════════════════════════════════════════════════════════════
   NAVBAR SCROLL EFFECT
   ══════════════════════════════════════════════════════════════ */
window.addEventListener('scroll',()=>{
  const nav = document.getElementById('navbar');
  const scrolled = window.scrollY > 40;
  nav.style.boxShadow = scrolled ? '0 4px 30px rgba(0,0,0,.25)' : 'none';
});

/* ══════════════════════════════════════════════════════════════
   SCROLL SPY — active nav link
   ══════════════════════════════════════════════════════════════ */
(function(){
  const links   = document.querySelectorAll('.nav-links a[href^="#"]');
  const NAV_H   = 70; // navbar height offset

  // Map each link to its target section
  const sections = Array.from(links).map(a => ({
    link: a,
    el  : document.querySelector(a.getAttribute('href'))
  })).filter(o => o.el);

  // Sort by DOM position so forEach finds the correct active section
  const sorted = [...sections].sort((a,b) => a.el.offsetTop - b.el.offsetTop);

  function setActive(id){
    links.forEach(a => a.classList.remove('nav-active'));
    if(!id) return;
    const match = sections.find(o => o.el.id === id);
    if(match) match.link.classList.add('nav-active');
  }

  function onScroll(){
    const scrollY = window.scrollY + NAV_H + 60;
    let current = '';
    sorted.forEach(({ el }) => {
      if(el.offsetTop <= scrollY) current = el.id;
    });
    setActive(current);
  }

  window.addEventListener('scroll', onScroll, { passive:true });
  onScroll(); // run once on load

  // Also set active immediately on link click (before scroll settles)
  links.forEach(a => {
    a.addEventListener('click', () => {
      links.forEach(l => l.classList.remove('nav-active'));
      a.classList.add('nav-active');
    });
  });
})();

/* ══════════════════════════════════════════════════════════════
   MOBILE HAMBURGER
   ══════════════════════════════════════════════════════════════ */
(function(){
  const hb = document.getElementById('hamburger');
  const nl = document.querySelector('.nav-links');
  let open = false;

  function closeMenu(){
    open = false;
    nl.removeAttribute('style'); // let CSS take over — never leave display:none as inline
  }

  function openMenu(){
    open = true;
    Object.assign(nl.style,{
      display:'flex', flexDirection:'column',
      position:'absolute', top:'66px', left:'0', right:'0',
      background:'var(--nav-bg)', backdropFilter:'blur(22px)',
      padding:'20px 5%', gap:'18px',
      borderBottom:'1px solid var(--border)', zIndex:'99',
    });
  }

  hb.addEventListener('click', ()=>{ open ? closeMenu() : openMenu(); });

  document.addEventListener('click', (event)=>{
    if(!open) return;
    if(hb.contains(event.target) || nl.contains(event.target)) return;
    closeMenu();
  });

  // Close when a link is clicked
  nl.querySelectorAll('a').forEach(a => a.addEventListener('click', closeMenu));

  // Reset inline styles when viewport grows back to desktop width
  window.addEventListener('resize', ()=>{ if(window.innerWidth > 640) closeMenu(); });
})();

/* ══════════════════════════════════════════════════════════════
   TERMINAL ANIMATION
   ══════════════════════════════════════════════════════════════ */
(function(){
  const cmdEl = document.getElementById('t-cmd');
  const outEl = document.getElementById('t-output');
  if(!cmdEl) return;

  const cmds = [
    { cmd:'php build --prod',    out:'✓ Build complete (1.2s)' },
    { cmd:'git push origin main',out:'✓ Pushed 3 commits' },
    { cmd:'wp plugin activate',  out:'✓ Plugin active' },
    { cmd:'npm run deploy',      out:'✓ Deployed successfully' },
    { cmd:'curl -s api/test',    out:'✓ API 200 OK' },
  ];

  let ci=0, ch=0, phase=0; // phase 0=typing, 1=output, 2=pause

  function tick(){
    const {cmd, out} = cmds[ci];
    if(phase === 0){
      cmdEl.textContent = cmd.slice(0, ++ch);
      if(ch >= cmd.length){ phase=1; setTimeout(tick, 500); return; }
      setTimeout(tick, 55 + Math.random()*30);
    } else if(phase === 1){
      outEl.textContent = out;
      phase=2; setTimeout(tick, 2200);
    } else {
      cmdEl.textContent = ''; outEl.textContent = '';
      ch=0; phase=0; ci=(ci+1)%cmds.length;
      setTimeout(tick, 350);
    }
  }
  setTimeout(tick, 1200);
})();
</script>

<!-- First-visit light mode hint -->
<div id="theme-hint" class="theme-hint" role="button" aria-label="Switch to light mode">
  <span class="theme-hint-icon">☀️</span>
  <span class="theme-hint-text">You can view this page in <strong>Light Mode</strong> — click to switch</span>
  <span class="theme-hint-bar"></span>
</div>

<script>
/* ── First-visit theme hint ─────────────────────────────────── */
(function(){
  if(localStorage.getItem('tb-visited')) return;
  localStorage.setItem('tb-visited','1');
  const hint = document.getElementById('theme-hint');
  const btn  = document.getElementById('theme-toggle');
  if(!hint || !btn) return;

  /* show after short delay */
  const showTimer = setTimeout(()=>{ hint.classList.add('th-show'); }, 900);

  /* auto-hide after 7 s visible */
  const hideTimer = setTimeout(()=>{
    hint.classList.remove('th-show');
    hint.classList.add('th-hide');
  }, 7900);

  /* click → switch theme + dismiss */
  hint.addEventListener('click', ()=>{
    clearTimeout(hideTimer);
    btn.click();
    hint.classList.remove('th-show');
    hint.classList.add('th-hide');
  });
})();
</script>
</body>
</html>
