<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('bookings')->truncate();
        Schema::enableForeignKeyConstraints();

        $hotelIds = DB::table('hotels')->pluck('hotel_id')->take(5)->toArray();
        if (empty($hotelIds)) {
            return;
        }

        $now = Carbon::now();
        $bookings = [
            [
                'hotel_id' => $hotelIds[0],
                'customer_name' => '山田太郎',
                'customer_contact' => '090-1234-5678',
                'chekin_time' => $now->copy()->addDays(3)->setTime(15, 0)->format('Y-m-d H:i:s'),
                'checkout_time' => $now->copy()->addDays(5)->setTime(10, 0)->format('Y-m-d H:i:s'),
                'created_at' => $now->format('Y-m-d H:i:s'),
                'updated_at' => $now->format('Y-m-d H:i:s'),
            ],
            [
                'hotel_id' => $hotelIds[1],
                'customer_name' => '佐藤花子',
                'customer_contact' => '080-9876-5432',
                'chekin_time' => $now->copy()->addDays(7)->setTime(14, 0)->format('Y-m-d H:i:s'),
                'checkout_time' => $now->copy()->addDays(9)->setTime(11, 0)->format('Y-m-d H:i:s'),
                'created_at' => $now->format('Y-m-d H:i:s'),
                'updated_at' => $now->format('Y-m-d H:i:s'),
            ],
            [
                'hotel_id' => $hotelIds[2],
                'customer_name' => '鈴木一郎',
                'customer_contact' => '070-1111-2222',
                'chekin_time' => $now->copy()->addDays(1)->setTime(16, 0)->format('Y-m-d H:i:s'),
                'checkout_time' => $now->copy()->addDays(2)->setTime(10, 0)->format('Y-m-d H:i:s'),
                'created_at' => $now->copy()->subDays(2)->format('Y-m-d H:i:s'),
                'updated_at' => $now->copy()->subDays(2)->format('Y-m-d H:i:s'),
            ],
        ];

        foreach ($bookings as $booking) {
            DB::table('bookings')->insert($booking);
        }
    }
}
