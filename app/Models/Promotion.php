<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Promotion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'value',
        'status',
        'frequency',
        'price_field',
        'value_type',
        'change'
    ];

    public function rules()
    {
        return [
            'name' => 'required',
            'start_date' => 'required|date_format:Y-m-d H:i:s',
            'end_date' => 'nullable|date_format:Y-m-d H:i:s|after:start_date',
            'value' => 'required|gt:0',
            'value_type' => [
                'required',
                Rule::in(['percent', 'monetary'])
            ],
            'status' => [
                'required',
                Rule::in(['active', 'inactive'])
            ],
            'frequency' => [
                'required',
                Rule::in(['single', 'weekly', 'monthly', 'annual'])
            ],
            'price_field' => [
                'required',
                Rule::in(['price', 'promotional_price', 'both'])
            ],
            'change' => [
                'required',
                Rule::in(['increase', 'decrease'])
            ]
        ];
    }

    public function feedback()
    {
        return [
            'required'       => 'The field is required',
            'date_format'    => 'The field format must be "Y-m-d H:i:s"',
            'end_date.after' => [
                'The value must be greater than field',
                'start_date'
            ],
            'value.gt'       => 'The value must be more than 0',
            'value_type.in'  => [
                'message' => 'Invalid value',
                'accepted_values' => '[\'percent\',\'monetary\']'
            ],
            'status.in'      => [
                'accepted_values' => '[\'active\',\'inactive\']'
            ],
            'frequency.in'   => [
                'message' => 'Invalid value',
                'accepted_values' => '[\'single\', \'weekly\', \'monthly\', \'annual\']'
            ],
            'price_field.in' => [
                'message' => 'Invalid value',
                'accepted_values' => '[\'price\', \'promotional_price\', \'both\']'
            ],
            'change.in'      => [
                'message' => 'Invalid value',
                'accepted_values' => '[\'increase\', \'decrease\']'
            ],
        ];
    }
}
