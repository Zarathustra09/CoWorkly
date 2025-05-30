@extends('layouts.admin.app')

@section('content')
    <div class="container py-4">
        <div class="row">
            <!-- Chat sidebar - users list -->
            <div class="col-md-3">
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-people-fill me-2"></i>Chat Members
                        </h5>
                        @if(Auth::id() === $booking->user_id)
                           <button type="button" id="addUserBtn" class="btn btn-sm btn-light">
                               <i class="bx bx-plus"></i>
                           </button>
                        @endif
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @foreach($chatUsers as $chatUser)
                                <li class="list-group-item d-flex align-items-center">
                                    @if($chatUser->profile_image)
                                        <img src="{{ asset('storage/profile_images/' . $chatUser->profile_image) }}"
                                             class="rounded-circle me-2" width="32" height="32" alt="{{ $chatUser->name }}">
                                    @else
                                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-2"
                                             style="width: 32px; height: 32px;">
                                            {{ substr($chatUser->name, 0, 1) }}
                                        </div>
                                    @endif

                                    <div>
                                        {{ $chatUser->name }}
                                        @if($groupChat->isAdmin($chatUser))
                                            <span class="badge bg-info ms-1">Admin</span>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Remove the old form here -->
                </div>

                <!-- Booking details card -->
                <div class="card shadow-sm">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-calendar-check me-2"></i>Booking Details
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-1"><strong>Workspace:</strong> {{ $booking->workspace->name }}</p>
                        <p class="mb-1"><strong>Dates:</strong>
                            @if($booking->start_datetime->format('Y-m-d') == $booking->end_datetime->format('Y-m-d'))
                                {{ $booking->start_datetime->format('M d, Y') }}
                            @else
                                {{ $booking->start_datetime->format('M d, Y') }} - {{ $booking->end_datetime->format('M d, Y') }}
                            @endif
                        </p>
                        <p class="mb-1"><strong>Type:</strong> {{ ucfirst($booking->booking_type) }}</p>
                        <p class="mb-0"><strong>Status:</strong>
                            @if($booking->status === 'confirmed')
                                <span class="badge bg-success">Confirmed</span>
                            @elseif($booking->status === 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @else
                                <span class="badge bg-danger">Cancelled</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Chat main content -->
            <div class="col-md-9">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-chat-dots me-2"></i>{{ $groupChat->name }}
                        </h5>
                    </div>

                    <!-- Chat messages area -->
                    <div class="card-body p-0">
                        <div id="chat-messages" class="p-3" style="height: 500px; overflow-y: auto;">
                            @if(count($messages) > 0)
                                @foreach($messages as $message)
                                    <div id="message-{{ $message->id }}" class="message-container {{ $message->user_id === Auth::id() ? 'text-end' : 'text-start' }} mb-3">
                                        <div class="d-inline-block {{ $message->user_id === Auth::id() ? 'bg-primary text-white' : 'bg-light' }} message p-2 px-3" style="max-width: 75%;">
                                            @if($message->user_id !== Auth::id())
                                                <div class="fw-bold text-start mb-1">{{ $message->user->name }}</div>
                                            @endif
                                            <div class="message-text" style="word-break: break-word; text-align: left;">
                                                {{ $message->message }}
                                            </div>
                                            <div class="message-footer d-flex justify-content-between align-items-center mt-1">
                                                <small class="text-{{ $message->user_id === Auth::id() ? 'white' : 'muted' }}">
                                                    {{ $message->created_at->format('h:i A') }}
                                                </small>
                                                @if($message->user_id === Auth::id() || $groupChat->isAdmin(Auth::user()))
                                                    <button type="button" class="btn btn-link p-0 ms-2 text-{{ $message->user_id === Auth::id() ? 'white' : 'muted' }} delete-message-btn"
                                                            data-message-id="{{ $message->id }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="text-muted small mt-1">
                                            {{ $message->created_at->format('M d, Y') }}
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center text-muted p-5">
                                    <i class="bi bi-chat-text fs-1"></i>
                                    <p class="mt-3">No messages yet. Start the conversation!</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Message input form -->
                    <div class="card-footer">
                        <form id="messageForm" action="{{ route('group-chats.messages.store', $groupChat) }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <input type="text" id="messageInput" name="message" class="form-control" placeholder="Type a message..." required>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send"></i> Send
                                </button>
                            </div>
                            @error('message')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </form>
                    </div>
                </div>

                <!-- Back button -->
                <div class="mt-3">
                    <a href="{{ route('workspace.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Back to Bookings
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Message Confirmation Modal -->
    <div class="modal fade" id="deleteMessageModal" tabindex="-1" aria-labelledby="deleteMessageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteMessageModalLabel">Delete Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this message? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteMessageForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Scroll to the bottom of the chat messages container
            const chatMessages = document.getElementById('chat-messages');
            chatMessages.scrollTop = chatMessages.scrollHeight;

            // Handle message submission via AJAX
            const messageForm = document.getElementById('messageForm');
            const messageInput = document.getElementById('messageInput');

            messageForm.addEventListener('submit', function(e) {
                e.preventDefault();

                if (messageInput.value.trim() === '') {
                    return;
                }

                const formData = new FormData(messageForm);

                fetch(messageForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Create and append the new message
                            const newMessage = `
                        <div id="message-${data.message.id}" class="message-container text-end mb-3">
                            <div class="d-inline-block bg-primary text-white message p-2 px-3" style="max-width: 75%;">
                                <div class="message-text" style="word-break: break-word; text-align: left;">
                                    ${data.message.text}
                                </div>
                                <div class="message-footer d-flex justify-content-between align-items-center mt-1">
                                    <small class="text-white">
                                        ${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                                    </small>
                                    <button type="button" class="btn btn-link p-0 ms-2 text-white delete-message-btn"
                                        data-message-id="${data.message.id}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="text-muted small mt-1">
                                ${new Date().toLocaleDateString('en-US', {month: 'short', day: 'numeric', year: 'numeric'})}
                            </div>
                        </div>
                    `;

                            chatMessages.insertAdjacentHTML('beforeend', newMessage);
                            chatMessages.scrollTop = chatMessages.scrollHeight;
                            messageInput.value = '';

                            // Add event listener to the newly created delete button
                            setupDeleteListener(document.querySelector(`#message-${data.message.id} .delete-message-btn`));
                        } else {
                            alert('Failed to send message. Please try again.');
                        }
                    })
                    .catch(error => {
                        console.error('Error sending message:', error);
                        alert('An error occurred. Please try again later.');
                    });
            });

            // Handle message deletion
            const deleteMessageModal = new bootstrap.Modal(document.getElementById('deleteMessageModal'));
            const deleteMessageForm = document.getElementById('deleteMessageForm');

            function setupDeleteListener(button) {
                button.addEventListener('click', function() {
                    const messageId = this.dataset.messageId;
                    deleteMessageForm.action = `{{ url('group-chat-messages') }}/${messageId}`;
                    deleteMessageModal.show();
                });
            }

            // Setup event listeners for all delete buttons
            document.querySelectorAll('.delete-message-btn').forEach(button => {
                setupDeleteListener(button);
            });

            // Handle message deletion form submission via AJAX
            deleteMessageForm.addEventListener('submit', function(e) {
                e.preventDefault();

                fetch(deleteMessageForm.action, {
                    method: 'DELETE',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const messageId = deleteMessageForm.action.split('/').pop();
                            const messageElement = document.getElementById(`message-${messageId}`);

                            if (messageElement) {
                                messageElement.remove();
                            }

                            deleteMessageModal.hide();
                        } else {
                            alert('Failed to delete message. Please try again.');
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting message:', error);
                        alert('An error occurred. Please try again later.');
                    });
            });

            // Add User SweetAlert functionality
            const addUserBtn = document.getElementById('addUserBtn');
            if (addUserBtn) {
                addUserBtn.addEventListener('click', function() {
                    const availableUsers = @json($availableUsers);

                    // Create options for the select input
                    let options = '';
                    availableUsers.forEach(user => {
                        options += `<option value="${user.id}">${user.name} (${user.email})</option>`;
                    });

                    Swal.fire({
                        title: 'Add User to Chat',
                        html: `
                            <select id="user-select" class="form-select">
                                <option value="">Select a user...</option>
                                ${options}
                            </select>
                        `,
                        showCancelButton: true,
                        confirmButtonText: 'Add',
                        showLoaderOnConfirm: true,
                        preConfirm: () => {
                            const selectedUserId = document.getElementById('user-select').value;
                            if (!selectedUserId) {
                                Swal.showValidationMessage('Please select a user');
                                return false;
                            }

                            // Send AJAX request to add the user
                            return fetch('{{ route('group-chats.users.add', $groupChat) }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                },
                                body: JSON.stringify({ user_id: selectedUserId })
                            })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Failed to add user');
                                    }
                                    return response.json();
                                })
                                .catch(error => {
                                    Swal.showValidationMessage(`Request failed: ${error.message}`);
                                });
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Success!',
                                text: 'User added to chat successfully',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                // Reload page to show the updated user list
                                window.location.reload();
                            });
                        }
                    });
                });
            }
        });
    </script>
@endpush

@push('styles')
    <style>
        /* Custom styles for chat interface */
        .message-container {
            margin-bottom: 15px;
        }

        .message {
            position: relative;
            border-radius: 12px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        /* Sender messages (right side) */
        .text-end .message {
            border-bottom-right-radius: 3px;
        }

        /* Receiver messages (left side) */
        .text-start .message {
            border-bottom-left-radius: 3px;
        }

        .message-footer {
            font-size: 0.75rem;
        }

        .delete-message-btn {
            opacity: 0.6;
            transition: opacity 0.2s;
        }

        .delete-message-btn:hover {
            opacity: 1;
        }

        /* Ensure chat container takes full height and scrolls properly */
        #chat-messages::-webkit-scrollbar {
            width: 6px;
        }

        #chat-messages::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        #chat-messages::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 6px;
        }

        #chat-messages::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }
    </style>
@endpush
