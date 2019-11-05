<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Device;

class RouterController extends Controller
{

    public function __construct()
    {
        $this->device = new Device;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $devices = $this->device->paginate(10);
        return view('admin.device.index',[
            'devices' => $devices
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function users(Device $router)
    {
        // $this->userRouterChecker($router);
        try {
            $client = new RouterOS\Client($router->ip_address, $router->username, $router->password);
        } catch (\PEAR2\Net\RouterOS\SocketException $e) {
            return view('user.device.error');
        }

        $responses = $client->sendSync(new RouterOS\Request('/ip/hotspot/user/print'));

        return view('user.device.users',[
            'responses' => $responses,
            'router'    => $router
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Device $device)
    {
        return view('admin.device.edit',[
            'device' => $device
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $this->validate($request, [
            'pptp_user' => 'required',
            'pptp_password' => 'required',
            'ip_address' => 'required',
            'chap_secret_line' => 'required',
        ]);

        $router = Device::find($request->id);
        $router->update([
            'pptp_user' => $request->pptp_user,
            'pptp_password' => $request->pptp_password,
            'ip_address' => $request->ip_address,
            'chap_secret_line' => $request->chap_secret_line,
        ]);

        return redirect()->route('admin.router.index')->with(['success' => 'Update router success']);;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
