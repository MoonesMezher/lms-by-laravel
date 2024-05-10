<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notifications = Notification::get();

        return $this->response('success', 'get notifications', $notifications ,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function read(Request $request, Notification $notification)
    {
        $item = Notification::findOrFail($notification);

        $item->read = true;

        return $this->response('success', 'get notifications', $item ,200);
    }
}
