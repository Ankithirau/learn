@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="container text-center text-dark">
        <div class="row">
            <div class="col-lg-4 d-block mx-auto">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center mb-6">
                                    <img src="{{URL::asset('assets/images/brand/logo.png')}}" class="bg-theme p-3" alt="">
                                </div>
                                <h3>Register</h3>
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <p class="text-muted">Create New Account</p>
                                    <div class="input-group mb-3">
                                        <span class="input-group-addon bg-white"><i class="fa fa-user w-4"></i></span>
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="input-group mb-4">
                                        <span class="input-group-addon bg-white"><i class="fa fa-envelope  w-4"></i></span>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="input-group mb-4">
                                        <span class="input-group-addon bg-white"><i class="fa fa-unlock-alt  w-4"></i></span>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="input-group mb-4">
                                        <span class="input-group-addon bg-white"><i class="fa fa-unlock-alt  w-4"></i></span>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary btn-block px-4">Create a new account</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection