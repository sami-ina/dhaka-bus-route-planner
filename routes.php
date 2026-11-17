<?php
/**
 * Dhaka Bus Route Planner & Transit Information System
 * REST API: Bus Route Search Endpoint
 * Response format: JSON
 */

header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../includes/functions.php';

$from = trim($_GET['from'] ?? '');
$to   = trim($_GET['to']   ?? '');

$dataSource = '';
if (!empty($from) && !empty($to)) {
    $results = searchBuses($from, $to, $dataSource);
} else {
    $results = getAllBuses($dataSource);
}

echo json_encode([
    'status' => 'success',
    'query' => [
        'from' => $from,
        'to' => $to
    ],
    'data_source' => $dataSource,
    'total' => count($results),
    'routes' => $results
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

