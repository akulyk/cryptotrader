<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use GuzzleHttp\Client as GuzzleClient;

class Yobit extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var \App\Services\Yobit
     */
    private $service;

    public function __construct(\App\Services\Yobit $service)
    {

        $this->service = $service;
    }


    public function getInfo(){
      $response = json_decode($this->service->getInfo());
      var_dump($response);
    }

    public function getPairs(){
        var_dump($this->service->getPairs());
    }
    public function getDepth($pair,$limit = 10){
      $asks = $this->service->getAsks($pair,$limit);
      $bids = $this->service->getBids($pair,$limit);
      var_dump($asks,$bids);
    }
}
