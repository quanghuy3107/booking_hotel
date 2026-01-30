<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Booking;

class BookingController extends Controller
{
    public function showSearch(): View
    {
        return view('admin.booking.search');
    }

    /**
     * @param Request $request
     * @return View
     */
    public function searchResult(Request $request): View
    {
        $customerName = trim((string) $request->input('customer_name', ''));
        $customerContact = trim((string) $request->input('customer_contact', ''));
        $chekinTime = trim((string) $request->input('chekin_time', ''));
        $checkoutTime = trim((string) $request->input('checkout_time', ''));

        $bookingList = Booking::searchBookings(
            $customerName ?: null,
            $customerContact ?: null,
            $chekinTime ?: null,
            $checkoutTime ?: null
        );

        return view('admin.booking.result', [
            'bookingList' => $bookingList,
        ]);
    }
}
