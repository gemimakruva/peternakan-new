<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>419 — Sesi Kedaluwarsa | SPMS Peternakan</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Inter','Nunito',system-ui,-apple-system,sans-serif;background:#FAF8F5;color:#2D3436;display:flex;align-items:center;justify-content:center;min-height:100vh;padding:1.5rem;text-align:center}
        .container{max-width:480px;width:100%}
        .illustration{margin-bottom:2rem}
        .illustration svg{width:160px;height:160px}
        .code{font-size:4rem;font-weight:700;color:#FFB300;line-height:1;margin-bottom:0.5rem}
        .title{font-size:1.35rem;font-weight:600;color:#2D3436;margin-bottom:0.75rem}
        .message{font-size:0.95rem;color:#6B7280;line-height:1.6;margin-bottom:2rem}
        .btn{display:inline-flex;align-items:center;gap:0.5rem;background:#F28B1E;color:#fff;border:none;border-radius:8px;padding:0.7rem 1.5rem;font-size:0.9rem;font-weight:500;text-decoration:none;cursor:pointer;transition:background 0.15s ease}
        .btn:hover{background:#D97706}
        .btn-secondary{background:#6B7280;margin-left:0.5rem}
        .btn-secondary:hover{background:#4B5563}
        .actions{display:flex;flex-wrap:wrap;justify-content:center;gap:0.75rem}
        @media(max-width:480px){.code{font-size:3rem}.illustration svg{width:120px;height:120px}}
    </style>
</head>
<body>
<div class="container">
    <div class="illustration">
        <svg viewBox="0 0 160 160" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="80" cy="80" r="72" fill="#FFFDE7" stroke="#E8E4DF" stroke-width="2"/>
            <!-- Clock face -->
            <circle cx="80" cy="78" r="36" fill="#fff" stroke="#2D3436" stroke-width="3"/>
            <circle cx="80" cy="78" r="32" fill="#fff" stroke="#E8E4DF" stroke-width="1"/>
            <!-- Hour markers -->
            <line x1="80" y1="48" x2="80" y2="52" stroke="#2D3436" stroke-width="2.5"/>
            <line x1="80" y1="104" x2="80" y2="108" stroke="#2D3436" stroke-width="2.5"/>
            <line x1="50" y1="78" x2="54" y2="78" stroke="#2D3436" stroke-width="2.5"/>
            <line x1="106" y1="78" x2="110" y2="78" stroke="#2D3436" stroke-width="2.5"/>
            <!-- Clock hands (showing time expired) -->
            <line x1="80" y1="78" x2="80" y2="56" stroke="#2D3436" stroke-width="3" stroke-linecap="round"/>
            <line x1="80" y1="78" x2="96" y2="68" stroke="#F28B1E" stroke-width="2.5" stroke-linecap="round"/>
            <!-- Center dot -->
            <circle cx="80" cy="78" r="3" fill="#F28B1E"/>
            <!-- Sand/time running out particles -->
            <circle cx="68" cy="124" r="2" fill="#FFB300" opacity="0.6"/>
            <circle cx="80" cy="128" r="2.5" fill="#FFB300" opacity="0.5"/>
            <circle cx="92" cy="122" r="1.5" fill="#FFB300" opacity="0.4"/>
            <circle cx="74" cy="130" r="1.5" fill="#FFB300" opacity="0.3"/>
            <circle cx="88" cy="132" r="2" fill="#FFB300" opacity="0.4"/>
            <!-- Expired indicator -->
            <path d="M56 38 L48 30" stroke="#E64A19" stroke-width="2" stroke-linecap="round"/>
            <path d="M104 38 L112 30" stroke="#E64A19" stroke-width="2" stroke-linecap="round"/>
        </svg>
    </div>
    <div class="code">419</div>
    <div class="title">Sesi Kedaluwarsa</div>
    <p class="message">Sesi Anda telah berakhir. Silakan muat ulang halaman untuk melanjutkan.</p>
    <div class="actions">
        <a href="javascript:location.reload()" class="btn">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/><path d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/></svg>
            Muat Ulang
        </a>
        <a href="/" class="btn btn-secondary">Ke Beranda</a>
    </div>
</div>
</body>
</html>
