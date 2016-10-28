<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\MessageRequest;
use DB;
use App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Datatables;
use App;
use Mail;
use Config;

class MessageController extends Controller {
    
    /**
     * Show the application home to the anonymous.
     *
     * @return Response
     */
    public function decode(Request $request)
    {        
        $messages = Message
            ::where('messages.id', '=', $request->idmessage)
            ->orWhereNotNull('deleted_at')
            ->select(array(
                'messages.id',
                'messages.title',
                'messages.message',
                'messages.password',
                'messages.status',
                'messages.slug',
                'messages.created_at'
            ))
            ->get();
        if (count($messages) > 0) {
            $oMessages = new Message();
            $password = $oMessages->decrypt($messages[0]->password);
            if ($request->password == $password)
                die ($messages[0]->message);
            else
                die ('');
        }
        else
            die ('');
    }

    /**
     * Show the application home to the anonymous.
     *
     * @return Response
     */
    public function show($slug = '')
    {        
        $messages = Message
            ::where('messages.deleted_at', '=', null)
            ->where('messages.slug', '=', $slug)
            ->select(array(
                'messages.id',
                'messages.title',
                'messages.message',
                'messages.password',
                'messages.status',
                'messages.slug',
                'messages.created_at'
            ))
            ->get();
        $status = Message
            ::where('messages.deleted_at', '=', null)
            ->where('messages.status', '=', 0)
            ->where('messages.slug', '=', $slug)
            ->select(array(
                'messages.id',
            ))
            ->count();
        if ($status > 0) {
            $value = array(
                'updated_at' => date('Y-m-d H:i:s', time()),
                'deleted_at' => date('Y-m-d H:i:s', time())
            );
            DB::table('messages')
                ->where('messages.deleted_at', '=', null)
                ->where('messages.status', '=', 0)
                ->where('messages.slug', '=', $slug)
                ->update($value);
        }
        return view('pages.show', compact('messages'));
    }

    /*
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        // Show the page
        return "";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return "";
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(MessageRequest $request)
    {
        $message = new Message($request->except('picture'));
        $message -> slug = md5($request->slug . uniqid());
        $message -> password = $message->encrypt($request->password);
        $message -> save();
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Message $message)
    {
        return "";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(MessageRequest $request, Message $message)
    {
        $message -> update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */

    public function delete(Message $message)
    {
        return "";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function destroy(Message $message)
    {
        $message->delete();
    }


    /**
     * Show a list of all the languages posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data(Request $request)
    {
        $message = Message::select(array('message.id','message.title','message.message','message.password'));
        return Datatables::of($message)
            ->add_column('actions', '<a href="{{{ URL::to(\'message/edit\' ) }}}" class="btn btn-success btn-sm iframe" ><span class="glyphicon glyphicon-pencil"></span>  {{ trans("modal.edit") }}</a>
                    <a href="{{{ URL::to(\'applyforpositions/\' . $id . \'/delete\' ) }}}" class="btn btn-sm btn-danger iframe"><span class="glyphicon glyphicon-trash"></span> {{ trans("modal.delete") }}</a>
                    <input type="hidden" name="row" value="{{$id}}" id="row">')
            ->remove_column('id')

            ->make();
    }
    
}
