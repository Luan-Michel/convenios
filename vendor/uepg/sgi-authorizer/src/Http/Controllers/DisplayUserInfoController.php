<?php

namespace Uepg\SGIAuthorizer\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Uepg\SGIAuthorizer\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class DisplayUserInfoController extends Controller {
	public function userInfo(){
		$data['usuario'] = Auth::user();
		return view(Config::get('sgiauthorizer.view.userInfoView'), $data);
	}
}