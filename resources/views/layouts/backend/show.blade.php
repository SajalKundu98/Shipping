@extends('layouts.backend.master')
@section('title')
@section('title', "Order $order->id")
@endsection
@section('admin-additional-css')
@endsection
@section('content')
@include('layouts.backend.includes.alert')
<div class="container">
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Order No: {{ $order->order_number }}</div>
                <div class="card-body">

                    <a href="{{ url('/all-orders') }}" title="Back">
                        <button class="btn btn-warning btn-sm">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        </button>
                    </a>
                    {!! Form::open([
                        'method'=>'DELETE',
                        'url' => ['orders', $order->id],
                        'style' => 'display:inline'
                    ]) !!}
                        {!! Form::button('<i class="fas fa-trash-alt" aria-hidden="true"></i>', array(
                                'type' => 'submit',
                                'class' => 'btn btn-danger btn-sm',
                                'title' => 'Delete Order',
                                'onclick'=>'return confirm("Confirm delete?")'
                        ))!!}
                    {!! Form::close() !!}
                    <br/>
                    <br/>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Image</th>
                                    <td>
                                        <img src="{{ asset('storage/'.$order->image) }}" alt="" style="width: 200px; height: 200px;">
                                    </td>
                                </tr>
                                <tr>
                                    <th> Customer Email </th>
                                    <td> {{ $order->customer_email }} </td>
                                </tr>
                                <tr>
                                    <th> Order number </th>
                                    <td> {{ $order->order_number }} </td>
                                </tr>
                                <tr>
                                    <th> Message To Customer </th>
                                    <td> {{ $order->message_to_customer_with_link }} </td>
                                </tr>
                                <tr>
                                    <th> Message To Admin </th>
                                    <td> {{ $order->message_to_admin }} </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('admin-additional-js')
@endsection