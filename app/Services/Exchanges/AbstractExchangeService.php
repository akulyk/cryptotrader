<?php namespace App\Services\Exchanges;

use App\Enums\StockExchangesEnum;
use GuzzleHttp\Client as GuzzleClient;

abstract class AbstractExchangeService{

    /**
     * @var GuzzleClient
     */
    protected $client;

    public function __construct(GuzzleClient $client)
    {

        $this->client = $client;
    }

    public function getTradeFee(){
        if($config = $this->getConfig()){
            if(isset($config[StockExchangesEnum::TRADE_FEE]) && $config[StockExchangesEnum::TRADE_FEE]){
                return $config[StockExchangesEnum::TRADE_FEE];
            }
        }
    }

    public function getWithdrawFee($currency){
        $config = $this->getConfig();
        $config[StockExchangesEnum::WITHDRAW][$currency][StockExchangesEnum::FEE];
    }

    protected function getConfig(){
        $class = new \ReflectionClass($this);
        $name = mb_strtolower($class->getShortName());
        $config = config('stock-exchanges.'.$name);
        return $config;
    }
}