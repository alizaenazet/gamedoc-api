<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $roles = ['pyscholog','psikiater','fisioterapis','social worker'];
        $services = ['personal','group'];
        $degree = ['S.Ps','M.Psi', 'Psy.D', ' Ph.D', 'S.Ked', 'Sp.KJ', 'M.Ked', 'S.Ft', 'M.Ft', 'S.Sos', 'M.Sos'];
        return [
            'profession' => $roles[random_int(0,3)],
            'service' => $services[random_int(0,1)],
            'degree' => $degree[random_int(0,(count($degree)-1))],
            'rating' => fake()->randomFloat(1,$min = 0.5, $max = 5.0),
        ];
    }
}
