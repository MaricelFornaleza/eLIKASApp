<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    function index()
    {
        if (Auth::user()->hasRole('admin')) {
            $users = User::where('id', '!=', Auth::id())->get();
            return view('common.chat.chat_admin')->with('users', $users);
        } else {
            return view('common.chat.admin_chat');
        }
    }
    public function getMessage($user_id)
    {
        $my_id = Auth::id();
        $messages = Chat::where(function ($query) use ($user_id, $my_id) {
            $query->where('sender', $my_id)->where('recipient', $user_id);
        })->orWhere(function ($query) use ($user_id, $my_id) {
            $query->where('sender', $user_id)->where('recipient', $my_id);
        })->get();

        return view('common.chat.index', ['messages' => $messages]);
    }
}