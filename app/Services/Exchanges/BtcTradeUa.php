<?php namespace App\Services\Exchanges;

use GuzzleHttp\Client as GuzzleClient;
use Guzzle\Stream\PhpStreamRequestFactory;

class BtcTradeUa extends AbstractExchangeService
{
    const API_URL = 'https://btc-trade.com.ua/api/';
    const API_TICKER = 'https://btc-trade.com.ua/api/ticker';
    const API_ASKS = 'https://btc-trade.com.ua/api/trades/sell/';
    const API_BIDS = 'https://btc-trade.com.ua/api/trades/buy/';

    protected $pairs = [];


    public function getAsks($pair){
       $client = clone $this->client;
       $response = $client->get(static::API_ASKS.$pair);
       return $response->getBody()->getContents();

    }
    public function getBids($pair){
        $client = clone $this->client;
        $response = $client->get(static::API_BIDS.$pair);
    }

}