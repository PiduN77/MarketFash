@extends('layouts.auth')

@section('content')
    <section>
        <div class="page-header min-vh-75">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                        <div class="card card-plain mt-8">
                            <div class="card-header pb-0 text-left bg-transparent">
                                <h3 class="font-weight-bolder text-info text-gradient">Welcome</h3>
                                <p class="mb-0">Create an account</p>
                            </div>
                            <div class="card-body">
                                <form role="form" method="POST" action="{{ route('register') }}">
                                    @csrf

                                    <!--User Type-->
                                    <input type="hidden" value="C" name="userType">
                                    <!--End User Type-->

                                    <!--Name-->
                                    <label for="name">Name</label>
                                    <div class="mb-3">
                                        <input id="name" type="name"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Name"
                                            aria-label="Name">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <!--End Name-->
                                    
                                    <!--Email-->
                                    <label for="email">Email</label>
                                    <div class="mb-3">
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email" placeholder="Email"
                                            aria-label="Email" aria-describedby="email-addon">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <!--End Email-->

                                    <!--Password-->
                                    <label for="password">Password</label>
                                    <div class="mb-3">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="new-password" placeholder="Password"
                                            aria-label="Password" aria-describedby="password-addon">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <!--End Password-->

                                    <!--Confirm Password-->
                                    <label for="password-confirm">Confirm Password</label>
                                    <div class="mb-3">
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" required autocomplete="new-password"
                                            placeholder="Confirm Password" aria-label="Password"
                                            aria-describedby="password-addon">
                                    </div>
                                    <!--End Confirm Password-->

                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Sign
                                            up</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                <p class="mb-4 text-sm mx-auto">
                                    Already have a Marketplace account?
                                    <a href="{{ route('login') }}" class="text-info text-gradient font-weight-bold">Log
                                        In</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                            <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6"
                                style="background-image:url('{{ asset('assets/img/curved-images/curved6.jpg') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection