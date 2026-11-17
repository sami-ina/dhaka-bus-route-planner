<?php
/**
 * Internationalization (i18n) & Language Management
 * Provides full English (en) and Bengali (bn) translations for RouteDhaka.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Determine active language: Priority: 1. $_GET['lang'], 2. $_SESSION['lang'], 3. $_COOKIE['lang'], 4. Default 'en'
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'bn'], true)) {
    $_SESSION['lang'] = $_GET['lang'];
    setcookie('route_dhaka_lang', $_GET['lang'], time() + (86400 * 30), '/');
} elseif (!isset($_SESSION['lang'])) {
    if (isset($_COOKIE['route_dhaka_lang']) && in_array($_COOKIE['route_dhaka_lang'], ['en', 'bn'], true)) {
        $_SESSION['lang'] = $_COOKIE['route_dhaka_lang'];
    } else {
        $_SESSION['lang'] = 'en';
    }
}

$current_lang = $_SESSION['lang'];

$translations = [
    'en' => [
        'brandSubtitle' => 'Bus routes & road construction',
        'planJourney' => 'Plan a journey',
        'busRoutes' => 'Bus routes',
        'roadUpdates' => 'Road updates',
        'systemArchitecture' => 'System Architecture',
        'skip' => 'Skip to main content',
        'openMenu' => 'Open menu',
        'closeMenu' => 'Close menu',
        'dhakaTransport' => 'Dhaka public transport',
        'heroTitle' => 'Know the way before you start moving.',
        'heroText' => 'Search any place in Dhaka, compare available buses, check road work, and estimate your fare.',
        'start' => 'Starting point',
        'destination' => 'Where to?',
        'placePlaceholder' => 'Type any place in Dhaka',
        'findRoutes' => 'Find routes',
        'swap' => 'Swap starting point and destination',
        'useLocation' => 'Use my current location',
        'suggestions' => 'Suggestions appear as you type.',
        'findingLocation' => 'Finding your location…',
        'locationSelected' => 'Current location selected.',
        'locationUnavailable' => 'Location access was not available. Type your starting place instead.',
        'locationUnsupported' => 'Location is not supported by this browser.',
        'quickAccess' => 'Quick access',
        'whereGoing' => 'Where are you going?',
        'seeRoadUpdates' => 'See road updates',
        'findBusesFrom' => 'Find buses from',
        'changeJourney' => 'Change journey',
        'journeyResults' => 'Journey results',
        'to' => 'to',
        'routesFound' => 'bus routes found',
        'trafficUpdated' => 'Traffic updated 2 minutes ago',
        'noDirectRoutes' => 'No direct bus found for this journey',
        'noDirectText' => 'Try a nearby major stop or view all available buses.',
        'showAllBuses' => 'Show all available buses',
        'sort' => 'Sort',
        'fastest' => 'Fastest',
        'lowestFare' => 'Lowest fare',
        'bestFare' => 'Best fare',
        'every' => 'Every',
        'duration' => 'duration',
        'distance' => 'distance',
        'estFare' => 'est. fare',
        'viewRoute' => 'View route',
        'roadMayAffect' => 'Road work may affect this journey',
        'roadMayAffectText' => 'Begum Rokeya Avenue has a lane restriction near Kazipara.',
        'viewUpdate' => 'View update',
        'backRoutes' => 'Back to all routes',
        'selectedBus' => 'Selected bus',
        'stopsRoute' => 'Stops on this route',
        'openGoogle' => 'Open in Google Maps',
        'checkRoad' => 'Check road updates',
        'googleRoute' => 'Google Maps route',
        'backPlanner' => 'Back to journey planner',
        'liveStatus' => 'Live status',
        'constructionTitle' => 'Road construction updates',
        'constructionText' => 'Plan around active repairs, lane closures, and construction work across Dhaka. Records include their latest update time.',
        'remaining' => 'remaining',
        'updated' => 'Updated',
        'planDifferent' => 'Plan a different journey',
        'activeDhaka' => 'Active in Dhaka',
        'reportedWorks' => 'reported road works',
        'lightTraffic' => 'Light traffic',
        'moderateTraffic' => 'Moderate traffic',
        'heavyTraffic' => 'Heavy traffic',
        'highImpact' => 'High impact',
        'mediumImpact' => 'Medium impact',
        'lowImpact' => 'Low impact',
        'currentLocation' => 'Current location, Dhaka',
        'dbLiveStatus' => 'Database: Connected to MySQL (dhaka_transit)',
        'dbFallbackStatus' => 'Database: Fallback Demo Data (MySQL not connected)',
        'switchLang' => 'বাংলা',
        'sysReq1Title' => 'Web-based system',
        'sysReq1Desc' => 'HTML, CSS, JavaScript, PHP, and MySQL.',
        'sysReq2Title' => 'External dependencies',
        'sysReq2Desc' => 'Map and traffic features may depend on external services, internet access, and data accuracy.',
        'sysReq3Title' => 'Responsive access',
        'sysReq3Desc' => 'Support desktop, tablet, and mobile browsers.'
    ],
    'bn' => [
        'brandSubtitle' => 'বাস রুট ও সড়ক নির্মাণ ব্যবস্থা',
        'planJourney' => 'যাত্রা পরিকল্পনা',
        'busRoutes' => 'বাস রুট',
        'roadUpdates' => 'সড়ক আপডেট',
        'systemArchitecture' => 'সিস্টেম আর্কিটেকচার',
        'skip' => 'মূল অংশে যান',
        'openMenu' => 'মেনু খুলুন',
        'closeMenu' => 'মেনু বন্ধ করুন',
        'dhakaTransport' => 'ঢাকা গণপরিবহন',
        'heroTitle' => 'যাত্রা শুরুর আগেই সঠিক পথ জেনে নিন।',
        'heroText' => 'ঢাকার যেকোনো স্থান খুঁজুন, বাস তুলনা করুন, সড়কের কাজ দেখুন এবং ভাড়া জানুন।',
        'start' => 'যাত্রা শুরুর স্থান',
        'destination' => 'কোথায় যাবেন?',
        'placePlaceholder' => 'ঢাকার যেকোনো স্থান লিখুন',
        'findRoutes' => 'বাস রুট খুঁজুন',
        'swap' => 'শুরুর স্থান ও গন্তব্য অদলবদল করুন',
        'useLocation' => 'আমার বর্তমান অবস্থান ব্যবহার করুন',
        'suggestions' => 'লিখতে শুরু করলে স্থানের পরামর্শ দেখা যাবে।',
        'findingLocation' => 'আপনার অবস্থান খোঁজা হচ্ছে…',
        'locationSelected' => 'বর্তমান অবস্থান নির্বাচন করা হয়েছে।',
        'locationUnavailable' => 'অবস্থান পাওয়া যায়নি। শুরুর স্থানটি লিখুন।',
        'locationUnsupported' => 'এই ব্রাউজারে অবস্থান সেবা নেই।',
        'quickAccess' => 'দ্রুত নির্বাচন',
        'whereGoing' => 'আপনি কোথায় যেতে চান?',
        'seeRoadUpdates' => 'সড়ক আপডেট দেখুন',
        'findBusesFrom' => 'এখান থেকে বাস খুঁজুন:',
        'changeJourney' => 'যাত্রা পরিবর্তন করুন',
        'journeyResults' => 'যাত্রার ফলাফল',
        'to' => 'থেকে',
        'routesFound' => 'টি বাস রুট পাওয়া গেছে',
        'trafficUpdated' => 'ট্রাফিক ২ মিনিট আগে আপডেট হয়েছে',
        'noDirectRoutes' => 'এই যাত্রার জন্য সরাসরি বাস পাওয়া যায়নি',
        'noDirectText' => 'কাছাকাছি কোনো প্রধান স্টপ চেষ্টা করুন অথবা সব বাস দেখুন।',
        'showAllBuses' => 'সব বাস দেখুন',
        'sort' => 'সাজান',
        'fastest' => 'দ্রুততম',
        'lowestFare' => 'সর্বনিম্ন ভাড়া',
        'bestFare' => 'সেরা ভাড়া',
        'every' => 'প্রতি',
        'duration' => 'সময়',
        'distance' => 'দূরত্ব',
        'estFare' => 'আনুমানিক ভাড়া',
        'viewRoute' => 'রুট দেখুন',
        'roadMayAffect' => 'সড়কের কাজ এই যাত্রায় প্রভাব ফেলতে পারে',
        'roadMayAffectText' => 'কাজীপাড়ার কাছে বেগম রোকেয়া সরণির একটি লেন সীমিত রয়েছে।',
        'viewUpdate' => 'আপডেট দেখুন',
        'backRoutes' => 'সব রুটে ফিরে যান',
        'selectedBus' => 'নির্বাচিত বাস',
        'stopsRoute' => 'এই রুটের স্টপসমূহ',
        'openGoogle' => 'গুগল ম্যাপে খুলুন',
        'checkRoad' => 'সড়ক আপডেট দেখুন',
        'googleRoute' => 'গুগল ম্যাপ রুট',
        'backPlanner' => 'যাত্রা পরিকল্পনায় ফিরুন',
        'liveStatus' => 'সরাসরি অবস্থা',
        'constructionTitle' => 'সড়ক নির্মাণ আপডেট',
        'constructionText' => 'ঢাকার চলমান মেরামত, বন্ধ লেন ও নির্মাণকাজ দেখে আপনার যাত্রা পরিকল্পনা করুন। প্রতিটি তথ্যের সর্বশেষ আপডেট সময় দেওয়া আছে।',
        'remaining' => 'বাকি',
        'updated' => 'আপডেট',
        'planDifferent' => 'অন্য যাত্রা পরিকল্পনা করুন',
        'activeDhaka' => 'ঢাকায় চলমান',
        'reportedWorks' => 'টি সড়কের কাজ',
        'lightTraffic' => 'হালকা যানজট',
        'moderateTraffic' => 'মাঝারি যানজট',
        'heavyTraffic' => 'ভারী যানজট',
        'highImpact' => 'উচ্চ প্রভাব',
        'mediumImpact' => 'মাঝারি প্রভাব',
        'lowImpact' => 'কম প্রভাব',
        'currentLocation' => 'বর্তমান অবস্থান, ঢাকা',
        'dbLiveStatus' => 'ডাটাবেজ: MySQL সংযুক্ত (dhaka_transit)',
        'dbFallbackStatus' => 'ডাটাবেজ: ডেমো ডামি ডাটা মোড (MySQL সংযুক্ত নেই)',
        'switchLang' => 'English',
        'sysReq1Title' => 'ওয়েব ভিত্তিক সিস্টেম',
        'sysReq1Desc' => 'HTML, CSS, JavaScript, PHP, এবং MySQL।',
        'sysReq2Title' => 'বহিঃস্থ নির্ভরতা',
        'sysReq2Desc' => 'ম্যাপ এবং ট্রাফিক সুবিধা বহিঃস্থ সেবা, ইন্টারনেট ও তথ্যের নির্ভুলতার উপর নির্ভরশীল।',
        'sysReq3Title' => 'রেসপনসিভ অ্যাক্সেস',
        'sysReq3Desc' => 'ডেস্কটপ, ট্যাবলেট এবং মোবাইল ব্রাউজার সমর্থন করে।'
    ]
];

/**
 * Translate helper function
 * @param string $key
 * @return string
 */
function t($key) {
    global $translations, $current_lang;
    if (isset($translations[$current_lang][$key])) {
        return $translations[$current_lang][$key];
    }
    return $translations['en'][$key] ?? $key;
}

/**
 * Returns current language code ('en' or 'bn')
 * @return string
 */
function getLanguage() {
    global $current_lang;
    return $current_lang;
}

