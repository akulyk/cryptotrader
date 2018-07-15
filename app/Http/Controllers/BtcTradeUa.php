<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use GuzzleHttp\Client as GuzzleClient;

class BtcTradeUa extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var \App\Services\Yobit
     */
    private $service;

    public function __construct(\App\Services\Exchanges\BtcTradeUa $service)
    {

        $this->service = $service;
    }


    public function getDepth($pair){
      $asks = $this->service->getAsks($pair);
      $bids = $this->service->getBids($pair);
      var_dump($asks,$bids);
    }
}
