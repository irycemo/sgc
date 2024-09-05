<?php

namespace App\Http\Traits;

trait WithCache{

    public $useCache = false;

    public function useCachedRows(){

        $this->useCache = true;

    }

    public function cache($callback){

        if($this->useCache && cache()->has($this->getId())){

            return cache()->get($this->getId());

        }

        $result = $callback();

        cache()->put($this->getId(), $result, 180);

        return $result;

    }

}
