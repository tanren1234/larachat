<?php

namespace App\Http\Controllers\Api;

use App\Handlers\UploadHandler;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function show (Request $request) {

        $user = User::find($request->user()->id);

        return $this->success($user);
    }

    public function upload (Request $request, UploadHandler $uploader) {

        $return = $uploader->save($request->file('upload_file'), $request->post('type'), $request->post('type'));

        return $this->success($return);
    }
}
