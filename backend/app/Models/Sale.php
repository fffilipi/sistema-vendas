<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'amount', 'sale_date'];

    // Uma venda pertence a um vendedor
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
