<!-- resources/views/admin/booking/partials/booking-card.blade.php -->
                                    <div class="card mb-3 booking-card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <img src="{{ $booking->workspace->image ? asset('storage/workspace_images/' . $booking->workspace->image) : asset('images/default_workspace.jpg') }}"
                                                         alt="{{ $booking->workspace->name }}"
                                                         class="img-fluid rounded"
                                                         style="height: 100px; width: 100%; object-fit: cover;">
                                                </div>
                                                <div class="col-md-7">
                                                    <h5 class="card-title">{{ $booking->workspace->name }}</h5>
                                                    <span class="badge bg-primary mb-2">{{ $booking->workspace->category->name }}</span>

                                                    <div class="mb-1">
                                                        <i class="bi bi-calendar3"></i>
                                                        @if($booking->start_datetime->format('Y-m-d') == $booking->end_datetime->format('Y-m-d'))
                                                            <span>{{ $booking->start_datetime->format('M d, Y') }}</span>
                                                        @else
                                                            <span>{{ $booking->start_datetime->format('M d, Y') }} - {{ $booking->end_datetime->format('M d, Y') }}</span>
                                                        @endif
                                                    </div>

                                                    <div class="mb-1">
                                                        <i class="bi bi-clock"></i> 9:00 AM - 5:00 PM
                                                    </div>

                                                    <div class="mb-1">
                                                        <i class="bi bi-tag"></i> {{ ucfirst($booking->booking_type) }} booking
                                                    </div>

                                                    @if($booking->payment_method)
                                                    <div class="mb-1">
                                                        <i class="bi bi-credit-card"></i> Paid via {{ strtoupper($booking->payment_method) }}
                                                        <small class="text-muted">(Ref: {{ $booking->payment_reference }})</small>
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="col-md-3 text-md-end">
                                                    <div class="status-badge mb-3">
                                                        @if($booking->status === 'confirmed')
                                                            <span class="badge bg-success">Confirmed</span>
                                                        @elseif($booking->status === 'pending')
                                                            <span class="badge bg-warning text-dark">Pending</span>
                                                        @else
                                                            <span class="badge bg-danger">Cancelled</span>
                                                        @endif
                                                    </div>

                                                    <div class="price mb-3">
                                                        <span class="fs-5 fw-bold">₱{{ number_format($booking->total_cost, 2) }}</span>
                                                    </div>

                                                    <div class="action-buttons d-grid gap-2">
                                                        <a href="{{ route('bookings.show', $booking) }}"
                                                           class="btn btn-outline-primary btn-sm booking-details-btn"
                                                           data-booking-id="{{ $booking->id }}"
                                                           data-workspace-name="{{ $booking->workspace->name }}"
                                                           data-booking-date="{{ $booking->start_datetime->format('M d, Y') }} {{ $booking->start_datetime->format('Y-m-d') != $booking->end_datetime->format('Y-m-d') ? ' - '.$booking->end_datetime->format('M d, Y') : '' }}"
                                                           data-booking-type="{{ ucfirst($booking->booking_type) }}"
                                                           data-booking-status="{{ $booking->status }}"
                                                           data-booking-cost="{{ number_format($booking->total_cost, 2) }}">
                                                            <i class="bi bi-eye"></i> Details
                                                        </a>

                                                        <button type="button"
                                                               class="btn btn-outline-info btn-sm chat-btn"
                                                               data-booking-id="{{ $booking->id }}"
                                                               data-workspace-name="{{ $booking->workspace->name }}">
                                                            <i class="bi bi-chat-dots"></i> Chat
                                                        </button>

                                                        @if($booking->status === 'pending')
                                                            <a href="{{ route('checkout.show', $booking) }}" class="btn btn-success btn-sm">
                                                                <i class="bi bi-credit-card"></i> Pay Now
                                                            </a>
                                                        @endif

                                                        @if($booking->status !== 'cancelled' && $booking->start_datetime->isFuture())
                                                            <form action="{{ route('bookings.update-status', $booking) }}" method="POST" class="d-grid">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="cancelled">
                                                                <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to cancel this booking?')">
                                                                    <i class="bi bi-x-circle"></i> Cancel
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
