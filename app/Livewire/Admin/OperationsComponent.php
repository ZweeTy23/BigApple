<?php

namespace App\Livewire\Admin;

use App\Models\AttendanceRecord;
use App\Models\Branch;
use App\Models\CashShift;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\Product;
use App\Models\Supply;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin')]
#[Title('Operaciones de Sucursal | Big Apple')]
class OperationsComponent extends Component
{
    public string $activeTab = 'caja'; // caja, asistencia, insumos, gastos, menu
    public string $selectedBranch = 'all';

    // Caja Form Properties
    public float $openingAmount = 1500.00;
    public float $countedCash = 0.00;
    public string $shiftNotes = '';

    // Empleado Form Properties
    public string $employeeName = '';
    public string $employeePosition = 'Cocinero';
    public string $employeePhone = '';
    public float $employeeSalary = 9000.00;
    public int $employeeBranchId = 1;

    // Asistencia Modal/Form
    public string $attendanceNotes = '';

    // Insumo Form Properties
    public string $supplyName = '';
    public string $supplyCategory = 'Carnes & Pollo';
    public string $supplyUnit = 'kg';
    public float $supplyStock = 10.0;
    public float $supplyMinStock = 5.0;
    public float $supplyUnitCost = 50.00;

    // Gasto Form Properties
    public string $expenseCategory = 'Insumos / Perecederos';
    public string $expenseDescription = '';
    public float $expenseAmount = 0.00;
    public string $expensePaymentMethod = 'cash';
    public string $expenseReceipt = '';

    public string $flashMessage = '';

    public function mount()
    {
        $user = Auth::user();
        if ($user && $user->isBranchManager() && $user->branch_id) {
            $this->selectedBranch = (string) $user->branch_id;
            $this->employeeBranchId = (int) $user->branch_id;
        } else {
            $this->selectedBranch = '1'; // Default first branch for superadmin
            $this->employeeBranchId = 1;
        }
    }

    public function getActiveBranchProperty()
    {
        return Branch::find($this->selectedBranch) ?? Branch::first();
    }

    // ==========================================
    // 1. GESTIÓN DE CAJA
    // ==========================================
    public function openCashDrawer()
    {
        $user = Auth::user();
        $branchId = $user->isBranchManager() ? $user->branch_id : (int) $this->selectedBranch;

        $existing = CashShift::where('branch_id', $branchId)->where('status', 'open')->first();
        if ($existing) {
            $this->flashMessage = '⚠️ Ya existe una caja abierta para esta sucursal.';
            return;
        }

        CashShift::create([
            'branch_id' => $branchId,
            'user_id' => $user->id,
            'opened_at' => now(),
            'opening_amount' => $this->openingAmount,
            'expected_cash' => $this->openingAmount,
            'status' => 'open',
            'notes' => 'Apertura de turno por ' . $user->name,
        ]);

        $this->flashMessage = '✅ Caja abierta correctamente con $' . number_format($this->openingAmount, 2);
    }

    public function closeCashDrawer(int $shiftId)
    {
        $shift = CashShift::find($shiftId);
        if (!$shift || $shift->status === 'closed') {
            return;
        }

        $expected = $shift->opening_amount + $shift->cash_sales - $shift->cash_expenses;
        $difference = $this->countedCash - $expected;

        $shift->update([
            'closed_at' => now(),
            'counted_cash' => $this->countedCash,
            'expected_cash' => $expected,
            'difference' => $difference,
            'status' => 'closed',
            'notes' => $this->shiftNotes ?: 'Corte de caja cerrado sin notas adicionales.',
        ]);

        $this->flashMessage = '🔒 Corte de caja realizado exitosamente. Diferencia: $' . number_format($difference, 2);
    }

    // ==========================================
    // 2. GESTIÓN DE EMPLEADOS & ASISTENCIA
    // ==========================================
    public function createEmployee()
    {
        $this->validate([
            'employeeName' => 'required|min:3',
            'employeePosition' => 'required',
        ]);

        $user = Auth::user();
        $branchId = $user->isBranchManager() ? $user->branch_id : $this->employeeBranchId;

        Employee::create([
            'branch_id' => $branchId,
            'name' => $this->employeeName,
            'position' => $this->employeePosition,
            'phone' => $this->employeePhone,
            'salary_monthly' => $this->employeeSalary,
            'is_active' => true,
        ]);

        $this->reset(['employeeName', 'employeePhone']);
        $this->flashMessage = '✅ Empleado registrado correctamente.';
    }

    public function clockIn(int $employeeId)
    {
        $today = now()->toDateString();
        $record = AttendanceRecord::where('employee_id', $employeeId)->whereDate('date', $today)->first();

        if ($record) {
            $this->flashMessage = '⚠️ Este empleado ya registró su entrada hoy.';
            return;
        }

        $emp = Employee::find($employeeId);
        AttendanceRecord::create([
            'employee_id' => $employeeId,
            'branch_id' => $emp->branch_id,
            'date' => $today,
            'clock_in' => now()->toTimeString(),
            'status' => now()->hour > 13 ? 'late' : 'on_time',
            'notes' => 'Registro checador digital',
        ]);

        $this->flashMessage = '⏰ Entrada registrada para ' . $emp->name;
    }

