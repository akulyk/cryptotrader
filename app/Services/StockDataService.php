<?php namespace App\Services;
use Illuminate\Support\Facades\Cache;

class StockDataService
{
    protected $lastUpdated;

    public function getData($pairs,array $stocks,$limit = 3,$cacheMinutes = 3){
        if(!is_array($pairs)){
            $pairs = [$pairs];
        }
        $cacheKey = serialize($pairs).serialize($stocks);
        $data = Cache::get($cacheKey, []);
        $this->lastUpdated = Cache::get('lastUpdateTime'.$cacheKey, date("d.m.Y H:i:s"));
        if (count($data) == 0) {
            foreach ($stocks as $name => $class){
                $stock = app()->make($class);
                foreach ($pairs as $pair) {
                    $data[$name][$pair]['bids'] = $stock->getBids($pair, $limit);
                    $data[$name][$pair]['asks'] = $stock->getAsks($pair, $limit);
                }
            }
            Cache::put($cacheKey, $data, $cacheMinutes);
            Cache::put('lastUpdateTime'.$cacheKey,$this->lastUpdated,$cacheMinutes);
        }

        return $data;
    }

    public function getLastUpdated(){
        return $this->lastUpdated;
    }

}