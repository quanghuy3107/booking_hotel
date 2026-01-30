<!-- base view -->
@extends('common.admin.base')

<!-- CSS per page -->
@section('custom_css')
    @vite('resources/scss/admin/search.scss')
    @vite('resources/scss/admin/result.scss')
@endsection

<!-- main containts -->
@section('main_contents')
    <div class="page-wrapper search-page-wrapper">
        @if(session('success'))
            <p class="flash-success" style="color: green;">{{ session('success') }}</p>
        @endif
        @if(session('error'))
            <p class="flash-error" style="color: red;">{{ session('error') }}</p>
        @endif
        <h2 class="title">検索画面</h2>
        <hr>
        <div class="search-hotel-name admin-form-card">
            <form action="{{ route('adminHotelSearchResult') }}" method="get" class="search-form-inline">
                <div class="form-group">
                    <label for="hotel_name">ホテル名</label>
                    <input type="text" id="hotel_name" name="hotel_name" value="{{ isset($hotel_name) ? $hotel_name : request()->query('hotel_name', '') }}" placeholder="ホテル名">
                </div>
                <div class="form-group">
                    <label for="prefecture_id">都道府県</label>
                    <select id="prefecture_id" name="prefecture_id">
                        <option value="">選択してください</option>
                        @isset($prefectures)
                            @foreach($prefectures as $pref)
                                @php $currentPref = isset($prefecture_id) ? $prefecture_id : request()->query('prefecture_id'); @endphp
                                <option value="{{ $pref->prefecture_id }}" {{ (string)$currentPref === (string)$pref->prefecture_id ? 'selected' : '' }}>{{ $pref->prefecture_name }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">検索</button>
            </form>
        </div>
        <hr>
    </div>
    @yield('search_results')
@endsection