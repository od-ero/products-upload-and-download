@extends('layouts.my_auth_master')
@section('subtitle')
 Reset password
@endsection

@section('contentheader_title')
 Reset assword
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header"><h3 class="text-center font-weight-light my-4">Password Recovery</h3></div>
            <div class="card-body">
                <div class="small mb-3 text-muted">Enter your email address and we will send you a link to reset your password.</div>
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputEmail" type="email" name="email" placeholder="name@example.com" required autofocus />
                        <label for="inputEmail">Email address</label>
                        @if ($errors->has('email'))
                                                    <div class="text-danger mt-2">
                                                        {{ $errors->first('email') }}
                                                    </div>
                                                @endif
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        <a class="small" href="{{ route('login') }}">Return to login</a>
                        <button class="btn btn-primary" type="submit">Reset Password</button>
                       
                    </div>
                </form>
            </div>
            <div class="card-footer text-center py-3">
                <div class="small"><a href="{{ route('register') }}">Need an account? Sign up!</a></div>
            </div>
        </div>
    </div>
</div>

@endsection