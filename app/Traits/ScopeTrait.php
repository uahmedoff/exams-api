<?php
namespace App\Traits;

trait ScopeTrait
{
    public function scopeSort($query){
        $column = (request()->get('column')) ?? 'id';
        $order = (request()->get('order')) ?? 'asc';
        return $query->orderBy($column, $order);
    }

    public function scopeSearch($query, $string){
        $columns = $this->search_columns;
        return $query->where(function ($query) use($string, $columns) {
            foreach ($columns as $column){
                $query->orwhere($column, 'ilike',  '%' . $string .'%');
            }
        });
    }
}
