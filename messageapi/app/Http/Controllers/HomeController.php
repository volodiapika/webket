<?php

namespace App\Http\Controllers;

use App\Message;

use DB;
use App\Http\Controllers;
use App;

class HomeController extends Controller {
    
	/**
	 * Show the application home to the anonymous.
	 *
	 * @return Response
	 */
	public function index()
	{
        $messages = Message
            ::where('messages.deleted_at', '=', null)
            ->select(array(
                'messages.id',
                'messages.created_at',
                'messages.status'
            ))
            ->get();
        if (count($messages) > 0) {
            foreach ($messages as $key => $value) {
                if ($value->status == 1) {
                    $numberString = $value->created_at->diffForHumans();
                    if (
                        strstr($numberString, ' hours ago') ||
                        strstr($numberString, ' hour ago')
                    ) {
                        $data = array(
                            'updated_at' => date('Y-m-d H:i:s', time()),
                            'deleted_at' => date('Y-m-d H:i:s', time())
                        );
                        DB::table('messages')
                            ->where('messages.id', '=', $value->id)
                            ->update($data);
                    }
                }
            }
        }
        $messages = Message
            ::where('messages.deleted_at', '=', null)
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
        return view('pages.home', compact('messages'));
	}
    
}