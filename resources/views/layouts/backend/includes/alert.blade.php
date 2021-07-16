<div class="container">
    <div class="row">
        <div class="col-lg-12">
            @if(Session::has('success'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <a href="#" class="alert-link">Success!</a> {{ Session::get('success') }}
                </div>
            @endif

            @if(Session::has('error'))
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <a href="#" class="alert-link">Error!</a> {{ Session::get('error') }}
                </div>
            @endif
        </div>
    </div>
</div>