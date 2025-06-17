<?php

namespace App\Http\Controllers\Admin;

use App\Models\ShippingInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderDiTempatController extends Controller
{
    public function index()
    {
        $orders = ShippingInfo::where('method', 'ambil_di_tempat')
            ->with('order:id,status')
            ->latest()
            ->paginate(10);
        return view('admin.orderDitempat', compact('orders'));
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

        return redirect()->route('order.ditempat', ['id' => $id])->with('success', 'Status barang berhasil diperbarui.');
    }


    public function search(Request $request)
    {
        $search = $request->get('search');

    $orders = ShippingInfo::where('method', 'ambil_di_tempat')
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

    return view('admin.orderDitempat', compact('orders'))->render();
    }
}