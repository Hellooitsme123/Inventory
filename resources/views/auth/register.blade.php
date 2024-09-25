@extends ('layouts.index')

@section('title','Sign Up')

@section('content')
    <div class="container-fluid padding mb-5">
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible mt-4">
            <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{Session::get('success')}}
        </div>
        @endif
        @if(Session::has('error'))
            <div class="alert alert-danger alert-dismissible mt-4">
                <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{Session::get('error')}}
            </div>
        @endif
        <div class="container">
            <div class="text-center">
                <div class="alert alert-danger alert-dismissible mt-4">
                    <div class="text-center fh5co_heading py-2">Sign Up</div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-6">
                        <form action="{{ route('handle.register') }}" method="POST">
                            @csrf

                            <div class="form-group col-12 py-3">
                                <input type="text" name="name" class="form-control form-control-user fh5co_contact_text_box" id="name" value="{{ old('name') }}" placeholder="Enter Name" required/>
                            </div>
                            <div class="form-group col-12 py-3">
                                <input type="email" name="email" class="form-control form-control-user fh5co_contact_text_box" id="email" value="{{ old('email') }}" aria-describedby="emailHelp" placeholder="Email" required/>
                            </div>
                            <div class="form-group col-12 py-3">
                                <input type="password" name="password" class="form-control form-control-user fh5co_contact_text_box" id="password" placeholder="Password" required/>
                            </div>
                            <div class="form-group col-12 py-3">
                                <input type="password" name="confpassword" class="form-control form-control-user fh5co_contact_text_box" id="password" placeholder="Confirm Password" required/>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">Sign Up</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection