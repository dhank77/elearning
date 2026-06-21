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

    protected static function booted()
    {
        $sendNotification = function (CourseOrder $order) {
            if ($order->status === 'paid') {
                $user = $order->user;
                if ($user && $user->phone) {
                    $appName = config('app.name', 'EduMentor');
                    $amountFormatted = number_format($order->amount, 0, ',', '.');
                    
                    $message = "Halo *{$user->name}*,\n\nPembayaran Anda untuk kelas *{$order->course->title}* telah berhasil dikonfirmasi!\n\n*Detail Pesanan:*\n- Nomor Pesanan: {$order->order_number}\n- Kelas: {$order->course->title}\n- Total Pembayaran: Rp {$amountFormatted}\n- Metode: " . ($order->payment_method === 'xendit' ? 'Xendit' : ($order->payment_method === 'free' ? 'Gratis' : 'Transfer Bank Manual')) . "\n\nSekarang Anda sudah bisa mengakses kelas ini melalui Dashboard. Selamat belajar!\n\n--\n*{$appName}*";
                    
                    try {
                        app(\App\Services\FonnteService::class)->sendMessage($user->phone, $message);
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::error('Fonnte dispatch error: ' . $e->getMessage());
                    }
                }
            }
        };

        static::created(function (CourseOrder $order) use ($sendNotification) {
            $sendNotification($order);
        });

        static::updated(function (CourseOrder $order) use ($sendNotification) {
            if ($order->isDirty('status')) {
                $sendNotification($order);
            }
        });
    }

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
