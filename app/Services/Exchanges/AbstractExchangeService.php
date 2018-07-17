<?php namespace App\Services\Exchanges;

use App\Enums\StockExchangesEnum;
use GuzzleHttp\Client as GuzzleClient;

abstract class AbstractExchangeService{

    /**
     * @var GuzzleClient
     */
    protected $client;

    protected $fiats = [
        'usd',
        'eur',
        'uah',
    ];

    public function __construct(GuzzleClient $client)
    {

        $this->client = $client;
    }
    //todo make a separate class for deposit
    public function getDepositFee($currency){
        $fee = 0;
        if($config = $this->getConfig()) {
            if(isset($config[StockExchangesEnum::DEPOSIT]) && $config[StockExchangesEnum::DEPOSIT]){
                $deposit = $config[StockExchangesEnum::DEPOSIT];
                if(isset($deposit[$currency])) {
                    if (count($deposit[$currency]) > 1) {
                        $fees = [];
                        foreach ($deposit[$currency] as $item) {
                            if(isset($item['fee'])) {
                                $fees[] = $item['fee'];
                            }
                        }
                        $fee = min($fees);
                    }else{
                        foreach($deposit[$currency] as $item){
                            if(isset($item['fee'])) {
                                $fee = $item['fee'];
                            }
                        }
                    }
                }
            }
        }
        return $fee;
    }

    public function getTradeFee(){
        if($config = $this->getConfig()){
            if(isset($config[StockExchangesEnum::TRADE_FEE]) && $config[StockExchangesEnum::TRADE_FEE]){
                return $config[StockExchangesEnum::TRADE_FEE];
            }
        }
    }

    public function getWithdrawFee($currency){
        if(in_array($currency,$this->fiats)){
            return $this->getWithdrawFiatFee($currency);
        }
        if($config = $this->getConfig()) {
            if(isset($config[StockExchangesEnum::WITHDRAW][$currency])){
                return $config[StockExchangesEnum::WITHDRAW][$currency][StockExchangesEnum::FEE];;
            }

        }
    }

    protected function getWithdrawFiatFee($currency){

    }

    protected function getConfig(){
        $class = new \ReflectionClass($this);
        $name = mb_strtolower($class->getShortName());
        $config = config('stock-exchanges.'.$name);
        return $config;
    }

    abstract public function getBids($pair,$limit);
    abstract public function getAsks($pair,$limit);
}