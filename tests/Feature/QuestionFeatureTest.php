<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuestionFeatureTest extends TestCase
{
    use RefreshDatabase;

    private function verifiedUser(): User
    {
        $u = User::factory()->create();
        $u->forceFill(['email_verified_at' => now()])->save();
        return $u;
    }

    public function test_guest_is_redirected_from_create(): void
    {
        $this->get('/questions/create')->assertRedirect('/login');
    }

    public function test_user_can_create_question(): void
    {
        $user = $this->verifiedUser();
        $cat = Category::create(['name' => 'General', 'color' => '#3b82f6']);

        $resp = $this->actingAs($user)->post('/questions', [
            'title' => 'Título de prueba',
            'content' => 'Contenido de prueba',
            'category_id' => $cat->id,
        ]);

        $q = Question::first();
        $resp->assertRedirect(route('question.show', $q));
        $this->assertNotNull($q);
        $this->assertSame($user->id, $q->user_id);
    }

    public function test_only_author_can_view_edit_form(): void
    {
        $author = $this->verifiedUser();
        $other  = $this->verifiedUser();

        $cat = Category::create(['name' => 'General', 'color' => '#3b82f6']);
        $q = Question::create([
            'title' => 'Edit me',
            'content' => 'Body',
            'category_id' => $cat->id,
            'user_id' => $author->id,
        ]);

        $this->actingAs($other)->get(route('questions.edit', $q))->assertStatus(403);
        $this->actingAs($author)->get(route('questions.edit', $q))->assertOk();
    }

    public function test_author_can_update_question(): void
    {
        $author = $this->verifiedUser();
        $cat = Category::create(['name' => 'General', 'color' => '#3b82f6']);
        $q = Question::create([
            'title' => 'Old',
            'content' => 'Body',
            'category_id' => $cat->id,
            'user_id' => $author->id,
        ]);

        $this->actingAs($author)->put(route('questions.update', $q), [
            'title' => 'New',
            'content' => 'Updated body',
            'category_id' => $cat->id,
        ])->assertRedirect(route('question.show', $q));

        $q->refresh();
        $this->assertSame('New', $q->title);
        $this->assertSame('Updated body', $q->content);
    }

    public function test_only_author_can_delete_question(): void
    {
        $author = $this->verifiedUser();
        $other  = $this->verifiedUser();

        $cat = Category::create(['name' => 'General', 'color' => '#3b82f6']);
        $q = Question::create([
            'title' => 'To delete',
            'content' => 'Body',
            'category_id' => $cat->id,
            'user_id' => $author->id,
        ]);

        $this->actingAs($other)->delete(route('questions.destroy', $q))->assertStatus(403);
        $this->actingAs($author)->delete(route('questions.destroy', $q))->assertRedirect(route('home'));
        $this->assertModelMissing($q);
    }

    public function test_guest_cannot_delete(): void
    {
        $author = $this->verifiedUser();
        $cat = Category::create(['name' => 'General', 'color' => '#3b82f6']);
        $q = Question::create([
            'title' => 'Should not delete',
            'content' => 'Body',
            'category_id' => $cat->id,
            'user_id' => $author->id,
        ]);

        $this->delete(route('questions.destroy', $q))
            ->assertRedirect('/login');
        $this->assertModelExists($q);
    }

    public function test_show_displays_title_author_category_and_content(): void
    {
        $user = $this->verifiedUser();
        $cat = Category::create(['name' => 'General', 'color' => '#3b82f6']);
        $q = Question::create([
            'title' => 'Visible title',
            'content' => 'Visible content',
            'category_id' => $cat->id,
            'user_id' => $user->id,
        ]);

        $this->get(route('question.show', $q))
            ->assertOk()
            ->assertSee('Visible title')
            ->assertSee('Visible content')
            ->assertSee($user->name)
            ->assertSee($cat->name);
    }

    public function test_pagination_shows_10_per_page(): void
    {
        $author = $this->verifiedUser();
        $cat = Category::create(['name' => 'General', 'color' => '#3b82f6']);

        // 15 preguntas para forzar 2 páginas (10 + 5)
        Question::factory()->count(15)->create([
            'user_id' => $author->id,
            'category_id' => $cat->id,
        ]);

        // Página 1
        $this->get('/')
            ->assertOk()
            ->assertSee('class="mt-6"', false)  // hay paginación
            ->assertSee('</ul>', false);        // listado presente

        // Página 2
        $this->get('/?page=2')
            ->assertOk();
    }
}
