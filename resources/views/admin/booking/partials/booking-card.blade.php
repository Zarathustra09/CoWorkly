<!-- resources/views/admin/booking/partials/booking-card.blade.php -->
                                                    <div class="card mb-3 booking-card" style="border: none; border-radius: 15px; overflow: hidden; background-color: #EEE9DA;">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <img src="{{ $booking->workspace->image ? asset('storage/workspace_images/' . $booking->workspace->image) : asset('images/default_workspace.jpg') }}"
                                                                         alt="{{ $booking->workspace->name }}"
                                                                         class="img-fluid rounded"
                                                                         style="height: 100px; width: 100%; object-fit: cover;">
                                                                </div>
                                                                <div class="col-md-7">
                                                                    <h5 class="card-title" style="color: #6096B4;">{{ $booking->workspace->name }}</h5>
                                                                    <span class="badge mb-2" style="background-color: #93BFCF; color: #EEE9DA;">{{ $booking->workspace->category->name }}</span>

                                                                    <div class="mb-1" style="color: #6096B4;">
                                                                        <i class="bi bi-calendar3"></i>
                                                                        @if($booking->start_datetime->format('Y-m-d') == $booking->end_datetime->format('Y-m-d'))
                                                                            <span>{{ $booking->start_datetime->format('M d, Y') }}</span>
                                                                        @else
                                                                            <span>{{ $booking->start_datetime->format('M d, Y') }} - {{ $booking->end_datetime->format('M d, Y') }}</span>
                                                                        @endif
                                                                    </div>

                                                                    <div class="mb-1" style="color: #6096B4;">
                                                                        <i class="bi bi-clock"></i> 9:00 AM - 5:00 PM
                                                                    </div>

                                                                    <div class="mb-1" style="color: #6096B4;">
                                                                        <i class="bi bi-tag"></i> {{ ucfirst($booking->booking_type) }} booking
                                                                    </div>

                                                                    @if($booking->payment_method)
                                                                    <div class="mb-1" style="color: #6096B4;">
                                                                        <i class="bi bi-credit-card"></i> Paid via {{ strtoupper($booking->payment_method) }}
                                                                        <small class="text-muted">(Ref: {{ $booking->payment_reference }})</small>
                                                                    </div>
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-3 text-md-end">
                                                                    <div class="status-badge mb-3">
                                                                        @if($booking->status === 'confirmed')
                                                                            <span class="badge" style="background-color: #6096B4; color: #EEE9DA;">Confirmed</span>
                                                                        @elseif($booking->status === 'pending')
                                                                            <span class="badge" style="background-color: #BDCDD6; color: #6096B4;">Pending</span>
                                                                        @else
                                                                            <span class="badge" style="background-color: #93BFCF; color: #EEE9DA;">Cancelled</span>
                                                                        @endif
                                                                    </div>

                                                                    <div class="price mb-3">
                                                                        <span class="fs-5 fw-bold" style="color: #6096B4;">₱{{ number_format($booking->total_cost, 2) }}</span>
                                                                    </div>

                                                                    <div class="action-buttons d-grid gap-2">
                                                                        @if($booking->groupChat)
                                                                        <a href="#"
                                                                           class="btn btn-sm chat-btn"
                                                                           data-booking-id="{{ $booking->id }}"
                                                                           data-group-chat-id="{{ $booking->groupChat->id }}"
                                                                           data-workspace-name="{{ $booking->workspace->name }}"
                                                                           style="background-color: #BDCDD6; color: #6096B4; border: none;">
                                                                            <i class="bi bi-chat-dots"></i> Chat
                                                                        </a>
                                                                        @else
                                                                        <button type="button"
                                                                               class="btn btn-sm"
                                                                               disabled
                                                                               title="Chat not available"
                                                                               style="background-color: #BDCDD6; color: #93BFCF; border: none; opacity: 0.7;">
                                                                            <i class="bi bi-chat-dots"></i> Chat Unavailable
                                                                        </button>
                                                                        @endif

                                                                        @if($booking->status === 'pending')
                                                                            <a href="{{ route('checkout.show', $booking) }}" class="btn btn-sm" style="background-color: #93BFCF; color: #EEE9DA; border: none;">
                                                                                <i class="bi bi-credit-card"></i> Pay Now
                                                                            </a>
                                                                        @endif

                                                                        @if($booking->status !== 'cancelled' && $booking->start_datetime->isFuture())
                                                                            <form action="{{ route('bookings.update-status', $booking) }}" method="POST" class="d-grid">
                                                                                @csrf
                                                                                @method('PATCH')
                                                                                <input type="hidden" name="status" value="cancelled">
                                                                                <button type="submit" class="btn btn-sm"
                                                                                        style="background-color: #EEE9DA; color: #6096B4; border: 1px solid #6096B4;"
                                                                                        onclick="return confirm('Are you sure you want to cancel this booking?')">
                                                                                    <i class="bi bi-x-circle"></i> Cancel
                                                                                </button>
                                                                            </form>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
