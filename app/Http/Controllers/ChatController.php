<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;
use Illuminate\Support\Facades\Log;


class ChatController extends Controller
{
    function index()
    {
        // join users table and chats table where the recipient is the authenticated user
        // do not get the authenticated user
        // Ang sender dapat dae nya macount si is_read na 0 (or unread messages) na bako para saiya
        // select id, name, photo, email, and count the unread messages

        $users = User::leftJoin('chats', function ($join) {
            $join->on('users.id', '=', 'chats.sender')
                ->where('chats.is_read', '=', '0')
                ->where('chats.recipient', '=', Auth::id());
        })
            ->where('users.id', '!=', Auth::id())
            ->select('users.id', 'users.name', 'users.photo', 'users.email', DB::raw("COUNT(chats.is_read) as unread"))
            ->groupBy('users.id', 'users.name', 'users.photo', 'users.email')
            ->get();

        // $users = Chat::all();


        // dd($users);
        $role = Auth::user()->officer_type;

        if ($role == "Administrator") {
            return view('common.chat.chat_admin', ['users' => $users]);
        } else {
            return view('common.chat.chat_field_officer',  ['users' => $users]);
        }
    }
    public function getMessage($user_id)
    {
        $my_id = Auth::id();
        $photo = Auth::user()->photo;
        Chat::where(['sender' => $user_id, 'recipient' => $my_id])->update(['is_read' => 1]);
        $messages = Chat::where(function ($query) use ($user_id, $my_id) {
            $query->where('sender', $my_id)->where('recipient', $user_id);
        })->orWhere(function ($query) use ($user_id, $my_id) {
            $query->where('sender', $user_id)->where('recipient', $my_id);
        })->orderBy('created_at', 'ASC')->get();
        // dd($messages);
        return view('common.chat.index', ['messages' => $messages]);
    }
    public function getAllMessages()
    {
        $users = User::leftJoin('chats', function ($join) {
            $join->on('users.id', '=', 'chats.sender')
                ->where('chats.is_read', '=', '0')
                ->where('chats.recipient', '=', Auth::id());
        })
            ->where('users.id', '!=', Auth::id())
            ->select('users.id', 'users.name', 'users.photo', 'users.email', DB::raw("COUNT(chats.is_read) as unread"))
            ->groupBy('users.id', 'users.name', 'users.photo', 'users.email')
            ->get();
        return view('common.chat.body', ['users' => $users]);
    }



    public function sendMessage(Request $request)
    {
        $sender = Auth::id();
        $recipient = $request->recipient;
        $message = $request->message;
        $chat = new Chat();
        $chat->sender = $sender;
        $chat->recipient = $recipient;
        $chat->message = $message;
        $chat->is_read = 0;
        $chat->save();

        $options  = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_id'),
            $options
        );

        $data = ['sender' => $sender, 'recipient' => $recipient];
        $pusher->trigger('my-channel', 'my-event', $data);
        Log::channel('chatlog')->info($message, ['id' => $chat->id, 'sender' => $sender, 'recipient' => $recipient]);
    }

    public function search(Request $request)
    {
        $text = $request->text;
        if (strlen($text) > 0) {
            $result =  User::leftJoin('chats', function ($join) {
                $join->on('users.id', '=', 'chats.sender')
                    ->where('chats.is_read', '=', '0')
                    ->where('chats.recipient', '=', Auth::id());
            })
                ->where('users.id', '!=', Auth::id())
                ->where(function ($q) use ($text) {
                    $q->where('users.name', 'ILIKE', "%{$text}%")
                        ->orWhere('users.email', 'ILIKE', "%{$text}%")
                        ->orWhere('users.officer_type', 'ILIKE', "%{$text}%");
                })
                ->select('users.id', 'users.name', 'users.photo', 'users.email', DB::raw("COUNT(chats.is_read) as unread"))
                ->groupBy('users.id', 'users.name', 'users.photo', 'users.email')
                ->get();
            // return response()->json($result);
            return Response($result);
        } else {
            $result = User::leftJoin('chats', function ($join) {
                $join->on('users.id', '=', 'chats.sender')
                    ->where('chats.is_read', '=', '0')
                    ->where('chats.recipient', '=', Auth::id());
            })
                ->where('users.id', '!=', Auth::id())
                ->select('users.id', 'users.name', 'users.photo', 'users.email', DB::raw("COUNT(chats.is_read) as unread"))
                ->groupBy('users.id', 'users.name', 'users.photo', 'users.email')
                ->get();
            return Response($result);
        }
    }
}