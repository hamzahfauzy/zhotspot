<?php

namespace App\Http\Controllers\User;

use PEAR2\Net\RouterOS;
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
        //
        $devices = auth()->user()->customer->devices()->paginate(10);
        return view('user.device.index',[
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
        return view('user.device.create');
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
        $this->validate($request,[
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        $device = $this->device->create([
            'customer_id' => auth()->user()->customer->id,
            'name' => $request->name,
            'username' => $request->username,
            'password' => $request->password,
        ]);

        $lastDevice = Device::orderby('ip_address','desc')->first();
        if($lastDevice->ip_address == "")
        {
            $lastSegment = 0;
            $chap_secret_line = 3;
        }
        else
        {
            $explode = explode('.',$lastDevice->ip_address);
            $lastSegment = end($explode);
            $chap_secret_line = $lastDevice->chap_secret_line+1;
        }

        $pptp = substring(md5($device->id),0,7);
        $ip = '192.168.0.'.($lastSegment+1);

        $device->update([
            'token' => md5($device->id),
            'pptp_user' => $pptp,
            'pptp_password' => $pptp,
            'ip_address' => $ip,
            'chap_secret_line' => $chap_secret_line
        ]);

        exec('sudo /var/www/html/bash/test.sh '.$pptp.' pptpd '.$pptp.' '.$ip.' 2>&1');
        exec('sudo /etc/init.d/pptpd restart 2>&1');

        return redirect()->route('user.router.index')->with(['success' => 'Create router success']);;
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

    public function users(Device $router)
    {
        $this->userRouterChecker($router);
        try {
            $client = new RouterOS\Client($router->ip_address, $router->username, $router->password);
        } catch (Exception $e) {
            return 'Unable to connect RouterOS';
        }

        $responses = $client->sendSync(new RouterOS\Request('/ip/hotspot/user/print'));

        return view('user.device.users',[
            'responses' => $responses,
            'router'    => $router
        ]);
    }

    public function usersOnline(Device $router)
    {
        $this->userRouterChecker($router);
        try {
            $client = new RouterOS\Client($router->ip_address, $router->username, $router->password);
        } catch (Exception $e) {
            return 'Unable to connect RouterOS';
        }

        $responses = $client->sendSync(new RouterOS\Request('/ip/hotspot/active/print'));

        return view('user.device.users-online',[
            'responses' => $responses,
            'router'    => $router
        ]);
    }

    public function usersOnlineRemove(Device $router, $name)
    {
        $this->userRouterChecker($router);

        try {
            $client = new RouterOS\Client($router->ip_address, $router->username, $router->password);
        } catch (Exception $e) {
            return 'Unable to connect RouterOS';
        }

        $printRequest = new RouterOS\Request('/ip/hotspot/active/print');
        $printRequest->setArgument('.proplist', '.id');
        $printRequest->setQuery(RouterOS\Query::where('user', $name));
        $id = $client->sendSync($printRequest)->getProperty('.id');

        $setRequest = new RouterOS\Request('/ip/hotspot/active/remove');
        $setRequest->setArgument('numbers', $id);
        $client->sendSync($setRequest);

        return redirect()->route('user.router.users.online',$router->id)->with(['success' => 'a user kicked']);;
    }

    public function profiles(Device $router)
    {
        $this->userRouterChecker($router);
        try {
            $client = new RouterOS\Client($router->ip_address, $router->username, $router->password);
        } catch (Exception $e) {
            return 'Unable to connect RouterOS';
        }

        $responses = $client->sendSync(new RouterOS\Request('/ip/hotspot/user/profile/print'));

        return view('user.device.profiles',[
            'responses' => $responses,
            'router'    => $router
        ]);
    }

    public function patchProfile(Device $router, $profile)
    {
        $this->userRouterChecker($router);
        return view('user.device.patch-profile',[
            'profile' => $profile,
            'router'    => $router
        ]);
    }

    public function savePatchProfile(Request $request)
    {
        $this->validate($request,[
            'masa_aktif' => 'required',
            'satuan' => 'required',
        ]);

        $router = Device::find($request->router_id);
        $this->userRouterChecker($router);

        try {
            $client = new RouterOS\Client($router->ip_address, $router->username, $router->password);
        } catch (Exception $e) {
            return 'Unable to connect RouterOS';
        }

        $onLogin = '{ 
                        :local date [/system clock get date];
                        :local time [/system clock get time];
                        :local setonline [/ip hotspot user set [find name=$user] comment="{\'status\':\'online\',\'waktu\':\'$time\',\'tanggal\':\'$date\'}"];
                        :if ([/system schedule find name=$user]="") do={ 
                                /system schedule add name=$user interval='.$request->masa_aktif.$request->satuan.' on-event="/ip hotspot user disable [find name=$user]\r\n/ip hotspot user set [find user=$user] comment=\"{\'status\':\'expired\',\'waktu\':\'\',\'tanggal\':\'\'}\"\r\n/ip hotspot active remove [find user=$user]\r\n/ip hotspot cookie remove [find user=$user]\r\n/system schedule remove [find name=$user]" 
                            } 
                    }';

        $onLogout = '{
                        :local date [/system clock get date];
                        :local time [/system clock get time];
                        :local setoffline [/ip hotspot user set [find name=$user] comment="{\'status\':\'offline\',\'waktu\':\'$time\',\'tanggal\':\'$date\'}"];
                    }';

        $printRequest = new RouterOS\Request('/ip/hotspot/user/profile/print');
        $printRequest->setArgument('.proplist', '.id');
        $printRequest->setQuery(RouterOS\Query::where('name', $request->name));
        $id = $client->sendSync($printRequest)->getProperty('.id');

        $setRequest = new RouterOS\Request('/ip/hotspot/user/profile/set');
        $setRequest->setArgument('numbers', $id);
        $setRequest->setArgument('on-login', $onLogin);
        $setRequest->setArgument('on-logout', $onLogout);
        $client->sendSync($setRequest);

        return redirect()->route('user.router.profiles',$request->router_id)->with(['success' => 'Patch profile success']);;
    }

    public function createProfile(Device $router)
    {
        $this->userRouterChecker($router);
        return view('user.device.add-profile',[
            'router'    => $router
        ]);
    }

    public function editProfile(Device $router, $profile)
    {
        $this->userRouterChecker($router);

        try {
            $client = new RouterOS\Client($router->ip_address, $router->username, $router->password);
        } catch (Exception $e) {
            return 'Unable to connect RouterOS';
        }
        $printRequest = new RouterOS\Request('/ip/hotspot/user/profile/print');
        $printRequest->setQuery(RouterOS\Query::where('name', $profile));
        $profile = $client->sendSync($printRequest);

        return view('user.device.edit-profile',[
            'profile' => $profile,
            'router'  => $router
        ]);
    }

    public function insertProfile(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            // 'shared_users' => 'required',
            // 'rate_limit' => 'required',
        ]);

        $router = Device::find($request->router_id);
        $this->userRouterChecker($router);
        try {
            $client = new RouterOS\Client($router->ip_address, $router->username, $router->password);
        } catch (Exception $e) {
            return 'Unable to connect RouterOS';
        }
        $util = new RouterOS\Util($client);
        $util->setMenu('/ip hotspot user profile');
        $util->add(
            array(
                'name' => $request->name,
                'shared-users' => $request->shared_users,
                'rate-limit' => $request->rate_limit,
            )
        );

        return redirect()->route('user.router.profiles',$request->router_id)->with(['success' => 'Add profile success']);;
    }

    public function updateProfile(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            // 'shared_users' => 'required',
            // 'rate_limit' => 'required',
        ]);

        $router = Device::find($request->router_id);
        $this->userRouterChecker($router);

        try {
            $client = new RouterOS\Client($router->ip_address, $router->username, $router->password);
        } catch (Exception $e) {
            return 'Unable to connect RouterOS';
        }

        $printRequest = new RouterOS\Request('/ip/hotspot/user/profile/print');
        $printRequest->setArgument('.proplist', '.id');
        $printRequest->setQuery(RouterOS\Query::where('name', $request->old_profile));
        $id = $client->sendSync($printRequest)->getProperty('.id');

        $setRequest = new RouterOS\Request('/ip/hotspot/user/profile/set');
        $setRequest->setArgument('numbers', $id);
        $setRequest->setArgument('name', $request->name);
        $setRequest->setArgument('shared-users', $request->shared_users);
        $setRequest->setArgument('rate-limit', $request->rate_limit);
        $client->sendSync($setRequest);

        return redirect()->route('user.router.profiles',$request->router_id)->with(['success' => 'Update profile success']);
    }

    public function createUser(Device $router)
    {
        $this->userRouterChecker($router);

        try {
            $client = new RouterOS\Client($router->ip_address, $router->username, $router->password);
        } catch (Exception $e) {
            return 'Unable to connect RouterOS';
        }

        $responses = $client->sendSync(new RouterOS\Request('/ip/hotspot/user/profile/print'));

        return view('user.device.add-user',[
            'responses' => $responses,
            'router'    => $router
        ]);
    }

    public function insertUser(Request $request)
    {

        $this->validate($request,[
            'name' => 'required',
            'password' => 'required',
        ]);

        $router = Device::find($request->router_id);
        $this->userRouterChecker($router);
        try {
            $client = new RouterOS\Client($router->ip_address, $router->username, $router->password);
        } catch (Exception $e) {
            return 'Unable to connect RouterOS';
        }
        $util = new RouterOS\Util($client);
        $util->setMenu('/ip hotspot user');
        $util->add(
            array(
                'name' => $request->name,
                'password' => $request->password,
                'profile' => $request->profile,
            )
        );

        return redirect()->route('user.router.users',$request->router_id)->with(['success' => 'Add user success']);;
    }

    public function editUser(Device $router, $name)
    {
        $this->userRouterChecker($router);
        try {
            $client = new RouterOS\Client($router->ip_address, $router->username, $router->password);
        } catch (Exception $e) {
            return 'Unable to connect RouterOS';
        }

        $printRequest = new RouterOS\Request('/ip/hotspot/user/print');
        $printRequest->setQuery(RouterOS\Query::where('name', $name));
        $user = $client->sendSync($printRequest);

        $responses = $client->sendSync(new RouterOS\Request('/ip/hotspot/user/profile/print'));

        return view('user.device.edit-user',[
            'user' => $user,
            'responses' => $responses,
            'router'    => $router
        ]);
    }

    public function updateUser(Request $request)
    {

        $this->validate($request,[
            'name' => 'required',
            'password' => 'required',
        ]);

        $router = Device::find($request->router_id);
        $this->userRouterChecker($router);
        try {
            $client = new RouterOS\Client($router->ip_address, $router->username, $router->password);
        } catch (Exception $e) {
            return 'Unable to connect RouterOS';
        }

        $printRequest = new RouterOS\Request('/ip/hotspot/user/print');
        $printRequest->setArgument('.proplist', '.id');
        $printRequest->setQuery(RouterOS\Query::where('name', $request->old_name));
        $id = $client->sendSync($printRequest)->getProperty('.id');

        $setRequest = new RouterOS\Request('/ip/hotspot/user/set');
        $setRequest->setArgument('numbers', $id);
        $setRequest->setArgument('name', $request->name);
        $setRequest->setArgument('password', $request->password);
        $setRequest->setArgument('profile', $request->profile);
        $client->sendSync($setRequest);

        return redirect()->route('user.router.users',$request->router_id)->with(['success' => 'Update user success']);;
    }

    public function activateUser(Device $router, $name)
    {
        $this->userRouterChecker($router);

        try {
            $client = new RouterOS\Client($router->ip_address, $router->username, $router->password);
        } catch (Exception $e) {
            return 'Unable to connect RouterOS';
        }

        $printRequest = new RouterOS\Request('/ip/hotspot/user/print');
        $printRequest->setArgument('.proplist', '.id');
        $printRequest->setQuery(RouterOS\Query::where('name', $name));
        $id = $client->sendSync($printRequest)->getProperty('.id');

        $setRequest = new RouterOS\Request('/ip/hotspot/user/set');
        $setRequest->setArgument('numbers', $id);
        $setRequest->setArgument('disabled', 'false');
        $client->sendSync($setRequest);

        return redirect()->route('user.router.users',$router->id)->with(['success' => 'Activate user success']);
    }

    public function deactivateUser(Device $router, $name)
    {
        $this->userRouterChecker($router);

        try {
            $client = new RouterOS\Client($router->ip_address, $router->username, $router->password);
        } catch (Exception $e) {
            return 'Unable to connect RouterOS';
        }

        $printRequest = new RouterOS\Request('/ip/hotspot/user/print');
        $printRequest->setArgument('.proplist', '.id');
        $printRequest->setQuery(RouterOS\Query::where('name', $name));
        $id = $client->sendSync($printRequest)->getProperty('.id');

        $setRequest = new RouterOS\Request('/ip/hotspot/user/set');
        $setRequest->setArgument('numbers', $id);
        $setRequest->setArgument('disabled', 'true');
        $client->sendSync($setRequest);

        return redirect()->route('user.router.users',$router->id)->with(['success' => 'Activate user success']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Device $router)
    {
        $this->userRouterChecker($router);
        return view('user.device.edit',[
            'router' => $router
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

        $this->validate($request,[
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        $device = $this->device->find($request->id);

        $this->userRouterChecker($device);
        
        $device->update([
            'name' => $request->name,
            'username' => $request->username,
            'password' => $request->password,
        ]);

        return redirect()->route('user.router.index')->with(['success' => 'Update router success']);;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $router = $this->device->find($request->id);
        $this->userRouterChecker($router);

        $router->delete();
        return redirect()->route('user.router.index')->with(['success' => 'Delete router success']);;
    }

    public function destroyUser(Request $request)
    {
        $router = $this->device->find($request->router_id);
        $this->userRouterChecker($router);

        try {
            $client = new RouterOS\Client($router->ip_address, $router->username, $router->password);
        } catch (Exception $e) {
            return 'Unable to connect RouterOS';
        }

        $printRequest = new RouterOS\Request('/ip/hotspot/user/print');
        $printRequest->setArgument('.proplist', '.id');
        $printRequest->setQuery(RouterOS\Query::where('name', $request->name));
        $id = $client->sendSync($printRequest)->getProperty('.id');
        //$id now contains the ID of the entry we're targeting

        $removeRequest = new RouterOS\Request('/ip/hotspot/user/remove');
        $removeRequest->setArgument('numbers', $id);
        $client->sendSync($removeRequest);

        return redirect()->route('user.router.users',$router->id)->with(['success' => 'Delete user success']);;
    }

    public function destroyProfile(Request $request)
    {
        $router = $this->device->find($request->router_id);
        $this->userRouterChecker($router);

        try {
            $client = new RouterOS\Client($router->ip_address, $router->username, $router->password);
        } catch (Exception $e) {
            return 'Unable to connect RouterOS';
        }

        $printRequest = new RouterOS\Request('/ip/hotspot/user/profile/print');
        $printRequest->setArgument('.proplist', '.id');
        $printRequest->setQuery(RouterOS\Query::where('name', $request->name));
        $id = $client->sendSync($printRequest)->getProperty('.id');
        //$id now contains the ID of the entry we're targeting

        $removeRequest = new RouterOS\Request('/ip/hotspot/user/profile/remove');
        $removeRequest->setArgument('numbers', $id);
        $client->sendSync($removeRequest);

        return redirect()->route('user.router.profiles',$router->id)->with(['success' => 'Delete profile success']);;
    }

    function userRouterChecker($router)
    {
        if($router->customer_id != auth()->user()->customer->id)
            return redirect()->back();
    }
}
