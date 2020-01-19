<?php

namespace App\Http\Controllers;

use App\Model\Tool;
use App\Model\Comment;
use Illuminate\Http\Request;
use App\Notifications\NewCommentPosted;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $tool = Tool::where('id', $request->tool_id)->first();

        return view('tools.message', compact('tool'));
    }

    public function store(Tool $tool)
    {

        request()->validate([
            'content' => 'required|min:5',
        ]);

        $comment = new Comment();
        $comment->content =request('content');
        $comment->user_id = auth()->user()->id;

        $tool->comments()->save($comment);

        //Notification
        $tool->user->notify(new NewCommentPosted($tool, auth()->user()));

        return redirect()->route('tools.show', $tool)->with('success', 'Votre message a bien été envoyé');;
    }

    public function storeCommentReply(Comment $comment)
    {

        request()->validate([
            'replyComment' => 'required|min:3'
        ]);
        $commentReply = new Comment();
        $commentReply->content = request('replyComment');
        $commentReply->user_id = auth()->user()->id;

        $comment->comments()->save($commentReply);

        return redirect()->route('tools.show', request()->tool_id)->with('success', 'Votre réponse a bien été envoyé');
    }


}
