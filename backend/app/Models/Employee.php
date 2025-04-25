<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email'];

    /**
     * Get the sales associated with the employee.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany The relationship indicating that an employee can have many sales.
     */
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
