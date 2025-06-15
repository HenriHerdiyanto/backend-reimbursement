<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'limit_per_month'];

    public function reimbursements()
    {
        return $this->hasMany(Reimbursement::class);
    }
}
