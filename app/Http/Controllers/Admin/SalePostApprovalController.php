<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SalePost;
use Illuminate\Http\Request;

class SalePostApprovalController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->q;

        $pending = SalePost::with('user')
            ->where('status', 0) // 0 = chờ duyệt
            ->when($q, function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                    ->orWhere('address', 'like', "%{$q}%")
                    ->orWhereHas('user', function ($u) use ($q) {
                        $u->where('name', 'like', "%{$q}%")
                          ->orWhere('email', 'like', "%{$q}%");
                    });
            })
            ->latest()
            ->paginate(10)
            ->appends($request->query());

        $approvedCount = SalePost::where('status', 1)->count();
        $pendingCount  = SalePost::where('status', 0)->count();

        return view('admin.posts.approve', compact('pending', 'approvedCount', 'pendingCount', 'q'));
    }

    public function show(SalePost $salePost)
    {
        $salePost->load('user');
        return view('admin.posts.approve_show', compact('salePost'));
    }

    public function approve(SalePost $salePost)
    {
        $salePost->update(['status' => 1]); // 1 = duyệt
        return back()->with('success', "Đã duyệt tin #{$salePost->id}");
    }

    public function reject(SalePost $salePost)
    {
        $salePost->update(['status' => 0]); // nếu bạn muốn reject -> vẫn 0 thì không khác
        // Gợi ý: nếu muốn “từ chối” riêng -> đổi schema status thành tinyint (0 pending, 1 approved, 2 rejected)
        return back()->with('success', "Đã từ chối (ẩn) tin #{$salePost->id}");
    }
}
