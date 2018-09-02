<?php namespace App\Services\Exchanges;

use GuzzleHttp\Client as GuzzleClient;
use Guzzle\Stream\PhpStreamRequestFactory;
use GuzzleHttp\Exception\ClientException;

class BtcTradeUa extends AbstractExchangeService
{
    const API_URL = 'https://btc-trade.com.ua/api/';
    const API_TICKER = 'https://btc-trade.com.ua/api/ticker';
    const API_ASKS = 'https://btc-trade.com.ua/api/trades/sell/';
    const API_BIDS = 'https://btc-trade.com.ua/api/trades/buy/';

    protected $pairs = [];


    public function getAsks($pair, $limit = 10)
    {
        $client = clone $this->client;
        try {
            $response = $client->get(static::API_ASKS . $pair);
            $asks = json_decode($response->getBody()->getContents());
            return $this->convertItemsToArray(array_slice($asks->list, 0, $limit));
        } catch (\Exception $e) {

        }

    }

    public function getBids($pair, $limit = 10)
    {
        $client = clone $this->client;
        try {
            $response = $client->get(static::API_BIDS . $pair);
            $bids = json_decode($response->getBody()->getContents());
            return $this->convertItemsToArray(array_slice($bids->list, 0, $limit));
        } catch (\Exception $e) {

        }
    }

    protected function convertItemsToArray($items){
        $data = [];
        foreach ($items as $item){
            if(is_object($item)){
                $item = [$item->price,$item->currency_trade,$item->currency_base];
            }
            $data[] = $item;
        }
        return $data;
    }

}