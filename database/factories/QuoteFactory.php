<?php

namespace Database\Factories;

use App\Models\Quote;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class QuoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Quote::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name() . ' Quote',
            'description' => $this->faker->sentence(6, true),
            'content' => '{"time":1000000000000,"blocks":[{"id":"TXT3GZCFhx","type":"header","data":{"text":"Test Quote","level":1}},{"id":"5vjic4NRtH","type":"paragraph","data":{"text":"Test Quote Content"}}],"version":"0.0"}',
            'status' => Quote::STATUS_DRAFT
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
