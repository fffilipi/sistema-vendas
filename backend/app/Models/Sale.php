<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'value', 'sale_date'];

    /**
     * Get the employee associated with the sale.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo The relationship indicating that a sale belongs to an employee.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
