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
        return "realy broken.";
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
//   string(18) "realy broken."
// }
```