<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use Illuminate\Http\Request;
use App\Models\Colocation;
use App\Models\Category;
use App\Models\Expense;

class ExpenseController extends Controller
{
    public function index(Colocation $colocation)
    {
    $expenses = $colocation->expenses()
        ->with(['payer', 'category'])
        ->latest()
        ->get();

    return view('expenses.index', compact('colocation', 'expenses'));
    }

    public function create(Colocation $colocation)
    {
    $categories = $colocation->categories;
    $members = $colocation->members;

    return view('expenses.create', compact('colocation', 'categories', 'members'));
    }

    public function store(StoreExpenseRequest $request, Colocation $colocation)
    {
    $request->validated();

    Expense::create([
        'title' => $request->title,
        'amount' => $request->amount,
        'date' => $request->date,
        'payer_id' => $request->payer_id,
        'category_id' => $request->category_id,
        'colocation_id' => $colocation->id,
    ]);

    return redirect()->route('expenses.index', $colocation)
        ->with('success', 'Expense added');
    }

    public function destroy(Expense $expense)
    {
    $expense->delete();

    return back();
    }
}
