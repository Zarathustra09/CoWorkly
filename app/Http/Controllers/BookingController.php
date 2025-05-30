<?php

    namespace App\Http\Controllers;

    use App\Models\Booking;
    use App\Models\GroupChat;
    use App\Models\WorkSpace;
    use App\Models\WorkSpaceCategory;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Log;

    class BookingController extends Controller
    {
        /**
         * Display a listing of available workspaces.
         */
        public function index(Request $request)
        {
            try {
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
            } catch (\Exception $e) {
                Log::error('Error displaying workspaces: ' . $e->getMessage(), [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                    'request' => $request->all()
                ]);

                return redirect()->back()
                    ->with('error', 'Unable to display workspaces. Please try again later.');
            }
        }

        /**
         * Show the form for creating a new booking.
         */
        public function create(WorkSpace $workspace)
        {
            try {
                return view('admin.booking.create', compact('workspace'));
            } catch (\Exception $e) {
                Log::error('Error loading booking form: ' . $e->getMessage(), [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                    'workspace_id' => $workspace->id
                ]);

                return redirect()->route('bookings.index')
                    ->with('error', 'Unable to load booking form. Please try again later.');
            }
        }

        /**
         * Store a newly created booking in storage.
         */
        /**
         * Store a newly created booking in storage.
         */
        /**
         * Store a newly created booking in storage.
         */
        public function store(Request $request)
        {
            try {
                // Customize validation
                $rules = [
                    'workspace_id' => 'required|exists:workspaces,id',
                    'start_datetime' => 'required|date',
                    'end_datetime' => 'required|date',
                    'booking_type' => 'required|in:hourly,daily',
                    'total_cost' => 'required|numeric|min:0',
                ];

                // First validate the basic rules
                $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules);

                // If basic validation fails
                if ($validator->fails()) {
                    Log::warning('Basic booking validation failed', [
                        'errors' => $validator->errors(),
                        'input' => $request->except(['_token'])
                    ]);
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                // Get the validated data
                $validated = $validator->validated();

                // Log the datetime values for debugging
                Log::info('Booking datetime values', [
                    'start_datetime' => $validated['start_datetime'],
                    'end_datetime' => $validated['end_datetime'],
                    'booking_type' => $validated['booking_type']
                ]);

                // Get Carbon instances for comparison
                $startDatetime = \Carbon\Carbon::parse($validated['start_datetime']);
                $endDatetime = \Carbon\Carbon::parse($validated['end_datetime']);

                // Force the times: start time to 9am, end time to 5pm
                $startDatetime->setTime(9, 0, 0);
                $endDatetime->setTime(17, 0, 0);

                // Update the validated data with the corrected times
                $validated['start_datetime'] = $startDatetime->toDateTimeString();
                $validated['end_datetime'] = $endDatetime->toDateTimeString();

                // Recalculate total cost based on corrected times
                $workspace = \App\Models\WorkSpace::find($validated['workspace_id']);
                $diffDays = $startDatetime->diffInDays($endDatetime) + 1;

                if ($validated['booking_type'] === 'hourly') {
                    // 8 hours per day (9am - 5pm)
                    $totalHours = $diffDays * 8;
                    $validated['total_cost'] = $workspace->hourly_rate * $totalHours;
                } else {
                    $validated['total_cost'] = $workspace->daily_rate * $diffDays;
                }

                // Check if the dates make sense (end date should be >= start date)
                if ($endDatetime < $startDatetime) {
                    Log::warning('End date is before start date', [
                        'start_datetime' => $validated['start_datetime'],
                        'end_datetime' => $validated['end_datetime']
                    ]);
                    return redirect()->back()
                        ->withErrors(['end_datetime' => 'End date cannot be before start date'])
                        ->withInput();
                }

                // Add the user ID
                $validated['user_id'] = auth()->id();
                $validated['status'] = 'pending';

                // Create the booking
                $booking = auth()->user()->bookings()->create($validated);

                // Create a group chat for this booking automatically
                $groupChat = GroupChat::create([
                    'booking_id' => $booking->id,
                    'created_by' => auth()->id(),
                    'name' => "Chat for {$workspace->name}"
                ]);

                // Add the booking creator as admin of the group chat
                $groupChat->users()->attach(auth()->id(), [
                    'is_admin' => true
                ]);

                Log::info('Booking created successfully with group chat', [
                    'booking_id' => $booking->id,
                    'group_chat_id' => $groupChat->id,
                    'user_id' => auth()->id(),
                    'workspace_id' => $validated['workspace_id'],
                    'final_start' => $validated['start_datetime'],
                    'final_end' => $validated['end_datetime']
                ]);

                // Redirect to checkout instead of booking.show
                return redirect()->route('checkout.show', $booking)
                    ->with('success', 'Booking created! Please complete payment to confirm.');

            } catch (\Exception $e) {
                Log::error('Error creating booking: ' . $e->getMessage(), [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                    'user_id' => auth()->id(),
                    'input' => $request->except(['_token'])
                ]);

                return redirect()->back()
                    ->with('error', 'Unable to complete your booking: ' . $e->getMessage())
                    ->withInput();
            }
        }

        /**
         * Display the specified booking.
         */
        public function show(Booking $booking)
        {
            try {
                // Check if user is authorized to view this booking
                if (auth()->id() != $booking->user_id && !auth()->user()->isAdmin()) {
                    Log::warning('Unauthorized booking access attempt', [
                        'user_id' => auth()->id(),
                        'booking_id' => $booking->id
                    ]);

                    return redirect()->route('bookings.index')
                        ->with('error', 'You are not authorized to view this booking.');
                }

                return view('admin.booking.show', compact('booking'));

            } catch (\Exception $e) {
                Log::error('Error displaying booking: ' . $e->getMessage(), [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                    'booking_id' => $booking->id,
                    'user_id' => auth()->id()
                ]);

                return redirect()->route('bookings.index')
                    ->with('error', 'Unable to display booking details. Please try again later.');
            }
        }

        /**
         * Update the specified booking status.
         */
        public function updateStatus(Request $request, Booking $booking)
        {
            try {
                $request->validate([
                    'status' => 'required|in:confirmed,cancelled',
                ]);

                // Check if user is authorized to update this booking
                if (auth()->id() != $booking->user_id && !auth()->user()->isAdmin()) {
                    Log::warning('Unauthorized booking status update attempt', [
                        'user_id' => auth()->id(),
                        'booking_id' => $booking->id
                    ]);

                    return redirect()->route('bookings.index')
                        ->with('error', 'You are not authorized to update this booking.');
                }

                $oldStatus = $booking->status;
                $booking->update(['status' => $request->status]);

                Log::info('Booking status updated', [
                    'booking_id' => $booking->id,
                    'old_status' => $oldStatus,
                    'new_status' => $request->status,
                    'updated_by' => auth()->id()
                ]);

                return back()->with('success', 'Booking status updated successfully!');

            } catch (\Illuminate\Validation\ValidationException $e) {
                Log::warning('Booking status validation failed: ' . $e->getMessage(), [
                    'errors' => $e->errors(),
                    'booking_id' => $booking->id,
                    'user_id' => auth()->id()
                ]);

                throw $e;

            } catch (\Exception $e) {
                Log::error('Error updating booking status: ' . $e->getMessage(), [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                    'booking_id' => $booking->id,
                    'user_id' => auth()->id(),
                    'input' => $request->all()
                ]);

                return back()
                    ->with('error', 'Unable to update booking status. Please try again later.');
            }
        }
    }
