<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Category;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Comment;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1) Categorías base (del seeder que hicimos)
        $this->call(CategorySeeder::class);

        // 2) Usuarios
        User::factory(20)->create();

        // Usuario fijo idempotente (no vuelve a fallar por UNIQUE)
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // 3) Obtén las categorías existentes (sembradas arriba)
        $categories = Category::all();
        if ($categories->isEmpty()) {
            // respaldo por si alguien borra las categorías
            $categories = Category::factory(4)->create();
        }

        // 4) Preguntas
        $questions = Question::factory(30)->create([
            'category_id' => fn () => $categories->random()->id,
            'user_id'     => fn () => User::inRandomOrder()->value('id'),
        ]);

        // 5) Respuestas
        Answer::factory(50)->create([
            'question_id' => fn () => $questions->random()->id,
            'user_id'     => fn () => User::inRandomOrder()->value('id'),
        ]);

        // 6) Comentarios (sobre preguntas)
        Comment::factory(100)->create([
            'commentable_id'   => fn () => $questions->random()->id,
            'commentable_type' => Question::class,
            'user_id'          => fn () => User::inRandomOrder()->value('id'),
        ]);
    }
}
