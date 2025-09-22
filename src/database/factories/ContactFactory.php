<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

class ContactFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition(): array
	{
		return [
			'category_id' => Category::inRandomOrder()->value('id') ?? 1, // ランダムカテゴリID
			'first_name'  => $this->faker->firstName(),
			'last_name'   => $this->faker->lastName(),
			'gender'      => $this->faker->numberBetween(1, 3), // 1=男,2=女,3=その他
			'email'       => $this->faker->unique()->safeEmail(),
			'tel'         => '0' . $this->faker->numberBetween(70, 90) . $this->faker->numberBetween(10000000, 99999999),
			'address'     => $this->faker->city() . $this->faker->streetAddress(),
			'building'    => $this->faker->optional()->secondaryAddress(),
			'detail'      => mb_substr($this->faker->realText(80), 0, 120),
			'created_at'  => now(),
			'updated_at'  => now(),
		];
	}
}
