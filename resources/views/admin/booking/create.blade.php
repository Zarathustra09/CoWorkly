@extends('layouts.admin.app')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card shadow-sm mb-4" style="border: none; border-radius: 15px; background-color: #EEE9DA;">
                    <div class="card-body">
                        <h2 class="fw-bold" style="color: #6096B4;">Book Workspace</h2>
                        <p class="text-muted">Complete the form to reserve your workspace</p>

                        @if ($errors->any())
                            <div class="alert alert-danger" style="background-color: #f8d7da; border-color: #f5c2c7; color: #842029;">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('bookings.store') }}" method="POST" id="bookingForm">
                            @csrf
                            <input type="hidden" name="workspace_id" value="{{ $workspace->id }}">

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <div class="card h-100" style="border: none; border-radius: 15px; overflow: hidden;">
                                        <img src="{{ $workspace->image ? asset('storage/workspace_images/' . $workspace->image) : asset('images/default_workspace.jpg') }}"
                                             class="card-img-top"
                                             alt="{{ $workspace->name }}"
                                             style="height: 200px; object-fit: cover;">

                                        <div class="card-body" style="background-color: #EEE9DA;">
                                            <h5 class="card-title" style="color: #6096B4;">{{ $workspace->name }}</h5>
                                            <div class="d-flex gap-2 mb-2">
                                                <span class="badge" style="background-color: #93BFCF; color: #EEE9DA;">{{ $workspace->category->name }}</span>
                                            </div>
                                            <p class="text-muted small">{{ Str::limit($workspace->description, 100) }}</p>

                                            <div class="fw-bold" style="color: #6096B4;">
                                                @if($workspace->hourly_rate)
                                                    <div>₱{{ number_format($workspace->hourly_rate) }} <small class="text-muted fw-normal">/ hour</small></div>
                                                @endif
                                                <div>₱{{ number_format($workspace->daily_rate) }} <small class="text-muted fw-normal">/ day</small></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="booking_type" class="form-label" style="color: #6096B4;"><i class="bx bx-purchase-tag me-1"></i>Booking Type</label>
                                        <select class="form-select @error('booking_type') is-invalid @enderror"
                                                id="booking_type" name="booking_type" required
                                                style="border-color: #BDCDD6; background-color: #EEE9DA; color: #6096B4;">
                                            @if($workspace->hourly_rate)
                                                <option value="hourly" {{ old('booking_type') == 'hourly' ? 'selected' : '' }}>Hourly (₱{{ number_format($workspace->hourly_rate) }}/hour)</option>
                                            @endif
                                            <option value="daily" {{ old('booking_type', 'daily') == 'daily' ? 'selected' : '' }}>Daily (₱{{ number_format($workspace->daily_rate) }}/day)</option>
                                        </select>
                                        @error('booking_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="start_date" class="form-label" style="color: #6096B4;"><i class="bx bx-calendar me-1"></i>Start Date</label>
                                        <input type="date"
                                               class="form-control @error('start_datetime') is-invalid @enderror"
                                               id="start_date"
                                               name="start_date"
                                               min="{{ date('Y-m-d') }}"
                                               value="{{ old('start_date', date('Y-m-d')) }}"
                                               required
                                               style="border-color: #BDCDD6; background-color: #EEE9DA; color: #6096B4;">
                                        @error('start_datetime')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="end_date" class="form-label" style="color: #6096B4;"><i class="bx bx-calendar-x me-1"></i>End Date</label>
                                        <input type="date"
                                               class="form-control @error('end_datetime') is-invalid @enderror"
                                               id="end_date"
                                               name="end_date"
                                               min="{{ date('Y-m-d') }}"
                                               value="{{ old('end_date', date('Y-m-d')) }}"
                                               required
                                               style="border-color: #BDCDD6; background-color: #EEE9DA; color: #6096B4;">
                                        @error('end_datetime')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <input type="hidden" name="start_datetime" id="start_datetime">
                                    <input type="hidden" name="end_datetime" id="end_datetime">
                                    <input type="hidden" name="total_cost" id="hidden_total_cost" value="0">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm sticky-md-top" style="top: 1rem; border: none; border-radius: 15px; background-color: #EEE9DA;">
                    <div class="card-body">
                        <h5 class="fw-bold" style="color: #6096B4;"><i class="bx bx-receipt me-1"></i>Booking Summary</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span style="color: #93BFCF;">Workspace:</span>
                            <span class="fw-medium" style="color: #6096B4;">{{ $workspace->name }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 booking-dates">
                            <span style="color: #93BFCF;">Date Range:</span>
                            <span class="fw-medium" id="date-range" style="color: #6096B4;">-</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 booking-hours">
                            <span style="color: #93BFCF;">Hours:</span>
                            <span class="fw-medium" style="color: #6096B4;">9:00 AM - 5:00 PM</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span style="color: #93BFCF;">Type:</span>
                            <span class="fw-medium" id="booking-type-display" style="color: #6096B4;">Daily</span>
                        </div>

                        <hr style="border-color: #BDCDD6;">

                        <div class="d-flex justify-content-between mb-2">
                            <span style="color: #93BFCF;">Duration:</span>
                            <span class="fw-medium" id="duration-display" style="color: #6096B4;">1 day</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span style="color: #93BFCF;">Rate:</span>
                            <span class="fw-medium" id="rate-display" style="color: #6096B4;">₱{{ number_format($workspace->daily_rate) }} / day</span>
                        </div>

                        <hr style="border-color: #BDCDD6;">

                        <div class="d-flex justify-content-between mb-3">
                            <span class="fs-5 fw-bold" style="color: #93BFCF;">Total:</span>
                            <span class="fs-5 fw-bold" id="total-cost" style="color: #6096B4;">₱0.00</span>
                        </div>

                        <button type="submit" form="bookingForm" class="btn w-100" style="background-color: #6096B4; color: #EEE9DA;">
                            <i class="bx bx-check-circle me-1"></i> Confirm Booking
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

                   @push('scripts')
                       <script>
                         document.addEventListener('DOMContentLoaded', function() {
                             const bookingTypeSelect = document.getElementById('booking_type');
                             const startDateInput = document.getElementById('start_date');
                             const endDateInput = document.getElementById('end_date');
                             const startDatetimeHidden = document.getElementById('start_datetime');
                             const endDatetimeHidden = document.getElementById('end_datetime');
                             const dateRangeDisplay = document.getElementById('date-range');
                             const bookingTypeDisplay = document.getElementById('booking-type-display');
                             const durationDisplay = document.getElementById('duration-display');
                             const rateDisplay = document.getElementById('rate-display');
                             const totalCostDisplay = document.getElementById('total-cost');
                             const hiddenTotalCostInput = document.getElementById('hidden_total_cost');

                             // Workspace rates
                             const hourlyRate = {{ $workspace->hourly_rate ?? 0 }};
                             const dailyRate = {{ $workspace->daily_rate }};

                             // Format a date for display
                             function formatDate(dateString) {
                                 const date = new Date(dateString);
                                 return date.toLocaleDateString('en-US', {
                                     month: 'short', day: 'numeric', year: 'numeric'
                                 });
                             }

                             // When the form is submitted
                             document.getElementById('bookingForm').addEventListener('submit', function(e) {
                                 e.preventDefault();

                                 // Set the hidden datetime fields with 9am and 5pm times
                                 const startDate = new Date(startDateInput.value);
                                 startDate.setHours(9, 0, 0);
                                 startDatetimeHidden.value = startDate.toISOString().slice(0, 19).replace('T', ' ');

                                 const endDate = new Date(endDateInput.value);
                                 endDate.setHours(17, 0, 0);
                                 endDatetimeHidden.value = endDate.toISOString().slice(0, 19).replace('T', ' ');

                                 // Submit the form
                                 this.submit();
                             });

                             // Handle when start date changes
                             startDateInput.addEventListener('change', function() {
                                 // Ensure end date is not before start date
                                 if (endDateInput.value < startDateInput.value) {
                                     endDateInput.value = startDateInput.value;
                                 }

                                 updateBookingSummary();
                             });

                             // Handle when end date changes
                             endDateInput.addEventListener('change', function() {
                                 // Ensure start date is not after end date
                                 if (startDateInput.value > endDateInput.value) {
                                     startDateInput.value = endDateInput.value;
                                 }

                                 updateBookingSummary();
                             });

                             // Handle when booking type changes
                             bookingTypeSelect.addEventListener('change', updateBookingSummary);

                             function updateBookingSummary() {
                                 const bookingType = bookingTypeSelect.value;
                                 const startDate = new Date(startDateInput.value);
                                 const endDate = new Date(endDateInput.value);

                                 // Set the booking type display
                                 bookingTypeDisplay.textContent = bookingType.charAt(0).toUpperCase() + bookingType.slice(1);

                                 // Set the date range display
                                 if (startDateInput.value === endDateInput.value) {
                                     dateRangeDisplay.textContent = formatDate(startDateInput.value);
                                 } else {
                                     dateRangeDisplay.textContent = `${formatDate(startDateInput.value)} to ${formatDate(endDateInput.value)}`;
                                 }

                                 // Calculate duration in days
                                 const oneDay = 24 * 60 * 60 * 1000;
                                 const diffDays = Math.round(Math.abs((endDate - startDate) / oneDay)) + 1;

                                 // Set the rate display based on booking type
                                 if (bookingType === 'hourly') {
                                     rateDisplay.textContent = `₱${hourlyRate.toFixed(2)} / hour`;

                                     // Calculate cost: 8 hours per day (9am - 5pm)
                                     const totalHours = diffDays * 8;
                                     durationDisplay.textContent = `${totalHours} hours (${diffDays} ${diffDays === 1 ? 'day' : 'days'})`;

                                     const cost = hourlyRate * totalHours;
                                     totalCostDisplay.textContent = `₱${cost.toFixed(2)}`;
                                     hiddenTotalCostInput.value = cost.toFixed(2);
                                 } else {
                                     rateDisplay.textContent = `₱${dailyRate.toFixed(2)} / day`;
                                     durationDisplay.textContent = `${diffDays} ${diffDays === 1 ? 'day' : 'days'}`;

                                     const cost = dailyRate * diffDays;
                                     totalCostDisplay.textContent = `₱${cost.toFixed(2)}`;
                                     hiddenTotalCostInput.value = cost.toFixed(2);
                                 }
                             }

                             // Initialize the summary
                             updateBookingSummary();
                         });
                       </script>
                   @endpush
