<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	use HasFactory;

	protected $fillable = ['content']; // 一括代入可能なカラム

	public function contacts()
	{
		return $this->hasMany(Contact::class); // リレーション（1対多）
	}
}
