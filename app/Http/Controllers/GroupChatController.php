<?php

namespace App\Http\Controllers;

use App\Models\GroupChat;
use App\Models\GroupChatMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GroupChatController extends Controller
{
    /**
     * Display the specified group chat with its messages.
     */
    /**
     * Display the specified group chat with its messages.
     */
    public function index()
    {
        try {
            // Get all group chats that the current user is a member of
            $groupChats = auth()->user()->groupChats()
                ->with(['booking.workspace', 'users', 'messages'])
                ->withCount('messages')
                ->orderByDesc(function($query) {
                    $query->select('created_at')
                        ->from('group_chat_messages')
                        ->whereColumn('group_chat_id', 'group_chats.id')
                        ->latest()
                        ->limit(1);
                })
                ->get();

            return view('admin.chat.index', compact('groupChats'));

        } catch (\Exception $e) {
            Log::error('Error displaying group chats: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'user_id' => auth()->id()
            ]);

            return redirect()->route('workspace.index')
                ->with('error', 'Unable to display conversations. Please try again later.');
        }
    }

    public function show(GroupChat $groupChat)
    {
        try {
            // Check if the user is part of this group chat
            if (!$groupChat->hasUser(Auth::user())) {
                Log::warning('Unauthorized group chat access attempt', [
                    'user_id' => Auth::id(),
                    'group_chat_id' => $groupChat->id
                ]);

                return redirect()->route('bookings.index')
                    ->with('error', 'You are not authorized to view this group chat.');
            }

            // Get messages with user info, ordered by creation time
            $messages = $groupChat->messages()
                ->with('user')
                ->orderBy('created_at', 'asc')
                ->get();

            // Load booking details
            $booking = $groupChat->booking;

            // Get all users in the group chat
            $chatUsers = $groupChat->users()->get();

            // Get users who can be added to the chat
            $availableUsers = [];

            // Only the booking creator can add users
            if (Auth::id() === $booking->user_id) {
                $existingUserIds = $chatUsers->pluck('id')->toArray();
                $availableUsers = User::whereNotIn('id', $existingUserIds)->get();
            }

            return view('admin.chat.show', compact('groupChat', 'messages', 'booking', 'chatUsers', 'availableUsers'));

        } catch (\Exception $e) {
            Log::error('Error displaying group chat: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'group_chat_id' => $groupChat->id,
                'user_id' => Auth::id()
            ]);

            return redirect()->route('bookings.index')
                ->with('error', 'Unable to display group chat. Please try again later.');
        }
    }

    /**
     * Store a newly created message in the group chat.
     */
    public function store(Request $request, GroupChat $groupChat)
    {
        try {
            $request->validate([
                'message' => 'required|string|max:1000',
            ]);

            // Check if the user is part of this group chat
            if (!$groupChat->hasUser(Auth::user())) {
                Log::warning('Unauthorized message send attempt', [
                    'user_id' => Auth::id(),
                    'group_chat_id' => $groupChat->id
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to send messages in this chat.'
                ], 403);
            }

            // Create the message
            $message = GroupChatMessage::create([
                'group_chat_id' => $groupChat->id,
                'user_id' => Auth::id(),
                'message' => $request->message,
                'is_read' => false
            ]);

            // In a real-time app, we'd broadcast an event here for WebSockets

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => [
                        'id' => $message->id,
                        'text' => $message->message,
                        'user_name' => Auth::user()->name,
                        'user_id' => Auth::id(),
                        'created_at' => $message->created_at->format('M d, Y h:i A')
                    ]
                ]);
            }

            return redirect()->route('group-chats.show', $groupChat)
                ->with('success', 'Message sent successfully!');

        } catch (\Exception $e) {
            Log::error('Error sending message: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'group_chat_id' => $groupChat->id,
                'user_id' => Auth::id()
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send message.'
                ], 500);
            }

            return back()
                ->with('error', 'Unable to send message. Please try again later.')
                ->withInput();
        }
    }

    /**
     * Add a new user to the group chat (only allowed for booking creator).
     */
  public function add(Request $request, GroupChat $groupChat)
  {
      try {
          $request->validate([
              'user_id' => 'required|exists:users,id',
          ]);

          $booking = $groupChat->booking;

          // Only the booking creator can add users
          if (Auth::id() !== $booking->user_id) {
              return response()->json([
                  'success' => false,
                  'message' => 'Only the booking creator can add users to this chat.'
              ], 403);
          }

          // Get the user to add
          $userToAdd = User::find($request->user_id);

          // Check if user already in the chat
          if ($groupChat->hasUser($userToAdd)) {
              return response()->json([
                  'success' => false,
                  'message' => 'User is already in this chat.'
              ], 400);
          }

          // Add the user
          $groupChat->users()->attach($userToAdd->id, [
              'is_admin' => false
          ]);

          Log::info('User added to group chat', [
              'group_chat_id' => $groupChat->id,
              'added_user_id' => $userToAdd->id,
              'added_by' => Auth::id()
          ]);

          return response()->json([
              'success' => true,
              'message' => "{$userToAdd->name} has been added to the chat.",
              'user' => [
                  'id' => $userToAdd->id,
                  'name' => $userToAdd->name
              ]
          ]);

      } catch (\Exception $e) {
          Log::error('Error adding user to group chat: ' . $e->getMessage(), [
              'file' => $e->getFile(),
              'line' => $e->getLine(),
              'group_chat_id' => $groupChat->id,
              'user_id' => Auth::id()
          ]);

          return response()->json([
              'success' => false,
              'message' => 'Unable to add user to the chat. Please try again later.'
          ], 500);
      }
  }


    /**
     * Remove a user from the group chat (only allowed for booking creator).
     */
    public function remove(Request $request, GroupChat $groupChat)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
            ]);

            $booking = $groupChat->booking;

            // Only the booking creator can remove users
            if (Auth::id() !== $booking->user_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only the booking creator can remove users from this chat.'
                ], 403);
            }

            // Get the user to remove
            $userToRemove = User::find($request->user_id);

            // Check if user is in the chat
            if (!$groupChat->hasUser($userToRemove)) {
                return response()->json([
                    'success' => false,
                    'message' => 'User is not in this chat.'
                ], 400);
            }

            // Can't remove yourself
            if ($userToRemove->id === Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot remove yourself from the chat.'
                ], 400);
            }

            // Remove the user
            $groupChat->users()->detach($userToRemove->id);

            Log::info('User removed from group chat', [
                'group_chat_id' => $groupChat->id,
                'removed_user_id' => $userToRemove->id,
                'removed_by' => Auth::id()
            ]);

            return response()->json([
                'success' => true,
                'message' => "{$userToRemove->name} has been removed from the chat.",
            ]);

        } catch (\Exception $e) {
            Log::error('Error removing user from group chat: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'group_chat_id' => $groupChat->id,
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to remove user from the chat. Please try again later.'
            ], 500);
        }
    }

    /**
     * Delete a message from the group chat.
     */
    public function delete(GroupChatMessage $message)
    {
        try {
            // Check if the user is the message author or an admin
            $groupChat = $message->groupChat;
            $isAdmin = $groupChat->isAdmin(Auth::user());
            $isAuthor = $message->user_id === Auth::id();

            if (!$isAuthor && !$isAdmin) {
                Log::warning('Unauthorized attempt to delete chat message', [
                    'user_id' => Auth::id(),
                    'message_id' => $message->id,
                    'group_chat_id' => $groupChat->id
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to delete this message.'
                ], 403);
            }

            // Delete the message
            $message->delete();

            Log::info('Message deleted from group chat', [
                'message_id' => $message->id,
                'group_chat_id' => $groupChat->id,
                'deleted_by' => Auth::id()
            ]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Message deleted successfully.'
                ]);
            }

            return redirect()->route('group-chats.show', $groupChat)
                ->with('success', 'Message deleted successfully.');

        } catch (\Exception $e) {
            Log::error('Error deleting message: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'message_id' => $message->id,
                'user_id' => Auth::id()
            ]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete message.'
                ], 500);
            }

            return back()
                ->with('error', 'Unable to delete message. Please try again later.');
        }
    }
}
