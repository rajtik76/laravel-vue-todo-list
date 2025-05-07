<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\TodoCreateRequest;
use App\Models\Todo;
use Illuminate\Http\RedirectResponse;

class TodoController extends Controller
{
    public function toggle(Todo $todo): RedirectResponse
    {
        $this->authorize('update', $todo);

        $todo->finished = !$todo->finished;
        $todo->save();

        return redirect()->back();
    }

    public function delete(Todo $todo): RedirectResponse
    {
        $this->authorize('delete', $todo);

        $todo->delete();

        return redirect()->back();
    }

    public function create(TodoCreateRequest $request): RedirectResponse
    {
        Todo::create([
            'user_id' => auth()->id(),
            'finished' => false,
            ...$request->validated()
        ]);

        return redirect()->back();
    }
}
