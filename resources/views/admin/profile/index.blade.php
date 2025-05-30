@extends('layouts.admin.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Profile Settings</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Profile Details</h5>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="d-flex align-items-start align-items-sm-center gap-4 mb-4">
                            <img src="{{ auth()->user()->profile_image
        ? asset('storage/'.auth()->user()->profile_image)
        : 'https://placehold.co/100x100/6777ef/ffffff?text=' . substr(auth()->user()->name, 0, 1) }}"
                                 alt="user-avatar"
                                 class="d-block rounded"
                                 height="100"
                                 width="100"
                                 id="uploadedAvatar">
                            <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-2 mb-2" tabindex="0">
                                    <span class="d-none d-sm-block">Upload new photo</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input type="file" name="profile_image" id="upload" class="account-file-input" hidden accept="image/png, image/jpeg">
                                </label>
                                <p class="text-muted mb-0">Allowed JPG or PNG. Max size of 2MB</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', auth()->user()->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', auth()->user()->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <h5 class="card-header">Change Password</h5>
                <div class="card-body">
                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        @if(session('password_success'))
                            <div class="alert alert-success">
                                {{ session('password_success') }}
                            </div>
                        @endif

                        <div class="row mb-3">
                            <label for="current_password" class="col-sm-2 col-form-label">Current Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-sm-2 col-form-label">New Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password_confirmation" class="col-sm-2 col-form-label">Confirm Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Change Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const upload = document.getElementById('upload');
        const avatarPreview = document.getElementById('uploadedAvatar');
        const profileForm = document.querySelector('form[action*="profile.update"]');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Only add event listener if elements exist
        if (upload && avatarPreview) {
            upload.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    // Show preview instantly
                    const blobUrl = URL.createObjectURL(this.files[0]);
                    avatarPreview.src = blobUrl;
                    avatarPreview.onload = () => URL.revokeObjectURL(blobUrl);

                    // Automatically upload the image
                    const formData = new FormData();
                    formData.append('profile_image', this.files[0]);
                    formData.append('_token', csrfToken);
                    formData.append('_method', 'PUT');

                    fetch('{{ route('profile.upload-image') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Show success message
                                const successAlert = document.createElement('div');
                                successAlert.className = 'alert alert-success mt-2';
                                successAlert.textContent = 'Profile image updated successfully';

                                // Insert after the upload button
                                const buttonWrapper = document.querySelector('.button-wrapper');
                                buttonWrapper.parentNode.insertBefore(successAlert, buttonWrapper.nextSibling);

                                // Remove after 3 seconds
                                setTimeout(() => successAlert.remove(), 3000);
                            } else {
                                console.error('Upload failed:', data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }
            });
        }
    });
</script>
@endpush
