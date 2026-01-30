<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class Booking extends Model
{
    protected $primaryKey = 'booking_id';

    protected $guarded = ['booking_id'];

    protected $casts = [
        'chekin_time' => 'datetime',
        'checkout_time' => 'datetime',
    ];

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class, 'hotel_id', 'hotel_id');
    }

    public static function searchBookings(
        ?string $customerName = null,
        ?string $customerContact = null,
        ?string $chekinTimeFrom = null,
        ?string $checkoutTimeFrom = null
    ): Collection {
        return self::query()
            ->when($customerName !== null && trim($customerName) !== '', function (Builder $q) use ($customerName) {
                $q->where('customer_name', 'LIKE', '%' . trim($customerName) . '%');
            })
            ->when($customerContact !== null && trim($customerContact) !== '', function (Builder $q) use ($customerContact) {
                $q->where('customer_contact', 'LIKE', '%' . trim($customerContact) . '%');
            })
            ->when($chekinTimeFrom !== null && trim($chekinTimeFrom) !== '', function (Builder $q) use ($chekinTimeFrom) {
                $q->whereDate('chekin_time', '>=', $chekinTimeFrom);
            })
            ->when($checkoutTimeFrom !== null && trim($checkoutTimeFrom) !== '', function (Builder $q) use ($checkoutTimeFrom) {
                $q->whereDate('checkout_time', '>=', $checkoutTimeFrom);
            })
            ->with('hotel')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
