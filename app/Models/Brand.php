<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description'
    ];

    public function rules()
    {
        return [
            'name'        => 'required',
            'description' => 'nullable'
        ];
    }

    public function feedback()
    {
        return [
            'required' => 'The field is required'
        ];
    }
}
