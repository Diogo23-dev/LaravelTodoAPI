<?php
use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\get;
use function Pest\Laravel\postJson;


uses(RefreshDatabase::class);


test('example', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('can list todos', function () {
    Todo::create([
        'title' => 'Apprendre Pest',
        'completed' => false,
    ]);

    $response = $this->getJson('/api/todos');

    $response
        ->assertOk()
        ->assertJsonCount(1)
        ->assertJsonFragment([
            'title' => 'Apprendre Pest',
        ]);
});

test('can create a todo', function () {
    $response = $this->postJson('/api/todos', [
        'title' => 'Créer mon premier test Pest',
    ]);

    $response->assertCreated();

    dump($response->json());

    $this->assertDatabaseHas('todos', [
        'title' => 'Créer mon premier test Pest',
        'completed' => false,
    ]);
});

test('cannot create a todo without a title', function () {
    $response = $this->postJson('/api/todos', []);

    $response
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['title']);
});

test('can update a todo', function () {
    $todo = Todo::create([
        'title' => 'Ancien titre',
        'completed' => false,
    ]);

    $response = $this->patchJson("/api/todos/{$todo->id}", [
        'title' => 'Nouveau titre',
        'completed' => true,
    ]);

    $response
        ->assertOk()
        ->assertJsonFragment([
            'title' => 'Nouveau titre',
            'completed' => true,
        ]);

    $this->assertDatabaseHas('todos', [
        'id' => $todo->id,
        'title' => 'Nouveau titre',
        'completed' => true,
    ]);
});

test('can delete a todo', function () {
    $todo = Todo::create([
        'title' => 'Todo à supprimer',
        'completed' => false,
    ]);

    $response = $this->deleteJson("/api/todos/{$todo->id}");

    $response->assertNoContent();

    $this->assertDatabaseMissing('todos', [
        'id' => $todo->id,
    ]);
});

test('can complete a todo', function () {
    $todo = Todo::create([
        'title' => 'Todo à terminer',
        'completed' => false,
    ]);

    $response = $this->patchJson("/api/todos/{$todo->id}/complete");

    $response
        ->assertOk()
        ->assertJsonFragment([
            'completed' => true,
        ]);

    $this->assertDatabaseHas('todos', [
        'id' => $todo->id,
        'completed' => true,
    ]);
});
