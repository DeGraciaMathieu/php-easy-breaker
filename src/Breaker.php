<?php

namespace DeGraciaMathieu\EasyBreaker;

use Closure;

class Breaker {

    public $exception;
    public $closure;

    public function when(string $exception) :Breaker
    {
        $this->exception = $exception;

        return $this;
    }

    public function do(Closure $closure) :Breaker
    {
        $this->closure = $closure;

        return $this;
    }
}
