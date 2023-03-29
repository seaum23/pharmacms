<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseRequest;
use App\Models\Expense;
use Illuminate\Http\Request;
use App\Http\Resources\ExpenseResource;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \App\Http\Resources\ExpenseResource
     */
    public function index()
    {
        return new ExpenseResource(Expense::get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseRequest $request)
    {
        $expense = Expense::create($request->validated());

        return response($expense, 201);
    }
}
