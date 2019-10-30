<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Payment,Product,Subscription};

class PaymentController extends Controller
{
    function __construct()
    {
        $this->payment = new Payment;
        $this->products = Product::get();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $payments = $this->payment->orderby('id','desc')->paginate(10);
        return view('admin.payment.index',[
            'payments' => $payments
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

    public function confirm(Request $request)
    {
        $this->payment->find($request->id)->update([
            'status' => 2
        ]);

        $payment = $this->payment->find($request->id);

        $subscription = new Subscription;
        $subscription->create([
            'customer_id' => $payment->customer_id,
            'payment_id'  => $payment->id,
            'status'      => 1
        ]);

        return redirect()->route('admin.payment.index')->with(['success' => 'Confirm payment success']);;
    }

    public function decline(Request $request)
    {
        $this->payment->find($request->id)->update([
            'status' => 3
        ]);

        return redirect()->route('admin.payment.index')->with(['success' => 'Decline payment success']);;
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
