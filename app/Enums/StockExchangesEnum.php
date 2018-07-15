<?php  namespace App\Enums;

class StockExchangesEnum{
    const KUNA_IO = 'kuna.io';
    const BTC_TRADE_UA = 'btc-trade.ua';
    const EXMO_COM = 'exmo.com';
    const WEX_NZ = 'wex.nz';
    const YOBIT_NET = 'yobit.net';

    const WITHDRAW = 'withdraw';
    const DEPOSIT = 'deposit';
    const FEE = 'fee';
    const TRADE_FEE = 'tradeFee';

    public static function getStockExchanges(){
        return [
            static::KUNA_IO,
            static::BTC_TRADE_UA,
            static::EXMO_COM,
            static::WEX_NZ,
            static::YOBIT_NET,
        ];
    }
}