<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contacts', function (Blueprint $table) {
			$table->id();

			$table->foreignID('category_id')
				->constrained('categories')
				->cascadeOnUpdate() // 親テーブル（categories）のIDが変更されたら、子テーブル（contacts）の参照も自動で更新する
				->restrictOnDelete(); // もしカテゴリが1件でも問い合わせに使われていたら、そのカテゴリを削除できない

			$table->string('first_name');
			$table->string('last_name');
			$table->tinyInteger('gender'); // 1:男性 2:女性 3:その他
			$table->string('email');
			$table->string('tel');
			$table->string('address');
			$table->string('building')->nullable();
			$table->text('detail'); // 制約（120文字以内）はバリデーションで

			$table->timestamps();

			// 検索用インデックス
			$table->index(['last_name', 'first_name']);
			$table->index('email');
			$table->index('gender');
			$table->index('category_id');
			$table->index('created_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('contacts');
	}
}
