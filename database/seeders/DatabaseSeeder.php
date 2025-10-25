<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1) Categorías base
        $this->call(CategorySeeder::class);

        // 2) Usuarios
        User::factory(20)->create();

        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // 3) Categorías existentes
        $categories = Category::all();
        if ($categories->isEmpty()) {
            // por si alguien borra las categorías en algún momento
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
