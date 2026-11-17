<?php
/**
 * Dhaka Bus Route Planner & Transit Information System
 * Route Details & Interactive Map Page (route-details.php)
 */

$current_page = 'routes';
$page_title = 'RouteDhaka - Route Details';
require_once __DIR__ . '/includes/header.php';

$routeId = (int)($_GET['id'] ?? 1);
$from    = trim($_GET['from'] ?? 'Mirpur 10');
$to      = trim($_GET['to']   ?? 'Farmgate');

$dataSource = '';
$route = getBusById($routeId, $dataSource);

if (!$route) {
    header("Location: routes.php");
    exit;
}

$lang = getLanguage();

$mapEmbedUrl = getGoogleMapsEmbedUrl($from, $to);
$externalMapUrl = getGoogleMapsExternalDirectionsUrl($from, $to);
?>

<div class="wide-container">
    <!-- Back Button -->
    <a href="routes.php?from=<?= urlencode($from) ?>&to=<?= urlencode($to) ?>" class="back-button">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M10 7l-5 5 5 5"/></svg>
        <?= e(t('backRoutes')) ?>
    </a>

    <div class="details-layout">
        <!-- Sidebar: Route Specs & Stops Timeline -->
        <aside class="details-aside">
            <div style="display: flex; align-items: flex-start; gap: 0.75rem;">
                <span class="bus-logo-badge" style="background-color: <?= e($route['color']) ?>; width: 46px; height: 46px;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 16V6.8C5 4.7 6.8 3 9 3h6c2.2 0 4 1.7 4 3.8V16"/><path d="M5 11h14M8 7h8M7 16h10v3H7z"/></svg>
                </span>
                <div>
                    <p class="eyebrow"><?= e(t('selectedBus')) ?></p>
                    <h1 style="font-size: 1.25rem; font-weight: 800;"><?= e($route['bus']) ?></h1>
                    <p style="margin-top: 2px; font-size: 0.75rem; color: #70827e;">
                        <?= e($route['number']) ?> · <?= e(t('every')) ?> <?= e(localUnit($route['frequency'], $lang)) ?>
                    </p>
                </div>
            </div>

            <!-- Stats 3-Col Box -->
            <div class="stat-box-3col">
                <span class="result-stat">
                    <strong><?= e(localUnit($route['duration'], $lang)) ?></strong>
                    <small><?= e(t('duration')) ?></small>
                </span>
                <span class="result-stat">
                    <strong><?= e(localUnit($route['distance'], $lang)) ?></strong>
                    <small><?= e(t('distance')) ?></small>
                </span>
                <span class="result-stat">
                    <strong>৳<?= e($route['fare']) ?></strong>
                    <small><?= e(t('estFare')) ?></small>
                </span>
            </div>

            <!-- Stops Timeline -->
            <h2 style="font-size: 0.875rem; font-weight: 800; color: #172725; margin-top: 1rem;"><?= e(t('stopsRoute')) ?></h2>
            <ol class="timeline-stops">
                <?php
                $totalStops = count($route['stops']);
                foreach ($route['stops'] as $idx => $stop):
                    $isFirst = ($idx === 0);
                    $isLast = ($idx === $totalStops - 1);
                    $stopName = $isFirst ? $from : ($isLast ? $to : $stop);
                ?>
                    <li class="timeline-item">
                        <div class="timeline-indicator">
                            <span class="step-dot" style="<?= ($isFirst || $isLast) ? 'background-color: var(--primary); color: white;' : '' ?>">
                                <?= $idx + 1 ?>
                            </span>
                            <?php if (!$isLast): ?>
                                <span class="step-line"></span>
                            <?php endif; ?>
                        </div>
                        <div class="timeline-label">
                            <?= e(displayPlace($stopName, $lang)) ?>
                            <?php if ($isFirst): ?>
                                <span style="font-size: 10px; color: #087f5b; font-weight: 800; margin-left: 4px;">(<?= e(t('start')) ?>)</span>
                            <?php elseif ($isLast): ?>
                                <span style="font-size: 10px; color: #e17727; font-weight: 800; margin-left: 4px;">(<?= e(t('destination')) ?>)</span>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ol>

            <!-- Action Buttons -->
            <div style="margin-top: 1.5rem; display: flex; flex-direction: column; gap: 0.65rem;">
                <a href="<?= e($externalMapUrl) ?>" target="_blank" rel="noopener noreferrer" class="primary-button" style="width: 100%;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" x2="9" y1="3" y2="18"/><line x1="15" x2="15" y1="6" y2="21"/></svg>
                    <?= e(t('openGoogle')) ?>
                </a>
                <a href="road-updates.php" class="secondary-button" style="width: 100%;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 18 12 3l4 15M6 18h12M9.3 13h5.4M10.5 8h3"/></svg>
                    <?= e(t('checkRoad')) ?>
                </a>
            </div>

            <div style="margin-top: 1rem; text-align: center; font-size: 11px; color: #7f9590;">
                Data Source: <strong><?= e($dataSource) ?></strong>
            </div>
        </aside>

        <!-- Interactive Google Map Embed -->
        <div class="map-frame-box">
            <iframe title="Google Maps route from <?= e($from) ?> to <?= e($to) ?>"
                    src="<?= e($mapEmbedUrl) ?>"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    allowfullscreen>
            </iframe>

            <!-- Map Floating Summary Badge -->
            <div class="map-summary">
                <span class="map-summary-icon" style="background-color: var(--primary);">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="6" cy="18" r="2"/>
                        <circle cx="18" cy="6" r="2"/>
                        <path d="M8 18h3a3 3 0 0 0 3-3v-6a3 3 0 0 1 3-3"/>
                    </svg>
                </span>
                <div>
                    <p style="font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.12em; color: #758883;">
                        <?= e(t('googleRoute')) ?>
                    </p>
                    <p style="font-size: 0.875rem; font-weight: 800; color: #172725;">
                        <?= e(displayPlace($from, $lang)) ?> &rarr; <?= e(displayPlace($to, $lang)) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

