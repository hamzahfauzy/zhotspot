<?php

namespace App\Http\Controllers\User;

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
        $payments = auth()->user()->customer->payments()->orderby('id','desc')->paginate(10);
        return view('user.payment.index',[
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
        return view('user.payment.create',[
            'products' => $this->products
        ]);
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
            'product' => 'required'
        ]);

        $product = Product::find($request->product);
        $customer_id = auth()->user()->customer->id;

        $payment = $this->payment->create([
            'customer_id' => $customer_id,
            'product_id'  => $request->product,
            'amount'      => $product->price,
            'file_url'    => '',
            'status'      => $product->price == 0 ? 1 : 0
        ]);

        $have_trial = true;
        $subscriptions = Subscription::where('customer_id',$customer_id)->get();
        foreach($subscriptions as $subscription)
        {
            if($subscription->payment->product->price == 0)
            {
                $have_trial = false;
                break;
            }
        }

        if($product->price == 0 && $have_trial)
        {
            $subscription = new Subscription;
            $subscription->create([
                'customer_id' => $customer_id,
                'payment_id'  => $payment->id,
                'status'      => 1
            ]);
        }

        return redirect()->route('user.payment.index')->with(['success' => 'Create payment success']);;
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

    public function upload(Request $request)
    {
        //
        $file = $request->file('file');
        $file_url = $file->store('public/payments');
        $this->payment->find($request->id)->update([
            'file_url' => $file_url,
            'status'   => 1
        ]);

        return redirect()->route('user.payment.index')->with(['success' => 'Upload payment success']);;
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
