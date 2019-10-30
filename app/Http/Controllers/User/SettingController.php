<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Product,Customer,Payment,Subscription};

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function lastStep()
    {
        if(!empty(auth()->user()->customer))
            return redirect('/dashboard');
        $products = Product::get();
        return view('user.setting.last-step',[
            'products' => $products,
            'sidebar' => false
        ]);
    }

    public function saveLastStep(Request $request)
    {
        $this->validate($request, [
            'address' => 'required',
            'phone'   => 'required',
            'product'   => 'required',
        ]);

        $customer = new Customer;
        $customer = $customer->create([
            'user_id' => auth()->user()->id,
            'address' => $request->address,
            'phone'   => $request->phone
        ]);

        $product = Product::find($request->product);

        $payment = new Payment;
        $payment = $payment->create([
            'customer_id' => $customer->id,
            'product_id'  => $request->product,
            'amount'      => $product->price,
            'file_url'    => '',
            'status'      => $product->price == 0 ? 1 : 0
        ]);

        if($product->price == 0)
        {
            $subscription = new Subscription;
            $subscription->create([
                'customer_id' => $customer->id,
                'payment_id'  => $payment->id,
                'status'      => 1
            ]);
        }

        return redirect('/dashboard');
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
