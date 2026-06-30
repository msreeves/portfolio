<?php
declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

$id = (int) ($_GET['id'] ?? 0);
if ($id <= 0) {
    movie_api_json(400, [
        'ok' => false,
        'error' => 'Missing or invalid id parameter.',
    ]);
}

$key = movie_api_key();
if ($key === '') {
    movie_api_json(500, [
        'ok' => false,
        'error' => 'TMDB API key is not configured.',
    ]);
}

$remoteUrl = MOVIE_API_TMDB_BASE . '/movie/' . $id . '?api_key=' . rawurlencode($key);
$cacheFile = movie_api_cache_dir() . '/' . movie_api_cache_key('movie', (string) $id);
$raw = movie_api_cache_read($cacheFile);

if ($raw === null) {
    $http = movie_api_http_get($remoteUrl);
    if ($http['error'] !== '') {
        movie_api_json(502, [
            'ok' => false,
            'error' => 'Failed to contact movie service.',
            'detail' => $http['error'],
        ]);
    }
    if ($http['status'] === 429) {
        movie_api_json(429, [
            'ok' => false,
            'error' => 'Movie service rate limit reached. Please retry shortly.',
        ]);
    }
    if ($http['status'] === 404) {
        movie_api_json(404, [
            'ok' => false,
            'error' => 'Movie not found.',
        ]);
    }
    if ($http['status'] < 200 || $http['status'] >= 300) {
        movie_api_json(502, [
            'ok' => false,
            'error' => 'Movie service returned an unexpected response.',
            'status' => $http['status'],
        ]);
    }
    $raw = $http['body'];
    movie_api_cache_write($cacheFile, $raw);
}

$decoded = json_decode($raw, true);
if (!is_array($decoded)) {
    movie_api_json(502, [
        'ok' => false,
        'error' => 'Invalid response from movie service.',
    ]);
}

$normalized = movie_api_normalize_movie($decoded);
$genres = [];
foreach (($decoded['genres'] ?? []) as $genreRow) {
    if (!is_array($genreRow)) {
        continue;
    }
    $g = trim((string) ($genreRow['name'] ?? ''));
    if ($g !== '') {
        $genres[] = $g;
    }
}

$normalized['runtime'] = isset($decoded['runtime']) ? (int) $decoded['runtime'] : null;
$normalized['genres'] = $genres;
$normalized['tagline'] = trim((string) ($decoded['tagline'] ?? ''));

movie_api_json(200, [
    'ok' => true,
    'movie' => $normalized,
]);
