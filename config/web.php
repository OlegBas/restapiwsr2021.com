<?php
use yii\web\Response;
use yii\web\JsonResponseFormatter;
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'cors' => [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'],
                // Allow only POST and PUT methods
                'Access-Control-Request-Method' => ['POST', 'PUT','GET','DELETE','HEAD','OPTIONS','PATCH'],
                // Allow only headers 'X-Wsse'
                'Access-Control-Request-Headers' => ['*'],
                // Allow credentials (cookies, authorization headers, etc.) to be exposed to the browser
                'Access-Control-Allow-Credentials' => null,
                // Allow OPTIONS caching
                'Access-Control-Max-Age' => 86400,
                // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                'Access-Control-Expose-Headers' => [''],
            ],
        ],
        'contentNegotiator' => [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
            'languages' => [
                'en',
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'sIuENlcCzCdeS4L_tOHXvbZtzF7Mprp9',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            'acceptableContentTypes' => [
                'application/json' => 1
            ]
        ],
        //TODO выучить наизусь свойства и методы
        'response' => [
            'class' => Response::class,
            'format' => Response::FORMAT_JSON;
            'formatters' => [
                Response::FORMAT_JSON => [
                    'class' => JsonResponseFormatter::class,           
                ],
            ],
            'charset' => 'utf-8'
        ],
        
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => false,
            'enableSession' => false,
            'loginUrl' => 'api/v1/auth/login',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => UrlRule::class,
                    'controller' => 'allatech/api/login'
                ],
                [
                    'class' => UrlRule::class,
                    'controller' => 'allatech/api/logout'
                ], 
                [
                    'class' => UrlRule::class,
                    'controller' => 'allatech/api/machines'
                ],                        
                
            ],
            
        ]
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
