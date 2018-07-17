<?php
return [
     'tradeFee'=>0.002,

      'withdraw'=>[
          'usd'=>[
              'visa/mastercard'=>[
                  'fee'=>0.05,
                  'additionFee'=>6,
                  'minAmountPerOperation'=>100,
                  'maxAmountPerOperation'=>2300,
                //  'maxAmountPerDay'=>100000,
               //   'maxAmountPerMonth'=>300000,
              ],
              'advCash'=>[
                  'type'=>'middleware',
                  'fee'=>0.02,
                  'maxAmountPerOperation'=>15000,
              ]
          ],
          'usdt'=>[
              'fee'=>10,
         //     'minAmountPerOperation'=>0.01,
         //     'maxAmountPerOperation'=>350,
          ],
          'btc'=>[
              'fee'=>0.0012,
              'minAmountPerOperation'=>0.01,
              'maxAmountPerOperation'=>350,
          ],
          'eth'=>[
              'fee'=>0.005,
            //  'minAmountPerOperation'=>0.1,
           //   'maxAmountPerOperation'=>500,
          ],
          'etc'=>[
              'fee'=>0.005,
              //  'minAmountPerOperation'=>0.1,
              //   'maxAmountPerOperation'=>500,
          ],
          'zec'=>[
              'fee'=>0.03,
          //    'minAmountPerOperation'=>0.01,
          //    'maxAmountPerOperation'=>500
          ],
          'waves'=>[
              'fee'=>0.002,
          //    'minAmountPerOperation'=>0.01,
           //   'maxAmountPerOperation'=>40000
          ],
          'btg'=>[
              'fee'=>0.01,
            //  'minAmountPerOperation'=>0.01,
            //  'maxAmountPerOperation'=>1000000
          ],
          'ltc'=>[
            'fee'=>0.002,
          ],
          'nmc'=>[
              'fee'=>0.002,
          ],
          'ppc'=>[
              'fee'=>0.2,
          ],
          'dash'=>[
              'fee'=>0.002,
          ],
          'doge'=>[
              'fee'=>100,
          ],
      ],
      'deposit'=>[
          'usd'=>[
              'advCash'=>[
                  'type'=>'middleware',
                  'fee'=>0
              ]
          ],
      ]
];