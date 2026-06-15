<?php

namespace App\Models;

use Database\Factories\CourseOrderFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'course_id', 'order_number', 'amount', 'status', 'payment_method', 'xendit_invoice_id', 'xendit_payment_url', 'paid_at'])]
class CourseOrder extends Model
{
    /** @use HasFactory<CourseOrderFactory> */
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }
}
