<?php
/**
 * Dhaka Bus Route Planner & Transit Information System
 * Home Page (index.php)
 */

$current_page = 'home';
$page_title = 'RouteDhaka - Know the way before you start moving';
require_once __DIR__ . '/includes/header.php';

$placesSource = '';
$allPlaces = getAllPlaces($placesSource);

$defaultFrom = $_GET['from'] ?? 'Mirpur 10';
$defaultTo   = $_GET['to']   ?? 'Farmgate';
$lang = getLanguage();
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-container">
        <div class="hero-text-wrap">
            <span class="hero-eyebrow"><?= e(t('dhakaTransport')) ?></span>
            <h1 class="hero-title"><?= e(t('heroTitle')) ?></h1>
            <p class="hero-subtitle"><?= e(t('heroText')) ?></p>
        </div>

        <!-- Journey Search Form -->
        <form action="routes.php" method="GET" class="search-form-card" id="journeySearchForm">
            <div class="search-grid">
                <!-- Starting Place -->
                <div class="location-field">
                    <span class="field-icon origin">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"/>
                            <circle cx="12" cy="10" r="2.5"/>
                        </svg>
                    </span>
                    <div class="field-content">
                        <label for="fromInput" class="field-label"><?= e(t('start')) ?></label>
                        <input type="text"
                               name="from"
                               id="fromInput"
                               class="field-input"
                               list="dhaka-places-list"
                               value="<?= e(displayPlace($defaultFrom, $lang)) ?>"
                               placeholder="<?= e(t('placePlaceholder')) ?>"
                               autocomplete="off"
                               required>
                    </div>
                </div>

                <!-- Swap Button -->
                <button type="button" class="swap-btn" id="swapPlacesBtn" title="<?= e(t('swap')) ?>" aria-label="<?= e(t('swap')) ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M7 7h11l-3-3M18 17H7l3 3"/>
                    </svg>
                </button>

                <!-- Destination Place -->
                <div class="location-field">
                    <span class="field-icon destination">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"/>
                            <circle cx="12" cy="10" r="2.5"/>
                        </svg>
                    </span>
                    <div class="field-content">
                        <label for="toInput" class="field-label"><?= e(t('destination')) ?></label>
                        <input type="text"
                               name="to"
                               id="toInput"
                               class="field-input"
                               list="dhaka-places-list"
                               value="<?= e(displayPlace($defaultTo, $lang)) ?>"
                               placeholder="<?= e(t('placePlaceholder')) ?>"
                               autocomplete="off"
                               required>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="primary-button search-btn-hero">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m16 16 5 5"/></svg>
                    <?= e(t('findRoutes')) ?>
                </button>
            </div>

            <!-- Datalist Autocomplete from Database/Dummy Data -->
            <datalist id="dhaka-places-list">
                <?php foreach ($allPlaces as $en => $bn): ?>
                    <option value="<?= e($lang === 'bn' ? $bn : $en) ?>"></option>
                <?php endforeach; ?>
            </datalist>

            <!-- Geolocation & Guidance -->
            <div class="form-extras">
                <button type="button" class="geo-btn" id="geoBtn">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="4"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3"/></svg>
                    <?= e(t('useLocation')) ?>
                </button>
                <span class="location-msg" id="locationStatus"
                      data-unsupported="<?= e(t('locationUnsupported')) ?>"
                      data-finding="<?= e(t('findingLocation')) ?>"
                      data-selected="<?= e(t('locationSelected')) ?>"
                      data-unavailable="<?= e(t('locationUnavailable')) ?>"
                      data-current="<?= e(t('currentLocation')) ?>">
                    <?= e(t('suggestions')) ?>
                </span>
            </div>
        </form>
    </div>
</section>

