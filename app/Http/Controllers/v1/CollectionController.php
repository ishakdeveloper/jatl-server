<?php

namespace App\Http\Controllers\v1;

use App\Models\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\CollectionResource;

class CollectionController extends Controller
{
    public function index(Collection $collection)
    {
        return CollectionResource::collection(Collection::paginate(20));
    }

    public function show(Collection $collection)
    {
        return new CollectionResource($collection);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'picture' => 'nullable'
        ]);

        $new_collec = Collection::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'description' => $request->description
        ]);

        return new CollectionResource($new_collec);
    }

    public function update(Request $request, Collection $collection)
    {
        if ($request->user()->id !== $collection->user_id) {
            return response()->json(['error' => 'You can only edit your own todos.'], 403);
        }
    
        $collection->update($request->only(['title', 'description']));
    
        return new CollectionResource($collection);
    }

    public function destroy(Collection $collection)
    {
        $res = $collection->delete();
        return new CollectionResource($res);
    }

    public function search($search)
    {
        $res = Collection::where('title', 'like', '%'.$search.'%')->orWhere('description', 'like', '%'.$search.'%')->get();
        return CollectionResource::collection($res);
    }
}
