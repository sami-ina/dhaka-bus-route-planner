<?php
/**
 * Dhaka Bus Route Planner & Transit Information System
 * Core Data Functions & Search Logic
 *
 * Implements transparent dual-mode data sourcing:
 * 1. Live MySQL queries when the database is connected.
 * 2. Static Fallback Dummy Data when MySQL is offline.
 * Clearly flags and distinguishes data origin for transparency.
 */

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/maps.php';
require_once __DIR__ . '/i18n.php';

// =====================================================================
// FALLBACK DUMMY DATA DATASET
// (Used when MySQL is offline or tables have not been imported yet)
// =====================================================================

$DUMMY_PLACES = [
    'Abdullahpur' => 'আব্দুল্লাহপুর', 'Agargaon' => 'আগারগাঁও', 'Airport' => 'বিমানবন্দর',
    'Asad Gate' => 'আসাদ গেট', 'Azimpur' => 'আজিমপুর', 'Badda' => 'বাড্ডা',
    'Banani' => 'বনানী', 'Bashundhara' => 'বসুন্ধরা', 'Dhanmondi 27' => 'ধানমন্ডি ২৭',
    'Farmgate' => 'ফার্মগেট', 'Gabtoli' => 'গাবতলী', 'Gulistan' => 'গুলিস্তান',
    'Gulshan 1' => 'গুলশান ১', 'Jatrabari' => 'যাত্রাবাড়ী', 'Kakrail' => 'কাকরাইল',
    'Kalabagan' => 'কলাবাগান', 'Kazipara' => 'কাজীপাড়া', 'Khilgaon' => 'খিলগাঁও',
    'Malibagh' => 'মালিবাগ', 'Mirpur 1' => 'মিরপুর ১', 'Mirpur 10' => 'মিরপুর ১০',
    'Mohakhali' => 'মহাখালী', 'Motijheel' => 'মতিঝিল', 'New Market' => 'নিউ মার্কেট',
    'Paltan' => 'পল্টন', 'Rampura' => 'রামপুরা', 'Shahbagh' => 'শাহবাগ',
    'Shewrapara' => 'শেওড়াপাড়া', 'Shyamoli' => 'শ্যামলী', 'Technical' => 'টেকনিক্যাল',
    'Uttara' => 'উত্তরা', 'Wari' => 'ওয়ারী'
];

