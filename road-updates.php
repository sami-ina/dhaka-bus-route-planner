<?php
/**
 * Dhaka Bus Route Planner & Transit Information System
 * Road Construction & Traffic Advisory Page (road-updates.php)
 */

$current_page = 'road-updates';
$page_title = 'RouteDhaka - Road Construction Updates';
require_once __DIR__ . '/includes/header.php';

$dataSource = '';
$roadItems = getAllRoadUpdates($dataSource);
$lang = getLanguage();

$mapEmbedUrl = getGoogleMapsAreaEmbedUrl('Dhaka, Bangladesh', 12);
?>

<div class="wide-container" style="max-width: 1350px;">
    <!-- Back to Journey Planner -->
    <a href="index.php" class="back-button">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M10 7l-5 5 5 5"/></svg>
        <?= e(t('backPlanner')) ?>
    </a>

    <!-- Page Title & Eyebrow -->
    <div style="margin-top: 1rem;">
        <p class="eyebrow"><?= e(t('liveStatus')) ?></p>
        <h1 class="page-title"><?= e(t('constructionTitle')) ?></h1>
        <p style="margin-top: 0.5rem; max-width: 650px; font-size: 0.875rem; line-height: 1.6; color: #637873;">
            <?= e(t('constructionText')) ?>
        </p>
    </div>

    <!-- Layout: Left list of construction items, Right Google Map -->
    <div class="road-layout">
        <!-- List of Construction Items -->
        <div>
            <?php foreach ($roadItems as $item):
                $impactLevel = $item['level'];
                $impactClass = ($impactLevel === 'High impact') ? 'high' : (($impactLevel === 'Low impact') ? 'low' : 'medium');
                $impactLabel = t(($impactLevel === 'High impact') ? 'highImpact' : (($impactLevel === 'Low impact') ? 'lowImpact' : 'mediumImpact'));
                $roadName = ($lang === 'bn') ? $item['roadBn'] : $item['road'];
                $areaName = ($lang === 'bn') ? $item['areaBn'] : $item['area'];
                $statusText = ($lang === 'bn') ? $item['statusBn'] : $item['status'];
                $detailText = ($lang === 'bn') ? $item['detailBn'] : $item['detail'];
                $remainingText = ($lang === 'bn') ? $item['remainingBn'] : $item['remaining'];
                $updatedText = ($lang === 'bn') ? $item['updatedBn'] : $item['updated'];
            ?>
                <article class="road-card">
                    <div style="display: flex; align-items: flex-start; gap: 0.75rem;">
                        <span style="display: grid; width: 40px; height: 40px; flex: none; place-items: center; border-radius: 0.75rem; background: #fff0e9; color: #df6941;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 18 12 3l4 15M6 18h12M9.3 13h5.4M10.5 8h3"/></svg>
                        </span>
                        <div style="flex: 1; min-width: 0;">
                            <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 0.5rem;">
                                <h2 style="font-size: 15px; font-weight: 800; color: #172725;"><?= e($roadName) ?></h2>
                                <span class="impact-badge <?= e($impactClass) ?>">
                                    <?= e($impactLabel) ?>
                                </span>
                            </div>
                            <p style="margin-top: 3px; font-size: 12px; font-weight: 600; color: #657a75;">
                                <?= e($areaName) ?> · <?= e($statusText) ?>
                            </p>
                            <p style="margin-top: 0.65rem; font-size: 12px; line-height: 1.5; color: #71827e;">
                                <?= e($detailText) ?>
                            </p>
                            <div style="margin-top: 0.75rem; display: flex; flex-wrap: wrap; gap: 0.75rem; font-size: 11px; font-weight: 700; color: #687b77;">
                                <span style="display: inline-flex; align-items: center; gap: 4px;">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M16 3v4M8 3v4M3 10h18"/></svg>
                                    <?= e($remainingText) ?> <?= e(t('remaining')) ?>
                                </span>
                                <span style="display: inline-flex; align-items: center; gap: 4px;">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
                                    <?= e(t('updated')) ?> <?= e($updatedText) ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>

            <a href="index.php" class="primary-button" style="width: 100%; margin-top: 0.5rem;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m16 16 5 5"/></svg>
                <?= e(t('planDifferent')) ?>
            </a>

            <div style="margin-top: 1rem; text-align: center; font-size: 11px; color: #7f9590;">
                Data Source: <strong><?= e($dataSource) ?></strong>
            </div>
        </div>

        <!-- Google Map of Dhaka Road Work Zones -->
        <div class="map-frame-box" style="min-height: 520px;">
            <iframe title="Google Map of Dhaka road updates"
                    src="<?= e($mapEmbedUrl) ?>"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    allowfullscreen>
            </iframe>

            <div class="map-summary">
                <span class="map-summary-icon" style="background-color: #df6941;">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3 2.7 20h18.6z"/><path d="M12 9v4M12 17h.01"/></svg>
                </span>
                <div>
                    <p style="font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.12em; color: #758883;">
                        <?= e(t('activeDhaka')) ?>
                    </p>
                    <p style="font-size: 0.875rem; font-weight: 800; color: #172725;">
                        <?= count($roadItems) ?> <?= e(t('reportedWorks')) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

