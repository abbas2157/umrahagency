<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PayrollItem extends Model
{
    protected $fillable = [
        'payroll_id',
        'agent_id',
        'base_salary',
        'commission',
        'bonus',
        'advance_deduct',
        'other_deduct',
        'tax_deduct',
        'net_payable',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'base_salary' => 'decimal:2',
            'commission' => 'decimal:2',
            'bonus' => 'decimal:2',
            'advance_deduct' => 'decimal:2',
            'other_deduct' => 'decimal:2',
            'tax_deduct' => 'decimal:2',
            'net_payable' => 'decimal:2',
        ];
    }

    public function payroll(): BelongsTo
    {
        return $this->belongsTo(Payroll::class);
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}
