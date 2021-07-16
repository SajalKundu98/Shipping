<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ShippingSystem - Preview</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('backend/css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

<body class="bg-gradient-primary">
@include('layouts.backend.includes.alert')
<div class="container">
    <div class="row mt-3">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">Preview</div>
                <div class="card-body">

                    <p class="text-center">Dear customer, here you find your Preview for Order {{ $order_info->order_number }}</p>

                    {!! Form::open(['url' => '/preview-update', 'class' => 'form-horizontal ',  'files' => true]) !!}

                        <div class="row">
                            <div class="col-md-12">
                                <img src="{{ asset('storage/'.$order_info->image) }}" alt="" style="width: 100%;">
                            </div>
                        </div>

                        <input type="hidden" name="order_info_id" value="{{ $order_info->id }}">



                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="form-group {{ $errors->has('message_to_admin') ? 'has-error' : ''}}">
                                    {!! Form::label('message_to_admin', 'Text Area', ['class' => 'control-label']) !!}
                                    {!! Form::textarea('message_to_admin', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required', 'rows' => '3', 'cols' => '5'] : ['class' => 'form-control', 'rows' => '3', 'cols' => '5']) !!}
                                    {!! $errors->first('message_to_admin', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::submit('Send', ['class' => 'btn btn-primary']) !!}
                                </div>
                            </div>
                        </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap core JavaScript-->
<script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('backend/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('backend/js/sb-admin-2.min.js') }}"></script>

</body>

</html>