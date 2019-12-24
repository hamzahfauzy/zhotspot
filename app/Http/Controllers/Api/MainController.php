<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Device;

class MainController extends Controller
{
    //

    function install($token)
    {
    	$useragent = $_SERVER ['HTTP_USER_AGENT'];
        if($useragent == "Mikrotik/6.x Fetch"){
        	$device = Device::where('token',$token)->first();
        	if(!empty($device))
        	{
        		return "/interface pptp-client add name=".str_replace(' ','',$device->name)." user=".$device->pptp_user." password=".$device->pptp_password." connect-to=\"z-hotspot.com\" disabled=no";
        	}
        }
    }
}
