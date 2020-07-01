<p align="center">
<a href="https://travis-ci.org/DeGraciaMathieu/php-easy-breaker"><img src="https://travis-ci.org/DeGraciaMathieu/php-easy-breaker.svg?branch=master" alt="Build Status"></a>
<a href="https://scrutinizer-ci.com/g/DeGraciaMathieu/php-easy-breaker/?branch=master"><img src="https://scrutinizer-ci.com/g/DeGraciaMathieu/php-easy-breaker/badges/coverage.png?b=master" alt="Code Coverage"></a>
<img src="https://img.shields.io/travis/php-v/DeGraciaMathieu/php-easy-breaker.svg" alt="PHP range">
<a href="https://packagist.org/packages/degraciamathieu/php-easy-breaker"><img src="https://img.shields.io/packagist/v/degraciamathieu/php-easy-breaker.svg?style=flat-square" alt="Latest Version on Packagist"></a>
<a href='https://packagist.org/packages/degraciamathieu/php-easy-breaker'><img src='https://img.shields.io/packagist/dt/degraciamathieu/php-easy-breaker.svg?style=flat-square' /></a>
</p>

# degraciamathieu/php-easy-breaker

PHP implementation of circuit breaker pattern.

## Installation

Run in console below command to download package to your project:

```
composer require degraciamathieu/php-easy-breaker
```
## usage

```php
require __DIR__.'/vendor/autoload.php';

use Exception;
use DeGraciaMathieu\EasyBreaker\Breaker;
use DeGraciaMathieu\EasyBreaker\CircuitBreaker;

$firstBreaker = (new Breaker)
    ->when(Exception::class)
    ->do(function(Exception $e){
        return "it's broken.";
    });

$secondBreaker = (new Breaker)
    ->when(Exception::class)
    ->do(function(Exception $e){
        return "really broken.";
    });

$thirdBreaker = (new Breaker)
    ->when(AnotherException::class)
    ->do(function(AnotherException $e){
        return "boom.";
    });

$results = (new CircuitBreaker())
    ->addBreaker($firstBreaker)
    ->addBreaker($secondBreaker)
    ->addBreaker($thirdBreaker)
    ->closure(function(){
        throw new Exception();
    });

var_dump($results);

// array(2) {
//   [0]=>
//   string(12) "it's broken."
//   [1]=>
//   string(18) "really broken."
// }
```
