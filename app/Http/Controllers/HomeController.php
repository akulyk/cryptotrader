<?php

namespace App\Http\Controllers;

use App\Services\DataService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Cache;

class HomeController extends BaseController
{


    public function index($pair = null)
    {
      $service = app()->make(DataService::class);
      $items = $service->getInfo($pair);
      $lastUpdated = $service->getLastUpdated();

        return view('home', [
            'items'=>$items,
            'lastUpdated'=>$lastUpdated
        ]);
    }



}
