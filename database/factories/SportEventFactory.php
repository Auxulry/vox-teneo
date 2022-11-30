<?php
namespace Database\Factories;

use App\Models\Organizer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SportEvent>
 */
class SportEventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'organizer_id' => Organizer::factory(),
            'event_date' => fake()->date('Y-m-d H:i:s'),
            'event_name' => 'event-' . fake()->name(),
            'event_type' => fake()->randomElement(['publish', 'unpublish'])
        ];
    }
}
