<?php

namespace App\Http\Controllers\Admin;

use App\Models\Table;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TableStoreRequest;

class TableController extends Controller
{
    public function index()
    {
        $tables=Table::all();
        return view('admin.tables.index',compact('tables'));
    }
    public function create()
    {
        $status_lists=Table::statusLists();
        $location_lists = Table::locationLists();
        return view('admin.tables.create', compact('status_lists', 'location_lists'));
    }
    public function store(TableStoreRequest $request)
    {
        Table::create([
            'name' => $request->name,
            'guest_number' => $request->guest_number,
            'status' => $request->status,
            'location' => $request->location,
        ]);

        return to_route('admin.tables.index')->with('success', 'Table created successfully.');
    }
    public function edit(Table $table)
    {
        $status_lists = Table::statusLists();
        $location_lists = Table::locationLists();
        return view('admin.tables.edit', compact('table', 'status_lists', 'location_lists'));
    }
    public function update(TableStoreRequest $request, Table $table)
    {
        $table->update($request->validated());

        return to_route('admin.tables.index')->with('success', 'Table updated successfully.');
    }
    public function destroy(Table $table)
    {
        $table->reservations()->delete();
        $table->delete();

        return to_route('admin.tables.index')->with('danger', 'Table daleted successfully.');
    }
}
