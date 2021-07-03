<?php

namespace App\Repositories\Eloquent;

use App\Models\KeyValue;
use App\Repositories\Contracts\IKeyValue;

class KeyValueRepository extends BaseRepository implements IKeyValue
{
    //returning the current model
    public function model()
    {
        return KeyValue::class; //this returns the model namespace - App\Model\Category
    }
}
