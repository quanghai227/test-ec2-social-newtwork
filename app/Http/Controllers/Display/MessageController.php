<?php

namespace App\Http\Controllers\Display;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use App\Events\MessageEvent;

class MessageController extends Controller
{
    public function get()
    {
        // get all users except the authenticated one
        $contacts = User::where('id', '!=', auth()->id())->get();

        // get a collection of items where sender_id is the user who sent us a message
        // and messages_count is the number of unread messages we have from him
        $unreadIds = Message::select(\DB::raw('`from_user` as sender_id, count(`from_user`) as messages_count'))
            ->where('to_user', auth()->id())
            ->where('read', false)
            ->groupBy('from_user')
            ->get();

        // add an unread key to each contact with the count of unread messages
        $contacts = $contacts->map(function($contact) use ($unreadIds) {
            $contactUnread = $unreadIds->where('sender_id', $contact->id)->first();

            $contact->unread = $contactUnread ? $contactUnread->messages_count : 0;

            return $contact;
        });


        return response()->json($contacts);
    }

    public function getMessagesFor($id)
    {
        // mark all messages with the selected contact as read
        Message::where('from_user', $id)->where('to_user', auth()->id())->update(['read' => true]);

        // get all messages between the authenticated user and the selected user
        $messages = Message::where(function($q) use ($id) {
            $q->where('from_user', auth()->id());
            $q->where('to_user', $id);
        })->orWhere(function($q) use ($id) {
            $q->where('from_user', $id);
            $q->where('to_user', auth()->id());
        })
            ->get();

        return response()->json($messages);
    }

    public function send(Request $request)
    {
        $message = Message::create([
            'from_user' => auth()->id(),
            'to_user' => $request->contact_id,
            'text' => $request->text
        ]);

        broadcast(new MessageEvent($message)); //send new message

        return response()->json($message);
    }
}
