<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\File;
use Illuminate\Http\RedirectResponse;
use App\Models\Hotel;
use App\Models\Prefecture;

class HotelController extends Controller
{
    /** get methods */

    public function showSearch(Request $request): View
    {
        $prefectures = Prefecture::orderBy('prefecture_id')->get();
        $hotelList = Hotel::with('prefecture')->orderBy('hotel_id')->get();

        return view('admin.hotel.result', [
            'hotelList' => $hotelList,
            'prefectures' => $prefectures,
            'hotel_name' => '',
            'prefecture_id' => null,
        ]);
    }

    public function showResult(): View
    {
        return view('admin.hotel.result');
    }

    public function showEdit($id): View
    {
        $hotel = Hotel::findOrFail($id);
        $prefectures = Prefecture::orderBy('prefecture_id')->get();
        return view('admin.hotel.edit', compact('hotel', 'prefectures'));
    }

    public function showCreate(): View
    {
        $prefectures = Prefecture::orderBy('prefecture_id')->get();
        return view('admin.hotel.create', compact('prefectures'));
    }


    public function searchResult(Request $request): View
    {
        $hotelName = trim((string) $request->input('hotel_name', ''));
        $prefectureId = $request->input('prefecture_id');
        if ($prefectureId === '' || $prefectureId === null) {
            $prefectureId = null;
        } else {
            $prefectureId = (int) $prefectureId;
        }

        $hotelList = Hotel::when($hotelName, function ($query) use ($hotelName) {
            return $query->where('hotel_name', 'LIKE', '%' . $hotelName . '%');
        })
            ->when($prefectureId, function ($query) use ($prefectureId) {
                return $query->where('prefecture_id', $prefectureId);
            })
            ->with('prefecture')
            ->orderBy('hotel_id')
            ->get();
        
        $prefectures = Prefecture::orderBy('prefecture_id')->get();

        return view('admin.hotel.result', [
            'hotelList' => $hotelList,
            'prefectures' => $prefectures,
            'hotel_name' => $hotelName,
            'prefecture_id' => $prefectureId,
        ]);
    }

    public function editConfirm(Request $request, $id)
    {
        $request->validate([
            'hotel_name' => 'required|string|max:255',
            'prefecture_id' => 'required|integer|exists:prefectures,prefecture_id',
            'file_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $hotel = Hotel::findOrFail($id);
        $prefecture = Prefecture::find($request->input('prefecture_id'));
        $tempFilePath = null;

        if ($request->hasFile('file_path')) {
            $tempDir = storage_path('app/temp/hotel_edit');
            if (!File::isDirectory($tempDir)) {
                File::makeDirectory($tempDir, 0755, true);
            }
            $tempFileName = $id . '_' . uniqid('', true) . '.' . $request->file('file_path')->getClientOriginalExtension();
            $request->file('file_path')->move($tempDir, $tempFileName);
            $tempFilePath = $tempDir . DIRECTORY_SEPARATOR . $tempFileName;
        }

        session([
            'edit_hotel' => [
                'id' => (int) $id,
                'hotel_name' => $request->input('hotel_name'),
                'prefecture_id' => (int) $request->input('prefecture_id'),
                'prefecture_name' => $prefecture ? $prefecture->prefecture_name : '',
                'temp_file_path' => $tempFilePath,
            ],
        ]);

        $editData = session('edit_hotel');
        $editData['has_new_image'] = !empty($editData['temp_file_path']) && File::exists($editData['temp_file_path']);

        return view('admin.hotel.edit_confirm', [
            'hotel' => $hotel,
            'editData' => $editData,
        ]);
    }

    public function editComplete(Request $request, $id): RedirectResponse
    {
        $editData = session('edit_hotel');
        if (!$editData || (int) $editData['id'] !== (int) $id) {
            return redirect()->route('adminHotelSearchPage')->with('error', 'セッションが無効です。');
        }

        $hotel = Hotel::findOrFail($id);
        $hotel->hotel_name = $editData['hotel_name'];
        $hotel->prefecture_id = $editData['prefecture_id'];

        if (!empty($editData['temp_file_path']) && File::exists($editData['temp_file_path'])) {
            if ($hotel->file_path && File::exists(public_path('assets/img/' . $hotel->file_path))) {
                File::delete(public_path('assets/img/' . $hotel->file_path));
            }
            $dir = public_path('assets/img/hotel');
            if (!File::isDirectory($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            $filename = uniqid('', true) . '.' . pathinfo($editData['temp_file_path'], PATHINFO_EXTENSION);
            $destPath = $dir . DIRECTORY_SEPARATOR . $filename;
            File::move($editData['temp_file_path'], $destPath);
            $hotel->file_path = 'hotel/' . $filename;
        }

        $hotel->save();
        session()->forget('edit_hotel');

        return redirect()->route('adminHotelSearchPage')->with('success', '更新しました');
    }

    public function create(Request $request)
    {
        $request->validate([
            'hotel_name' => 'required|string|max:255',
            'prefecture_id' => 'required|integer|exists:prefectures,prefecture_id',
            'file_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $hotel = new Hotel();
        $hotel->hotel_name = $request->input('hotel_name');
        $hotel->prefecture_id = $request->input('prefecture_id');

        if ($request->hasFile('file_path')) {
            $hotel->file_path = $this->storeHotelImage($request->file('file_path'));
        }

        $hotel->save();

        return redirect()->route('adminHotelSearchPage')->with('success', 'Hotel created successfully.');
    }

    public function delete(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->delete();

        return redirect()->route('adminHotelSearchPage')->with('success', 'Hotel deleted successfully.');
    }

    private function storeHotelImage(\Illuminate\Http\UploadedFile $file): string
    {
        $dir = public_path('assets/img/hotel');
        if (!File::isDirectory($dir)) {
            File::makeDirectory($dir, 0755, true);
        }
        $filename = uniqid('', true) . '.' . $file->getClientOriginalExtension();
        $file->move($dir, $filename);

        return 'hotel/' . $filename;
    }
}
