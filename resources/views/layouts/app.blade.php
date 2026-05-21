<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Label DataHub')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Onest:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #41354d;
            --bg-sidebar: #342a3f;
            --bg-elevated: #4b3d58;
            --bg-input: #2e2538;
            --accent: #cff784;
            --accent-dim: rgba(207, 247, 132, 0.14);
            --accent-soft: rgba(207, 247, 132, 0.08);
            --accent-glow: rgba(207, 247, 132, 0.32);
            --text: #f5f3f8;
            --text-muted: rgba(245, 243, 248, 0.55);
            --line: rgba(255, 255, 255, 0.07);
            --line-strong: rgba(255, 255, 255, 0.12);
            --shadow-sm: 0 2px 12px rgba(0, 0, 0, 0.18);
            --shadow: 0 10px 40px rgba(0, 0, 0, 0.22);
            --shadow-lg: 0 16px 48px rgba(0, 0, 0, 0.28);
            --radius-sm: 10px;
            --radius: 14px;
            --radius-lg: 18px;
            --radius-xl: 22px;
            --radius-pill: 999px;
            --block-gap: 20px;
            --ease: cubic-bezier(0.25, 0.1, 0.25, 1);
            --ease-out: cubic-bezier(0.22, 1, 0.36, 1);
            --ease-spring: cubic-bezier(0.34, 1.2, 0.64, 1);
        }

        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pageEnter {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes sidebarIn {
            from {
                opacity: 0;
                transform: translateX(-12px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes glowPulse {
            0%, 100% { opacity: 0.45; transform: scale(1); }
            50% { opacity: 0.75; transform: scale(1.08); }
        }

        @keyframes floatOrb {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(3%, -2%) scale(1.05); }
            66% { transform: translate(-2%, 2%) scale(0.98); }
        }

        @keyframes avatarGlow {
            0%, 100% { box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2), 0 0 0 rgba(207, 247, 132, 0); }
            50% { box-shadow: 0 8px 24px rgba(0, 0, 0, 0.22), 0 0 16px rgba(207, 247, 132, 0.2); }
        }

        @keyframes shimmer {
            0% { background-position: 0% 50%; }
            100% { background-position: 200% 50%; }
        }

        * { box-sizing: border-box; }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        body {
            margin: 0;
            color: var(--text);
            font-family: Onest, 'Segoe UI', system-ui, sans-serif;
            background: var(--bg);
            height: 100vh;
            overflow: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .app-shell {
            display: grid;
            grid-template-columns: 252px 1fr;
            height: 100vh;
        }

        .sidebar {
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            background: rgba(52, 42, 63, 0.92);
            backdrop-filter: none;
            border-right: 1px solid var(--line);
            padding: 20px 14px;
            display: flex;
            flex-direction: column;
            gap: 22px;
        }

        html:not(.app-ready) .sidebar {
            animation: sidebarIn 0.45s var(--ease-out) backwards;
        }

        .brand {
            padding: 14px 12px;
            border-radius: var(--radius-lg);
            background: rgba(255, 255, 255, 0.03);
        }

        html:not(.app-ready) .brand {
            animation: fadeSlideUp 0.45s var(--ease-out) 0.06s backwards;
        }

        .brand-title {
            margin: 0;
            font-size: 21px;
            font-weight: 700;
            letter-spacing: -0.03em;
            background: linear-gradient(120deg, var(--text) 0%, var(--accent) 45%, var(--text) 90%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 6s linear infinite;
        }

        .brand-sub {
            margin: 6px 0 0;
            color: var(--text-muted);
            font-size: 12px;
            font-weight: 500;
        }

        .side-nav {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .side-nav a,
        .logout-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text-muted);
            text-decoration: none;
            border: none;
            background: transparent;
            border-radius: var(--radius-pill);
            padding: 10px 14px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            font-family: inherit;
            transition: color 0.25s var(--ease-out), background 0.25s var(--ease-out), transform 0.25s var(--ease-spring), box-shadow 0.25s var(--ease-out);
            text-align: left;
            width: 100%;
        }

        html:not(.app-ready) .side-nav a {
            animation: fadeSlideUp 0.4s var(--ease-out) backwards;
        }

        html:not(.app-ready) .side-nav a:nth-child(1) { animation-delay: 0.1s; }
        html:not(.app-ready) .side-nav a:nth-child(2) { animation-delay: 0.13s; }
        html:not(.app-ready) .side-nav a:nth-child(3) { animation-delay: 0.16s; }
        html:not(.app-ready) .side-nav a:nth-child(4) { animation-delay: 0.19s; }
        html:not(.app-ready) .side-nav a:nth-child(5) { animation-delay: 0.22s; }

        .nav-icon {
            width: 32px;
            height: 32px;
            border-radius: var(--radius-sm);
            background: rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
            transition: background 0.2s var(--ease), transform 0.2s var(--ease);
        }

        .side-nav a:hover,
        .logout-btn:hover {
            color: var(--text);
            background: rgba(255, 255, 255, 0.06);
            transform: translateX(4px);
        }

        .side-nav a:hover .nav-icon {
            background: rgba(207, 247, 132, 0.12);
            transform: scale(1.08);
        }

        .side-nav a.active {
            color: #2a2233;
            background: var(--accent);
            font-weight: 600;
            box-shadow: 0 4px 24px var(--accent-glow);
            transform: translateX(0);
        }

        .side-nav a.active .nav-icon {
            background: rgba(42, 34, 51, 0.2);
            color: #2a2233;
        }

        .side-nav a.active:hover {
            color: #2a2233;
            background: var(--accent);
            filter: brightness(1.05);
        }

        .role-pill {
            color: var(--text-muted);
            font-size: 12px;
            font-weight: 500;
            padding: 12px 14px;
            border-radius: var(--radius-lg);
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--line);
            display: block;
        }

        .role-pill strong {
            color: var(--accent);
            font-weight: 600;
        }

        .sidebar-bottom {
            margin-top: auto;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .logout-btn { color: var(--text-muted); }

        .main {
            position: relative;
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 32px 36px 48px;
            width: 100%;
            background-color: var(--bg);
            isolation: isolate;
        }

        .main::before,
        .main::after {
            content: none;
            position: fixed;
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
            filter: blur(60px);
        }

        .main::before {
            width: min(480px, 50vw);
            height: min(480px, 50vw);
            top: -8%;
            right: -5%;
            background: rgba(207, 247, 132, 0.14);
            animation: floatOrb 18s ease-in-out infinite;
        }

        .main::after {
            width: min(360px, 40vw);
            height: min(360px, 40vw);
            bottom: -5%;
            left: 20%;
            background: rgba(207, 247, 132, 0.08);
            animation: floatOrb 22s ease-in-out infinite reverse;
        }

        .page-content {
            position: relative;
            z-index: 1;
            animation: pageEnter 0.22s var(--ease-out) forwards;
        }

        html:not(.app-ready) .page-content {
            animation-duration: 0.35s;
            animation-delay: 0.04s;
            animation-fill-mode: backwards;
        }

        .page-content > .ok {
            animation: slideDown 0.3s var(--ease-out) backwards;
        }

        .main::-webkit-scrollbar { width: 8px; }
        .main::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.12);
            border-radius: 8px;
        }

        /* ——— Секции страницы ——— */
        .page-section {
            margin-bottom: var(--block-gap);
        }

        .page-section:last-child {
            margin-bottom: 0;
        }

        /* ——— Page header ——— */
        .page-header {
            margin-bottom: 28px;
        }

        .page-header .title {
            margin: 0 0 8px;
            font-size: 34px;
            font-weight: 700;
            letter-spacing: -0.045em;
            line-height: 1.1;
        }

        .page-header .muted {
            margin: 0;
            font-size: 15px;
            line-height: 1.5;
            max-width: 520px;
        }

        /* ——— Cards ——— */
        .card {
            background: rgba(75, 61, 88, 0.72);
            border: 1px solid var(--line);
            border-radius: var(--radius-xl);
            padding: 22px 24px;
            margin-bottom: 0;
            box-shadow: var(--shadow-sm);
            backdrop-filter: none;
            transition: transform 0.3s var(--ease-out), box-shadow 0.3s var(--ease-out), border-color 0.25s var(--ease-out);
        }

        .layout-stack > .card:hover,
        .layout-stack > .split-incidents-export > .card:hover,
        .split-2-equal > .card:hover {
            border-color: rgba(255, 255, 255, 0.1);
            box-shadow: var(--shadow);
        }

        .layout-stack > .card,
        .layout-stack > .split-2-equal,
        .layout-stack > .split-incidents-export {
            margin-bottom: 0;
        }

        .card-flat {
            box-shadow: none;
            background: rgba(75, 61, 88, 0.45);
        }

        /* ——— Entity cards (треки / артисты) ——— */
        .grid-entities {
            display: grid;
            gap: var(--block-gap);
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            align-items: stretch;
        }

        .entity-card {
            display: flex;
            flex-direction: column;
            height: 100%;
            padding: 18px 18px 16px;
            background: rgba(75, 61, 88, 0.72);
            border: 1px solid var(--line);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-sm);
            backdrop-filter: none;
            transition: transform 0.35s var(--ease-spring), box-shadow 0.35s var(--ease-out), border-color 0.3s var(--ease-out);
        }

        .entity-card:hover {
            border-color: rgba(207, 247, 132, 0.22);
            box-shadow: var(--shadow-lg), 0 0 0 1px rgba(207, 247, 132, 0.06);
            transform: translateY(-4px) scale(1.01);
        }

        .entity-card:hover .entity-card__avatar {
            transform: scale(1.06) rotate(-2deg);
        }

        .entity-card__head {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 14px;
            flex-shrink: 0;
        }

        .entity-card__avatar {
            width: 56px;
            height: 56px;
            border-radius: var(--radius);
            flex-shrink: 0;
            background: linear-gradient(145deg, rgba(207, 247, 132, 0.28) 0%, rgba(46, 37, 56, 0.9) 100%);
            border: 1px solid rgba(207, 247, 132, 0.15);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: var(--accent);
            transition: transform 0.4s var(--ease-spring);
        }

        .entity-card__avatar--artist {
            background: linear-gradient(145deg, rgba(207, 247, 132, 0.2) 0%, rgba(65, 53, 77, 0.95) 100%);
        }

        .entity-card__title-wrap {
            min-width: 0;
            flex: 1;
        }

        .entity-card__title {
            margin: 0 0 8px;
            font-size: 17px;
            font-weight: 600;
            line-height: 1.25;
            letter-spacing: -0.02em;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .entity-card__content {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 0;
        }

        .entity-card--uniform {
            height: 300px;
            min-height: 300px;
            max-height: 300px;
        }

        .entity-card--artist.entity-card--uniform {
            height: auto;
            min-height: 300px;
            max-height: none;
        }

        .entity-card--artist .entity-card__content {
            min-height: 0;
            gap: 12px;
        }

        .entity-card--artist .entity-card__details {
            overflow: visible;
            min-height: auto;
        }

        .entity-card--artist .entity-card__stats {
            margin-top: 0;
        }

        .entity-card--track.entity-card--uniform {
            height: auto;
            min-height: 420px;
            max-height: none;
            padding: 22px 22px 20px;
        }

        .entity-card--track .entity-card__head {
            margin-bottom: 18px;
        }

        .entity-card--track .entity-card__title {
            margin-bottom: 10px;
        }

        .entity-card--track .entity-card__title-wrap .meta-row {
            gap: 6px;
            margin-bottom: 0;
        }

        .entity-card--track .entity-card__content {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0;
            min-height: auto;
        }

        .entity-card--track .entity-card__details {
            flex: 1 0 auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
            overflow: visible;
            min-height: auto;
        }

        .entity-card--track .detail-block {
            flex-shrink: 0;
            min-height: auto;
        }

        .entity-card--track .detail-block .section-label {
            display: block;
            margin: 0 0 10px;
        }

        .entity-card--track .detail-lines li {
            padding: 4px 0;
            line-height: 1.55;
        }

        .entity-card--track .detail-empty {
            margin: 6px 0 0;
        }

        .entity-card--track .entity-card__stats {
            flex-shrink: 0;
            margin-top: auto;
            padding-top: 18px;
        }

        .entity-card__details {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 12px;
            overflow: hidden;
            min-height: 0;
        }

        .detail-block {
            min-height: 0;
        }

        .detail-block .section-label {
            margin: 0 0 6px;
        }

        .detail-lines {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .detail-lines li {
            font-size: 13px;
            line-height: 1.45;
            color: rgba(245, 243, 248, 0.9);
            padding: 3px 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .detail-lines .li-meta {
            color: var(--text-muted);
        }

        .detail-empty {
            font-size: 13px;
            color: var(--text-muted);
            margin: 0;
        }

        .entity-card__stats {
            flex-shrink: 0;
            margin-top: auto;
            padding-top: 14px;
            border-top: 1px solid var(--line);
        }

        .entity-card__substats {
            margin-top: 10px;
            font-size: 12px;
            color: var(--text-muted);
            line-height: 1.5;
        }

        .entity-card__bio {
            margin: 8px 0 0;
            font-size: 12px;
            line-height: 1.4;
            color: var(--text-muted);
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .meta-row {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 14px;
        }

        .tag {
            font-size: 11px;
            font-weight: 500;
            padding: 4px 10px;
            border-radius: var(--radius-pill);
            background: var(--accent-soft);
            color: rgba(245, 243, 248, 0.75);
            border: 1px solid rgba(207, 247, 132, 0.12);
        }

        .section-label {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-muted);
            margin: 16px 0 8px;
        }

        .section-label:first-child { margin-top: 0; }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin: 14px 0;
        }

        .stat-box {
            padding: 12px 14px;
            border-radius: var(--radius);
            background: rgba(46, 37, 56, 0.65);
            border: 1px solid var(--line);
        }

        .stat-box .label {
            display: block;
            font-size: 11px;
            color: var(--text-muted);
            margin-bottom: 5px;
            font-weight: 500;
            letter-spacing: 0.02em;
        }

        .stat-box .value {
            font-size: 17px;
            font-weight: 700;
            color: var(--accent);
            letter-spacing: -0.03em;
            line-height: 1.2;
        }

        .list-clean {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .list-clean li {
            padding: 8px 0;
            border-bottom: 1px solid var(--line);
            font-size: 13px;
            color: rgba(245, 243, 248, 0.88);
            display: flex;
            justify-content: space-between;
            gap: 12px;
        }

        .list-clean li:last-child { border-bottom: none; }

        .list-clean .li-meta {
            color: var(--text-muted);
            font-size: 12px;
            flex-shrink: 0;
        }

        .list-more {
            font-size: 12px;
            color: var(--text-muted);
            padding: 6px 0 0;
        }

        .title {
            margin: 0 0 8px;
            font-size: 20px;
            font-weight: 600;
            letter-spacing: -0.02em;
        }

        .card > .title { margin-bottom: 16px; }

        .grid {
            display: grid;
            gap: 16px;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        }

        .split-2,
        .split-2-equal {
            display: grid;
            gap: var(--block-gap);
            grid-template-columns: repeat(2, minmax(0, 1fr));
            align-items: stretch;
        }

        .split-2-equal > .card {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .split-incidents-export {
            display: grid;
            gap: var(--block-gap);
            grid-template-columns: minmax(0, 1fr) 248px;
            align-items: stretch;
        }

        .split-incidents-export > .card {
            display: flex;
            flex-direction: column;
            min-width: 0;
            margin-bottom: 0;
        }

        .layout-stack {
            display: flex;
            flex-direction: column;
            gap: var(--block-gap);
        }

        .card-table {
            overflow: visible;
        }

        .table-collapsible-actions {
            display: flex;
            justify-content: flex-start;
            padding-top: 10px;
        }

        .table-toggle-btn {
            border: 1px solid var(--line-strong);
            background: rgba(255, 255, 255, 0.04);
            color: var(--text);
            border-radius: var(--radius-pill);
            padding: 8px 14px;
            font-size: 13px;
            font-weight: 500;
            font-family: inherit;
            cursor: pointer;
            transition: background 0.2s var(--ease-out), border-color 0.2s var(--ease-out), transform 0.2s var(--ease-spring);
        }

        .table-toggle-btn:hover {
            background: rgba(255, 255, 255, 0.09);
            border-color: rgba(255, 255, 255, 0.16);
            transform: translateY(-1px);
        }

        .card-table tr.row-collapsed {
            display: none;
        }

        .data-source-note {
            margin-top: 10px;
            display: inline-block;
            padding: 6px 10px;
            border-radius: var(--radius-pill);
            font-size: 12px;
            border: 1px solid rgba(207, 247, 132, 0.24);
            background: var(--accent-dim);
            color: var(--accent);
            font-weight: 500;
        }

        .admin-dl {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .admin-dl-hero {
            display: grid;
            gap: 14px;
            grid-template-columns: 1.4fr 1fr;
            align-items: stretch;
        }

        .admin-dl-hero-main,
        .admin-dl-hero-side {
            background: rgba(46, 37, 56, 0.55);
            border: 1px solid var(--line);
            border-radius: var(--radius-lg);
            padding: 16px 18px;
        }

        .admin-dl-caption {
            margin: 0 0 8px;
            color: var(--text-muted);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 600;
        }

        .admin-dl-title {
            margin: 0;
            font-size: 22px;
            letter-spacing: -0.03em;
        }

        .admin-dl-subtitle {
            margin: 8px 0 0;
            color: var(--text-muted);
            font-size: 13px;
        }

        .admin-dl-kpi {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 10px;
            margin-top: 10px;
        }

        .admin-dl-kpi-card {
            border-radius: var(--radius);
            border: 1px solid var(--line);
            background: rgba(46, 37, 56, 0.5);
            padding: 12px 14px;
        }

        .admin-dl-kpi-card .k-label {
            display: block;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-muted);
            margin-bottom: 6px;
            font-weight: 600;
        }

        .admin-dl-kpi-card .k-value {
            display: block;
            color: var(--accent);
            font-size: 22px;
            letter-spacing: -0.03em;
            line-height: 1.1;
            font-weight: 700;
        }

        .admin-dl-kpi-card .k-note {
            display: block;
            margin-top: 6px;
            font-size: 12px;
            color: var(--text-muted);
        }

        .admin-dl-links {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .admin-dl-link {
            display: block;
            padding: 11px 12px;
            border-radius: var(--radius);
            border: 1px solid var(--line);
            background: rgba(255, 255, 255, 0.02);
            color: var(--text);
            font-size: 13px;
            text-decoration: none;
        }

        .admin-dl-link:hover {
            border-color: rgba(207, 247, 132, 0.24);
            background: var(--accent-soft);
            opacity: 1;
        }

        .admin-dl-section-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .admin-dl-section-head .title {
            margin: 0;
            font-size: 18px;
        }

        .stack { display: flex; flex-direction: column; gap: 16px; }

        .muted {
            color: var(--text-muted);
            font-size: 14px;
            line-height: 1.55;
        }

        .ok {
            background: var(--accent-dim);
            color: var(--accent);
            padding: 14px 18px;
            border: 1px solid rgba(207, 247, 132, 0.22);
            border-radius: var(--radius-lg);
            margin-bottom: var(--block-gap);
            font-size: 14px;
            font-weight: 500;
            box-shadow: var(--shadow-sm);
        }

        .empty-state {
            text-align: center;
            padding: 48px 24px;
            color: var(--text-muted);
            font-size: 15px;
        }

        .empty-state span {
            display: block;
            font-size: 32px;
            margin-bottom: 12px;
            opacity: 0.4;
        }

        /* ——— Forms ——— */
        .form-card .title { margin-bottom: 4px; }

        .form-card .card-desc {
            margin: 0 0 14px;
            min-height: 0;
        }

        .form-stretch {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 0;
        }

        .form-stretch > form {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 0;
        }

        .form-fields {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .form-fields--center {
            justify-content: center;
            gap: 12px;
        }

        .form-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: auto;
            padding-top: 16px;
        }

        .form-actions form {
            flex: unset;
            display: inline;
        }

        .field-row-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .field-row-2 > div input,
        .field-row-2 > div select {
            margin-bottom: 0;
        }

        .field-row-2 label {
            margin-top: 0;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-muted);
        }

        input,
        select {
            width: 100%;
            padding: 12px 16px;
            margin-bottom: 14px;
            border-radius: var(--radius);
            border: 1px solid var(--line);
            color: var(--text);
            background: rgba(46, 37, 56, 0.8);
            outline: none;
            font-family: inherit;
            font-size: 14px;
            transition: border-color 0.2s var(--ease), box-shadow 0.2s var(--ease), background 0.2s var(--ease);
        }

        input:hover,
        select:hover {
            border-color: var(--line-strong);
        }

        input::placeholder { color: rgba(245, 243, 248, 0.32); }

        input:focus,
        select:focus {
            border-color: rgba(207, 247, 132, 0.5);
            background: rgba(46, 37, 56, 0.95);
            box-shadow: 0 0 0 3px var(--accent-dim);
        }

        select option {
            background: var(--bg-input);
            color: var(--text);
        }

        button.primary {
            border: none;
            padding: 12px 24px;
            border-radius: var(--radius-pill);
            cursor: pointer;
            font-weight: 600;
            font-family: inherit;
            font-size: 14px;
            color: #2a2233;
            background: var(--accent);
            transition: transform 0.25s var(--ease-spring), filter 0.25s var(--ease-out), box-shadow 0.25s var(--ease-out);
            box-shadow: 0 4px 24px var(--accent-glow);
        }

        button.primary:hover {
            filter: brightness(1.1);
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 32px var(--accent-glow);
        }

        button.primary:active {
            transform: translateY(0) scale(0.98);
        }

        button.secondary {
            border: 1px solid var(--line-strong);
            padding: 12px 24px;
            border-radius: var(--radius-pill);
            cursor: pointer;
            font-weight: 500;
            font-family: inherit;
            font-size: 14px;
            color: var(--text);
            background: rgba(255, 255, 255, 0.04);
            transition: background 0.25s var(--ease-out), border-color 0.25s var(--ease-out), transform 0.25s var(--ease-spring);
        }

        button.secondary:hover {
            background: rgba(255, 255, 255, 0.09);
            border-color: rgba(255, 255, 255, 0.16);
            transform: translateY(-2px);
        }

        button.secondary:active {
            transform: scale(0.98);
        }

        /* ——— Tables ——— */
        .table-wrap {
            border-radius: var(--radius-lg);
            overflow-x: auto;
            overflow-y: visible;
            border: 1px solid var(--line);
            background: rgba(46, 37, 56, 0.55);
            -webkit-overflow-scrolling: touch;
        }

        .table-wrap table {
            width: 100%;
            min-width: max(100%, 520px);
        }

        .table-wrap--fit {
            overflow-x: visible;
            overflow-y: visible;
        }

        .table-wrap--fit table,
        .table-compact {
            min-width: 0;
            width: 100%;
            table-layout: fixed;
        }

        .table-compact th,
        .table-compact td {
            padding: 10px 10px;
            font-size: 12px;
            vertical-align: top;
        }

        .table-compact .cell-wrap {
            word-break: break-word;
            white-space: normal;
            line-height: 1.4;
        }

        .table-compact .cell-ellipsis {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .table-compact th:nth-child(1) { width: 14%; }
        .table-compact th:nth-child(2) { width: 32%; }
        .table-compact th:nth-child(3) { width: 10%; }
        .table-compact th:nth-child(4) { width: 22%; }
        .table-compact th:nth-child(5) { width: 22%; }

        .card-table--incidents .title {
            margin-bottom: 12px;
        }

        .card-table--incidents .table-wrap {
            min-width: 0;
        }

        .card-table--incidents .table-wrap table.table-incidents {
            width: 100%;
            min-width: 0;
            table-layout: fixed;
        }

        .table-incidents .col-type { width: 118px; }
        .table-incidents .col-msg { width: auto; }
        .table-incidents .col-pct { width: 56px; }
        .table-incidents .col-track { width: 26%; }
        .table-incidents .col-artist { width: 22%; }

        .table-incidents th,
        .table-incidents td {
            padding: 11px 14px;
            font-size: 13px;
            vertical-align: middle;
            overflow: hidden;
        }

        .table-incidents .cell-type {
            white-space: nowrap;
        }

        .table-incidents .cell-type .badge {
            display: inline-block;
            max-width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            vertical-align: middle;
        }

        .table-incidents .cell-msg {
            white-space: nowrap;
            text-overflow: ellipsis;
            line-height: 1.4;
        }

        .table-incidents .cell-pct {
            white-space: nowrap;
            text-align: right;
            font-variant-numeric: tabular-nums;
        }

        .table-incidents .cell-track,
        .table-incidents .cell-artist {
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .card-exports {
            padding: 22px 20px;
        }

        .card-exports__head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 6px;
        }

        .card-exports__head .title {
            margin: 0;
            font-size: 20px;
        }

        .card-exports .card-desc {
            margin: 0 0 16px;
            font-size: 13px;
            line-height: 1.4;
        }

        .export-format {
            flex-shrink: 0;
            padding: 4px 10px;
            border-radius: var(--radius-pill);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: var(--accent);
            background: var(--accent-dim);
            border: 1px solid rgba(207, 247, 132, 0.22);
        }

        .export-tiles {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 10px;
            min-height: 0;
        }

        .export-tile {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 14px;
            min-height: 72px;
            padding: 14px 16px;
            border-radius: var(--radius-lg);
            background: rgba(46, 37, 56, 0.45);
            border: 1px solid var(--line);
            color: var(--text);
            text-decoration: none;
            transition: background 0.25s var(--ease-out), border-color 0.25s var(--ease-out), box-shadow 0.25s var(--ease-out), transform 0.25s var(--ease-spring);
        }

        .export-tile:hover {
            background: var(--accent-soft);
            border-color: rgba(207, 247, 132, 0.28);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .export-tile__icon {
            flex-shrink: 0;
            width: 42px;
            height: 42px;
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            font-weight: 700;
            color: #2a2233;
            background: var(--accent);
        }

        .export-tile__body {
            min-width: 0;
            flex: 1;
        }

        .export-tile__name {
            display: block;
            font-size: 14px;
            font-weight: 600;
            line-height: 1.3;
        }

        .export-tile__hint {
            display: block;
            margin-top: 3px;
            font-size: 11px;
            font-weight: 500;
            color: var(--text-muted);
            line-height: 1.3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            text-align: left;
            padding: 14px 18px;
            border-bottom: 1px solid var(--line);
            font-size: 13px;
        }

        th {
            color: var(--text-muted);
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            background: rgba(255, 255, 255, 0.03);
        }

        tbody tr {
            transition: background 0.2s var(--ease-out);
        }

        tbody tr:hover td {
            background: rgba(207, 247, 132, 0.06);
        }
        tbody tr:last-child td { border-bottom: 0; }

        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
            background: var(--accent-dim);
            color: var(--accent);
            border: 1px solid rgba(207, 247, 132, 0.2);
        }

        .badge-muted {
            background: rgba(255, 255, 255, 0.06);
            color: var(--text-muted);
            border-color: var(--line);
        }

        .link-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .link-list a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            border-radius: var(--radius-lg);
            background: rgba(46, 37, 56, 0.55);
            border: 1px solid var(--line);
            color: var(--text);
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: background 0.25s var(--ease-out), border-color 0.25s var(--ease-out), transform 0.3s var(--ease-spring);
        }

        .link-list a:hover {
            background: var(--accent-dim);
            border-color: rgba(207, 247, 132, 0.22);
            transform: translateX(6px);
            opacity: 1;
        }

        .link-list a::after {
            content: '→';
            margin-left: auto;
            color: var(--accent);
        }

        .table-actions {
            display: grid;
            grid-template-columns: minmax(80px, 1fr) minmax(80px, 1fr) auto;
            gap: 8px;
            align-items: center;
            min-width: 260px;
        }

        .table-actions input {
            margin-bottom: 0;
            padding: 8px 10px;
            font-size: 13px;
        }

        .table-actions button {
            padding: 8px 14px;
            font-size: 13px;
            white-space: nowrap;
        }

        strong { font-weight: 600; color: var(--text); }

        a {
            color: var(--accent);
            text-decoration: none;
            transition: opacity 0.15s ease;
        }

        a:hover { opacity: 0.85; }

        @media (max-width: 900px) {
            body { height: auto; overflow: auto; }
            .app-shell { grid-template-columns: 1fr; height: auto; }
            .sidebar { position: static; height: auto; }
            .side-nav { flex-direction: row; flex-wrap: wrap; }
            .side-nav a, .logout-btn { width: auto; }
            .main { height: auto; padding: 20px 16px; max-width: none; }
            .split-2, .split-2-equal, .split-incidents-export, .stats-row { grid-template-columns: 1fr; }
            .grid-entities { grid-template-columns: 1fr; }
            .entity-card--uniform {
                height: auto;
                min-height: 300px;
                max-height: none;
            }

            .entity-card--track.entity-card--uniform {
                min-height: 380px;
            }
            .entity-card:hover { transform: none; }
            .field-row-2 { grid-template-columns: 1fr; }
            .page-header .title { font-size: 26px; }
            .table-actions { grid-template-columns: 1fr; min-width: 0; }
            .admin-dl-hero { grid-template-columns: 1fr; }
            .admin-dl-kpi { grid-template-columns: 1fr 1fr; }
        }

        @supports not ((-webkit-backdrop-filter: blur(1px)) or (backdrop-filter: blur(1px))) {
            .sidebar,
            .card,
            .entity-card {
                background: rgba(67, 54, 81, 0.96);
            }
        }
    </style>
    <script>
        try {
            if (sessionStorage.getItem('df-app')) {
                document.documentElement.classList.add('app-ready');
            }
        } catch (e) {}
    </script>
</head>
<body>
<div class="app-shell">
    <aside class="sidebar">
        @auth
            <div class="brand">
                <p class="brand-title">Label DataHub</p>
                <p class="brand-sub">Аналитика музыки</p>
            </div>

            <nav class="side-nav">
                <a href="{{ route('tracks.index') }}" class="{{ request()->routeIs('tracks.*') ? 'active' : '' }}">
                    <span class="nav-icon">♪</span> Треки
                </a>
                <a href="{{ route('artists.index') }}" class="{{ request()->routeIs('artists.*') ? 'active' : '' }}">
                    <span class="nav-icon">★</span> Артисты
                </a>
                <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    <span class="nav-icon">◫</span> Отчёты
                </a>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.*') ? 'active' : '' }}">
                        <span class="nav-icon">⚙</span> Админ
                    </a>
                @endif
            </nav>

            <div class="sidebar-bottom">
                @php
                    $roleLabel = match(auth()->user()->role) {
                        'admin' => 'администратор',
                        'artist' => 'артист',
                        default => auth()->user()->role,
                    };
                @endphp
                <span class="role-pill">Роль: <strong>{{ $roleLabel }}</strong></span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="logout-btn" type="submit">Выйти</button>
                </form>
            </div>
        @endauth
    </aside>

    <main class="main">
        <div class="page-content">
            @if(session('status'))
                <div class="ok">{{ session('status') }}</div>
            @endif
            @yield('content')
        </div>
    </main>
</div>
<script>
    try {
        sessionStorage.setItem('df-app', '1');
    } catch (e) {}
    document.documentElement.classList.add('app-ready');

    (function initCompactCardTables() {
        var visibleRowsLimit = 5;
        var tables = document.querySelectorAll('.card-table .table-wrap table');

        tables.forEach(function (table) {
            var tbody = table.querySelector('tbody');
            if (!tbody) return;

            var rows = Array.from(tbody.children).filter(function (row) {
                if (row.tagName !== 'TR') return false;
                return row.querySelector('td[colspan]') === null;
            });

            if (rows.length <= visibleRowsLimit) return;

            var hiddenRows = rows.slice(visibleRowsLimit);
            hiddenRows.forEach(function (row) {
                row.classList.add('row-collapsed');
            });

            var tableWrap = table.closest('.table-wrap');
            if (!tableWrap) return;

            var actions = document.createElement('div');
            actions.className = 'table-collapsible-actions';

            var toggleBtn = document.createElement('button');
            toggleBtn.type = 'button';
            toggleBtn.className = 'table-toggle-btn';
            toggleBtn.setAttribute('aria-expanded', 'false');

            var isExpanded = false;
            var collapsedCount = hiddenRows.length;

            function renderState() {
                hiddenRows.forEach(function (row) {
                    row.classList.toggle('row-collapsed', !isExpanded);
                });
                toggleBtn.textContent = isExpanded ? 'Свернуть' : 'Развернуть (+' + collapsedCount + ')';
                toggleBtn.setAttribute('aria-expanded', isExpanded ? 'true' : 'false');
            }

            toggleBtn.addEventListener('click', function () {
                isExpanded = !isExpanded;
                renderState();
            });

            renderState();
            actions.appendChild(toggleBtn);
            tableWrap.insertAdjacentElement('afterend', actions);
        });
    })();
</script>
</body>
</html>
