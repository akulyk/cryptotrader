<?php namespace App\Services\Exchanges;

use GuzzleHttp\Client as GuzzleClient;
use Guzzle\Stream\PhpStreamRequestFactory;
use GuzzleHttp\Exception\ClientException;

class Kuna extends AbstractExchangeService
{
    const API_URL = 'https://kuna.io/api/v2/';
    const API_TICKER = 'https://kuna.io/api/v2/tickers';
    const API_DEPTH = 'https://kuna.io/api/v2/depth?market=';

    public function getDepth($pair){
        $pair = $this->normalizePair($pair);
        $client = clone $this->client;
        try {
            $response = $client->get(static::API_DEPTH . $pair);

            return $response->getBody()->getContents();
        } catch (ClientException $e){

        }
    }

    public function getAsks($pair,$limit = 10){
     if($depth = $this->getDepth($pair)){
       $depth = json_decode($depth);
         asort($depth->asks);
       return array_slice($depth->asks,0,$limit);
     }

    }
    public function getBids($pair,$limit = 10){
        if($depth = $this->getDepth($pair)){
            $depth = json_decode($depth);
            return array_slice($depth->bids,0,$limit);
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