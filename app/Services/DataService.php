<?php namespace App\Services;
use Illuminate\Support\Facades\Cache;

class DataService
{
    protected $lastUpdated;

    protected $usd_uah = 28.2;

    protected $cacheDuration = 10;

    protected $itemsLimit = 3;

    protected $pairs = [
        'btc_usd',
        'eth_usd',
        'zec_usd',
        'ltc_usd',
        'nmc_usd',
        'nvc_usd',
        'ppc_usd',
        'btc_uah',
        'eth_uah',
        'zec_uah',
        'ltc_uah',
    ];

    protected $stocks = [
      'yobit'=> \App\Services\Exchanges\Yobit::class,
      'exmo' => \App\Services\Exchanges\Exmo::class,
      'kuna' => \App\Services\Exchanges\Kuna::class,
      'wex' => \App\Services\Exchanges\Wex::class,
      'btcTradeUa' => \App\Services\Exchanges\BtcTradeUa::class,
    ];

    public function getInfo($pair = null){
        if($pair){
            $pairs = [$pair];
        } else{
            $pairs = $this->getPairs();
        }
        $data = $this->getData($pairs,$this->itemsLimit,$this->cacheDuration);

        $asks = $this->normalizeAsks($data['asks']);
        $bids = $this->normalizeBids($data['bids']);

        $min = $this->getMinValues($asks,$bids);
        $max = $this->getMaxValues($asks,$bids);

        $items = $this->normalizeData($pairs,$asks,$bids,$min,$max);
        return $items;
    }

    public function getLastUpdated(){
        return $this->lastUpdated;
    }

    public function getPairs(){
        return $this->pairs;
    }

    protected function getData($pairs,$limit = 3,$cacheMinutes = 3){
        $data = Cache::get('trades', []);
        $this->lastUpdated = Cache::get('lastUpdateTime', date("d.m.Y H:i:s"));
        if (count($data) == 0) {
            $yobit = app()->make($this->getStock('yobit'));
            $exmo = app()->make($this->getStock('exmo'));
            $kuna = app()->make($this->getStock('kuna'));
            $wex = app()->make($this->getStock('wex'));
            $btcTradeUa = app()->make($this->getStock('btcTradeUa'));

            if (isset($pairs) && count($pairs) > 0) {
                foreach ($pairs as $pair) {
                    $data['bids'][$pair]['kuna'] = $kuna->getBids($pair, $limit);
                    $data['bids'][$pair]['exmo'] = $exmo->getBids($pair, $limit);
                    $data['bids'][$pair]['yobit'] = $yobit->getBids($pair, $limit);
                    $data['bids'][$pair]['wex'] = $wex->getBids($pair, $limit);
                    $data['bids'][$pair]['btcTradeUa'] = $btcTradeUa->getBids($pair, $limit);
                    $data['asks'][$pair]['kuna'] = $kuna->getAsks($pair, $limit);
                    $data['asks'][$pair]['exmo'] = $exmo->getAsks($pair, $limit);
                    $data['asks'][$pair]['yobit'] = $yobit->getAsks($pair, $limit);
                    $data['asks'][$pair]['wex'] = $wex->getAsks($pair, $limit);
                    $data['asks'][$pair]['btcTradeUa'] = $btcTradeUa->getAsks($pair, $limit);
                }
            }
            Cache::put('trades', $data, $cacheMinutes);
            Cache::put('lastUpdateTime',$this->lastUpdated,$cacheMinutes);
        }

        return $data;
    }

    protected function getMinValues($asks,$bids){
        $min = ['ask'=>[],'bid'=>[]];
        foreach ($asks as $currency=> $items){
            $min['ask'][$currency] = $this->getMin($items);
        }
        foreach ($bids as $currency => $items){

            $min['bid'][$currency] = $this->getMin($items);
        }
        return $min;
    }

    protected function getMaxValues($asks,$bids){
        $max = ['ask'=>[],'bid'=>[]];
        foreach ($asks as $currency=> $items){
            $max['ask'][$currency] = $this->getMax($items);

        }
        foreach ($bids as $currency => $items){
            $max['bid'][$currency] = $this->getMax($items);

        }
        return $max;
    }


