<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{

    use HasApiTokens, HasRoles, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Reimbursement[] $reimbursements
     * @method \Illuminate\Database\Eloquent\Relations\HasMany reimbursements()
     */
    public function reimbursements()
    {
        return $this->hasMany(Reimbursement::class);
    }
}
