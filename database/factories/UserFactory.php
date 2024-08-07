<?php

namespace Database\Factories;

use App\Http\Constantes\Constantes;
use App\Models\Oficina;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'clave' => User::max('clave') + 1,
            'valuador' => 1,
            'name' => $this->faker->name(),
            'ap_paterno' => $this->faker->word(),
            'ap_materno' => $this->faker->word(),
            'oficina_id' => Oficina::inRandomOrder()->first()->id,
            'area' => $this->faker->randomElement(Constantes::AREAS_ADSCRIPCION),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'status' => 'activo',
            'password' => '$2y$10$Ur7K1sG00.tfnozl8V97x.4fVhyMWK7Ydc1QXaraKmMCa.Y/mozqa', // 12345678
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'current_team_id' => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * Indicate that the user should have a personal team.
     */
    public function withPersonalTeam(): static
    {
        if (! Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        return $this->has(
            Team::factory()
                ->state(function (array $attributes, User $user) {
                    return ['name' => $user->name.'\'s Team', 'user_id' => $user->id, 'personal_team' => true];
                }),
            'ownedTeams'
        );
    }
}