$DUMMY_BUSES = [
    [
        'id' => 1, 'bus' => 'Bahon Express', 'number' => 'B-17', 'duration' => '48 min',
        'duration_minutes' => 48, 'distance' => '12.4 km', 'distance_km' => 12.4, 'fare' => 45,
        'traffic' => 'moderate', 'color' => '#f59e0b', 'frequency' => '12–15 min', 'note' => 'Fastest route',
        'stops' => ['Mirpur 10', 'Kazipara', 'Shewrapara', 'Agargaon', 'Farmgate', 'Shahbagh', 'Paltan', 'Motijheel']
    ],
    [
        'id' => 2, 'bus' => 'Shikor Paribahan', 'number' => 'S-08', 'duration' => '42 min',
        'duration_minutes' => 42, 'distance' => '10.1 km', 'distance_km' => 10.1, 'fare' => 40,
        'traffic' => 'light', 'color' => '#18a572', 'frequency' => '15–20 min', 'note' => 'Less crowded',
        'stops' => ['Mirpur 10', 'Mirpur 1', 'Technical', 'Shyamoli', 'Dhanmondi 27', 'New Market', 'Azimpur']
    ],
    [
        'id' => 3, 'bus' => 'Bihanga Paribahan', 'number' => 'B-22', 'duration' => '55 min',
        'duration_minutes' => 55, 'distance' => '14.6 km', 'distance_km' => 14.6, 'fare' => 50,
        'traffic' => 'heavy', 'color' => '#ef6a54', 'frequency' => '18–22 min', 'note' => 'More seats',
        'stops' => ['Mirpur 10', 'Agargaon', 'Mohakhali', 'Gulshan 1', 'Badda']
    ],
    [
        'id' => 4, 'bus' => 'Airport Bangabandhu Avenue', 'number' => 'A-11', 'duration' => '49 min',
        'duration_minutes' => 49, 'distance' => '15.2 km', 'distance_km' => 15.2, 'fare' => 55,
        'traffic' => 'moderate', 'color' => '#3b82f6', 'frequency' => '10–15 min', 'note' => 'Airport route',
        'stops' => ['Uttara', 'Airport', 'Banani', 'Mohakhali', 'Farmgate', 'Shahbagh']
    ],
    [
        'id' => 5, 'bus' => 'Victor Classic', 'number' => 'V-05', 'duration' => '44 min',
        'duration_minutes' => 44, 'distance' => '11.8 km', 'distance_km' => 11.8, 'fare' => 40,
        'traffic' => 'heavy', 'color' => '#8b5cf6', 'frequency' => '12–18 min', 'note' => 'City route',
        'stops' => ['Badda', 'Rampura', 'Malibagh', 'Kakrail', 'Paltan', 'Motijheel']
    ],
    [
        'id' => 6, 'bus' => 'Turag Transport', 'number' => 'T-19', 'duration' => '58 min',
        'duration_minutes' => 58, 'distance' => '16.3 km', 'distance_km' => 16.3, 'fare' => 60,
        'traffic' => 'moderate', 'color' => '#0ea5a4', 'frequency' => '15–20 min', 'note' => 'Long route',
        'stops' => ['Jatrabari', 'Gulistan', 'Paltan', 'Shahbagh', 'Farmgate', 'Mohakhali']
    ],
    [
        'id' => 7, 'bus' => 'Achim Paribahan', 'number' => 'A-07', 'duration' => '52 min',
        'duration_minutes' => 52, 'distance' => '13.9 km', 'distance_km' => 13.9, 'fare' => 50,
        'traffic' => 'light', 'color' => '#db2777', 'frequency' => '14–18 min', 'note' => 'Popular route',
        'stops' => ['Gabtoli', 'Shyamoli', 'Asad Gate', 'Dhanmondi 27', 'Kalabagan', 'Shahbagh', 'Gulistan']
    ],
    [
        'id' => 8, 'bus' => 'Raida Enterprise', 'number' => 'R-03', 'duration' => '47 min',
        'duration_minutes' => 47, 'distance' => '14.1 km', 'distance_km' => 14.1, 'fare' => 50,
        'traffic' => 'moderate', 'color' => '#ca8a04', 'frequency' => '10–16 min', 'note' => 'Northern route',
        'stops' => ['Abdullahpur', 'Uttara', 'Airport', 'Bashundhara', 'Badda', 'Rampura']
    ]
];

