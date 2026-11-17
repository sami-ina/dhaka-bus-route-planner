<?php
/**
 * Google Maps Integration & Configuration
 *
 * This configuration manages:
 * 1. Optional Google Maps JavaScript API Key
 * 2. Fallback Google Maps Embed URL generation (no API key required)
 * 3. Direct Google Maps Transit Directions deep links
 */

// If you have a Google Maps JavaScript API key, insert it here:
define('GOOGLE_MAPS_API_KEY', '');

// Default center coordinates for Dhaka city
define('DHAKA_DEFAULT_LAT', 23.8103);
define('DHAKA_DEFAULT_LNG', 90.4125);
define('DHAKA_DEFAULT_ZOOM', 12);

/**
 * Generates an embedded Google Maps URL for an origin and destination transit route.
 * Works out-of-the-box in iframes without requiring a paid API key.
 *
 * @param string $origin Starting place in Dhaka
 * @param string $destination Ending place in Dhaka
 * @return string
 */
function getGoogleMapsEmbedUrl($origin, $destination) {
    $originParam = urlencode(trim($origin) . ', Dhaka, Bangladesh');
    $destParam   = urlencode(trim($destination) . ', Dhaka, Bangladesh');
    return "https://www.google.com/maps?output=embed&saddr={$originParam}&daddr={$destParam}&travelmode=transit";
}

/**
 * Generates an embedded Google Maps URL for general Dhaka area or road updates.
 *
 * @param string $query Query location or coordinates
 * @param int $zoom Zoom level (1-20)
 * @return string
 */
function getGoogleMapsAreaEmbedUrl($query = 'Dhaka, Bangladesh', $zoom = 12) {
    $queryParam = urlencode($query);
    return "https://www.google.com/maps?output=embed&q={$queryParam}&z={$zoom}";
}

/**
 * Generates an external deep-link to Google Maps Transit Directions.
 * Opens the full interactive Google Maps app on mobile or desktop.
 *
 * @param string $origin
 * @param string $destination
 * @return string
 */
function getGoogleMapsExternalDirectionsUrl($origin, $destination) {
    $originParam = urlencode(trim($origin) . ', Dhaka, Bangladesh');
    $destParam   = urlencode(trim($destination) . ', Dhaka, Bangladesh');
    return "https://www.google.com/maps/dir/?api=1&origin={$originParam}&destination={$destParam}&travelmode=transit";
}

