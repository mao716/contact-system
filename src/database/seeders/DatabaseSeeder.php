<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->call(CategorySeeder::class); // カテゴリ作成

		\App\Models\Contact::factory(35)->create(); // ダミーのお問い合わせ作成
	}
}
