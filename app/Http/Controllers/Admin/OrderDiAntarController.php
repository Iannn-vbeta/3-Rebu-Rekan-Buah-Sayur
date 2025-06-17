<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ShippingInfo;
use Illuminate\Http\Request;

class OrderDiAntarController extends Controller
{
    public function index()
    {
        $orders = ShippingInfo::where('method', 'antar')
            ->with('order:id,status')
            ->latest()
            ->paginate(10);
        return view('admin.orderDiantar', compact('orders'));
    }

    public function update(Request $request, $id)
    {
        $shippingInfo = ShippingInfo::findOrFail($id);

        $validated = $request->validate([
            'status_barang' => 'required', 
        ]);

        $shippingInfo->update([
            'status_barang' => $validated['status_barang'],
        ]);

        return redirect()->route('order.diantar', ['id' => $id])->with('success', 'Status barang berhasil diperbarui.');
    }


    public function search(Request $request)
    {
        $search = $request->get('search');

    $orders = ShippingInfo::where('method', 'antar')
        ->where(function ($query) use ($search) {
            $query->where('order_id', 'like', "%$search%")
                  ->orWhere('address', 'like', "%$search%")
                  ->orWhere('status_barang', 'like', "%$search%");
        })
        ->with('order:id,status')
        ->latest()
        ->paginate(10);

    if ($request->ajax()) {
        return view('components.admin.order-diantar-table', compact('orders'))->render();
    }

    return view('admin.orderDiantar', compact('orders'))->render();
    }
}