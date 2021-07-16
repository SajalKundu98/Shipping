<?php

namespace App\Http\Controllers;

use App\Models\OrderInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Mail\MailToCustomer;
use App\Mail\MailToAdmin;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class UploadController extends Controller
{
    public function uploadFile(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'message_to_customer_with_link' => 'required|string',
            'customer_email' => 'required|email',
            'order_number' => 'required|unique:order_infos',
            'file' => 'required|mimes: jpg,png,jpeg,gif'
        ]);

        if($validate->fails()){
            return response()->json(['msg' => 'failed', 'errors' => $validate->errors()], 422);
        }
        
        if ($request->file('file')) {
            $filePath = $request->file('file');
            $fileName = $request->order_number.'.'.strtolower($filePath->getClientOriginalExtension());
            $path = $request->file('file')->storeAs('uploads', $fileName, 'public');
        }else{
            $path =  null;
        }

        $order_info = new OrderInfo();
        $order_info->image = $path;
        $order_info->order_number = $request->order_number;
        $order_info->customer_email = $request->customer_email;
        $order_info->message_to_customer_with_link = $request->message_to_customer_with_link;
        $order_info->save();

        $url = env("APP_URL").'/preview?id='.$request->order_number;

        Mail::to($request->customer_email)->send(new MailToCustomer($url));

        
        Session::flash('flash_message', __('Order Info Sent Successfully'));
        Session::flash('flash_type', 'success');
        
        return response()->json([
            'msg' => 'success'
        ]);
       
    }

    public function previewData(Request $request)
    {
        if(isset($request->id)){
            $order_id = $request->id;
            $order_info = OrderInfo::where('order_number', $order_id)->first();
            if(!$order_info){
                return redirect('/login');
            }
            return view('layouts.backend.preview', compact('order_info'));
        }else{
            return redirect('/login');
        }
        
    }

    public function previewDataUpdate(Request $request)
    {
        $this->validate($request, [
            'message_to_admin' => 'required|string'
        ]);

        $order_info = OrderInfo::find($request->order_info_id);
        if(!$order_info){
            return redirect('/login');
        }

        $order_info->message_to_admin = $request->message_to_admin;
        $order_info->save();

        Mail::to('info')->send(new MailToAdmin($order_info));
        return redirect()->back()->with('success', 'Successfully Sent');
    }

    public function allOrders()
    {
        $order_infos = OrderInfo::latest()->paginate(25);
        return view('layouts.backend.all-orders', compact('order_infos'));
    }

    public function show($id)
    {
        $order = OrderInfo::find($id);
        if(!$order){
            return redirect('/all-orders')->with('error', 'Order Info Not found');
        }
        return view('layouts.backend.show', compact('order'));
    }

    public function destroy($id)
    {
        $order = OrderInfo::find($id);
        if(!$order){
            return redirect('/all-orders')->with('error', 'Order Info Not found');
        }

        if (Storage::disk('public')->exists($order->image)) {
            Storage::disk('public')->delete($order->image);
        }

        $order->delete();

        return redirect('/all-orders')->with('success', 'Order Info Deleted!');
    }

    public function customerInfo(Request $request)
    {
        $order_id = $request->order_id;
        $response = Http::accept('application/json')->withBasicAuth('info@holzura.de', 'Holzura+2020')->withHeaders([
            'X-Billbee-Api-Key' => '2739C559-8D9C-43DB-A954-A90EFC8EDD6D',
        ])->get('https://app.billbee.io/api/v1/orders/findbyextref/'.$order_id);

        return response()->json([
            'response' => json_decode($response->body()),
        ]);
    }
}
