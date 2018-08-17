<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;
use App\Student;
use App\Teacher;
use App\Level;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Storage::deleteDirectory('courses');
        Storage::deleteDirectory('users');

        Storage::makeDirectory('courses');
        Storage::makeDirectory('users');

        factory(Role::class, 1)->create(['name' => 'admin']);
        factory(Role::class, 1)->create(['name' => 'teacher']);
        factory(Role::class, 1)->create(['name' => 'student']);

        factory(User::class, 1)->create([
            'name' => 'bob303',
            'email' => 'gdf000@gmail.com',
            'password' => bcrypt('secret'),
            'role_id' => Role::ADMIN,
        ])->each(function(User $u){
            factory(Student::class, 1)->create(['user_id' => $u->id]);
        });

        factory(User::class, 50)->create()->each(function(User $u){
            factory(Student::class, 1)->create(['user_id' => $u->id]);
        });

        factory(User::class, 10)->create()->each(function(User $u){
            factory(Student::class, 1)->create(['user_id' => $u->id]);
            factory(Teacher::class, 1)->create(['user_id' => $u->id]);
        });

        factory(Level::class, 1)->create(['name' => 'Principiante']);
        factory(Level::class, 1)->create(['name' => 'Intermedio']);
        factory(Level::class, 1)->create(['name' => 'Avanzado']);

        factory(Category::class, 5)->create();


    }
}
