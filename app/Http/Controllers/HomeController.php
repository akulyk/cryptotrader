<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Cache;

class HomeController extends BaseController
{
    public function index($pair = null)
    {
        if ($pair) {

        } else {
            $pairs = [
                'btc_usd',
                'eth_usd',
                'zec_usd',
                'ltc_usd',
                'btc_uah',
                'eth_uah',
            ];
        }
        $data = Cache::get('trades', []);

        if (count($data) == 0) {
            $yobit = app()->make(\App\Services\Exchanges\Yobit::class);
            $exmo = app()->make(\App\Services\Exchanges\Exmo::class);
            $kuna = app()->make(\App\Services\Exchanges\Kuna::class);
            $wex = app()->make(\App\Services\Exchanges\Wex::class);

            $limit = 3;
            if (isset($pairs) && count($pairs) > 0) {
                foreach ($pairs as $pair) {
                    $data['bids'][$pair]['kuna'] = $kuna->getBids($pair, $limit);
                    $data['bids'][$pair]['exmo'] = $exmo->getBids($pair, $limit);
                    $data['bids'][$pair]['yobit'] = $yobit->getBids($pair, $limit);
                    $data['bids'][$pair]['wex'] = $wex->getBids($pair, $limit);
                    $data['asks'][$pair]['kuna'] = $kuna->getAsks($pair, $limit);
                    $data['asks'][$pair]['exmo'] = $exmo->getAsks($pair, $limit);
                    $data['asks'][$pair]['yobit'] = $yobit->getAsks($pair, $limit);
                    $data['asks'][$pair]['wex'] = $wex->getAsks($pair, $limit);
                }
            }
            Cache::put('trades', $data, 10);
        }


        $asks = $this->normalizeAsks($data['asks']);
        $bids = $this->normalizeBids($data['bids']);
        $min = ['ask'=>[],'bid'=>[]];
        $max = ['ask'=>[],'bid'=>[]];
        foreach ($asks as $currency=> $items){

            $min['ask'][$currency] = $this->getMin($items);
            $max['ask'][$currency] = $this->getMax($items);

        }
        foreach ($bids as $currency => $items){

            $min['bid'][$currency] = $this->getMin($items);
            $max['bid'][$currency] = $this->getMax($items);

        }
       var_dump($asks,$bids,$min,$max);
        die;
        return view('home', ['asks' => $asks,
            'bids' => $bids,
            'min'=>$min,
            'max'=>$max,
            'pairs' => $pairs,
        ]);
    }

    protected function normalizeAsks($items)
    {
        $data = [];
        foreach ($items as $currency => $stock) {
            foreach ($stock as $stock_name => $asks) {
                if ($asks && is_array($asks)) {
                    foreach ($asks as $ask) {
                        $data[$currency][(float)$ask[0]] = ['stock'=>$stock_name];
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
                        $data[$currency][(float)$bid[0]] = ['stock'=>$stock_name];
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
}
