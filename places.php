<?php
/**
 * Dhaka Bus Route Planner & Transit Information System
 * REST API: Dhaka Places Endpoint
 * Response format: JSON
 */

header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../includes/functions.php';

$dataSource = '';
$placesMap = getAllPlaces($dataSource);

$placesList = [];
foreach ($placesMap as $en => $bn) {
    $placesList[] = [
        'name_en' => $en,
        'name_bn' => $bn
    ];
}

echo json_encode([
    'status' => 'success',
    'data_source' => $dataSource,
    'total' => count($placesList),
    'places' => $placesList
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

