@extends('layouts.my_auth_master')
@section('subtitle')
  Register
@endsection

@section('contentheader_title')
    Register
@endsection

@section('content')

            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Account</h3></div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-floating mb-3">
                                    <input class="form-control" id="inputName"  name="name" type="text" placeholder="Enter your name" required autofocus autocomplete="name"  />
                                    <label for="inputEmail">Full Name</label>
                                    @if ($errors->has('name'))
                                        <div class="text-danger mt-2">
                                            {{ $errors->first('name') }}
                                        </div>
                                   @endif
                                </div>

                               
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="inputEmail"  name="email" type="email" placeholder="name@example.com" required autocomplete="username" />
                                    <label for="inputEmail">Email address</label>
                                    @if ($errors->has('email'))
                                        <div class="text-danger mt-2">
                                            {{ $errors->first('email') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Create a password"  required autocomplete="new-password"  />
                                            <label for="inputPassword">Password</label>
                                            @if ($errors->has('password'))
                                                <div class="text-danger mt-2">
                                                    {{ $errors->first('password') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="inputPasswordConfirm" type="password" placeholder="Confirm password"  name="password_confirmation" required autocomplete="new-password" />
                                            <label for="inputPasswordConfirm">Confirm Password</label>
                                            @if ($errors->has('password_confirmation'))
                                                <div class="text-danger mt-2">
                                                    {{ $errors->first('password_confirmation') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 mb-0">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-block">Create Account</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer text-center py-3">
                            <div class="small"><a href="{{ route('login') }}">Have an account? Go to login</a></div>
                        </div>
                    </div>
                </div>
            </div>
@endsection


