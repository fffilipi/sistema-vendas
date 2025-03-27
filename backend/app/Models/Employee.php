<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email'];

    // Um vendedor pode ter várias vendas
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
