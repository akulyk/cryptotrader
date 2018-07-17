<?php namespace App\Services\Exchanges;


class Exmo extends AbstractExchangeService
{
    const API_URL = 'https://api.exmo.com/v1/';
    const API_TICKER = 'https://kuna.io/api/v2/tickers';
    const API_DEPTH = 'https://api.exmo.com/v1/order_book/?pair=';

    protected $pairs = [];

    public function getDepth($pair,$limit=10){
        $pair = $this->normalizePair($pair);
        $client = clone $this->client;
        $response = $client->get(static::API_DEPTH.$pair.'&limit='.$limit);
        return $response->getBody()->getContents();
    }

    public function getAsks($pair,$limit = 10){
     if($depth = $this->getDepth($pair,$limit)){
       $depth = json_decode($depth);
       $pair = $this->normalizePair($pair);
       if(property_exists($depth,$pair)) {
           $ask = $depth->$pair->ask;
           return array_slice($ask, 0, 10);
       }
     }

    }
    public function getBids($pair,$limit = 10){
        if($depth = $this->getDepth($pair,$limit)){
            $depth = json_decode($depth);
            $pair = $this->normalizePair($pair);
            if(property_exists($depth,$pair)) {
                $bid = $depth->$pair->bid;
                return array_slice($bid, 0, 10);
            }
        }
    }

    public function deposit($currency){
       $deposit = config('stock-exchanges.exmo.deposit');
        if(isset($deposit[$currency])){
            return $deposit[$currency];
        }
    }
    public function withdraw($currency){
       $withdraw = config('stock-exchanges.exmo.withdraw');
       if(isset($withdraw[$currency])){
           return $withdraw[$currency];
       }
    }

    protected function normalizePair($pair){
       $pair = mb_strtoupper($pair);

        return $pair;
    }


}