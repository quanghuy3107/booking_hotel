@extends('admin.booking.search')

@section('booking_results')
    <div class="page-wrapper search-page-wrapper">
        <div class="search-result">
            <h3 class="search-result-title">検索結果</h3>
            @if ($bookingList->isNotEmpty())
                <div class="table-wrap">
                    <table class="shopsearchlist_table">
                        <thead>
                            <tr>
                                <td>顧客名</td>
                                <td>顧客連絡先</td>
                                <td>チェックイン日時</td>
                                <td>チェックアウト日時</td>
                                <td>予約日時</td>
                                <td>情報更新日時</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookingList as $booking)
                                <tr>
                                    <td>{{ $booking->customer_name }}</td>
                                    <td>{{ $booking->customer_contact }}</td>
                                    <td>{{ $booking->chekin_time ? $booking->chekin_time->format('Y-m-d H:i') : '-' }}</td>
                                    <td>{{ $booking->checkout_time ? $booking->checkout_time->format('Y-m-d H:i') : '-' }}</td>
                                    <td>{{ $booking->created_at ? $booking->created_at->format('Y-m-d H:i:s') : '-' }}</td>
                                    <td>{{ $booking->updated_at ? $booking->updated_at->format('Y-m-d H:i:s') : '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="no-results">検索結果がありません</p>
            @endif
        </div>
    </div>
@endsection
