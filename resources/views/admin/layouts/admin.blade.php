<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admin Panel – Kedai Cap Tiga Buaya">
    <title>@yield('title', 'Dashboard Admin') – Kedai Cap Tiga Buaya</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --green-900: #0f2d18;
            --green-800: #133920;
            --green-700: #1a4d2b;
            --green-600: #236535;
            --green-500: #2d7a40;
            --green-400: #3a9651;
            --green-100: #d1fae5;
            --green-50:  #f0fdf4;
            --accent:    #2d7a40;
            --bg:        #f4f6f3;
            --surface:   #ffffff;
            --border:    #e5e9e6;
            --text-1:    #0f1f13;
            --text-2:    #3d5444;
            --text-3:    #7a9482;
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --shadow-sm: 0 1px 3px rgba(0,0,0,.07), 0 1px 2px rgba(0,0,0,.05);
            --shadow-md: 0 4px 16px rgba(0,0,0,.09);
            --transition: 0.22s cubic-bezier(.4,0,.2,1);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text-1);
            min-height: 100vh;
            display: flex;
            font-size: 14px;
        }

        /* ── SCROLLBAR ── */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #c8d5cc; border-radius: 99px; }

        /* ══════════════════ SIDEBAR ══════════════════ */
                        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: var(--green-800);
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            transition: width var(--transition);
            flex-shrink: 0;
            z-index: 100;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 18px 18px 16px;
            text-decoration: none;
            border-bottom: 1px solid rgba(255,255,255,.08);
            margin-bottom: 6px;
        }
        .sidebar-brand img {
            width: 42px;
            height: 42px;
            object-fit: contain;
            background: transparent;
            padding: 0;
            border: none;
        }
        .sidebar-brand-text {
            line-height: 1.25;
        }
        .sidebar-brand-text .brand-main {
            font-size: 15px;
            font-weight: 700;
            color: #ffffff;
            display: block;
            letter-spacing: .2px;
        }
        .sidebar-brand-text .brand-sub {
            font-size: 11.5px;
            color: rgba(255,255,255,.65);
            display: block;
            text-transform: uppercase;
            letter-spacing: .8px;
            margin-top: 4px;
            font-weight: 600;
        }

                .sidebar-section-label {
            font-size: 11px;
            font-weight: 700;
            color: #ffffff;
            opacity: .85;
            text-transform: uppercase;
            letter-spacing: 1.1px;
            padding: 10px 18px 6px;
        }

        .nav-menu { list-style: none; padding: 0 12px; }
        .nav-item { margin-bottom: 3px; }
        .nav-item a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10.5px 14px;
            color: #ffffff;
            text-decoration: none;
            border-radius: var(--radius-sm);
            font-size: 13.5px;
            font-weight: 500;
            transition: all var(--transition);
            position: relative;
        }
        .nav-item a i {
            width: 20px;
            text-align: center;
            font-size: 15.5px;
            flex-shrink: 0;
            color: #ffffff;
        }
        .nav-item a:hover {
            background: rgba(255,255,255,.12);
            color: #ffffff;
        }
        .nav-item a:hover i {
            color: #ffffff;
        }
        .nav-item.active a {
            background: rgba(255,255,255,.18);
            color: #ffffff;
            font-weight: 600;
        }
        .nav-item.active a i {
            color: #ffffff;
        }
        .nav-folder { margin-bottom: 3px; }
        .nav-folder-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 10.5px 14px;
            color: #ffffff;
            background: transparent;
            border: none;
            border-radius: var(--radius-sm);
            font-size: 13.5px;
            font-weight: 500;
            font-family: inherit;
            cursor: pointer;
            transition: all var(--transition);
            text-align: left;
        }
        .nav-folder-btn .folder-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .nav-folder-btn .folder-left i {
            width: 20px;
            text-align: center;
            font-size: 15.5px;
            flex-shrink: 0;
            color: #ffffff;
            transition: color var(--transition);
        }
        .nav-folder-btn .folder-arrow {
            font-size: 11.5px;
            color: #ffffff;
            opacity: .7;
            transition: transform var(--transition);
        }
        .nav-folder-btn:hover {
            background: rgba(255,255,255,.12);
            color: #ffffff;
        }
        .nav-folder-btn:hover .folder-left i {
            color: #ffffff;
        }
        .nav-folder.open .nav-folder-btn {
            color: #ffffff;
            background: rgba(255,255,255,.1);
            font-weight: 600;
        }
        .nav-folder.open .folder-arrow {
            transform: rotate(90deg);
            color: #ffffff;
            opacity: 1;
        }
        .nav-sub-menu {
            list-style: none;
            padding: 5px 0 5px 18px;
            position: relative;
        }
        .nav-sub-item { margin-bottom: 2px; }
        .nav-sub-item a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            color: rgba(255,255,255,.9);
            text-decoration: none;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 500;
            transition: all var(--transition);
            position: relative;
        }
        .nav-sub-item a i {
            font-size: 13px;
            width: 16px;
            text-align: center;
            color: #ffffff;
            opacity: .9;
        }
        .nav-sub-item a:hover {
            background: rgba(255,255,255,.12);
            color: #ffffff;
        }
        .nav-sub-item a:hover i {
            color: #ffffff;
            opacity: 1;
        }
        .nav-sub-item.active a {
            background: rgba(255,255,255,.2);
            color: #ffffff;
            font-weight: 600;
        }
        .nav-sub-item.active a i {
            color: #ffffff;
            opacity: 1;
        }

        .sidebar-footer {
            margin-top: auto;
            border-top: 1px solid rgba(255,255,255,.08);
            padding: 16px 14px;
        }
        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 8px 8px;
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: background var(--transition);
        }
        .sidebar-user:hover { background: rgba(255,255,255,.07); }
        .sidebar-user img {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255,255,255,.2);
        }
        .sidebar-user-info { flex: 1; min-width: 0; }
        .sidebar-user-info .u-name {
            font-size: 13.5px;
            font-weight: 700;
            color: #fff;
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .sidebar-user-info .u-role {
            font-size: 11.5px;
            color: rgba(255,255,255,.5);
            display: block;
        }
        .btn-logout {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #f87171;
            text-decoration: none;
            font-size: 12.5px;
            font-weight: 600;
            padding: 8px 6px 2px;
            background: none;
            border: none;
            cursor: pointer;
            width: 100%;
            text-align: left;
            transition: color var(--transition);
        }
        .btn-logout:hover { color: #fca5a5; }

        /* ══════════════════ MAIN WRAPPER ══════════════════ */
        .admin-wrap {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        /* ── TOPBAR ── */
        .topbar {
            height: 60px;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 28px;
            gap: 16px;
            position: sticky;
            top: 0;
            z-index: 99;
        }
        .topbar-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-1);
        }
        .topbar-search {
            flex: 1;
            max-width: 320px;
            margin-left: auto;
            position: relative;
        }
        .topbar-search input {
            width: 100%;
            padding: 7px 12px 7px 36px;
            border: 1.5px solid var(--border);
            border-radius: 99px;
            font-family: inherit;
            font-size: 13px;
            color: var(--text-1);
            background: var(--bg);
            outline: none;
            transition: border-color var(--transition), background var(--transition);
        }
        .topbar-search input:focus {
            border-color: var(--green-500);
            background: #fff;
        }
        .topbar-search i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-3);
            font-size: 13px;
        }
        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-left: 16px;
        }
        .topbar-icon-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 1.5px solid var(--border);
            background: var(--surface);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text-2);
            font-size: 14px;
            transition: all var(--transition);
            position: relative;
            text-decoration: none;
        }
        .topbar-icon-btn:hover { background: var(--bg); border-color: var(--green-400); color: var(--green-600); }
        .notif-dot {
            position: absolute;
            top: 5px; right: 5px;
            width: 7px; height: 7px;
            background: #ef4444;
            border-radius: 50%;
            border: 1.5px solid #fff;
        }
        .topbar-user {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            padding: 4px 10px;
            border-radius: 99px;
            border: 1.5px solid var(--border);
            transition: all var(--transition);
            text-decoration: none;
            color: var(--text-1);
        }
        .topbar-user:hover { background: var(--bg); border-color: var(--green-400); }
        .topbar-user img {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            object-fit: cover;
        }
        .topbar-user span { font-size: 13px; font-weight: 600; }
        .topbar-user i { font-size: 11px; color: var(--text-3); }

        /* ── PAGE CONTENT ── */
        .page-content {
            flex: 1;
            padding: 28px 32px;
            overflow-y: auto;
        }

        /* ── PAGE HEADER ── */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 24px;
            gap: 16px;
        }
        .page-header-left h1 {
            font-size: 22px;
            font-weight: 800;
            color: var(--text-1);
            margin-bottom: 4px;
        }
        .page-header-left p {
            font-size: 13.5px;
            color: var(--text-2);
        }
        .page-header-right { display: flex; gap: 10px; align-items: center; flex-shrink: 0; }

        /* ── BACK LINK ── */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-2);
            text-decoration: none;
            margin-bottom: 10px;
            transition: color var(--transition);
        }
        .back-link:hover { color: var(--green-600); }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 18px;
            border-radius: var(--radius-sm);
            font-family: inherit;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: all var(--transition);
            white-space: nowrap;
        }
        .btn-primary {
            background: var(--green-700);
            color: #fff;
        }
        .btn-primary:hover { background: var(--green-600); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(35,101,53,.3); }
        .btn-outline {
            background: var(--surface);
            color: var(--text-1);
            border: 1.5px solid var(--border);
        }
        .btn-outline:hover { border-color: var(--green-500); color: var(--green-700); background: var(--green-50); }
        .btn-sm { padding: 6px 14px; font-size: 12.5px; }
        .btn-danger { background: #fef2f2; color: #ef4444; border: 1.5px solid #fecaca; }
        .btn-danger:hover { background: #ef4444; color: #fff; }

        /* ── CARD ── */
        .card {
            background: var(--surface);
            border-radius: var(--radius-md);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
        }
        .card-body { padding: 20px 22px; }

        /* ── STAT CARD ── */
        .stat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 18px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: var(--shadow-sm);
            transition: box-shadow var(--transition);
        }
        .stat-card:hover { box-shadow: var(--shadow-md); }
        .stat-label { font-size: 11px; font-weight: 600; color: var(--text-3); text-transform: uppercase; letter-spacing: .7px; margin-bottom: 6px; }
        .stat-value { font-size: 22px; font-weight: 800; color: var(--text-1); margin-bottom: 4px; }
        .stat-note { font-size: 11.5px; color: var(--text-3); }
        .stat-note.up { color: #16a34a; }
        .stat-note.down { color: #ef4444; }
        .stat-icon {
            width: 44px; height: 44px;
            border-radius: var(--radius-sm);
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        /* ── TABLE ── */
        .table-wrap {
            background: var(--surface);
            border-radius: var(--radius-md);
            border: 1px solid var(--border);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table thead th {
            padding: 12px 16px;
            text-align: left;
            font-size: 11px;
            font-weight: 700;
            color: var(--text-3);
            text-transform: uppercase;
            letter-spacing: .7px;
            background: #f8faf9;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }
        .data-table tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background var(--transition);
        }
        .data-table tbody tr:last-child { border-bottom: none; }
        .data-table tbody tr:hover { background: #f8faf9; }
        .data-table tbody td { padding: 13px 16px; vertical-align: middle; font-size: 13.5px; }

        /* ── BADGE ── */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 99px;
            font-size: 11.5px;
            font-weight: 600;
        }
        .badge-green  { background: #dcfce7; color: #16a34a; }
        .badge-yellow { background: #fef9c3; color: #ca8a04; }
        .badge-blue   { background: #dbeafe; color: #2563eb; }
        .badge-red    { background: #fee2e2; color: #dc2626; }
        .badge-gray   { background: #f1f5f9; color: #64748b; }

        /* ── FORM ── */
        .form-label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            color: var(--text-2);
            text-transform: uppercase;
            letter-spacing: .6px;
            margin-bottom: 6px;
        }
        .form-label .req { color: #ef4444; }
        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: inherit;
            font-size: 13.5px;
            color: var(--text-1);
            background: var(--surface);
            outline: none;
            transition: border-color var(--transition), box-shadow var(--transition);
        }
        .form-control:focus {
            border-color: var(--green-500);
            box-shadow: 0 0 0 3px rgba(45,122,64,.12);
        }
        .form-control::placeholder { color: #b0bfb8; }
        select.form-control { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%237a9482' d='M6 8L1 3h10z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; padding-right: 36px; }
        textarea.form-control { resize: vertical; min-height: 100px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-group { margin-bottom: 18px; }
        .form-hint { font-size: 12px; color: var(--text-3); margin-top: 5px; display: flex; align-items: center; gap: 5px; }

        /* ── TOGGLE ── */
        .toggle-wrap { display: flex; align-items: center; justify-content: space-between; padding: 14px 16px; background: #f8faf9; border-radius: var(--radius-sm); border: 1.5px solid var(--border); margin-bottom: 10px; }
        .toggle-info .toggle-title { font-size: 13px; font-weight: 700; color: var(--text-1); }
        .toggle-info .toggle-desc { font-size: 11.5px; color: var(--text-3); }
        .toggle { position: relative; width: 42px; height: 24px; flex-shrink: 0; }
        .toggle input { opacity: 0; width: 0; height: 0; }
        .toggle-slider {
            position: absolute; inset: 0;
            background: #d1d5db;
            border-radius: 99px;
            cursor: pointer;
            transition: background var(--transition);
        }
        .toggle-slider::before {
            content: '';
            position: absolute;
            width: 18px; height: 18px;
            left: 3px; top: 3px;
            background: #fff;
            border-radius: 50%;
            transition: transform var(--transition);
            box-shadow: 0 1px 3px rgba(0,0,0,.2);
        }
        .toggle input:checked + .toggle-slider { background: var(--green-500); }
        .toggle input:checked + .toggle-slider::before { transform: translateX(18px); }

        /* ── PAGINATION ── */
        .pagination {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .page-btn {
            width: 32px; height: 32px;
            display: flex; align-items: center; justify-content: center;
            border-radius: var(--radius-sm);
            border: 1.5px solid var(--border);
            background: var(--surface);
            color: var(--text-2);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all var(--transition);
        }
        .page-btn:hover { border-color: var(--green-400); color: var(--green-700); }
        .page-btn.active { background: var(--green-700); border-color: var(--green-700); color: #fff; }
        .page-btn.disabled { opacity: .4; pointer-events: none; }

        /* ── TOOLBAR ── */
        .toolbar {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }
        .toolbar-search {
            position: relative;
            flex: 1;
            min-width: 220px;
        }
        .toolbar-search input {
            width: 100%;
            padding: 9px 12px 9px 36px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: inherit;
            font-size: 13px;
            color: var(--text-1);
            background: var(--surface);
            outline: none;
            transition: border-color var(--transition);
        }
        .toolbar-search input:focus { border-color: var(--green-500); }
        .toolbar-search i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-3);
            font-size: 13px;
        }
        .toolbar-filter {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 9px 14px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            background: var(--surface);
            font-size: 13px;
            color: var(--text-2);
            cursor: pointer;
            font-family: inherit;
            transition: all var(--transition);
        }
        .toolbar-filter:hover { border-color: var(--green-400); color: var(--green-700); }
        .toolbar-select {
            padding: 9px 32px 9px 12px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: inherit;
            font-size: 13px;
            color: var(--text-2);
            background: var(--surface);
            cursor: pointer;
            outline: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%237a9482' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            transition: border-color var(--transition);
        }
        .toolbar-select:focus { border-color: var(--green-500); }

        /* ── ICON BTN (table actions) ── */
        .icon-btn {
            width: 30px; height: 30px;
            border-radius: 6px;
            border: 1.5px solid var(--border);
            background: var(--surface);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text-2);
            font-size: 13px;
            transition: all var(--transition);
            text-decoration: none;
        }
        .icon-btn:hover { background: var(--bg); border-color: var(--green-400); color: var(--green-700); }

        /* ── TABS ── */
        .tabs {
            display: flex;
            background: #f1f5f3;
            border-radius: var(--radius-sm);
            padding: 4px;
            gap: 4px;
            margin-bottom: 24px;
        }
        .tab-btn {
            flex: 1;
            padding: 9px 16px;
            border-radius: 6px;
            border: none;
            background: transparent;
            font-family: inherit;
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text-3);
            cursor: pointer;
            transition: all var(--transition);
        }
        .tab-btn.active {
            background: var(--surface);
            color: var(--text-1);
            box-shadow: var(--shadow-sm);
        }

        /* ── SECTION CARD (form) ── */
        .section-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            margin-bottom: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }
        .section-card-header {
            padding: 16px 22px;
            border-bottom: 1px solid var(--border);
        }
        .section-card-header h3 {
            font-size: 14.5px;
            font-weight: 700;
            color: var(--text-1);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .section-card-header p {
            font-size: 12.5px;
            color: var(--text-3);
            margin-top: 3px;
        }
        .section-card-body { padding: 22px; }

        /* ── UPLOAD ZONE ── */
        .upload-zone {
            border: 2px dashed var(--border);
            border-radius: var(--radius-md);
            padding: 40px 20px;
            text-align: center;
            cursor: pointer;
            transition: all var(--transition);
            background: #fafcfa;
        }
        .upload-zone:hover { border-color: var(--green-400); background: var(--green-50); }
        .upload-zone i { font-size: 28px; color: var(--text-3); margin-bottom: 10px; display: block; }
        .upload-zone .upload-title { font-size: 13px; font-weight: 700; color: var(--text-1); }
        .upload-zone .upload-hint { font-size: 12px; color: var(--text-3); margin-top: 4px; }

        /* ── PROGRESS ── */
        .progress-bar-wrap { height: 8px; background: #e5e9e6; border-radius: 99px; overflow: hidden; margin: 8px 0; }
        .progress-bar { height: 100%; background: linear-gradient(90deg, var(--green-500), var(--green-400)); border-radius: 99px; transition: width .4s ease; }

        /* ── TIMELINE ── */
        .timeline { position: relative; padding-left: 24px; }
        .timeline::before { content: ''; position: absolute; left: 8px; top: 0; bottom: 0; width: 2px; background: var(--border); }
        .timeline-item { position: relative; margin-bottom: 20px; }
        .timeline-dot {
            position: absolute;
            left: -20px;
            top: 3px;
            width: 16px; height: 16px;
            border-radius: 50%;
            background: var(--surface);
            border: 2px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            font-size: 8px;
        }
        .timeline-dot.done { background: var(--green-100); border-color: var(--green-500); color: var(--green-600); }
        .timeline-dot.active { background: var(--green-600); border-color: var(--green-600); color: #fff; }
        .timeline-title { font-size: 13px; font-weight: 700; color: var(--text-1); }
        .timeline-time { font-size: 11.5px; color: var(--text-3); margin-bottom: 3px; }
        .timeline-desc { font-size: 12.5px; color: var(--text-2); }

        /* ── MENU ITEM (order detail) ── */
        .order-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 16px 0;
            border-bottom: 1px solid var(--border);
        }
        .order-item:last-of-type { border-bottom: none; }
        .order-item-img {
            width: 64px; height: 64px;
            border-radius: 10px;
            object-fit: cover;
            flex-shrink: 0;
            background: #e5e9e6;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
            position: relative;
        }
        .order-item-img .qty-badge {
            position: absolute;
            top: -6px; right: -6px;
            width: 20px; height: 20px;
            background: var(--green-700);
            color: #fff;
            border-radius: 50%;
            font-size: 10px;
            font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            border: 2px solid #fff;
        }
        .order-item-info { flex: 1; }
        .order-item-name { font-size: 14px; font-weight: 700; color: var(--text-1); margin-bottom: 3px; }
        .order-item-sub { font-size: 12.5px; color: var(--text-3); }
        .order-item-price { font-size: 14px; font-weight: 700; color: var(--text-1); text-align: right; flex-shrink: 0; }
        .order-note {
            margin-top: 8px;
            padding: 8px 12px;
            background: #f8faf9;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 12px;
            color: var(--text-2);
            display: flex; gap: 6px; align-items: flex-start;
        }
        .order-note i { color: var(--text-3); margin-top: 1px; flex-shrink: 0; }

        /* ── TOTAL TABLE ── */
        .total-table { width: 100%; border-collapse: collapse; }
        .total-table tr td { padding: 7px 0; font-size: 13.5px; color: var(--text-2); }
        .total-table tr td:last-child { text-align: right; font-weight: 600; color: var(--text-1); }
        .total-table .grand td { padding-top: 12px; border-top: 1.5px solid var(--border); font-size: 14.5px; font-weight: 800; color: var(--text-1); }
        .total-table .grand td:first-child { text-transform: uppercase; font-size: 11px; letter-spacing: .6px; color: var(--text-3); }
        .total-table .grand td:last-child { font-size: 18px; color: var(--green-700); }

        /* ── QUICK ACTION CARD ── */
        .action-card {
            background: var(--green-800);
            color: #fff;
            border-radius: var(--radius-md);
            padding: 22px;
            margin-bottom: 16px;
        }
        .action-card h4 { font-size: 14px; font-weight: 700; margin-bottom: 4px; }
        .action-card p { font-size: 12.5px; color: rgba(255,255,255,.65); margin-bottom: 16px; }
        .action-card .btn-white {
            background: #fff;
            color: var(--green-800);
            padding: 10px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 700;
            text-align: center;
            display: block;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all var(--transition);
            width: 100%;
        }
        .action-card .btn-white:hover { background: #f0fdf4; }
        .action-card .btn-cancel {
            display: block;
            text-align: center;
            color: #f87171;
            font-size: 12.5px;
            font-weight: 700;
            margin-top: 10px;
            cursor: pointer;
            background: none;
            border: none;
            width: 100%;
            text-decoration: none;
        }
        .action-card .btn-cancel:hover { color: #fca5a5; }
        .action-card .divider { text-align: center; font-size: 11px; color: rgba(255,255,255,.35); margin: 8px 0; }

        /* ── FOOTER BAR ── */
        .footer-bar {
            position: sticky;
            bottom: 0;
            background: var(--surface);
            border-top: 1px solid var(--border);
            padding: 14px 32px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            z-index: 10;
        }
        .footer-bar-left { margin-right: auto; font-size: 13px; color: var(--text-3); }

        /* ── DETAIL SECTION LABEL ── */
        .detail-label {
            font-size: 10.5px;
            font-weight: 700;
            color: var(--text-3);
            text-transform: uppercase;
            letter-spacing: .7px;
            margin-bottom: 3px;
        }
        .detail-value { font-size: 13.5px; font-weight: 500; color: var(--text-1); }

        /* ── AVATAR EDIT ── */
        .avatar-wrap {
            position: relative;
            display: inline-block;
        }
        .avatar-wrap img {
            width: 90px; height: 90px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,.12);
        }
        .avatar-edit-btn {
            position: absolute;
            bottom: 2px; right: 2px;
            width: 26px; height: 26px;
            background: var(--green-700);
            color: #fff;
            border-radius: 50%;
            border: 2px solid #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 10px;
            cursor: pointer;
        }

        /* ── SECURITY SCORE ── */
        .security-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 20px; }
        .security-score-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; }
        .security-score-pct { font-size: 20px; font-weight: 800; color: var(--green-700); }
        .security-item { display: flex; align-items: center; gap: 8px; padding: 8px 0; border-bottom: 1px solid var(--border); font-size: 13px; color: var(--text-2); }
        .security-item:last-child { border-bottom: none; }
        .security-item i.ok { color: var(--green-500); }
        .security-item i.warn { color: #f59e0b; }
        .security-item i.bad { color: #ef4444; }

        /* ── PROFILE SIDEBAR ── */
        .profile-sidebar-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 24px 20px;
            text-align: center;
        }
        .profile-sidebar-card .u-name { font-size: 16px; font-weight: 800; margin: 12px 0 4px; }
        .profile-sidebar-card .u-badges { display: flex; justify-content: center; gap: 6px; flex-wrap: wrap; margin-bottom: 16px; }
        .profile-sidebar-card .u-badge { padding: 3px 10px; border-radius: 99px; font-size: 11px; font-weight: 700; background: #dcfce7; color: #16a34a; }
        .profile-sidebar-card .u-badge.blue { background: #dbeafe; color: #2563eb; }
        .profile-contact { text-align: left; border-top: 1px solid var(--border); padding-top: 16px; }
        .contact-row { display: flex; align-items: center; gap: 10px; font-size: 13px; color: var(--text-2); padding: 6px 0; }
        .contact-row i { width: 16px; color: var(--text-3); font-size: 13px; }

        /* ── PAYMENT BADGE ── */
        .pay-badge { display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px; border-radius: 99px; font-size: 11.5px; font-weight: 700; background: #dcfce7; color: #16a34a; }

        /* ── ALERT BOX ── */
        .alert-box {
            padding: 12px 14px;
            border-radius: var(--radius-sm);
            font-size: 12.5px;
            display: flex;
            gap: 10px;
            align-items: flex-start;
        }
        .alert-box.warning { background: #fffbeb; border: 1px solid #fde68a; color: #92400e; }
        .alert-box.info { background: #eff6ff; border: 1px solid #bfdbfe; color: #1e40af; }
        .alert-box i { flex-shrink: 0; margin-top: 1px; }

        /* ── BADGE LABEL (pratinjau) ── */
        .badge-outline { display: inline-flex; align-items: center; gap: 5px; padding: 4px 12px; border-radius: 99px; font-size: 12px; font-weight: 600; border: 1.5px solid var(--border); color: var(--text-2); }
        .badge-outline i { font-size: 10px; }

        /* ── SUMMARY ROWS ── */
        .summary-row { display: flex; justify-content: space-between; padding: 5px 0; font-size: 13px; color: var(--text-2); border-bottom: 1px solid var(--border); }
        .summary-row:last-child { border-bottom: none; }
        .summary-row .s-key { font-size: 10.5px; font-weight: 700; color: var(--text-3); text-transform: uppercase; }
        .summary-row .s-val { font-weight: 600; color: var(--text-1); }

        /* ── DASHBOARD GRID ── */
        .dash-bottom-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; align-items: stretch; }
        .chart-placeholder {
            background: linear-gradient(135deg, var(--green-50), #fff);
            border-radius: var(--radius-md);
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 8px;
            border: 1.5px dashed var(--border);
            color: var(--text-3);
            font-size: 13px;
        }
        .chart-placeholder i { font-size: 28px; color: var(--green-400); }
        .quick-stats { display: flex; flex-direction: column; gap: 12px; }
        .quick-stat-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            font-size: 13.5px;
        }
        .quick-stat-row .q-label { color: var(--text-2); font-weight: 500; display: flex; align-items: center; gap: 8px; }
        .quick-stat-row .q-label i { width: 28px; height: 28px; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 13px; }
        .quick-stat-row .q-val { font-weight: 800; color: var(--text-1); }

        /* ── MENU PHOTO THUMBNAIL ── */
        .menu-thumb { width: 44px; height: 44px; border-radius: 8px; object-fit: cover; background: var(--bg); display: flex; align-items: center; justify-content: center; font-size: 18px; }

        @media (max-width: 900px) {
            .stat-grid { grid-template-columns: 1fr 1fr; }
            .dash-bottom-grid { grid-template-columns: 1fr; }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Kedai Cap Tiga Buaya">
            <div class="sidebar-brand-text">
                <span class="brand-main">Cap Tiga Buaya</span>
                <span class="brand-sub">Admin</span>
            </div>
        </a>

        <p class="sidebar-section-label">Menu Utama</p>
        <ul class="nav-menu">
            <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa-solid fa-chart-pie"></i> Dashboard
                </a>
            </li>
            
            <!-- FOLDER: MENU -->
            <li class="nav-folder {{ request()->routeIs('admin.menu*') ? 'open' : '' }}" id="folder-menu">
                <button type="button" class="nav-folder-btn" onclick="toggleFolder('folder-menu')">
                    <span class="folder-left">
                        <i class="fa-solid fa-book-open"></i> Menu
                    </span>
                    <i class="fa-solid fa-chevron-right folder-arrow"></i>
                </button>
                <ul class="nav-sub-menu" id="folder-menu-list" style="{{ request()->routeIs('admin.menu*') ? '' : 'display:none;' }}">
                    <li class="nav-sub-item {{ request()->routeIs('admin.menu.index') || request()->routeIs('admin.menu.create') || request()->routeIs('admin.menu.edit') ? 'active' : '' }}">
                        <a href="{{ route('admin.menu.index') }}">
                            <i class="fa-solid fa-utensils"></i> Kelola Menu
                        </a>
                    </li>
                </ul>
            </li>

            <!-- FOLDER: PESANAN -->
            <li class="nav-folder {{ request()->routeIs('admin.pesanan*') ? 'open' : '' }}" id="folder-pesanan">
                <button type="button" class="nav-folder-btn" onclick="toggleFolder('folder-pesanan')">
                    <span class="folder-left">
                        <i class="fa-solid fa-receipt"></i> Pesanan
                    </span>
                    <i class="fa-solid fa-chevron-right folder-arrow"></i>
                </button>
                <ul class="nav-sub-menu" id="folder-pesanan-list" style="{{ request()->routeIs('admin.pesanan*') ? '' : 'display:none;' }}">
                    <li class="nav-sub-item {{ request()->routeIs('admin.pesanan.dine_in') ? 'active' : '' }}">
                        <a href="{{ route('admin.pesanan.dine_in') }}">
                            <i class="fa-solid fa-utensils"></i> Pesanan Dine In
                        </a>
                    </li>
                    <li class="nav-sub-item {{ request()->routeIs('admin.pesanan.take_away') ? 'active' : '' }}">
                        <a href="{{ route('admin.pesanan.take_away') }}">
                            <i class="fa-solid fa-bag-shopping"></i> Pesanan Take Away
                        </a>
                    </li>
                </ul>
            </li>

            <!-- KELOLA GAMBAR -->
            <li class="nav-item {{ request()->routeIs('admin.banner*') ? 'active' : '' }}">
                <a href="{{ route('admin.banner.index') }}">
                    <i class="fa-solid fa-images"></i> Kelola Gambar
                </a>
            </li>
        </ul>

        <p class="sidebar-section-label">Pengaturan</p>
        <ul class="nav-menu">
            <li class="nav-item {{ request()->routeIs('admin.akun*') ? 'active' : '' }}">
                <a href="{{ route('admin.akun') }}">
                    <i class="fa-solid fa-circle-user"></i> Pengaturan
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div style="width:38px; height:38px; border-radius:50%; background:rgba(255,255,255,0.15); display:flex; align-items:center; justify-content:center; font-size:16px; border:2px solid rgba(255,255,255,0.2); flex-shrink:0;">
                    <i class="fa-solid fa-user-tie" style="color:#ffffff;"></i>
                </div>
                <div class="sidebar-user-info">
                    <span class="u-name">{{ Auth::user()?->name ?? 'Admin' }}</span>
                    <span class="u-role">Administrator</span>
                </div>
            </div>
            <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fa-solid fa-right-from-bracket"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN WRAPPER -->
    <div class="admin-wrap">
        <!-- PAGE CONTENT -->
        <div class="page-content" id="page-content">
            @yield('content')
        </div>

        @hasSection('footer_bar')
        <div class="footer-bar">
            @yield('footer_bar')
        </div>
        @endif
    </div>

    <script>
        function toggleFolder(folderId) {
            const folder = document.getElementById(folderId);
            const list = document.getElementById(folderId + '-list');
            if (!folder || !list) return;

            const isOpen = folder.classList.contains('open');
            if (isOpen) {
                folder.classList.remove('open');
                list.style.display = 'none';
            } else {
                folder.classList.add('open');
                list.style.display = 'block';
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
