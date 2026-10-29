<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class PesananController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.pesanan.dine_in');
    }

    public function dineIn(Request $request)
    {
        $query = Order::with('items')->where('order_type', 'dine_in')->latest();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('table_number', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(15);

        return view('admin.pesanan.dine_in', compact('orders'));
    }

    public function takeAway(Request $request)
    {
        $query = Order::with('items')->where('order_type', 'take_away')->latest();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(15);

        return view('admin.pesanan.take_away', compact('orders'));
    }

    public function show($id)
    {
        // Cari berdasarkan id atau order_number
        $order = is_numeric($id) 
            ? Order::with(['items.menu'])->findOrFail($id)
            : Order::with(['items.menu'])->where('order_number', $id)->firstOrFail();

        return view('admin.pesanan.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'order_status'   => ['nullable', 'in:pending,processing,completed,cancelled'],
            'payment_status' => ['nullable', 'in:unpaid,paid'],
        ]);

        $order->update(array_filter($validated));

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
