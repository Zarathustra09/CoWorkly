<?php

namespace App\Http\Controllers;

use App\Models\WorkSpace;
use Illuminate\Http\Request;

class WorkSpaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = WorkSpace::with('category')->where('is_available', true);

        // Apply category filter if provided
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        $workspaces = $query->orderBy('is_premium', 'desc')
            ->orderBy('name', 'asc')
            ->paginate(9);

        return view('admin.booking.index', compact('workspaces'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkSpace $workSpace)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkSpace $workSpace)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkSpace $workSpace)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkSpace $workSpace)
    {
        //
    }
}
