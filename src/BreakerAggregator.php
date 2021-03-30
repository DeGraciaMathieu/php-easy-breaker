<?php

namespace DeGraciaMathieu\EasyBreaker;

use Exception;
use Illuminate\Support\Collection;
use DeGraciaMathieu\EasyBreaker\Breaker;
use DeGraciaMathieu\EasyBreaker\BreakerAggregator;

class BreakerAggregator
{
    protected $collection;

    public function __construct()
    {
        $this->collection = new Collection;
    }

    public function add(Breaker $breaker): BreakerAggregator
    {
        $this->collection->push($breaker);

        return $this;
    }    

    public function retrieve(Exception $exception): array
    {
        return $this->collection
            ->filter(function($breaker) use($exception) {
                return $breaker->exception === get_class($exception);
            })
            ->values()
            ->all();
    }       
}
