@extends('layouts.backend.master')
@section('title')
    Home
@endsection
@section('admin-additional-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection
@section('content')
@include('layouts.backend.includes.alert')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Upload</div>
                <div class="card-body">

                    {!! Form::open(['url' => '/upload-save', 'class' => 'form-horizontal ',  'files' => true]) !!}
                    
                    <div class="dropzone" id="myDropzone"> </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('order_number') ? 'has-error' : ''}}">
                                    {!! Form::label('order_number', 'Order Number', ['class' => 'control-label']) !!}
                                    {!! Form::text('order_number', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required', 'id' => 'order_number'] : ['class' => 'form-control', 'id' => 'order_number']) !!}
                                    {!! $errors->first('order_number', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('customer_email') ? 'has-error' : ''}}">
                                    {!! Form::label('customer_email', 'Customer Email', ['class' => 'control-label']) !!}
                                    {!! Form::text('customer_email', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required', 'id' => 'customer_email'] : ['class' => 'form-control', 'id' => 'customer_email']) !!}
                                    {!! $errors->first('customer_email', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group {{ $errors->has('message_to_customer_with_link') ? 'has-error' : ''}}">
                                    {!! Form::label('message_to_customer_with_link', 'Message To Customer', ['class' => 'control-label']) !!}
                                    {!! Form::textarea('message_to_customer_with_link', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required', 'id' => 'message_to_customer_with_link'] : ['class' => 'form-control', 'id' => 'message_to_customer_with_link']) !!}
                                    {!! $errors->first('message_to_customer_with_link', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::submit('Create', ['class' => 'btn btn-primary', 'id' => 'submit-all']) !!}
                                </div>
                            </div>
                        </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('admin-additional-js')
<script type="text/javascript">
    Dropzone.options.myDropzone= {
        url: '{{ url("image-upload") }}',
        autoProcessQueue: false,
        uploadMultiple: false,
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        maxFiles: 1,
        maxFilesize: 8,
        acceptedFiles: 'image/*',
        addRemoveLinks: true,
        success: function(file, response){
            if(response.msg == 'success'){
                
                Swal.fire({
                    title: 'Order Info Sent',
                    text: "Order Info Sent Successfully",
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK'
                  }).then((result) => {
                    if (result.isConfirmed) {
                        var base_url = "{{ env('APP_URL') }}";
                        window.location = base_url+'/home';
                    }
                })
            }
        },
        error: function(file, response){
            Swal.fire({
                title: '<strong class="text-danger">Error</strong>',
                icon: 'info',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'OK',
                html:
                    '<p>'+response.errors.order_number || ''+'</p>,'+
                    '<p>'+response.errors.file || ''+'</p>,'+
                    '<p>'+response.errors.customer_email || ''+'</p>,'+
                    '<p>'+response.errors.message_to_customer_with_link || ''+'</p>',
                showCloseButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    var base_url = "{{ env('APP_URL') }}";
                    window.location = base_url+'/home';
                }
            })
        },
        init: function() {
            dzClosure = this;
            document.getElementById("submit-all").addEventListener("click", function(e) {
                e.preventDefault();
                e.stopPropagation();
                dzClosure.processQueue();
            });
            this.on("sending", function(file, xhr, formData) {
                formData.append("order_number", $("#order_number").val());
                formData.append("customer_email", $("#customer_email").val());
                formData.append("message_to_customer_with_link", $("#message_to_customer_with_link").val());
            });
        }
    }
</script>

<script>
    $(document).on('keyup', "#order_number", function(e){
        e.preventDefault();
        var order_id = $(this).val();
        let _token   = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{ url('customer-info') }}",
            type:"GET",
            data:{
                order_id:order_id,
                _token: _token
            },
            success:function(response){
                $("#customer_email").val(response.response.Data.Customer.Email);
            },
        });
    });
</script>
@endsection