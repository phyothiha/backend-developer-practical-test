<?php

namespace App\Http\Filters;

class PostFilter extends QueryFilter
{
    public function likes()
    {
        return $this->builder->withCount('likes');
    }
    
    public function tags()
    {
        return $this->builder->with('tags');
    }
    
    public function author()
    {
        return $this->builder->with('author');
    }
    
    public function ids($values)
    {
        return $this->builder->whereIn('id', $values);
    }
    
    public function createdAt($value)
    {
        return $this->builder->whereDate('created_at', $value);
    }
}