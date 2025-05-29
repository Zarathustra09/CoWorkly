<?php

    namespace App\Http\Controllers;

    use App\Models\WorkSpace;
    use App\Models\WorkSpaceCategory;
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

            // Apply type filter if provided
            if ($request->has('type')) {
                $query->where('type', $request->type);
            }

            $workspaces = $query->orderBy('name', 'asc')
                ->paginate(9);

            $categories = WorkSpaceCategory::all();

            return view('admin.booking.index', compact('workspaces', 'categories'));
        }

        /**
         * Show the form for booking a workspace.
         */
        public function booking(WorkSpace $workspace)
        {
            return view('admin.booking.create', compact('workspace'));
        }

        /**
         * Other methods remain the same...
         */
    }
