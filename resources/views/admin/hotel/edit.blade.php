@extends('common.admin.base')

@section('custom_css')
    @vite('resources/scss/admin/search.scss')
@endsection

@section('main_contents')
    <div class="page-wrapper search-page-wrapper">
        <h2 class="title">ホテル情報編集</h2>
        <hr>
        <div class="search-hotel-name admin-form-card">
            <form action="{{ route('adminHotelEditConfirm', ['id' => $hotel->hotel_id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="admin-form-row">
                    <label for="hotel_name">ホテル名 <span class="required">*</span></label>
                    <input type="text" id="hotel_name" name="hotel_name" value="{{ old('hotel_name', $hotel->hotel_name) }}" maxlength="255" required>
                    @error('hotel_name')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                <div class="admin-form-row">
                    <label for="prefecture_id">都道府県 <span class="required">*</span></label>
                    <select id="prefecture_id" name="prefecture_id" required>
                        @foreach($prefectures as $pref)
                            <option value="{{ $pref->prefecture_id }}" {{ old('prefecture_id', $hotel->prefecture_id) == $pref->prefecture_id ? 'selected' : '' }}>{{ $pref->prefecture_name }}</option>
                        @endforeach
                    </select>
                    @error('prefecture_id')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                <div class="admin-form-row">
                    <label for="file_path">ホテル画像（任意）</label>
                    @if($hotel->file_path)
                        <div class="current-image">
                            <p>現在の画像:</p>
                            <img src="{{ asset('assets/img/' . $hotel->file_path) }}" alt="{{ $hotel->hotel_name }}">
                        </div>
                    @endif
                    <input type="file" id="file_path" name="file_path" accept="image/jpeg,image/png,image/jpg,image/gif">
                    @error('file_path')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                <div class="admin-form-actions">
                    <button type="submit" class="btn btn-primary">確認画面へ</button>
                </div>
            </form>
        </div>
        <hr>
    </div>
@endsection
