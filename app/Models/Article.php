<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    // 以下の $fillable を追加（保存を許可するカラム名を配列で指定）
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'body',
        'tags',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}