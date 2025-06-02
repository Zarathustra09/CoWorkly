@extends('layouts.admin.app')

                                        @section('content')
                                            <div class="container py-4">
                                                <div class="row">
                                                    <!-- Chat sidebar - users list -->
                                                    <div class="col-md-3">
                                                        <div class="card shadow-sm mb-3" style="border: none; border-radius: 15px; overflow: hidden; background-color: #EEE9DA;">
                                                            <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #93BFCF; border: none; color: #EEE9DA;">
                                                                <h5 class="card-title mb-0">
                                                                    <i class="bx bx-group me-2"></i>Chat Members
                                                                </h5>
                                                                @if(Auth::id() === $booking->user_id)
                                                                   <button type="button" id="addUserBtn" class="btn btn-sm" style="background-color: #EEE9DA; color: #6096B4;">
                                                                       <i class="bx bx-plus"></i>
                                                                   </button>
                                                                @endif
                                                            </div>
                                                            <div class="card-body p-0" style="background-color: #EEE9DA;">
                                                            <ul class="list-group list-group-flush">
                                                                @foreach($chatUsers as $chatUser)
                                                                    <li class="list-group-item d-flex align-items-center"
                                                                        style="background-color: #EEE9DA; border-color: #BDCDD6;"
                                                                        data-user-id="{{ $chatUser->id }}">
                                                                        @if($chatUser->profile_image)
                                                                            <img src="{{ asset('storage/' . $chatUser->profile_image) }}"
                                                                                 class="rounded-circle me-2" width="32" height="32" alt="{{ $chatUser->name }}">
                                                                        @else
                                                                            <div class="rounded-circle d-flex align-items-center justify-content-center me-2"
                                                                                 style="width: 32px; height: 32px; background-color: #BDCDD6; color: #6096B4;">
                                                                                {{ substr($chatUser->name, 0, 1) }}
                                                                            </div>
                                                                        @endif

                                                                        <div style="color: #6096B4;">
                                                                            {{ $chatUser->name }}
                                                                            @if($groupChat->isAdmin($chatUser))
                                                                                <span class="badge ms-1" style="background-color: #93BFCF; color: #EEE9DA;">Admin</span>
                                                                            @endif
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            </div>
                                                        </div>

                                                        <!-- Booking details card -->
                                                        <div class="card shadow-sm" style="border: none; border-radius: 15px; overflow: hidden; background-color: #EEE9DA;">
                                                            <div class="card-header" style="background-color: #BDCDD6; border: none; color: #6096B4;">
                                                                <h5 class="card-title mb-0">
                                                                    <i class="bx bx-calendar-check me-2"></i>Booking Details
                                                                </h5>
                                                            </div>
                                                            <div class="card-body" style="background-color: #EEE9DA;">
                                                                <p class="mb-1"><strong style="color: #6096B4;">Workspace:</strong> <span style="color: #93BFCF;">{{ $booking->workspace->name }}</span></p>
                                                                <p class="mb-1"><strong style="color: #6096B4;">Dates:</strong> <span style="color: #93BFCF;">
                                                                    @if($booking->start_datetime->format('Y-m-d') == $booking->end_datetime->format('Y-m-d'))
                                                                        {{ $booking->start_datetime->format('M d, Y') }}
                                                                    @else
                                                                        {{ $booking->start_datetime->format('M d, Y') }} - {{ $booking->end_datetime->format('M d, Y') }}
                                                                    @endif
                                                                </span></p>
                                                                <p class="mb-1"><strong style="color: #6096B4;">Type:</strong> <span style="color: #93BFCF;">{{ ucfirst($booking->booking_type) }}</span></p>
                                                                <p class="mb-0"><strong style="color: #6096B4;">Status:</strong>
                                                                    @if($booking->status === 'confirmed')
                                                                        <span class="badge" style="background-color: #6096B4; color: #EEE9DA;">
                                                                            <i class="bx bx-check-circle me-1"></i> Confirmed
                                                                        </span>
                                                                    @elseif($booking->status === 'pending')
                                                                        <span class="badge" style="background-color: #BDCDD6; color: #6096B4;">
                                                                            <i class="bx bx-time me-1"></i> Pending
                                                                        </span>
                                                                    @else
                                                                        <span class="badge" style="background-color: #93BFCF; color: #EEE9DA;">
                                                                            <i class="bx bx-x-circle me-1"></i> Cancelled
                                                                        </span>
                                                                    @endif
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Chat main content -->
                                                    <div class="col-md-9">
                                                        <div class="card shadow-sm" style="border: none; border-radius: 15px; overflow: hidden; background-color: #EEE9DA;">
                                                            <div class="card-header" style="background-color: #93BFCF; border: none; color: #EEE9DA;">
                                                                <h5 class="card-title mb-0">
                                                                    <i class="bx bx-message-dots me-2"></i>{{ $groupChat->name }}
                                                                </h5>
                                                            </div>

                                                            <!-- Chat messages area -->
                                                            <div class="card-body p-0" style="background-color: #EEE9DA;">
                                                                <div id="chat-messages" class="p-3" style="height: 500px; overflow-y: auto; background-color: #EEE9DA;">
                                                                    @if(count($messages) > 0)
                                                                        @foreach($messages as $message)
                                                                            <div id="message-{{ $message->id }}" class="message-container {{ $message->user_id === Auth::id() ? 'text-end' : 'text-start' }} mb-3">
                                                                                <div class="d-inline-block message p-2 px-3"
                                                                                     style="max-width: 75%; border-radius: 12px; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
                                                                                            background-color: {{ $message->user_id === Auth::id() ? '#6096B4' : '#BDCDD6' }};
                                                                                            color: {{ $message->user_id === Auth::id() ? '#EEE9DA' : '#6096B4' }};">
                                                                                    @if($message->user_id !== Auth::id())
                                                                                        <div class="fw-bold text-start mb-1">{{ $message->user->name }}</div>
                                                                                    @endif
                                                                                    <div class="message-text" style="word-break: break-word; text-align: left;">
                                                                                        {{ $message->message }}
                                                                                    </div>
                                                                                    <div class="message-footer d-flex justify-content-between align-items-center mt-1">
                                                                                        <small style="color: {{ $message->user_id === Auth::id() ? '#EEE9DA' : '#6096B4' }};">
                                                                                            {{ $message->created_at->format('h:i A') }}
                                                                                        </small>
                                                                                        @if($message->user_id === Auth::id() || $groupChat->isAdmin(Auth::user()))
                                                                                            <button type="button" class="btn btn-link p-0 ms-2 delete-message-btn"
                                                                                                    style="color: {{ $message->user_id === Auth::id() ? '#EEE9DA' : '#6096B4' }};"
                                                                                                    data-message-id="{{ $message->id }}">
                                                                                                <i class="bx bx-trash"></i>
                                                                                            </button>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                                <div class="small mt-1" style="color: #93BFCF;">
                                                                                    {{ $message->created_at->format('M d, Y') }}
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    @else
                                                                        <div class="text-center p-5">
                                                                            <i class="bx bx-chat fs-1" style="color: #BDCDD6;"></i>
                                                                            <p class="mt-3" style="color: #6096B4;">No messages yet. Start the conversation!</p>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <!-- Message input form -->
                                                            <div class="card-footer" style="background-color: #BDCDD6; border: none;">
                                                                <form id="messageForm" action="{{ route('group-chats.messages.store', $groupChat) }}" method="POST">
                                                                    @csrf
                                                                    <div class="input-group">
                                                                        <input type="text" id="messageInput" name="message" class="form-control"
                                                                               placeholder="Type a message..." required
                                                                               style="border-color: #93BFCF; background-color: #EEE9DA; color: #6096B4;">
                                                                        <button type="submit" class="btn" style="background-color: #6096B4; color: #EEE9DA;">
                                                                            <i class="bx bx-send"></i> Send
                                                                        </button>
                                                                    </div>
                                                                    @error('message')
                                                                    <div class="small mt-1" style="color: #FF0000;">{{ $message }}</div>
                                                                    @enderror
                                                                </form>
                                                            </div>
                                                        </div>

                                                        <!-- Back button -->
                                                        <div class="mt-3">
                                                            <a href="{{ route('workspace.index') }}" class="btn"
                                                               style="background-color: #EEE9DA; color: #6096B4; border: 1px solid #BDCDD6;">
                                                                <i class="bx bx-arrow-back me-1"></i> Back to Bookings
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Delete Message Confirmation Modal -->
                                            <div class="modal fade" id="deleteMessageModal" tabindex="-1" aria-labelledby="deleteMessageModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content" style="background-color: #EEE9DA; border: none; border-radius: 15px;">
                                                        <div class="modal-header" style="background-color: #93BFCF; color: #EEE9DA; border: none;">
                                                            <h5 class="modal-title" id="deleteMessageModalLabel">Delete Message</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: #EEE9DA;"></button>
                                                        </div>
                                                        <div class="modal-body" style="color: #6096B4;">
                                                            Are you sure you want to delete this message? This action cannot be undone.
                                                        </div>
                                                        <div class="modal-footer" style="border-color: #BDCDD6;">
                                                            <button type="button" class="btn" style="background-color: #BDCDD6; color: #6096B4;" data-bs-dismiss="modal">Cancel</button>
                                                            <form id="deleteMessageForm" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn" style="background-color: #6096B4; color: #EEE9DA;">Delete</button>
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
                                                                    <div class="d-inline-block message p-2 px-3"
                                                                         style="max-width: 75%; border-radius: 12px; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1); background-color: #6096B4; color: #EEE9DA;">
                                                                        <div class="message-text" style="word-break: break-word; text-align: left;">
                                                                            ${data.message.text}
                                                                        </div>
                                                                        <div class="message-footer d-flex justify-content-between align-items-center mt-1">
                                                                            <small style="color: #EEE9DA;">
                                                                                ${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                                                                            </small>
                                                                            <button type="button" class="btn btn-link p-0 ms-2 delete-message-btn"
                                                                                style="color: #EEE9DA;"
                                                                                data-message-id="${data.message.id}">
                                                                                <i class="bx bx-trash"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="small mt-1" style="color: #93BFCF;">
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
                                                                    <select id="user-select" class="form-select" style="background-color: #EEE9DA; border-color: #BDCDD6; color: #6096B4;">
                                                                        <option value="">Select a user...</option>
                                                                        ${options}
                                                                    </select>
                                                                `,
                                                                showCancelButton: true,
                                                                confirmButtonText: 'Add',
                                                                confirmButtonColor: '#6096B4',
                                                                cancelButtonColor: '#BDCDD6',
                                                                showLoaderOnConfirm: true,
                                                          // Replace the preConfirm function in your addUserBtn event listener with this:
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
                                                                      'Accept': 'application/json',
                                                                      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                                                  },
                                                                  body: JSON.stringify({ user_id: selectedUserId })
                                                              })
                                                              .then(response => {
                                                                  if (!response.ok) {
                                                                      return response.json().then(err => {
                                                                          throw new Error(err.message || 'Failed to add user');
                                                                      }).catch(() => {
                                                                          throw new Error('Failed to add user. Server returned an invalid response.');
                                                                      });
                                                                  }
                                                                  return response.json();
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

                                                    // Add this inside your document ready function in show.blade.php
// Find where you set up the addUserBtn functionality and add this code below it

// Add remove buttons to each chat member
                                                    const chatMembersList = document.querySelector('.list-group-flush');
                                                    if (chatMembersList) {
                                                        const isBookingCreator = {{ Auth::id() === $booking->user_id ? 'true' : 'false' }};

                                                        if (isBookingCreator) {
                                                            document.querySelectorAll('.list-group-item').forEach(item => {
                                                                const userId = item.getAttribute('data-user-id');
                                                                const userName = item.querySelector('div').textContent.trim().split('\n')[0].trim();

                                                                // Don't add remove button for the current user/admin
                                                                if (userId != {{ Auth::id() }}) {
                                                                    const removeBtn = document.createElement('button');
                                                                    removeBtn.className = 'btn btn-sm text-danger ms-auto remove-user-btn';
                                                                    removeBtn.innerHTML = '<i class="bx bx-x"></i>';
                                                                    removeBtn.setAttribute('data-user-id', userId);
                                                                    removeBtn.setAttribute('data-user-name', userName);
                                                                    removeBtn.style.backgroundColor = 'transparent';
                                                                    removeBtn.style.border = 'none';

                                                                    item.appendChild(removeBtn);
                                                                }
                                                            });
                                                        }

                                                        // Setup event listeners for remove buttons
                                                        document.querySelectorAll('.remove-user-btn').forEach(btn => {
                                                            btn.addEventListener('click', function(e) {
                                                                e.preventDefault();
                                                                const userId = this.getAttribute('data-user-id');
                                                                const userName = this.getAttribute('data-user-name');

                                                                Swal.fire({
                                                                    title: 'Remove User',
                                                                    text: `Are you sure you want to remove ${userName} from this chat?`,
                                                                    icon: 'warning',
                                                                    showCancelButton: true,
                                                                    confirmButtonColor: '#6096B4',
                                                                    cancelButtonColor: '#BDCDD6',
                                                                    confirmButtonText: 'Yes, remove'
                                                                }).then((result) => {
                                                                    if (result.isConfirmed) {
                                                                        // Send AJAX request to remove the user
                                                                        fetch('{{ route('group-chats.users.remove', $groupChat) }}', {
                                                                            method: 'POST',
                                                                            headers: {
                                                                                'Content-Type': 'application/json',
                                                                                'Accept': 'application/json',
                                                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                                                            },
                                                                            body: JSON.stringify({ user_id: userId })
                                                                        })
                                                                            .then(response => {
                                                                                if (!response.ok) {
                                                                                    return response.json().then(err => {
                                                                                        throw new Error(err.message || 'Failed to remove user');
                                                                                    });
                                                                                }
                                                                                return response.json();
                                                                            })
                                                                            .then(data => {
                                                                                if (data.success) {
                                                                                    Swal.fire({
                                                                                        title: 'Success!',
                                                                                        text: data.message,
                                                                                        icon: 'success',
                                                                                        timer: 2000,
                                                                                        showConfirmButton: false
                                                                                    }).then(() => {
                                                                                        // Reload page to update the user list
                                                                                        window.location.reload();
                                                                                    });
                                                                                }
                                                                            })
                                                                            .catch(error => {
                                                                                Swal.fire({
                                                                                    icon: 'error',
                                                                                    title: 'Error',
                                                                                    text: error.message
                                                                                });
                                                                            });
                                                                    }
                                                                });
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
                                                    background: #EEE9DA;
                                                }

                                                #chat-messages::-webkit-scrollbar-thumb {
                                                    background: #BDCDD6;
                                                    border-radius: 6px;
                                                }

                                                #chat-messages::-webkit-scrollbar-thumb:hover {
                                                    background: #93BFCF;
                                                }
                                            </style>
                                        @endpush
