@extends('layouts.auth')

@section('content')
    <section>
        <div class="page-header min-vh-75">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                        <div class="card card-plain mt-8 mb-10">
                            <div class="card-header pb-0 text-left bg-transparent">
                                <h3 class="font-weight-bolder text-info text-gradient">Verifikasi OTP</h3>
                                <p class="mb-0">Masukkan kode OTP yang dikirim ke email <b>{{ session('email') }}</b>
                                </p>
                            </div>
                            <div class="card-body">
                                    <form method="POST" action="{{ route('otp.store') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <div class="row otp-inputs">
                                            @for ($i = 0; $i < 6; $i++)
                                                <div class="col-2 p-0">
                                                    <input type="text" name="otp[]" id="otp{{ $i }}"
                                                        style="width: 80%;" maxlength="1"
                                                        class="form-control text-center otp-input @error('otp') is-invalid @enderror"
                                                        required>
                                                </div>
                                            @endfor
                                            @error('otp')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <p class="mb-0 mt-3">Tidak menerima OTP? <b id="countdown"></b></p>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" href="dashboardSeller.html"
                                            class="btn bg-gradient-info w-100 mt-4 mb-0">DAFTAR</button>
                                    </div>
                                </form>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const otpInputs = document.querySelectorAll('.otp-input');

            otpInputs.forEach((input, index) => {
                input.addEventListener('input', (e) => {
                    // Move to next input field if not the last one
                    if (input.value.length === 1 && index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }
                });

                input.addEventListener('keydown', (e) => {
                    // Move to previous input field on backspace
                    if (e.key === 'Backspace' && index > 0 && input.value.length === 0) {
                        otpInputs[index - 1].focus();
                    }
                });
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const otpInputs = document.querySelectorAll('.otp-input');

            otpInputs.forEach((input, index) => {
                input.addEventListener('input', (e) => {
                    // Move to next input field if not the last one
                    if (input.value.length === 1 && index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }
                });

                input.addEventListener('keydown', (e) => {
                    // Move to previous input field on backspace
                    if (e.key === 'Backspace' && index > 0 && input.value.length === 0) {
                        otpInputs[index - 1].focus();
                    }
                });
            });

            const form = document.getElementById('otp-form');
            form.addEventListener('submit', (e) => {
                const allInputs = Array.from(otpInputs);
                const allFilled = allInputs.every(input => input.value.length === 1);

                if (!allFilled) {
                    e.preventDefault();
                    alert('Please complete the OTP');
                }
            });
        });
    </script>
@endsection