<?php

namespace Mekaeil\LaravelTranslation\Repository\Contracts;

use Mekaeil\LaravelTranslation\Repository\Contracts\RepositoryInterface;

class CoreEloquents implements RepositoryInterface
{
    protected $model;

    /**
     * @param int $ID
     * @return mixed
     * @desc FIND ITEM
     */
    public function find(int $ID)
    {
        return $this->model::find($ID);
    }

    /**
     * @param array $item
     * @return mixed
     * @desc STORE ITEM IN DB
     */
    public function store(array $item)
    {
        return  $this->model::create($item);
    }

    /**
     * @param int $ID
     * @param array $item
     * @return null / boolean
     * @desc UPDATE ITEM
     */
    public function update(int $ID, array $item)
    {
        $findItem = $this->find($ID);
        if ($item)
        {
            return $findItem->update($item);
        }
        return null;
    }

    /**
     * @param array|null $columns
     * @param array $relations
     * @param int|null $perPage
     * @param array|null $condition
     * @return mixed
     */
    public function all(array $columns = [], array $relations = [], int $perPage = null, array $condition = [])
    {
        $query = $this->model::query();

        if (!empty($relations))
        {
            $query->with($relations);
        }

        if (!empty($columns))
        {
            return $query->get($columns);
        }

        if (!empty($condition))
        {
            foreach ($condition as $key => $value){

                if ( is_array($value)){
                    $query->where($value[0],$value[1],$value[2]);
                }else{
                    $query->where($key,$value);
                }
            }
        }

        if (!is_null($perPage))
        {
            return $query->paginate($perPage);
        }

        return $query->get();

    }


    public function getRecord(array $condition = [], bool $single = true, int $perPage=null)
    {
        $query = $this->model::query();

        if (!empty($condition))
        {
            foreach ($condition as $key => $value){
                $query->where($key,$value);
            }
        }

        if (! is_null($perPage))
        {
            return $query->paginate($perPage);
        }

        $method = $single ? 'first' : 'get';

        return $query->{$method}();

    }

    /**
     * @param $param1
     * @param $param2
     * @param bool $return_array
     * @return mixed
     * @desc RETURN PLUCK DATA WITH LARAVEL ELOQUENT
     */
    public function pluckData($param1 , $param2 , $return_array =  true, array $condition = [])
    {
        $query = $this->model::query();

        if (!empty($condition))
        {
            foreach ($condition as $key => $value){
                $query->where($key,$value);
            }
        }

        if($return_array)
        {
            return $query->pluck($param1,$param2)->toArray();
        }

        return $query->pluck($param1,$param2);
    }

    public function delete($ID)
    {
        $query = $this->model::query();
        $trans = $query->find($ID);

        return $trans->delete();
    }


}