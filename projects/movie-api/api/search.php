<?php
declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

$query = trim((string) ($_GET['query'] ?? ''));
$page = max(1, (int) ($_GET['page'] ?? 1));

if ($query === '') {
    movie_api_json(400, [
        'ok' => false,
        'error' => 'Missing query parameter.',
    ]);
}

$key = movie_api_key();
if ($key === '') {
    movie_api_json(500, [
        'ok' => false,
        'error' => 'TMDB API key is not configured.',
    ]);
}

$remoteUrl = MOVIE_API_TMDB_BASE . '/search/movie?api_key=' . rawurlencode($key)
    . '&query=' . rawurlencode($query)
    . '&page=' . $page
    . '&include_adult=false';

$cacheFile = movie_api_cache_dir() . '/' . movie_api_cache_key('search', $query . '|' . $page);
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

$results = [];
foreach (($decoded['results'] ?? []) as $row) {
    if (!is_array($row)) {
        continue;
    }
    $normalized = movie_api_normalize_movie($row);
    if ((int) $normalized['id'] <= 0 || (string) $normalized['title'] === '') {
        continue;
    }
    $results[] = $normalized;
}

movie_api_json(200, [
    'ok' => true,
    'query' => $query,
    'page' => max(1, (int) ($decoded['page'] ?? $page)),
    'totalPages' => max(1, (int) ($decoded['total_pages'] ?? 1)),
    'totalResults' => max(0, (int) ($decoded['total_results'] ?? 0)),
    'results' => $results,
]);
