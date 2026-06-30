<?php
declare(strict_types=1);

const MOVIE_API_TMDB_BASE = 'https://api.themoviedb.org/3';
const MOVIE_API_IMAGE_BASE = 'https://image.tmdb.org/t/p/w500';
const MOVIE_API_CACHE_TTL_SECONDS = 300;

/**
 * Return TMDB API key.
 */
function movie_api_key(): string
{
    $env = trim((string) getenv('TMDB_API_KEY'));
    if ($env !== '') {
        return $env;
    }

    // Fallback keeps local dev functional if env var is not set.
    return 'b7edac97c062531f29b57a28262b887c';
}

/**
 * Send JSON response.
 * @param array<string,mixed> $payload
 */
function movie_api_json(int $statusCode, array $payload): void
{
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

/**
 * @return array{status:int,body:string,error:string}
 */
function movie_api_http_get(string $url): array
{
    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CONNECTTIMEOUT => 8,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_HTTPHEADER => ['Accept: application/json'],
            CURLOPT_USERAGENT => 'LocalMovieApi/1.0',
        ]);
        $body = curl_exec($ch);
        $err = $body === false ? (string) curl_error($ch) : '';
        $status = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);

        return [
            'status' => $status,
            'body' => is_string($body) ? $body : '',
            'error' => $err,
        ];
    }

    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'timeout' => 15,
            'header' => "Accept: application/json\r\nUser-Agent: LocalMovieApi/1.0\r\n",
        ],
    ]);
    $body = @file_get_contents($url, false, $context);
    $status = 0;
    $headers = function_exists('http_get_last_response_headers')
        ? (http_get_last_response_headers() ?: [])
        : ($http_response_header ?? []);
    if (isset($headers[0]) && preg_match('#\s(\d{3})\s#', (string) $headers[0], $m) === 1) {
        $status = (int) $m[1];
    }

    return [
        'status' => $status,
        'body' => is_string($body) ? $body : '',
        'error' => $body === false ? 'HTTP request failed.' : '',
    ];
}

function movie_api_cache_dir(): string
{
    $dir = __DIR__ . '/cache';
    if (!is_dir($dir)) {
        @mkdir($dir, 0775, true);
    }

    return $dir;
}

function movie_api_cache_key(string $prefix, string $value): string
{
    return $prefix . '_' . sha1($value) . '.json';
}

function movie_api_cache_read(string $cacheFile): ?string
{
    if (!is_file($cacheFile)) {
        return null;
    }
    $mtime = @filemtime($cacheFile);
    if (!is_int($mtime) || (time() - $mtime) > MOVIE_API_CACHE_TTL_SECONDS) {
        return null;
    }
    $content = @file_get_contents($cacheFile);
    return is_string($content) ? $content : null;
}

function movie_api_cache_write(string $cacheFile, string $content): void
{
    @file_put_contents($cacheFile, $content, LOCK_EX);
}

function movie_api_poster_url(?string $posterPath): string
{
    $path = trim((string) $posterPath);
    if ($path === '' || $path === 'null') {
        return '';
    }
    if ($path[0] !== '/') {
        $path = '/' . $path;
    }

    return MOVIE_API_IMAGE_BASE . $path;
}

/**
 * @param array<string,mixed> $movie
 * @return array<string,mixed>
 */
function movie_api_normalize_movie(array $movie): array
{
    $id = isset($movie['id']) ? (int) $movie['id'] : 0;
    $title = trim((string) ($movie['title'] ?? $movie['original_title'] ?? ''));
    $overview = trim((string) ($movie['overview'] ?? ''));
    $releaseDate = trim((string) ($movie['release_date'] ?? ''));
    $rating = isset($movie['vote_average']) ? (float) $movie['vote_average'] : null;
    $posterPath = trim((string) ($movie['poster_path'] ?? ''));

    return [
        'id' => $id,
        'title' => $title,
        'overview' => $overview,
        'releaseDate' => $releaseDate,
        'rating' => $rating,
        'posterPath' => $posterPath,
        'posterUrl' => movie_api_poster_url($posterPath),
    ];
}
