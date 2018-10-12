<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Chat;
use App\Events\MessageStored;

class ChatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required'
        ]);

        $message = auth()->user()->chat()->create([
            'body' => $request->body
        ]);

        $message = $message->whereId($message->id)->with('user')->first();

        broadcast(new MessageStored($message))->toOthers();

        return $message;
    }

    public function show()
    {
        return Chat::with('user')->get();
    }
}
