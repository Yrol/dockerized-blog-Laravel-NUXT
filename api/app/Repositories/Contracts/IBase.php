<?php

namespace App\Repositories\Contracts;

/*
* Base interface that consist of blueprints of common methods
*/
interface IBase
{
    public function all();
    public function find($id);
    public function findWhere($column, $value);
    public function findWhereFirst($column, $value);
    public function paginate($perpage);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
