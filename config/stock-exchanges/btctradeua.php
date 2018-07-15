<?php
return [
      'tradeFee'=>0.001,
      'withdraw'=>[
          'uah'=>[
              'visa/mastercard'=>[
                  'fee'=>0.01,
                  'minAmountPerOperation'=>500,
              ],
          ],
          'btc'=>[
              'fee'=>0.0006,
              'minAmountPerOperation'=>0.001,
           //   'maxAmountPerOperation'=>350,
          ],
          'bch'=>[
              'fee'=>0.001,
              'minAmountPerOperation'=>0.001,
              //   'maxAmountPerOperation'=>350,
          ],
          'eth'=>[
              'fee'=>0.005,
              'minAmountPerOperation'=>0.01,
      //        'maxAmountPerOperation'=>500,
          ],
          'etc'=>[
              'fee'=>0.015,
              'minAmountPerOperation'=>0.01,
              //        'maxAmountPerOperation'=>500,
          ],
          'zec'=>[
              'fee'=>0.005,
              'minAmountPerOperation'=>0.001,
             // 'maxAmountPerOperation'=>500
          ],
          'waves'=>[
              'fee'=>0.01,
              'minAmountPerOperation'=>1,
              //         'maxAmountPerOperation'=>40000
          ],
          'doge'=>[
              'fee'=>5,
              'minAmountPerOperation'=>1,
              //         'maxAmountPerOperation'=>40000
          ],
          'nvc'=>[
              'fee'=>0.01,
              'minAmountPerOperation'=>0.001,
      //        'maxAmountPerOperation'=>1000000
          ],
          'ltc'=>[
              'fee'=>0.01,
              'minAmountPerOperation'=>0.001,
              //        'maxAmountPerOperation'=>1000000
          ],
          'dash'=>[
              'fee'=>0.01,
              'minAmountPerOperation'=>0.01,
              //        'maxAmountPerOperation'=>1000000
          ],
          'ppc'=>[
              'fee'=>0.01,
              'minAmountPerOperation'=>0.01,
              //        'maxAmountPerOperation'=>1000000
          ],
          'usdt'=>[
              'fee'=>5
          ],
          'xmr'=>[
              'fee'=>0.015
          ]
      ],
      'deposit'=>[
          'uah'=>[
              'visa/mastercard'=>[
              'fee'=>0.022,
              'minAmountPerOperation'=>500,
     //         'additionalFee'=>5,
     //         'maxAmountPerOperation'=>14500,
        //      'maxNumberOperationsPerDay'=>5,
          ],
        ],
      ]
];