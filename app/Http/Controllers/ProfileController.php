<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
   public function index()
   {
       try {
           return view('admin.profile.index');
       } catch (\Exception $e) {
           return redirect()->back()->with('error', 'Error loading profile page: ' . $e->getMessage());
       }
   }

   public function update(Request $request)
   {
       try {
           $user = auth()->user();

           $validated = $request->validate([
               'name' => ['required', 'string', 'max:255'],
               'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
               'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
           ]);

           if ($request->hasFile('profile_image')) {
               // Delete old image if exists
               if ($user->profile_image) {
                   Storage::disk('public')->delete($user->profile_image);
               }

               $path = $request->file('profile_image')->store('profile-images', 'public');
               $user->profile_image = $path;
           }

           $user->name = $validated['name'];
           $user->email = $validated['email'];
           $user->save();

           return redirect()->back()->with('success', 'Profile updated successfully.');
       } catch (\Illuminate\Validation\ValidationException $e) {
           return redirect()->back()->withErrors($e->validator)->withInput();
       } catch (\Exception $e) {
           return redirect()->back()->with('error', 'Error updating profile: ' . $e->getMessage())->withInput();
       }
   }

   public function updatePassword(Request $request)
   {
       try {
           $validated = $request->validate([
               'current_password' => ['required', 'current_password'],
               'password' => ['required', Password::defaults(), 'confirmed'],
           ]);

           $user = auth()->user();
           $user->password = Hash::make($validated['password']);
           $user->save();

           return redirect()->back()->with('password_success', 'Password changed successfully.');
       } catch (\Illuminate\Validation\ValidationException $e) {
           return redirect()->back()->withErrors($e->validator)->withInput();
       } catch (\Exception $e) {
           return redirect()->back()->with('error', 'Error changing password: ' . $e->getMessage());
       }
   }

    public function uploadImage(Request $request)
    {
        try {
            $request->validate([
                'profile_image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            ]);

            $user = auth()->user();

            // Delete old image if exists
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }

            $path = $request->file('profile_image')->store('profile-images', 'public');
            $user->profile_image = $path;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Profile image updated successfully',
                'path' => asset('storage/' . $path)
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->errors()['profile_image'][0] ?? 'Validation failed'
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error uploading image: ' . $e->getMessage()
            ], 500);
        }
    }
}
