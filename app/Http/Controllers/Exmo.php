<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use GuzzleHttp\Client as GuzzleClient;

class Exmo extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var \App\Services\Exchanges\Exmo
     */
    private $service;

    public function __construct(\App\Services\Exchanges\Exmo $service)
    {

        $this->service = $service;
    }

    public function getDepth($pair,$limit = 10){
      $asks = $this->service->getAsks($pair,$limit);
      $bids = $this->service->getBids($pair,$limit);
      var_dump($this->service->withdraw('btc'),$this->service->deposit('uah'));
    }
}
