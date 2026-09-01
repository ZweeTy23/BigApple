<?php

namespace App\Livewire\Admin;

use App\Models\Branch;
use App\Models\CashShift;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\Order;
use App\Models\Product;
use App\Models\Supply;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DashboardComponent extends Component
{
    public string $selectedBranch = 'all';

    public function mount()
    {
        $user = Auth::user();
        if ($user && $user->isBranchManager() && $user->branch_id) {
            $this->selectedBranch = (string) $user->branch_id;
        }
    }

    public function selectBranch(string $branchId)
    {
        $user = Auth::user();
        if ($user && $user->isSuperAdmin()) {
            $this->selectedBranch = $branchId;
        }
    }

    public function render()
    {
        $user = Auth::user();
        $isManager = $user && $user->isBranchManager();
        $branchId = $isManager ? $user->branch_id : ($this->selectedBranch === 'all' ? null : (int) $this->selectedBranch);

        $branches = Branch::where('is_active', true)->get();
        $activeBranchModel = $branchId ? Branch::find($branchId) : null;

        // Query orders with branch filter
        $ordersQuery = Order::query();
        $expensesQuery = Expense::query();
        $suppliesQuery = Supply::query();
        $shiftsQuery = CashShift::query();
        $employeesQuery = Employee::query();

        if ($branchId) {
            $ordersQuery->where('branch_id', $branchId);
            $expensesQuery->where('branch_id', $branchId);
            $suppliesQuery->where('branch_id', $branchId);
            $shiftsQuery->where('branch_id', $branchId);
            $employeesQuery->where('branch_id', $branchId);
        }

        $totalOrders = (clone $ordersQuery)->count();
        $pendingOrders = (clone $ordersQuery)->where('status', 'pending')->count();
        $completedOrders = (clone $ordersQuery)->where('status', 'completed')->count();
        $totalSales = (clone $ordersQuery)->where('status', '!=', 'cancelled')->sum('total');

        // Financials: Gastos y Utilidad Neta
        $totalExpenses = (clone $expensesQuery)->sum('amount');
        $netProfit = $totalSales - $totalExpenses;

        // Operaciones & Alertas
        $lowStockCount = (clone $suppliesQuery)->whereColumn('current_stock', '<=', 'min_stock')->count();
        $openShift = (clone $shiftsQuery)->where('status', 'open')->latest()->first();
        $totalEmployees = (clone $employeesQuery)->where('is_active', true)->count();

        $totalProducts = Product::count();
        $availableProducts = Product::where('is_available', true)->count();

        $recentOrders = (clone $ordersQuery)->with('branch', 'items')->latest()->take(6)->get();
        $recentExpenses = (clone $expensesQuery)->with('branch')->latest()->take(5)->get();

        // Branch Comparison (for Super Admin)
        $branchStats = [];
        if (!$isManager) {
            foreach ($branches as $b) {
                $bSales = Order::where('branch_id', $b->id)->where('status', '!=', 'cancelled')->sum('total');
                $bExpenses = Expense::where('branch_id', $b->id)->sum('amount');
                $bOrdersCount = Order::where('branch_id', $b->id)->count();
                $bShift = CashShift::where('branch_id', $b->id)->where('status', 'open')->first();

                $branchStats[] = [
                    'id' => $b->id,
                    'name' => $b->name,
                    'sales' => $bSales,
                    'expenses' => $bExpenses,
                    'net' => $bSales - $bExpenses,
                    'orders_count' => $bOrdersCount,
                    'has_open_shift' => (bool) $bShift,
                ];
            }
        }

        return view('livewire.admin.dashboard-component', [
            'branches' => $branches,
            'selectedBranch' => $this->selectedBranch,
            'activeBranchModel' => $activeBranchModel,
            'isManager' => $isManager,
            'totalProducts' => $totalProducts,
            'availableProducts' => $availableProducts,
            'totalOrders' => $totalOrders,
            'pendingOrders' => $pendingOrders,
            'completedOrders' => $completedOrders,
            'totalSales' => $totalSales,
            'totalExpenses' => $totalExpenses,
            'netProfit' => $netProfit,
            'lowStockCount' => $lowStockCount,
            'openShift' => $openShift,
            'totalEmployees' => $totalEmployees,
            'recentOrders' => $recentOrders,
            'recentExpenses' => $recentExpenses,
            'branchStats' => $branchStats,
        ])->layout('layouts.admin');
    }
}