$DUMMY_ROAD_UPDATES = [
    [
        'id' => 1, 'road' => 'Begum Rokeya Avenue', 'roadBn' => 'বেগম রোকেয়া সরণি',
        'area' => 'Kazipara to Shewrapara', 'areaBn' => 'কাজীপাড়া থেকে শেওড়াপাড়া',
        'status' => 'Lane restricted', 'statusBn' => 'লেন সীমিত',
        'remaining' => '12 days', 'remainingBn' => '১২ দিন',
        'level' => 'High impact', 'updated' => '8 min ago', 'updatedBn' => '৮ মিনিট আগে',
        'detail' => 'Utility relocation is restricting the left lane. Use Mirpur Road through Agargaon as an alternative.',
        'detailBn' => 'ইউটিলিটি স্থানান্তরের কারণে বাম লেন সীমিত। বিকল্প হিসেবে আগারগাঁও হয়ে মিরপুর রোড ব্যবহার করুন।'
    ],
    [
        'id' => 2, 'road' => 'Airport Road', 'roadBn' => 'বিমানবন্দর সড়ক',
        'area' => 'Banani rail crossing', 'areaBn' => 'বনানী রেল ক্রসিং',
        'status' => 'Night work only', 'statusBn' => 'শুধু রাতে কাজ',
        'remaining' => '5 days', 'remainingBn' => '৫ দিন',
        'level' => 'Low impact', 'updated' => '24 min ago', 'updatedBn' => '২৪ মিনিট আগে',
        'detail' => 'Resurfacing work runs from 11:00 PM to 5:00 AM. Daytime traffic is operating normally.',
        'detailBn' => 'রাত ১১টা থেকে ভোর ৫টা পর্যন্ত সড়ক মেরামত চলে। দিনের বেলা যান চলাচল স্বাভাবিক।'
    ],
    [
        'id' => 3, 'road' => 'Moghbazar Flyover', 'roadBn' => 'মগবাজার ফ্লাইওভার',
        'area' => 'Moghbazar intersection', 'areaBn' => 'মগবাজার মোড়',
        'status' => 'One lane closed', 'statusBn' => 'একটি লেন বন্ধ',
        'remaining' => '8 days', 'remainingBn' => '৮ দিন',
        'level' => 'Medium impact', 'updated' => '41 min ago', 'updatedBn' => '৪১ মিনিট আগে',
        'detail' => 'Expansion joint repair is underway. Expect delays during the evening peak period.',
        'detailBn' => 'এক্সপ্যানশন জয়েন্ট মেরামত চলছে। সন্ধ্যার ব্যস্ত সময়ে বিলম্ব হতে পারে।'
    ]
];

// =====================================================================
// DATA FETCHING & QUERY FUNCTIONS
// =====================================================================

/**
 * Retrieves all Dhaka places.
 * Queries MySQL `places` table if connected; otherwise falls back to dummy data.
 *
 * @param string &$dataSource Outputs 'MySQL Database' or 'Fallback Dummy Data'
 * @return array Associative array [EnglishName => BengaliName]
 */
function getAllPlaces(&$dataSource = null) {
    global $DUMMY_PLACES;
    $db = getDB();

    if ($db) {
        try {
            $stmt = $db->query("SELECT name_en, name_bn FROM places ORDER BY name_en ASC");
            $places = [];
            while ($row = $stmt->fetch()) {
                $places[$row['name_en']] = $row['name_bn'];
            }
            if (!empty($places)) {
                $dataSource = 'MySQL Database';
                return $places;
            }
        } catch (PDOException $e) {
            // Log and fallback
        }
    }

    $dataSource = 'Fallback Dummy Data';
    return $DUMMY_PLACES;
}

/**
 * Converts a place name to the requested language.
 *
 * @param string $place Name in English or Bengali
 * @param string $language 'en' or 'bn'
 * @return string
 */
function displayPlace($place, $language = null) {
    if ($language === null) {
        $language = getLanguage();
    }
    $allPlaces = getAllPlaces();

    // Check if the input is already in Bangla
    $englishPlace = $place;
    foreach ($allPlaces as $en => $bn) {
        if ($bn === $place) {
            $englishPlace = $en;
            break;
        }
    }

    if ($language === 'bn') {
        return $allPlaces[$englishPlace] ?? $place;
    }
    return $englishPlace;
}

/**
 * Canonicalizes place name for robust matching.
 */
function canonicalPlace($place) {
    $allPlaces = getAllPlaces();
    $placeTrim = trim($place);
    foreach ($allPlaces as $en => $bn) {
        if ($bn === $placeTrim || strcasecmp($en, $placeTrim) === 0) {
            return strtolower($en);
        }
    }
    return strtolower($placeTrim);
}

/**
 * Retrieves all bus routes with their sequential stops.
 *
 * @param string &$dataSource
 * @return array
 */
