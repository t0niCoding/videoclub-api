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
            $response = self::getClient()->get(self::normalizeEndpoint($endpoint), [
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
                'base_uri' => config('services.tmdb.base_url'),
                'timeout' => 10.0,
                'headers' => [
                    'Authorization' => 'Bearer ' . config('services.tmdb.api_key'),
                    'Accept' => 'application/json',
                ],
                // 'verify' => true, // Habilitar en producción
            ]);
        }
        
        return self::$client;
    }

    private static function normalizeEndpoint(string $endpoint): string
    {
        return ltrim($endpoint, '/');
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

    /*
    public static function getApi(string $endpoint, array $params = []): array
    {
        $baseUrl = config('services.tmdb.base_url');
        $apiKey = config('services.tmdb.api_key');
    
        //$params['api_key'] = $params['api_key'] ?? $apiKey; 
        //$params['language'] = $params['language'] ?? 'en-US';
        //$params['page'] = $params['page'] ?? 1;

        $client = new Client([
            'base_uri' => $baseUrl,
            'timeout'  => 10.0,
            'verify' => false,  // Desactivar verificación SSL (activar mas adelante)
        ]);

       // $endpoint = ltrim($endpoint, '/');
        
        $fullUrl = $baseUrl . '/' . $endpoint;

        try {
          
            $response = $client->request('GET', $fullUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Accept' => 'application/json',
                ],
                'query' => $params,
            ]);
            
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {

            Log::error('TMDB API Error', [
                'error_message' => $e->getMessage(),
                'error_details' => $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : 'No response body available'
            ]);
            throw new \Exception('TMDB API request failed: ' . $e->getMessage());
        }
    }*/
}
