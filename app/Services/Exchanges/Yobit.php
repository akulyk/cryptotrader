<?php namespace App\Services\Exchanges;

class Yobit extends AbstractExchangeService
{
    const API_INFO = 'https://yobit.net/api/3/info';
    const API_DEPTH = 'https://yobit.net/api/3/depth/';
    const API_TICKET = 'https://yobit.net/api/3/ticker/';
    const API_TRADES = 'https://yobit.net/api/3/trades/';

    protected $pairs = [];


    public function getInfo()
    {
        $client = clone $this->client;
        $response = $client->get(static::API_INFO);
        return $response->getBody();
    }

    public function getPairs()
    {
        if (count($this->pairs) == 0) {
            if ($response = json_decode($this->getInfo())) {
                $this->pairs = array_keys((array)$response->pairs);
            }
        }
        return $this->pairs;
    }

    public function getDepth($pair,$limit = 10){
        if(in_array($pair,$this->getPairs())){
            $url = static::API_DEPTH.$pair.'?limit='.$limit;
            $client = clone $this->client;
            if($response =  $client->get($url)){
                if($body = $response->getBody()){
                    return json_decode($body->getContents());
                }
            }
        }
    }

    public function getAsks($pair,$limit = 10){
        if($depth = $this->getDepth($pair,$limit)){
            $asks = $depth->{$pair}->asks;
            return $asks;
        }
    }
    public function getBids($pair,$limit = 10){
        if($depth = $this->getDepth($pair,$limit)){
            $bids = $depth->{$pair}->bids;
            return $bids;
        }
    }

}