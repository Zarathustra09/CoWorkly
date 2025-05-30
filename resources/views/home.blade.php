@extends('layouts.admin.app')

                        @section('content')
                        <div class="container py-4">
                            <h1 class="h3 mb-4" style="color: #6096B4;">Welcome to Your Dashboard</h1>

                            <div class="row">
                                <!-- Stats Cards -->
                                <div class="col-md-4 mb-4">
                                    <div class="card shadow-sm h-100" style="border: none; border-radius: 15px; background-color: #EEE9DA;">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="mb-0" style="color: #6096B4;">My Bookings</h5>
                                                <div class="rounded-circle p-2" style="background-color: #93BFCF;">
                                                    <i class="bx bx-calendar fs-4" style="color: #EEE9DA;"></i>
                                                </div>
                                            </div>
                                            <h2 class="mb-1" style="color: #6096B4;">{{ Auth::user()->bookings->count() }}</h2>
                                            <p class="text-muted small mb-0">
                                                <span style="color: #6096B4;">
                                                    <i class="bx bx-check-circle"></i>
                                                    {{ Auth::user()->bookings->where('status', 'confirmed')->count() }} confirmed
                                                </span>
                                            </p>
                                        </div>
                                        <div class="card-footer border-0" style="background-color: #BDCDD6; border-radius: 0 0 15px 15px;">
                                            <a href="{{ route('workspace.index') }}" class="btn btn-sm" style="background-color: #6096B4; color: #EEE9DA;">
                                                <i class="bx bx-list-ul me-1"></i> View All
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <div class="card shadow-sm h-100" style="border: none; border-radius: 15px; background-color: #EEE9DA;">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="mb-0" style="color: #6096B4;">Active Chats</h5>
                                                <div class="rounded-circle p-2" style="background-color: #93BFCF;">
                                                    <i class="bx bx-chat fs-4" style="color: #EEE9DA;"></i>
                                                </div>
                                            </div>
                                            <h2 class="mb-1" style="color: #6096B4;">{{ Auth::user()->groupChats->count() }}</h2>
                                            <p class="text-muted small mb-0">
                                                <i class="bx bx-message"></i>
                                                @php
                                                    $messageCount = 0;
                                                    foreach(Auth::user()->groupChats as $chat) {
                                                        $messageCount += $chat->messages->count();
                                                    }
                                                @endphp
                                                {{ $messageCount }} total messages
                                            </p>
                                        </div>
                                        <div class="card-footer border-0" style="background-color: #BDCDD6; border-radius: 0 0 15px 15px;">
                                            <a href="{{ route('group-chats.index') }}" class="btn btn-sm" style="background-color: #6096B4; color: #EEE9DA;">
                                                <i class="bx bx-conversation me-1"></i> Open Chats
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <div class="card shadow-sm h-100" style="border: none; border-radius: 15px; background-color: #EEE9DA;">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="mb-0" style="color: #6096B4;">Quick Actions</h5>
                                                <div class="rounded-circle p-2" style="background-color: #93BFCF;">
                                                    <i class="bx bx-plus-circle fs-4" style="color: #EEE9DA;"></i>
                                                </div>
                                            </div>
                                            <div class="d-grid gap-2">
                                                <a href="{{ route('bookings.index') }}" class="btn btn-sm" style="background-color: #6096B4; color: #EEE9DA;">
                                                    <i class="bx bx-calendar-plus me-1"></i> Book a Workspace
                                                </a>
                                                <a href="{{ route('group-chats.index') }}" class="btn btn-sm" style="background-color: #93BFCF; color: #EEE9DA;">
                                                    <i class="bx bx-chat me-1"></i> View Conversations
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Recent Bookings -->
                                <div class="col-md-6 mb-4">
                                    <div class="card shadow-sm" style="border: none; border-radius: 15px; overflow: hidden;">
                                        <div class="card-header" style="background-color: #93BFCF; border: none;">
                                            <h5 class="mb-0" style="color: #EEE9DA;"><i class="bx bx-calendar-check me-2"></i>Recent Bookings</h5>
                                        </div>
                                        <div class="card-body p-0" style="background-color: #EEE9DA;">
                                            <div class="list-group list-group-flush">
                                                @forelse(Auth::user()->bookings->sortByDesc('created_at')->take(5) as $booking)
                                                    <div class="list-group-item" style="background-color: #EEE9DA; border-color: #BDCDD6;">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <h6 class="mb-1" style="color: #6096B4;">{{ $booking->workspace->name }}</h6>
                                                                <p class="mb-0 small" style="color: #93BFCF;">
                                                                    <i class="bx bx-calendar me-1"></i> {{ $booking->start_datetime->format('M d, Y') }} - {{ $booking->end_datetime->format('M d, Y') }}
                                                                </p>
                                                            </div>
                                                            <div class="d-flex align-items-center">
                                                                <span class="badge me-2" style="background-color:
                                                                    {{ $booking->status === 'confirmed' ? '#6096B4' : ($booking->status === 'pending' ? '#BDCDD6' : '#93BFCF') }};
                                                                    color: #EEE9DA;">
                                                                    <i class="bx {{ $booking->status === 'confirmed' ? 'bx-check-circle' : ($booking->status === 'pending' ? 'bx-time' : 'bx-x-circle') }} me-1"></i>
                                                                    {{ ucfirst($booking->status) }}
                                                                </span>
                        {{--                                        <a href="{{ route('bookings.show', $booking) }}" class="btn btn-sm btn-outline-primary">--}}
                        {{--                                            <i class="bx bx-show"></i>--}}
                        {{--                                        </a>--}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="list-group-item text-center py-4" style="background-color: #EEE9DA; border-color: #BDCDD6;">
                                                        <i class="bx bx-calendar fs-1 mb-2" style="color: #BDCDD6;"></i>
                                                        <p class="mb-0" style="color: #6096B4;">No bookings yet</p>
                                                        <a href="{{ route('bookings.index') }}" class="btn btn-sm mt-2" style="background-color: #6096B4; color: #EEE9DA;">
                                                            <i class="bx bx-calendar-edit me-1"></i> Book Now
                                                        </a>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                        @if(Auth::user()->bookings->count() > 5)
                                            <div class="card-footer text-end" style="background-color: #BDCDD6; border: none;">
                                                <a href="{{ route('workspace.index') }}" class="btn btn-sm" style="background-color: #6096B4; color: #EEE9DA;">
                                                    <i class="bx bx-right-arrow-alt me-1"></i> View All
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Recent Chats -->
                                <div class="col-md-6 mb-4">
                                    <div class="card shadow-sm" style="border: none; border-radius: 15px; overflow: hidden;">
                                        <div class="card-header" style="background-color: #93BFCF; border: none;">
                                            <h5 class="mb-0" style="color: #EEE9DA;"><i class="bx bx-message-square-dots me-2"></i>Recent Conversations</h5>
                                        </div>
                                        <div class="card-body p-0" style="background-color: #EEE9DA;">
                                            <div class="list-group list-group-flush">
                                                @forelse(Auth::user()->groupChats->sortByDesc(function($chat) {
                                                    return $chat->messages->max('created_at') ?? $chat->created_at;
                                                })->take(5) as $chat)
                                                    <div class="list-group-item" style="background-color: #EEE9DA; border-color: #BDCDD6;">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <h6 class="mb-1" style="color: #6096B4;">{{ $chat->name }}</h6>
                                                                <p class="small mb-0" style="color: #93BFCF;">
                                                                    <i class="bx bx-message-detail me-1"></i> {{ $chat->messages->count() }} {{ Str::plural('message', $chat->messages->count()) }} ·
                                                                    <i class="bx bx-group me-1"></i> {{ $chat->users->count() }} {{ Str::plural('participant', $chat->users->count()) }}
                                                                </p>
                                                            </div>
                                                            <a href="{{ route('group-chats.show', $chat) }}" class="btn btn-sm" style="background-color: #6096B4; color: #EEE9DA;">
                                                                <i class="bx bx-chat me-1"></i> Open
                                                            </a>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="list-group-item text-center py-4" style="background-color: #EEE9DA; border-color: #BDCDD6;">
                                                        <i class="bx bx-chat fs-1 mb-2" style="color: #BDCDD6;"></i>
                                                        <p class="mb-0" style="color: #6096B4;">No conversations yet</p>
                                                        <p class="small" style="color: #93BFCF;">Chats are created when you book a workspace</p>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                        @if(Auth::user()->groupChats->count() > 5)
                                            <div class="card-footer text-end" style="background-color: #BDCDD6; border: none;">
                                                <a href="{{ route('group-chats.index') }}" class="btn btn-sm" style="background-color: #6096B4; color: #EEE9DA;">
                                                    <i class="bx bx-right-arrow-alt me-1"></i> View All
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endsection
