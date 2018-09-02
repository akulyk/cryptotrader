<?php

namespace App\Http\Controllers;

use App\Services\DataService;
use App\Services\Exchanges\Wex;
use App\Services\StockDataService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Cache;

class HomeController extends BaseController
{


    public function actionIndex($pair = null)
    {
      $service = app()->make(DataService::class);
      $items = $service->getInfo($pair);
      $lastUpdated = $service->getLastUpdated();

        return view('home', [
            'items'=>$items,
            'lastUpdated'=>$lastUpdated
        ]);
    }

    public function actionCurrency(Request $request){
        $currency = $request->get('currency') ?: 'btc_usd';
        $stocks = [
            'yobit'=>\App\Services\Exchanges\Yobit::class,
            'wex'=>Wex::class,
            'kuna'=>\App\Services\Exchanges\Kuna::class,
            'exmo'=>\App\Services\Exchanges\Exmo::class,
            'btctradeua'=>\App\Services\Exchanges\BtcTradeUa::class
        ];

        $service = app()->make(StockDataService::class);
        $items = $service->getData($currency,$stocks);

        return view('currency',[
            'currency'=>$currency,
            'lastUpdated'=>'',
            'stocks'=>$stocks,
            'items'=>$items]);
    }



}
