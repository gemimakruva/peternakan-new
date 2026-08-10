<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>500 — Terjadi Kesalahan | SPMS Peternakan</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Inter','Nunito',system-ui,-apple-system,sans-serif;background:#FAF8F5;color:#2D3436;display:flex;align-items:center;justify-content:center;min-height:100vh;padding:1.5rem;text-align:center}
        .container{max-width:480px;width:100%}
        .illustration{margin-bottom:2rem}
        .illustration svg{width:160px;height:160px}
        .code{font-size:4rem;font-weight:700;color:#E64A19;line-height:1;margin-bottom:0.5rem}
        .title{font-size:1.35rem;font-weight:600;color:#2D3436;margin-bottom:0.75rem}
        .message{font-size:0.95rem;color:#6B7280;line-height:1.6;margin-bottom:2rem}
        .btn{display:inline-flex;align-items:center;gap:0.5rem;background:#F28B1E;color:#fff;border:none;border-radius:8px;padding:0.7rem 1.5rem;font-size:0.9rem;font-weight:500;text-decoration:none;cursor:pointer;transition:background 0.15s ease}
        .btn:hover{background:#D97706}
        @media(max-width:480px){.code{font-size:3rem}.illustration svg{width:120px;height:120px}}
    </style>
</head>
<body>
<div class="container">
    <div class="illustration">
        <svg viewBox="0 0 160 160" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="80" cy="80" r="72" fill="#FBE9E7" stroke="#E8E4DF" stroke-width="2"/>
            <!-- Broken egg bottom half -->
            <ellipse cx="80" cy="102" rx="28" ry="20" fill="#FFFDE7"/>
            <ellipse cx="80" cy="102" rx="28" ry="20" fill="none" stroke="#D97706" stroke-width="2"/>
            <!-- Yolk -->
            <circle cx="80" cy="100" r="12" fill="#FFB300"/>
            <circle cx="76" cy="96" r="3" fill="#FFFDE7" opacity="0.6"/>
            <!-- Broken shell top - zigzag -->
            <path d="M54 88 L60 78 L66 86 L72 74 L78 84 L84 72 L90 82 L96 74 L102 84 L106 76" stroke="#D97706" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
            <!-- Shell fragment left -->
            <path d="M52 86 Q48 70 56 60 L60 78 Z" fill="#FFFDE7" stroke="#D97706" stroke-width="1.5"/>
            <!-- Shell fragment right -->
            <path d="M108 82 Q112 68 104 58 L100 76 Z" fill="#FFFDE7" stroke="#D97706" stroke-width="1.5"/>
            <!-- Crack lines -->
            <line x1="72" y1="50" x2="68" y2="42" stroke="#E64A19" stroke-width="2" stroke-linecap="round"/>
            <line x1="88" y1="48" x2="92" y2="38" stroke="#E64A19" stroke-width="2" stroke-linecap="round"/>
            <line x1="80" y1="46" x2="80" y2="36" stroke="#E64A19" stroke-width="2" stroke-linecap="round"/>
            <!-- Splash drops -->
            <circle cx="46" cy="108" r="3" fill="#FFB300" opacity="0.5"/>
            <circle cx="114" cy="104" r="2.5" fill="#FFB300" opacity="0.5"/>
            <circle cx="50" cy="96" r="2" fill="#FFB300" opacity="0.4"/>
        </svg>
    </div>
    <div class="code">500</div>
    <div class="title">Terjadi Kesalahan</div>
    <p class="message">Maaf, terjadi kesalahan di server. Silakan coba lagi nanti.</p>
    <a href="/" class="btn">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5z"/></svg>
        Kembali ke Beranda
    </a>
</div>
</body>
</html>
