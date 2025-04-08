<?php 

namespace App\ETL\Connection;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class TmdbConnection
{

    private static ?Client $client = null;

    public static function getApi(string $endpoint, array $params = []): array
    {
        try {
            $client = self::getClient();
            $url = self::buildUrl($endpoint);
            
            $response = $client->get($url, [
                'query' => array_filter($params),
            ]);
            
            return json_decode($response->getBody(), true) ?: [];
        } catch (RequestException $e) {
            self::logError($e);
            throw new \Exception('TMDB API request failed: ' . $e->getMessage());
        }
    }

    private static function getClient(): Client
    {
        if (self::$client === null) {
            self::$client = new Client([
                'timeout' => 10.0,
                'headers' => [
                    'Authorization' => 'Bearer ' . config('services.tmdb.api_key'),
                    'Accept' => 'application/json',
                ],
                'verify' => false,
            ]);
        }
        
        return self::$client;
    }

    private static function buildUrl(string $endpoint): string
    {
        $baseUrl = rtrim(config('services.tmdb.base_url'), '/');
        $endpoint = ltrim($endpoint, '/');
        
        return "{$baseUrl}/{$endpoint}";
    }

    private static function logError(RequestException $e): void
    {
        Log::error('TMDB API Error', [
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
            'response' => $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : null,
            'uri' => $e->getRequest()->getUri(),
        ]);
    }
}
