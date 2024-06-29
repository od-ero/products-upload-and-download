@extends('layouts.my_auth_master')
@section('subtitle')
 Email Verification
@endsection

@section('contentheader_title')
 Email Verification
@endsection

@section('content')

            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Email Verification</h3></div>
                        <div class="card-body">
                            <div class="mb-4 text-muted">
                                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                            </div>

                            @if (session('status') == 'verification-link-sent')
                                <div class="mb-4 fw-medium text-success">
                                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                                </div>
                            @endif

                            <div class="mt-4 d-flex align-items-center justify-content-between">
                                <form method="POST" action="{{ route('verification.send') }}">
                                    @csrf

                                    <div>
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Resend Verification Email') }}
                                        </button>
                                    </div>
                                </form>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <button type="submit" class="btn btn-link text-muted text-decoration-underline">
                                        {{ __('Log Out') }}
                                    </button>
                                </form>
                            </div>
                         </div>
                        <div class="card-footer text-center py-3">
                            <div class="small"><a href="{{ route('login') }}">Have an account? Go to login</a></div>
                        </div>
                    </div>
                </div>
            </div>
@endsection


