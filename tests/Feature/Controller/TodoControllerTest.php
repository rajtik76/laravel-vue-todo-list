<?php
declare(strict_types=1);

/**
 * Feature tests for the Todo functionality within the application.
 *
 * Contains tests for:
 * - Visibility of a user's todos on the dashboard.
 * - Authorization checks for deleting a todo.
 * - Authorization checks for toggling a todo's completion status.
 *
 * Namespace: Tests\Feature\Controller
 *
 * Utilizes Laravel and Pest testing utilities.
 */

namespace Tests\Feature\Controller;

use App\Models\Todo;
use App\Models\User;
use Inertia\Testing\AssertableInertia;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseEmpty;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\patch;

/**
 * Tests the visibility of todos on the dashboard for a specific user.
 *
 * Verifies that:
 * - Only the todos belonging to the authenticated user are displayed.
 * - Todos created by other users are not visible on the authenticated user's dashboard.
 *
 * Utilizes Inertia assertions to confirm the correct number of todos are passed to the frontend component.
 */
test('todo is seen on dashboard', function () {
    $user = User::factory()->create();
    Todo::factory()
        ->count(3)
        ->recycle($user)
        ->create();

    $anotherUser = User::factory()->create();
    Todo::factory()
        ->count(3)
        ->recycle($anotherUser)
        ->create();

    actingAs($user);

    get(route('dashboard'))
        ->assertInertia(fn(AssertableInertia $page) => $page
            ->component('Dashboard')
            ->has('todos', 3) // Only 3 todos are visible on the dashboard
        );
});

/**
 * Ensures that the owner of a todo item can delete it.
 *
 * Verifies:
 * - The authenticated user is the owner of the todo item.
 * - The request to delete the todo item responds with a successful redirection (HTTP status 302).
 * - The todo item is successfully removed from the database.
 *
 * Utilizes Laravel and Pest testing utilities.
 */
test('only owner can delete todo', function () {
    $todo = Todo::factory()->create();

    actingAs($todo->user);

    delete(route('todo.delete', $todo->id))
        ->assertStatus(302);

    assertDatabaseEmpty('todos');
});

/**
 * Ensures that only the owner of a todo item can delete it.
 *
 * Verifies:
 * - When an unauthorized user attempts to delete a todo item, the request fails with a 403 status code.
 * - The todo item remains intact in the database after an unauthorized delete attempt.
 *
 * Utilizes Laravel and Pest testing utilities.
 */
test('another user can not delete todo', function () {
    $todo = Todo::factory()->create();
    $anotherUser = User::factory()->create();

    actingAs($anotherUser);

    delete(route('todo.delete', $todo->id))
        ->assertStatus(403);

    assertDatabaseCount('todos', 1);
});

/**
 * Ensures that a todo item's completion status can be toggled by its owner.
 *
 * Verifies:
 * - The authenticated user is the owner of the todo item.
 * - The request to toggle the completion status responds with a successful redirection (HTTP status 302).
 * - The todo item's `finished` attribute is successfully updated in the database.
 *
 * Utilizes Laravel and Pest testing utilities to validate functionality.
 */
test('only owner can toggle todo', function () {
    $todo = Todo::factory()
        ->notFinished()
        ->create();

    actingAs($todo->user);

    patch(route('todo.toggle', $todo->id))
        ->assertStatus(302);

    assertDatabaseHas('todos', [
        'id' => $todo->id,
        'finished' => true,
    ]);
});

/**
 * Ensures that only the owner of a todo can toggle its completion status.
 *
 * Verifies:
 * - An unauthorized user (not the owner of the todo) receives a forbidden (HTTP status 403) response when attempting to toggle the completion status.
 * - The `finished` column in the database remains unchanged for the targeted todo.
 *
 * Utilizes Laravel and Pest testing utilities to validate authorization and database state persistence.
 */
test('another user can not toggle todo', function () {
    $todo = Todo::factory()
        ->notFinished()
        ->create();
    $anotherUser = User::factory()->create();

    actingAs($anotherUser);

    patch(route('todo.toggle', $todo->id))
        ->assertStatus(403);

    assertDatabaseHas('todos', [
        'id' => $todo->id,
        'finished' => false,
    ]);
});