<!-- Quick Access Destinations -->
<section class="content-container">
    <div class="section-head">
        <div>
            <p class="eyebrow"><?= e(t('quickAccess')) ?></p>
            <h2 class="section-title"><?= e(t('whereGoing')) ?></h2>
        </div>
        <a href="road-updates.php" class="text-button">
            <?= e(t('seeRoadUpdates')) ?>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M14 7l5 5-5 5"/></svg>
        </a>
    </div>

    <div class="quick-grid">
        <?php
        $popularDestinations = ['Farmgate', 'Motijheel', 'Gulshan 1', 'Uttara'];
        foreach ($popularDestinations as $popPlace):
            $placeDisplayName = displayPlace($popPlace, $lang);
        ?>
            <a href="routes.php?from=<?= urlencode($defaultFrom) ?>&to=<?= urlencode($popPlace) ?>" class="quick-card">
                <div>
                    <span class="quick-dest"><?= e($placeDisplayName) ?></span>
                    <span class="quick-sub"><?= e(t('findBusesFrom')) ?> <?= e(displayPlace($defaultFrom, $lang)) ?></span>
                </div>
                <span class="quick-arrow">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M14 7l5 5-5 5"/></svg>
                </span>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<!-- System Architecture & Requirements Section (Matching User's Specified Design) -->
<section class="system-reqs-section" id="system-architecture">
    <div class="wide-container">
        <div style="text-align: center; margin-bottom: 2.5rem;">
            <p class="eyebrow"><?= $lang === 'bn' ? 'সিস্টেম ডিজাইন ও প্রযুক্তি' : 'System Architecture & Requirements' ?></p>
            <h2 class="section-title" style="font-size: 1.85rem; margin-top: 4px;">
                <?= $lang === 'bn' ? 'সিস্টেমের মূল বৈশিষ্ট্য ও উপাদান' : 'Core System Specifications & Architecture' ?>
            </h2>
            <p style="color: #556b66; font-size: 0.95rem; margin-top: 8px; max-width: 600px; margin-left: auto; margin-right: auto;">
                <?= $lang === 'bn' ? 'এই প্রকল্পটি সম্পূর্ণ পিএইচপি ও মাইএসকিউএল ভিত্তিক এবং সব ডিভাইসে রেসপনসিভ।' : 'Engineered as a robust web-based system fulfilling all core project constraints.' ?>
            </p>
        </div>

        <div class="system-reqs-grid">
            <!-- Card 1: Web-based system -->
            <div class="system-req-card">
                <div class="system-req-icon-wrap">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="7" r="4"/>
                        <path d="M6 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/>
                        <path d="m17 11 2 2-2 2"/>
                        <path d="m21 11-2 2 2 2"/>
                    </svg>
                </div>
                <h3 class="system-req-title"><?= e(t('sysReq1Title')) ?></h3>
                <p class="system-req-desc"><?= e(t('sysReq1Desc')) ?></p>
                <div>
                    <span class="system-req-badge">PHP <?= phpversion() ?></span>
                    <span class="system-req-badge">MySQL 8.0</span>
                    <span class="system-req-badge">PDO Driver</span>
                </div>
            </div>

            <!-- Card 2: External dependencies -->
            <div class="system-req-card">
                <div class="system-req-icon-wrap">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17.5 19H9a7 7 0 1 1 6.71-9h1.79a4.5 4.5 0 1 1 0 9Z"/>
                    </svg>
                </div>
                <h3 class="system-req-title"><?= e(t('sysReq2Title')) ?></h3>
                <p class="system-req-desc"><?= e(t('sysReq2Desc')) ?></p>
                <div>
                    <span class="system-req-badge">Google Maps API</span>
                    <span class="system-req-badge">Transit Layer</span>
                    <span class="system-req-badge">Traffic Data</span>
                </div>
            </div>

            <!-- Card 3: Responsive access -->
            <div class="system-req-card">
                <div class="system-req-icon-wrap">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="20" height="14" x="2" y="3" rx="2"/>
                        <line x1="8" x2="16" y1="21" y2="21"/>
                        <line x1="12" x2="12" y1="17" y2="21"/>
                    </svg>
                </div>
                <h3 class="system-req-title"><?= e(t('sysReq3Title')) ?></h3>
                <p class="system-req-desc"><?= e(t('sysReq3Desc')) ?></p>
                <div>
                    <span class="system-req-badge">Desktop (1920px)</span>
                    <span class="system-req-badge">Tablet (768px)</span>
                    <span class="system-req-badge">Mobile (360px)</span>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