function getAllBuses(&$dataSource = null) {
    global $DUMMY_BUSES;
    $db = getDB();

    if ($db) {
        try {
            $sql = "SELECT b.id, b.bus_name AS bus, b.bus_number AS number, b.duration_text AS duration,
                           b.duration_minutes, b.distance_text AS distance, b.distance_km, b.fare,
                           b.traffic_condition AS traffic, b.badge_color AS color, b.frequency, b.note
                    FROM buses b
                    WHERE b.is_active = 1
                    ORDER BY b.id ASC";
            $stmt = $db->query($sql);
            $buses = $stmt->fetchAll();

            if (!empty($buses)) {
                // Fetch stops for each bus
                $stopsStmt = $db->prepare("SELECT stop_name FROM bus_stops WHERE bus_id = ? ORDER BY stop_order ASC");
                foreach ($buses as &$bus) {
                    $stopsStmt->execute([$bus['id']]);
                    $bus['stops'] = $stopsStmt->fetchAll(PDO::FETCH_COLUMN);
                }
                unset($bus);

                $dataSource = 'MySQL Database';
                return $buses;
            }
        } catch (PDOException $e) {
            // fallback
        }
    }

    $dataSource = 'Fallback Dummy Data';
    return $DUMMY_BUSES;
}

/**
 * Finds all buses operating between two places.
 *
 * @param string $from Origin
 * @param string $to Destination
 * @param string &$dataSource
 * @return array
 */
function searchBuses($from, $to, &$dataSource = null) {
    $origin = canonicalPlace($from);
    $destination = canonicalPlace($to);
    $allBuses = getAllBuses($dataSource);

    $matched = [];
    foreach ($allBuses as $bus) {
        $stopsLower = array_map('strtolower', $bus['stops']);

        $fromIndex = -1;
        $toIndex = -1;

        foreach ($stopsLower as $idx => $stop) {
            if ($fromIndex === -1 && (strpos($stop, $origin) !== false || strpos($origin, $stop) !== false)) {
                $fromIndex = $idx;
            }
            if ($toIndex === -1 && (strpos($stop, $destination) !== false || strpos($destination, $stop) !== false)) {
                $toIndex = $idx;
            }
        }

        if ($fromIndex !== -1 && $toIndex !== -1 && $fromIndex !== $toIndex) {
            $matched[] = $bus;
        }
    }

    return $matched;
}

/**
 * Gets a specific bus by ID.
 *
 * @param int $id
 * @param string &$dataSource
 * @return array|null
 */
function getBusById($id, &$dataSource = null) {
    $buses = getAllBuses($dataSource);
    foreach ($buses as $bus) {
        if ((int)$bus['id'] === (int)$id) {
            return $bus;
        }
    }
    return $buses[0] ?? null;
}

/**
 * Retrieves all road construction updates.
 *
 * @param string &$dataSource
 * @return array
 */
function getAllRoadUpdates(&$dataSource = null) {
    global $DUMMY_ROAD_UPDATES;
    $db = getDB();

    if ($db) {
        try {
            $stmt = $db->query("SELECT id, road_en AS road, road_bn AS roadBn, area_en AS area, area_bn AS areaBn,
                                       status_en AS status, status_bn AS statusBn, remaining_en AS remaining,
                                       remaining_bn AS remainingBn, impact_level AS level, updated_en AS updated,
                                       updated_bn AS updatedBn, detail_en AS detail, detail_bn AS detailBn
                                FROM road_updates
                                ORDER BY id ASC");
            $rows = $stmt->fetchAll();
            if (!empty($rows)) {
                $dataSource = 'MySQL Database';
                return $rows;
            }
        } catch (PDOException $e) {
            // fallback
        }
    }

    $dataSource = 'Fallback Dummy Data';
    return $DUMMY_ROAD_UPDATES;
}

/**
 * Localizes time/duration units for Bengali.
 */
function localUnit($value, $lang = null) {
    if ($lang === null) {
        $lang = getLanguage();
    }
    if ($lang === 'bn') {
        $value = str_replace('min', 'মিনিট', $value);
        $value = str_replace('km', 'কিমি', $value);
    }
    return $value;
}

/**
 * Sanitizes output for safe HTML display.
 */
function e($string) {
    return htmlspecialchars((string)$string, ENT_QUOTES, 'UTF-8');
}

