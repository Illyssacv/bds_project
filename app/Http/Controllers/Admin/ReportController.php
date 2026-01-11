<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Danh sách report
     */
    public function index(Request $request)
    {
        $status = $request->status; // null | 0 | 1 | 2

        $reports = Report::with(['salePost', 'reporter'])
            ->when($status !== null, function ($q) use ($status) {
                $q->where('status', (int) $status);
            })
            ->latest()
            ->paginate(10);

        return view('admin.report.index', compact('reports', 'status'));
    }

    /**
     * Duyệt report + ẩn bài đăng
     */
    public function reviewAndHide($id)
    {
        $report = Report::with('salePost')->findOrFail($id);

        // Chỉ xử lý nếu còn pending
        if ($report->status !== Report::STATUS_PENDING) {
            return back()->with('error', 'Report này đã được xử lý.');
        }

        // Gọi business logic trong Model
        $report->markAsReviewedAndHidePost();

        return back()->with('success', 'Đã duyệt report và ẩn bài đăng.');
    }

    /**
     * Bác bỏ report
     */
    public function dismiss($id)
    {
        $report = Report::findOrFail($id);

        if ($report->status !== Report::STATUS_PENDING) {
            return back()->with('error', 'Report này đã được xử lý.');
        }

        $report->dismiss();

        return back()->with('success', 'Đã bác bỏ report.');
    }
}
