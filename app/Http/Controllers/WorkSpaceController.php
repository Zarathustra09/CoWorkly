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
        public function index()
        {
            // Eager load the workspace and category relations to avoid N+1 query issues
            $user = auth()->user()->load(['bookings.workspace.category']);

            return view('admin.workspace.index', compact('user'));
        }
    }
