<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class Hotel extends Model
{
    /**
     * @var string Primary key
     */
    protected $primaryKey = 'hotel_id';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['hotel_id'];

    /**
     * Relationship: Hotel belongs to a Prefecture
     *
     * @return BelongsTo
     */
    public function prefecture(): BelongsTo
    {
        return $this->belongsTo(Prefecture::class, 'prefecture_id', 'prefecture_id');
    }

    /**
     * Relationship: Hotel has many Bookings
     *
     * @return HasMany
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'hotel_id', 'hotel_id');
    }

    /**
     * Search hotels by name (case-insensitive search)
     *
     * @param string $hotelName
     * @return Collection
     */
    public static function getHotelListByName(string $hotelName): Collection
    {
        return self::where('hotel_name', 'LIKE', '%' . $hotelName . '%')
            ->with('prefecture')
            ->get();
    }

    /**
     * Search hotels by multiple criteria
     *
     * @param string|null $hotelName
     * @param int|null $prefectureId
     * @return Collection
     */
    public static function searchHotels(?string $hotelName = null, ?int $prefectureId = null): Collection
    {
        return self::when($hotelName, function ($query) use ($hotelName) {
            return $query->where('hotel_name', 'LIKE', '%' . $hotelName . '%');
        })
            ->when($prefectureId, function ($query) use ($prefectureId) {
                return $query->where('prefecture_id', $prefectureId);
            })
            ->with('prefecture')
            ->get();
    }

    /**
     * Search hotels with backend pagination.
     *
     * @param string|null $hotelName
     * @param int|null $prefectureId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public static function searchHotelsPaginate(?string $hotelName = null, ?int $prefectureId = null, int $perPage = 10): LengthAwarePaginator
    {
        return self::when($hotelName, function ($query) use ($hotelName) {
            return $query->where('hotel_name', 'LIKE', '%' . $hotelName . '%');
        })
            ->when($prefectureId, function ($query) use ($prefectureId) {
                return $query->where('prefecture_id', $prefectureId);
            })
            ->with('prefecture')
            ->orderBy('hotel_id')
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * Override serializeDate method to customize date format
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
