@extends('admin.hotel.search')

@section('search_results')

    <div class="page-wrapper search-page-wrapper">
        <div class="search-result">
            <h3 class="search-result-title">検索結果</h3>
            @if ($hotelList->isNotEmpty())
                <div class="table-wrap">
                    <table class="shopsearchlist_table">
                        <thead>
                            <tr>
                                <td>ホテル名</td>
                                <td>都道府県</td>
                                <td>登録日</td>
                                <td>更新日</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hotelList as $hotel)
                                <tr>
                                    <td>{{ $hotel->hotel_name }}</td>
                                    <td>{{ $hotel->prefecture->prefecture_name ?? '-' }}</td>
                                    <td>{{ $hotel->created_at ? $hotel->created_at->format('Y-m-d H:i') : '-' }}</td>
                                    <td>{{ $hotel->updated_at ? $hotel->updated_at->format('Y-m-d H:i') : '-' }}</td>
                                    <td class="cell-actions">
                                        <a href="{{ route('adminHotelEditPage', ['id' => $hotel->hotel_id]) }}" class="btn btn-outline">編集</a>
                                    </td>
                                    <td class="cell-actions">
                                        <form action="{{ route('adminHotelDeleteProcess', ['id' => $hotel->hotel_id]) }}"
                                              method="post"
                                              class="form-delete-hotel"
                                              style="display:inline;"
                                              id="delete-form-{{ $hotel->hotel_id }}">
                                            @csrf
                                            <button type="button"
                                                    class="btn btn-danger"
                                                    onclick="showDeleteConfirm({{ $hotel->hotel_id }}, '{{ $hotel->hotel_name }}')">
                                                削除
                                            </button>
                                        </form>


                                    </td>
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
    <div class="modal-overlay" id="deleteModal">
        <div class="modal-content">
            <div class="modal-title">本当に削除してもよろしいですか？</div>
            <div class="modal-buttons">
                <button class="modal-btn btn-cancel" onclick="closeDeleteModal()">キャンセル</button>
                <button class="modal-btn btn-ok" onclick="confirmDelete()">削除</button>
            </div>
        </div>
    </div>


    <script>
        let currentDeleteFormId = null;

        function showDeleteConfirm(hotelId, hotelName) {
            currentDeleteFormId = 'delete-form-' + hotelId;
            document.getElementById('deleteModal').classList.add('active');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('active');
            currentDeleteFormId = null;
        }

        function confirmDelete() {
            if (currentDeleteFormId) {
                document.getElementById(currentDeleteFormId).submit();
            }
        }

        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });
    </script>

@endsection