    public function clockOut(int $employeeId)
    {
        $today = now()->toDateString();
        $record = AttendanceRecord::where('employee_id', $employeeId)->whereDate('date', $today)->first();

        if (!$record) {
            $this->flashMessage = '⚠️ No hay registro de entrada para marcar salida.';
            return;
        }

        $record->update([
            'clock_out' => now()->toTimeString(),
        ]);

        $this->flashMessage = '👋 Salida registrada para ' . $record->employee->name;
    }

    // ==========================================
    // 3. INSUMOS E INVENTARIO
    // ==========================================
    public function createSupply()
    {
        $this->validate([
            'supplyName' => 'required',
            'supplyStock' => 'required|numeric|min:0',
        ]);

        $user = Auth::user();
        $branchId = $user->isBranchManager() ? $user->branch_id : (int) $this->selectedBranch;

        Supply::create([
            'branch_id' => $branchId,
            'name' => $this->supplyName,
            'category' => $this->supplyCategory,
            'unit' => $this->supplyUnit,
            'current_stock' => $this->supplyStock,
            'min_stock' => $this->supplyMinStock,
            'unit_cost' => $this->supplyUnitCost,
        ]);

        $this->reset(['supplyName', 'supplyStock', 'supplyMinStock']);
        $this->flashMessage = '📦 Insumo agregado al inventario.';
    }

    public function adjustStock(int $supplyId, float $delta)
    {
        $supply = Supply::find($supplyId);
        if ($supply) {
            $supply->current_stock = max(0, $supply->current_stock + $delta);
            $supply->save();
            $this->flashMessage = '📦 Stock actualizado para ' . $supply->name . ' (' . $supply->current_stock . ' ' . $supply->unit . ')';
        }
    }

    // ==========================================
    // 4. COMPRAS Y GASTOS
    // ==========================================
    public function recordExpense()
    {
        $this->validate([
            'expenseDescription' => 'required|min:3',
            'expenseAmount' => 'required|numeric|min:1',
        ]);

        $user = Auth::user();
        $branchId = $user->isBranchManager() ? $user->branch_id : (int) $this->selectedBranch;

        Expense::create([
            'branch_id' => $branchId,
            'user_id' => $user->id,
            'category' => $this->expenseCategory,
            'description' => $this->expenseDescription,
            'amount' => $this->expenseAmount,
            'payment_method' => $this->expensePaymentMethod,
            'receipt_number' => $this->expenseReceipt,
            'date' => now()->toDateString(),
        ]);

        // Si fue en efectivo, descontar del turno de caja activo
        if ($this->expensePaymentMethod === 'cash') {
            $activeShift = CashShift::where('branch_id', $branchId)->where('status', 'open')->first();
            if ($activeShift) {
                $activeShift->cash_expenses += $this->expenseAmount;
                $activeShift->save();
            }
        }

        $this->reset(['expenseDescription', 'expenseAmount', 'expenseReceipt']);
        $this->flashMessage = '💸 Gasto registrado correctamente por $' . number_format($this->expenseAmount, 2);
    }

    // ==========================================
    // 5. BEBIDAS & MENÚ DISPONIBLE
    // ==========================================
    public function toggleProductStatus(int $productId)
    {
        $product = Product::find($productId);
        if ($product) {
            $product->is_available = !$product->is_available;
            $product->save();
            $this->flashMessage = '🍔 Estado de ' . $product->name . ' cambiado a: ' . ($product->is_available ? 'Disponible' : 'Agotado');
        }
    }

    public function render()
    {
        $user = Auth::user();
        $branches = Branch::all();
        $branchId = ($user && $user->isBranchManager()) ? $user->branch_id : (int) $this->selectedBranch;

        $currentShift = CashShift::where('branch_id', $branchId)->where('status', 'open')->latest()->first();
        $pastShifts = CashShift::where('branch_id', $branchId)->latest()->take(10)->get();

        $employees = Employee::where('branch_id', $branchId)->with('attendances')->get();
        $todayAttendance = AttendanceRecord::where('branch_id', $branchId)->whereDate('date', now()->toDateString())->with('employee')->get();

        $supplies = Supply::where('branch_id', $branchId)->orderBy('category')->get();
        $expenses = Expense::where('branch_id', $branchId)->latest()->take(20)->get();
        $products = Product::with('category')->orderBy('category_id')->get();

        return view('livewire.admin.operations-component', [
            'branches' => $branches,
            'currentShift' => $currentShift,
            'pastShifts' => $pastShifts,
            'employees' => $employees,
            'todayAttendance' => $todayAttendance,
            'supplies' => $supplies,
            'expenses' => $expenses,
            'products' => $products,
            'activeBranch' => Branch::find($branchId),
        ]);
    }
}
