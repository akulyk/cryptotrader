<?php namespace App\Services\Exchanges;

use GuzzleHttp\Client as GuzzleClient;
use Guzzle\Stream\PhpStreamRequestFactory;
use GuzzleHttp\Exception\ClientException;

class Kuna
{
    const API_URL = 'https://kuna.io/api/v2/';
    const API_TICKER = 'https://kuna.io/api/v2/tickers';
    const API_DEPTH = 'https://kuna.io/api/v2/depth?market=';
    /**
     * @var GuzzleClient
     */
    protected $client;
    protected $pairs = [];

    public function __construct(GuzzleClient $client)
    {

        $this->client = $client;
    }

    public function getDepth($pair){
        $pair = $this->normalizePair($pair);
        $client = clone $this->client;
        try {
            $response = $client->get(static::API_DEPTH . $pair);

            return $response->getBody()->getContents();
        } catch (ClientException $e){

        }
    }

    public function getAsks($pair){
     if($depth = $this->getDepth($pair)){
       $depth = json_decode($depth);
       return array_slice($depth->asks,0,10);
     }

    }
    public function getBids($pair){
        if($depth = $this->getDepth($pair)){
            $depth = json_decode($depth);
            return array_slice($depth->bids,0,10);
        }
    }

    protected function normalizePair($pair){
        if(strpos($pair,'_')!== false){
            $pair = str_replace('_','',$pair);
        }

        if(strpos($pair,'-')!== false){
            $pair = str_replace('-','',$pair);
        }

        return $pair;
    }

}