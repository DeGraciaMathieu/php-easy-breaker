<?php

namespace DeGraciaMathieu\Clike\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use DeGraciaMathieu\EasyBreaker\Breaker;
use DeGraciaMathieu\EasyBreaker\CircuitBreaker;

class CircuitBreakerTest extends TestCase
{
    /**
     * @test
     */
    public function process_with_break()
    {
        $firstBreaker = $this->makeBreaker($message = "it's realy broken.", $exception = Exception::class);
        $secondBreaker = $this->makeBreakerWithCustomException($customMessage = "it's realy broken.", CustomException::class);
        $thirdBreaker = $this->makeBreaker($message = "it's realy realy broken.", $exception = Exception::class);

        $results = (new CircuitBreaker())
            ->addBreaker($firstBreaker)
            ->addBreaker($secondBreaker)
            ->addBreaker($thirdBreaker)
            ->closure(function(){
                throw new Exception();
            });


        $this->assertNotNull($results);
        $this->assertCount(2, $results);
        $this->assertEquals($results[0], "it's realy broken.");
        $this->assertEquals($results[1], "it's realy realy broken.");
    }

    /**
     * @test
     */
    public function process_without_break()
    {
        $firstBreaker = $this->makeBreaker($message = "it's realy broken.", $exception = Exception::class);

        $results = (new CircuitBreaker())
            ->addBreaker($firstBreaker)
            ->closure(function(){
                return;
            });


        $this->assertNull($results);
    }

    /**
     * @param  strng $message
     * @return \DeGraciaMathieu\EasyBreaker\Breaker
     */
    protected function makeBreaker(string $message) :Breaker
    {
        return $this->makeBreakerWithCustomException($message, Exception::class);
    }

    /**
     * @param  string $message
     * @param  string $exception
     * @return \DeGraciaMathieu\EasyBreaker\Breaker
     */
    protected function makeBreakerWithCustomException(string $message, string $exception) :Breaker
    {
        return (new Breaker)
            ->when($exception)
            ->do(function(Exception $e) use($message) {
                return $message;
            });
    }
}
