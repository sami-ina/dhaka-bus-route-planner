<?php
/**
 * Dhaka Bus Route Planner & Transit Information System
 * Global Footer Template
 */
$lang = getLanguage();
?>
    </main>

    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-top">
                <div>
                    <h3 style="font-size: 16px; font-weight: 800; color: #172725;">RouteDhaka</h3>
                    <p style="font-size: 13px; color: #627772; margin-top: 4px; max-width: 450px;">
                        <?= $lang === 'bn' ? 'ঢাকার গণপরিবহন ও সড়ক ব্যবস্থাপনার সমন্বিত ওয়েব প্ল্যাটফর্ম।' : 'Integrated web-based transit planner and road construction alert system for Dhaka city.' ?>
                    </p>
                </div>
                <div class="footer-links">
                    <a href="index.php"><?= e(t('planJourney')) ?></a>
                    <a href="routes.php"><?= e(t('busRoutes')) ?></a>
                    <a href="road-updates.php"><?= e(t('roadUpdates')) ?></a>
                    <a href="index.php#system-architecture"><?= e(t('systemArchitecture')) ?></a>
                </div>
            </div>
            <div class="footer-bottom">
                <div>
                    &copy; <?= date('Y') ?> RouteDhaka. Built with <strong>HTML5, CSS3, JavaScript, PHP &amp; MySQL</strong>.
                </div>
                <div>
                    <?= $lang === 'bn' ? 'রেসপনসিভ ওয়েব সিস্টেম · গুগল ম্যাপস ইন্টিগ্রেশন' : 'Responsive Web System · Google Maps Integration' ?>
                </div>
            </div>
        </div>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>

