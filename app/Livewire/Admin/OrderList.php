<?php

namespace App\Livewire\Admin;

use App\Models\Branch;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OrderList extends Component
{
    public string $selectedStatus = 'all';
    public string $selectedBranch = 'all';
    public string $search = '';
    public ?int $selectedOrderId = null;

    public function mount()
    {
        $user = Auth::user();
        if ($user && $user->isBranchManager() && $user->branch_id) {
            $this->selectedBranch = (string) $user->branch_id;
        }
    }

    public function updateOrderStatus(int $orderId, string $status)
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->status = $status;
            $order->save();
        }
    }

    public function viewOrder(int $orderId)
    {
        $this->selectedOrderId = $orderId;
    }

    public function closeOrderDetail()
    {
        $this->selectedOrderId = null;
    }

    public function render()
    {
        $user = Auth::user();
        $isManager = $user && $user->isBranchManager();
        $branches = Branch::where('is_active', true)->get();

        $query = Order::with('branch', 'items');

        // Apply Branch filter
        if ($isManager && $user->branch_id) {
            $query->where('branch_id', $user->branch_id);
        } elseif ($this->selectedBranch !== 'all') {
            $query->where('branch_id', (int) $this->selectedBranch);
        }

        // Apply Status filter
        if ($this->selectedStatus !== 'all') {
            $query->where('status', $this->selectedStatus);
        }

        // Apply Search filter
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('order_number', 'like', '%' . $this->search . '%')
                  ->orWhere('customer_name', 'like', '%' . $this->search . '%')
                  ->orWhere('customer_phone', 'like', '%' . $this->search . '%');
            });
        }

        $orders = $query->latest()->get();
        $activeOrder = $this->selectedOrderId ? Order::with('branch', 'items')->find($this->selectedOrderId) : null;

        return view('livewire.admin.order-list', [
            'orders' => $orders,
            'branches' => $branches,
            'isManager' => $isManager,
            'activeOrder' => $activeOrder,
        ])->layout('layouts.admin');
    }
}

