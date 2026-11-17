<?php
/**
 * Dhaka Bus Route Planner & Transit Information System
 * Global Header Template
 */

require_once __DIR__ . '/functions.php';

$page_title = $page_title ?? 'RouteDhaka - ' . t('brandSubtitle');
$current_page = $current_page ?? 'home';
$lang = getLanguage();
$is_live_db = isDatabaseConnected();
?>
<!DOCTYPE html>
<html lang="<?= e($lang) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($page_title) ?></title>
    <meta name="description" content="Find Dhaka bus routes, stops, road construction updates, alternative routes, and estimated fares.">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23087f5b'><path d='M5 16V6.8C5 4.7 6.8 3 9 3h6c2.2 0 4 1.7 4 3.8V16'/><path d='M5 11h14M8 7h8M7 16h10v3H7zM8 19v2M16 19v2'/></svg>">
</head>
<body>
    <a href="#main-content" class="skip-link"><?= e(t('skip')) ?></a>

    <!-- Database Connection Transparency Banner -->
    <div class="db-status-bar <?= $is_live_db ? 'live' : 'fallback' ?>">
        <div class="db-pill">
            <span class="db-indicator"></span>
            <span>
                <?php if ($is_live_db): ?>
                    <strong><?= e(t('dbLiveStatus')) ?></strong> &mdash; <em>Tables: places, buses, bus_stops, road_updates</em>
                <?php else: ?>
                    <strong><?= e(t('dbFallbackStatus')) ?></strong> &mdash; <em>Import database.sql to MySQL to activate full live database</em>
                <?php endif; ?>
            </span>
        </div>
        <div>
            <span style="opacity: 0.85;">PHP <?= phpversion() ?> · MySQL / PDO</span>
        </div>
    </div>

    <!-- Site Header -->
    <header class="site-header">
        <div class="header-container">
            <a href="index.php" class="brand-link" aria-label="Route Dhaka Home">
                <span class="brand-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 16V6.8C5 4.7 6.8 3 9 3h6c2.2 0 4 1.7 4 3.8V16"/>
                        <path d="M5 11h14M8 7h8M7 16h10v3H7zM8 19v2M16 19v2"/>
                        <circle cx="8.5" cy="14" r=".8" fill="currentColor" stroke="none"/>
                        <circle cx="15.5" cy="14" r=".8" fill="currentColor" stroke="none"/>
                    </svg>
                </span>
                <span>
                    <span class="brand-name">RouteDhaka</span>
                    <span class="brand-sub"><?= e(t('brandSubtitle')) ?></span>
                </span>
            </a>

            <!-- Desktop Navigation -->
            <nav class="primary-nav" aria-label="Primary Navigation">
                <a href="index.php" class="nav-link <?= $current_page === 'home' ? 'active' : '' ?>">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m16 16 5 5"/></svg>
                    <?= e(t('planJourney')) ?>
                </a>
                <a href="routes.php" class="nav-link <?= $current_page === 'routes' ? 'active' : '' ?>">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 16V6.8C5 4.7 6.8 3 9 3h6c2.2 0 4 1.7 4 3.8V16"/><path d="M5 11h14M8 7h8M7 16h10v3H7z"/></svg>
                    <?= e(t('busRoutes')) ?>
                </a>
                <a href="road-updates.php" class="nav-link <?= $current_page === 'road-updates' ? 'active' : '' ?>">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 18 12 3l4 15M6 18h12M9.3 13h5.4M10.5 8h3"/></svg>
                    <?= e(t('roadUpdates')) ?>
                </a>
                <a href="index.php#system-architecture" class="nav-link">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                    <?= e(t('systemArchitecture')) ?>
                </a>
            </nav>

            <!-- Language Switcher & Mobile Menu Trigger -->
            <div class="header-actions">
                <a href="?lang=<?= $lang === 'en' ? 'bn' : 'en' ?>" class="lang-btn" aria-label="Switch Language">
                    <?= e(t('switchLang')) ?>
                </a>
                <button type="button" class="menu-toggle" id="menuToggle" aria-label="Toggle navigation menu" aria-expanded="false">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Drawer -->
        <nav class="mobile-nav" id="mobileNav" aria-label="Mobile Navigation">
            <a href="index.php" class="mobile-link <?= $current_page === 'home' ? 'active' : '' ?>"><?= e(t('planJourney')) ?></a>
            <a href="routes.php" class="mobile-link <?= $current_page === 'routes' ? 'active' : '' ?>"><?= e(t('busRoutes')) ?></a>
            <a href="road-updates.php" class="mobile-link <?= $current_page === 'road-updates' ? 'active' : '' ?>"><?= e(t('roadUpdates')) ?></a>
            <a href="index.php#system-architecture" class="mobile-link"><?= e(t('systemArchitecture')) ?></a>
        </nav>
    </header>
    <main id="main-content">