    protected function normalizeAsks($items)
    {
        $data = [];

        foreach ($items as $currency => $stock) {
            foreach ($stock as $stock_name => $asks) {
                if ($asks && is_array($asks)) {
                    foreach ($asks as $ask) {
                        $data[$currency]["$ask[0]"] = ['stock'=>$stock_name];
                    }
                }
            }

        }
        return $data;
    }

    protected function normalizeBids($items)
    {
        $data = [];

        foreach ($items as $currency => $stock) {
            foreach ($stock as $stock_name => $bids) {
                if ($bids && is_array($bids)) {
                    foreach ($bids as $bid) {
                        $data[$currency]["$bid[0]"] = ['stock'=>$stock_name];
                    }
                }
            }

        }

        return $data;
    }

    protected function getMax($currency){
        return max(array_keys($currency));
    }
    protected function getMin($currency){
        return min(array_keys($currency));
    }

    protected function normalizeData($pairs,$asks,$bids,$min,$max){
        $data = [];
        foreach ($pairs as $pair) {
            $minBid = $this->round($min['bid'][$pair]);
            $maxBid = $this->round($max['bid'][$pair]);
            $minBidStock = $bids[$pair][$min['bid'][$pair]]['stock'];
            $maxBidStock = $bids[$pair][$max['bid'][$pair]]['stock'];
            $minAsk = $this->round($min['ask'][$pair]);
            $maxAsk = $this->round($max['ask'][$pair]);
            $minAskStock = $asks[$pair][$min['ask'][$pair]]['stock'];
            $maxAskStock = $asks[$pair][$max['ask'][$pair]]['stock'];
            $delta = $this->round($max['bid'][$pair] - $min['ask'][$pair]);

            $profit = $this->getProfit($pair,$maxBid,$minAsk,$maxBidStock,$minAskStock);

            if(strpos($pair,'uah') !== false) {
                $minBid = $this->prepareValueWithBrackets($minBid);
                $maxBid = $this->prepareValueWithBrackets($maxBid);

                $minAsk =  $this->prepareValueWithBrackets($minAsk);
                $maxAsk =  $this->prepareValueWithBrackets($maxAsk);

                $delta = $this->prepareValueWithBrackets($delta);

                $profit = $this->prepareValueWithBrackets($profit);
            }
                $data[] = [
                    'pair' => $pair,
                    'minBid' => $minBid,
                    'maxBid' => $maxBid,
                    'minBidStock' => $minBidStock,
                    'maxBidStock' => $maxBidStock,
                    'minAsk' =>$minAsk,
                    'maxAsk' => $maxAsk,
                    'minAskStock' => $minAskStock,
                    'maxAskStock' => $maxAskStock,
                    'delta' => $delta,
                    'profit' => $profit,
                ];
        }
        return $data;
    }

    protected function convertUahToUsd($value,$course = 28.2){
        return round($value / $course,2);
    }

    protected function prepareValueWithBrackets($value){
        return $value . " (".$this->convertUahToUsd($value).")";
    }

    protected function getProfit($pair,$maxBid,$minAsk,$maxBidStock,$minAskStock){
       
        $currencies = explode('_',$pair);
        $askCurrency = $currencies[0];
        $bidCurrency = $currencies[1];
        $bidStock = app()->make($this->getStock($maxBidStock));
        $askStock = app()->make($this->getStock($minAskStock));
        $depositFee = $askStock->getDepositFee($bidCurrency);
        $buyTradeFee = $askStock->getTradeFee();
        $askPrice = $minAsk * (1 + $depositFee);
        $askItem = 1 * (1 - $buyTradeFee);
        $withdrawFee = $askStock->getWithdrawFee($askCurrency);
        $itemQuantityRemainAfterWithdraw = $askItem - $withdrawFee;
        $sellTradeFee = $bidStock->getTradeFee();
        $bidPrice = $itemQuantityRemainAfterWithdraw * $maxBid * (1 - $sellTradeFee);

        $profit = $bidPrice - $askPrice;

        return round($profit,2);
    }

    protected function getStock($stock){
        if(isset($this->stocks[$stock])){
            return $this->stocks[$stock];
        }
    }

    protected function round($value,$digits = 4){
        return round($value,$digits);
    }

}