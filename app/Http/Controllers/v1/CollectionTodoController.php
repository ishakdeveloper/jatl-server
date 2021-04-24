<?php

namespace App\Http\Controllers\v1;

use App\Models\Todo;
use App\Models\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\TodoResource;

class CollectionTodoController extends Controller
{

    public function index($collection)
    {
        $todos = Todo::where('collection_id', $collection)->get();
        return TodoResource::collection($todos);
    }

    public function show($collection, Todo $todo)
    {
        return new TodoResource($todo);
    }

    public function store(Request $request, $collection, Todo $todo)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable'
        ]);

        $new_todo = Todo::create([
            'collection_id' => $collection,
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'description' => $request->description
        ]);

        return new TodoResource($new_todo);
    }

    public function update(Request $request, Collection $collection, Todo $todo)
    {
        // dd(Todo::find($todo));
        if ($request->user()->id !== $todo->user_id) {
            return response()->json(['error' => 'You can only edit your own todos.'], 403);
        }
    
        $todo->update($request->only(['title', 'description']));
    
        return new TodoResource($todo);
    }

    public function destroy($collection, Todo $todo)
    {
        $todo->delete();
        return new TodoResource($todo);
    }

    public function search($collection, $search)
    {
        $res = Todo::where('title', 'like', '%'.$search.'%')->orWhere('description', 'like', '%'.$search.'%')->get();
        return TodoResource::collection($res);
    }
}
