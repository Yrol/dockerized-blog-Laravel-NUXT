<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Resources\KeyValueResource;
use App\Models\KeyValue;
use App\Repositories\Contracts\IKeyValue;
use Illuminate\Http\Request;
use App\Repositories\Eloquent\Criteria\LatestFirst;
use Illuminate\Http\Response;

class KeyValueSettingsController extends Controller
{
    protected $keyvalues;

    public function __construct(IKeyValue $keyvalue)
    {
        $this->keyvalues = $keyvalue;
        $this->middleware('auth');
    }

    public function index()
    {
        $keyvalue =  $this->keyvalues->withCriteria([
            new LatestFirst()
        ])->all();

        return KeyValueResource::collection($keyvalue);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'key' => ['required','unique:keyvalues,key', 'min:4'],
            'value' => ['required']
        ]);

        $resource = $this->keyvalues->create($request->all());
        return response(new KeyValueResource($resource), Response::HTTP_CREATED);
    }

    public function update(Request $request, KeyValue $keyvalue)
    {
        $request->merge(['slug' => str_slug($request->key)]);

        $this->validate($request, [
            'key' => ['required','unique:keyvalues,key', 'min:4'],
            'value' => ['required'],
            'slug' => ['required_with:key', 'string', "unique:keyvalues,slug, {$keyvalue->slug}"] //unique category slug except the current one
        ]);

        $resource = $this->keyvalues->update($keyvalue->id, $request->only(['key', 'value']));

        return response()->json(new KeyValueResource($resource), Response::HTTP_ACCEPTED);
    }

    public function destroy(KeyValue $keyvalue)
    {
        //delete defined in BaseRepository
        if ($this->keyvalues->delete($keyvalue->id)) {
            return response()->json(null, Response::HTTP_NO_CONTENT);
        }

        return response()->json(null, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
