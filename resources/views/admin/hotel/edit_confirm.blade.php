@extends('common.admin.base')

@section('custom_css')
    @vite('resources/scss/admin/search.scss')
@endsection

@section('main_contents')
    <div class="page-wrapper search-page-wrapper">
        <h2 class="title">編集内容確認</h2>
        <hr>
        <div class="search-hotel-name admin-form-card">
            <table class="confirm-table">
                <tbody>
                    <tr>
                        <td>ホテル名</td>
                        <td>{{ $editData['hotel_name'] }}</td>
                    </tr>
                    <tr>
                        <td>都道府県</td>
                        <td>{{ $editData['prefecture_name'] }}</td>
                    </tr>
                    <tr>
                        <td>ホテル画像</td>
                        <td>
                            @if(!empty($editData['has_new_image']))
                                新しい画像をアップロード済み
                            @else
                                {{ $hotel->file_path ? '変更なし' : 'なし' }}
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="confirm-actions">
                <form action="{{ route('adminHotelEditComplete', ['id' => $hotel->hotel_id]) }}" method="post" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-primary">更新する</button>
                </form>
                <a href="{{ route('adminHotelEditPage', ['id' => $hotel->hotel_id]) }}" class="btn btn-outline">戻る</a>
            </div>
        </div>
        <hr>
    </div>
@endsection
