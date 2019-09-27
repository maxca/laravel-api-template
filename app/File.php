<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'name',
        'extension',
        'path',
        'type',
        'size',
    ];

    public function profile()
    {
        return $this->morphedByMany(User::class, 'fileables');
    }

    public function book()
    {
        return $this->morphedByMany(User::class, 'fileables');
    }
}
