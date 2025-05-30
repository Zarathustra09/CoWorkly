@extends('layouts.admin.app')

                                            @section('content')
                                            <div class="container py-5">
                                                <div class="row mb-4">
                                                    <div class="col-md-8">
                                                        <h1 class="fw-bold" style="color: #6096B4;">Available Workspaces</h1>
                                                        <p style="color: #93BFCF;">Find and book your perfect workspace</p>
                                                    </div>
                                                    <div class="col-md-4 text-end">
                                                        <div class="d-flex justify-content-md-end gap-2">
                                                            <div class="dropdown">
                                                                <button class="btn dropdown-toggle" type="button" id="categoryFilter" data-bs-toggle="dropdown" aria-expanded="false"
                                                                    style="background-color: #93BFCF; color: #EEE9DA; border: none;">
                                                                    <i class="bx bx-category-alt me-1"></i> Category
                                                                </button>
                                                                <ul class="dropdown-menu" aria-labelledby="categoryFilter" style="background-color: #EEE9DA;">
                                                                    <li><a class="dropdown-item" href="{{ route('bookings.index') }}" style="color: #6096B4;">All Categories</a></li>
                                                                    @foreach($categories as $category)
                                                                        <li><a class="dropdown-item" href="{{ route('bookings.index', ['category' => $category->id]) }}" style="color: #6096B4;">{{ $category->name }}</a></li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                            <div class="dropdown">
                                                                <button class="btn dropdown-toggle" type="button" id="typeFilter" data-bs-toggle="dropdown" aria-expanded="false"
                                                                    style="background-color: #BDCDD6; color: #6096B4; border: none;">
                                                                    <i class="bx bx-filter me-1"></i> Type
                                                                </button>
                                                                <ul class="dropdown-menu" aria-labelledby="typeFilter" style="background-color: #EEE9DA;">
                                                                    <li><a class="dropdown-item" href="{{ route('bookings.index') }}" style="color: #6096B4;">All Types</a></li>
                                                                    <li><a class="dropdown-item" href="{{ route('bookings.index', ['type' => 'desk']) }}" style="color: #6096B4;">Desk</a></li>
                                                                    <li><a class="dropdown-item" href="{{ route('bookings.index', ['type' => 'meeting_room']) }}" style="color: #6096B4;">Meeting Room</a></li>
                                                                    <li><a class="dropdown-item" href="{{ route('bookings.index', ['type' => 'study_pod']) }}" style="color: #6096B4;">Study Pod</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row g-4">
                                                    @forelse($workspaces as $workspace)
                                                        <div class="col-md-6 col-lg-4">
                                                            <div class="card h-100 shadow-sm" style="border: none; border-radius: 15px; overflow: hidden; background-color: #EEE9DA;">
                                                                <img src="{{ $workspace->image ? asset('storage/workspace_images/' . $workspace->image) : asset('images/default_workspace.jpg') }}"
                                                                     class="card-img-top"
                                                                     alt="{{ $workspace->name }}"
                                                                     style="height: 200px; object-fit: cover;">

                                                                <div class="card-body">
                                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                                        <span class="badge" style="background-color: #93BFCF; color: #EEE9DA;">{{ $workspace->category->name }}</span>
                                                                        @if(!$workspace->is_available)
                                                                            <span class="badge" style="background-color: #6096B4; color: #EEE9DA;"><i class="bx bx-x-circle me-1"></i> Unavailable</span>
                                                                        @endif
                                                                    </div>
                                                                    <h5 class="card-title" style="color: #6096B4;">{{ $workspace->name }}</h5>
                                                                    <p class="card-text text-muted small">{{ Str::limit($workspace->description, 100) }}</p>

                                                                    <div class="mb-3">
                                                                        <div class="d-flex justify-content-between small mb-2" style="color: #93BFCF;">
                                                                            <span>
                                                                                <i class="bx bx-tag"></i>
                                                                                {{ ucfirst(str_replace('_', ' ', $workspace->type)) }}
                                                                            </span>
                                                                        </div>
                                                                    </div>

                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <div>
                                                                            @if($workspace->hourly_rate)
                                                                                <p class="mb-0 fw-bold" style="color: #6096B4;">₱{{ number_format($workspace->hourly_rate) }} <small class="text-muted fw-normal">/ hour</small></p>
                                                                            @endif
                                                                            <p class="mb-0 fw-bold" style="color: #6096B4;">₱{{ number_format($workspace->daily_rate) }} <small class="text-muted fw-normal">/ day</small></p>
                                                                        </div>
                                                                        <a href="{{ route('bookings.create', $workspace->id) }}" class="btn" style="background-color: #6096B4; color: #EEE9DA;">
                                                                            <i class="bx bx-calendar-plus me-1"></i> Book Now
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <div class="col-12 text-center py-5" style="color: #BDCDD6;">
                                                            <i class="bx bx-search-alt display-1"></i>
                                                            <h3 class="mt-3" style="color: #6096B4;">No workspaces found</h3>
                                                            <p style="color: #93BFCF;">Try adjusting your search criteria</p>
                                                        </div>
                                                    @endforelse
                                                </div>

                                                <div class="d-flex justify-content-center mt-4">
                                                    {{ $workspaces->links('pagination::bootstrap-5') }}
                                                </div>
                                            </div>
                                            @endsection

                                            @push('scripts')
                                            <script>
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                                                    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                                                        return new bootstrap.Tooltip(tooltipTriggerEl)
                                                    })
                                                });
                                            </script>
                                            @endpush
