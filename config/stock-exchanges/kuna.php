<?php
return [
      'tradeFee'=>0.0025,

      'withdraw'=>[
          'uah'=>[
              'visa/mastercard'=>[
                  'fee'=>0.01,
                  'minAmountPerOperation'=>100,
              ],
          ],
          'btc'=>[
              'fee'=>0.001,
              'minAmountPerOperation'=>0.001,
           //   'maxAmountPerOperation'=>350,
          ],
          'eth'=>[
              'fee'=>0.005,
              'minAmountPerOperation'=>0.01,
      //        'maxAmountPerOperation'=>500,
          ],
          'zec'=>[
              'fee'=>0.001,
              'minAmountPerOperation'=>0.001,
             // 'maxAmountPerOperation'=>500
          ],
          'waves'=>[
              'fee'=>0.01,
              'minAmountPerOperation'=>1,
     //         'maxAmountPerOperation'=>40000
          ],
          'eos'=>[
              'fee'=>0.1,
              'minAmountPerOperation'=>0.001,
      //        'maxAmountPerOperation'=>1000000
          ],
          'ltc'=>[
              'fee'=>0.001,
              'minAmountPerOperation'=>0.001,
              //        'maxAmountPerOperation'=>1000000
          ],
          'dash'=>[
              'fee'=>0.01,
              'minAmountPerOperation'=>0.01,
              //        'maxAmountPerOperation'=>1000000
          ],
      ],
      'deposit'=>[
          'uah'=>[
              'visa/mastercard'=>[
                  'fee'=>0.01,
                  'additionalFee'=>5,
                  'maxAmountPerOperation'=>14500,
        //      'maxNumberOperationsPerDay'=>5,
              ],
          ],
      ]
];