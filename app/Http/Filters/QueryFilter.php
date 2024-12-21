<?php

namespace App\Http\Filters;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

abstract class QueryFilter
{
    protected $request;
    
    protected $builder;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    /**
     * Load model relationships.
     */
    protected function include($relationships): Builder
    { 
        if (is_string($relationships)) {
            $methods = $this->sanitizePayload($relationships);
                               
            foreach ($methods as $method) {
                if (method_exists($this, $method)) {
                    $this->invokeCb($method);
                }
            }
        }
        
        return $this->builder;
    }
    
    /**
     * Filter column values.
     */
    protected function filter($columns): Builder
    {
        if (is_array($columns)) {
            foreach ($columns as $name => $value) {
                if (method_exists($this, $name) && ! empty($value)) {
                    $arr = $this->sanitizePayload($value);
                    
                    if (count($arr) == 1) {
                        $this->invokeCb($name, $arr[0]);
                    } else {
                        $this->invokeCb($name, $arr);
                    }                    
                }
            }
        }
                
        return $this->builder;
    }
    
    /**
     * Entry point for filtering.
     */
    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;
                        
        foreach ($this->filters() as $name => $value) {
            if (method_exists($this, $name) && ! empty($value)) {
                $this->invokeCb($name, $value);
            }
        }
        
        return $this->builder;
    }
    
    /**
     * Get all incoming request's query string values.
     */
    protected function filters(): array
    {
        return $this->request->query();
    }
    
    /**
     * Sanitize query string key's value.
     */
    protected function sanitizePayload($value): array
    {
        return array_filter(
            explode(',', strtolower($value))
        );
    }
    
    /**
     * Invoke callback function
     */
    protected function invokeCb($callback, $args = null): void
    {
        call_user_func([$this, $callback], $args);
    }
}