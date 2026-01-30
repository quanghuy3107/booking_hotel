@extends('common.admin.base')

@section('custom_css')
    @vite('resources/scss/admin/search.scss')
    @vite('resources/scss/admin/result.scss')
@endsection

@section('main_contents')
    <div class="page-wrapper search-page-wrapper">
        <h2 class="title">予約情報検索</h2>
        <hr>
        <div class="search-hotel-name admin-form-card">
            <form action="{{ route('adminBookingSearchResult') }}" method="post">
                @csrf
                <div class="admin-form-row">
                    <label for="customer_name">顧客名</label>
                    <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name', '') }}" placeholder="顧客名">
                </div>
                <div class="admin-form-row">
                    <label for="customer_contact">顧客連絡先</label>
                    <input type="text" id="customer_contact" name="customer_contact" value="{{ old('customer_contact', '') }}" placeholder="顧客連絡先">
                </div>
                <div class="admin-form-row">
                    <label for="chekin_time">チェックイン日時</label>
                    <input type="datetime-local" id="chekin_time" name="chekin_time" value="{{ old('chekin_time', '') }}">
                </div>
                <div class="admin-form-row">
                    <label for="checkout_time">チェックアウト日時</label>
                    <input type="datetime-local" id="checkout_time" name="checkout_time" value="{{ old('checkout_time', '') }}">
                </div>
                <div class="admin-form-actions">
                    <button type="submit" class="btn btn-primary">検索</button>
                </div>
            </form>
        </div>
        <hr>
    </div>
    @yield('booking_results')
@endsection
