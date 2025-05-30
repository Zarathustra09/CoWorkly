@extends('layouts.admin.app')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-4">Dashboard</h1>

    <div class="row">
        <!-- Stats Cards -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">My Bookings</h5>
                        <div class="rounded-circle bg-primary bg-opacity-10 p-2">
                            <i class="bx bx-calendar fs-4 text-primary"></i>
                        </div>
                    </div>
                    <h2 class="mb-1">{{ Auth::user()->bookings->count() }}</h2>
                    <p class="text-muted small mb-0">
                        <span class="text-success">
                            <i class="bx bx-check-circle"></i>
                            {{ Auth::user()->bookings->where('status', 'confirmed')->count() }} confirmed
                        </span>
                    </p>
                </div>
                <div class="card-footer bg-light border-0">
                    <a href="{{ route('workspace.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Active Chats</h5>
                        <div class="rounded-circle bg-success bg-opacity-10 p-2">
                            <i class="bx bx-chat fs-4 text-success"></i>
                        </div>
                    </div>
                    <h2 class="mb-1">{{ Auth::user()->groupChats->count() }}</h2>
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
                <div class="card-footer bg-light border-0">
                    <a href="{{ route('group-chats.index') }}" class="btn btn-sm btn-outline-success">Open Chats</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Quick Actions</h5>
                        <div class="rounded-circle bg-info bg-opacity-10 p-2">
                            <i class="bx bx-plus-circle fs-4 text-info"></i>
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <a href="{{ route('bookings.index') }}" class="btn btn-sm btn-primary">
                            <i class="bx bx-calendar-plus me-1"></i> Book a Workspace
                        </a>
                        <a href="{{ route('group-chats.index') }}" class="btn btn-sm btn-outline-primary">
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
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Recent Bookings</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse(Auth::user()->bookings->sortByDesc('created_at')->take(5) as $booking)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $booking->workspace->name }}</h6>
                                        <p class="text-muted mb-0 small">
                                            {{ $booking->start_datetime->format('M d, Y') }} - {{ $booking->end_datetime->format('M d, Y') }}
                                        </p>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-{{ $booking->status === 'confirmed' ? 'success' : ($booking->status === 'pending' ? 'warning' : 'secondary') }} me-2">
                                            {{ ucfirst($booking->status) }}
                                        </span>
{{--                                        <a href="{{ route('bookings.show', $booking) }}" class="btn btn-sm btn-outline-primary">--}}
{{--                                            <i class="bx bx-show"></i>--}}
{{--                                        </a>--}}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="list-group-item text-center py-4">
                                <i class="bx bx-calendar fs-1 text-secondary mb-2"></i>
                                <p class="mb-0">No bookings yet</p>
                                <a href="{{ route('bookings.index') }}" class="btn btn-sm btn-primary mt-2">
                                    Book Now
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
                @if(Auth::user()->bookings->count() > 5)
                    <div class="card-footer bg-light text-end">
                        <a href="{{ route('workspace.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Chats -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Recent Conversations</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse(Auth::user()->groupChats->sortByDesc(function($chat) {
                            return $chat->messages->max('created_at') ?? $chat->created_at;
                        })->take(5) as $chat)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $chat->name }}</h6>
                                        <p class="text-muted mb-0 small">
                                            {{ $chat->messages->count() }} {{ Str::plural('message', $chat->messages->count()) }} ·
                                            {{ $chat->users->count() }} {{ Str::plural('participant', $chat->users->count()) }}
                                        </p>
                                    </div>
                                    <a href="{{ route('group-chats.show', $chat) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bx bx-chat me-1"></i> Open
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="list-group-item text-center py-4">
                                <i class="bx bx-chat fs-1 text-secondary mb-2"></i>
                                <p class="mb-0">No conversations yet</p>
                                <p class="text-muted small">Chats are created when you book a workspace</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                @if(Auth::user()->groupChats->count() > 5)
                    <div class="card-footer bg-light text-end">
                        <a href="{{ route('group-chats.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
