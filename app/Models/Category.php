<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'parent',
        'level'
    ];

    public function rules()
    {
        return [
            'name'   => 'required',
            'parent' => 'nullable|gt:0',
            'level'  => 'required|gt:0'
        ];
    }

    public function feedback()
    {
        return [
            'required' => 'The field is required',
            'gt'       => 'Value must be null or greater than 0'
        ];
    }
}
