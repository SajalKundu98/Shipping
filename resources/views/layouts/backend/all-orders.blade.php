@extends('layouts.backend.master')
@section('title')
    All Orders
@endsection
@section('admin-additional-css')
@endsection
@section('content')
@include('layouts.backend.includes.alert')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">All Orders</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Order Number</th>
                                    <th>Email</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($order_infos as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img src="{{ asset('storage/'.$item->image) }}" alt="" style="width: 50px; height: 50px;">
                                    </td>
                                    <td>{{ $item->order_number }}</td>
                                    <td>{{ $item->customer_email }}</td>
                                    <td>
                                        <a href="{{ url('/orders/' . $item->id) }}" title="View Order">
                                            <button class="btn btn-info btn-sm">
                                                <i class="fa fa-eye" aria-hidden="true"></i> 
                                                
                                            </button>
                                        </a>
                                        {!! Form::open([
                                            'method'=>'DELETE',
                                            'url' => ['/orders', $item->id],
                                            'style' => 'display:inline'
                                        ]) !!}
                                            {!! Form::button('<i class="fas fa-trash-alt" aria-hidden="true"></i>', array(
                                                    'type' => 'submit',
                                                    'class' => 'btn btn-danger btn-sm',
                                                    'title' => 'Delete Order',
                                                    'onclick'=>'return confirm("Confirm delete?")'
                                            )) !!}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="pagination-wrapper"> {!! $order_infos->appends(['search' => Request::get('search')])->render() !!} </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('admin-additional-js')
@endsection