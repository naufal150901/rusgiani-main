<x-auth.layout>
    @slot('title')
        {{ $title }}
    @endslot
    <div class="container">
        <div class="row flex-center min-vh-100 py-5">
            <div class="col-sm-10 col-md-8 col-lg-5 col-xl-5 col-xxl-3"><a
                    class="d-flex flex-center text-decoration-none mb-4" href="">
                    <div class="d-flex align-items-center fw-bolder fs-3 d-inline-block"><img
                            src="{{ asset('assets') }}/assets/img/icons/logo.png" alt="phoenix" width="58" />
                    </div>
                </a>
                <div class="text-center mb-7">
                    <h3 class="text-body-highlight">Sign In</h3>
                    <p class="text-body-tertiary">Get access to your account</p>
                </div>
                <a href="{{ route('google.login') }}" class="btn btn-phoenix-secondary w-100 mb-3"><span
                        class="fab fa-google text-danger me-2 fs-9"></span>Sign in with google</a>
                <button class="btn btn-phoenix-secondary w-100"><span
                        class="fab fa-facebook text-primary me-2 fs-9"></span>Sign in with facebook</button>
                <div class="position-relative">
                    <hr class="bg-body-secondary mt-5 mb-4" />
                    <div class="divider-content-center">or use email</div>
                </div>
                <div>
                </div>
                <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate=""
                    onsubmit="showLoader()">
                    @csrf
                    <div class="mb-3 text-start">
                        <label class="form-label" for="email">Email address</label>
                        <div class="form-icon-container">
                            <input class="form-control form-icon-input" id="email" type="email"
                                placeholder="name@example.com" name="email" value="{{ old('email') }}" required
                                autofocus autocomplete="username" /><span
                                class="fas fa-user text-body fs-9 form-icon"></span>
                        </div>
                        <div class="valid-feedback">Looks good!</div>
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label" for="password">Password</label>
                        <div class="form-icon-container" data-password="data-password">
                            <input class="form-control form-icon-input pe-6" id="password" type="password"
                                placeholder="Password" data-password-input="data-password-input" name="password"
                                required autocomplete="current-password" /><span
                                class="fas fa-key text-body fs-9 form-icon"></span>
                        </div>
                    </div>
                    <div class="row flex-between-center mb-7">
                        <div class="col-auto">
                            <div class="form-check mb-0">
                                <input class="form-check-input" id="basic-checkbox" type="checkbox" checked="checked" />
                                <label class="form-check-label mb-0" for="basic-checkbox">Remember me</label>
                            </div>
                        </div>
                        <div class="col-auto"><a class="fs-9 fw-semibold" href="{{ route('password.request') }}">Forgot
                                Password?</a>
                        </div>
                    </div>
                    <button class="btn btn-primary w-100 mb-3">Sign In</button>
                </form>
                <div class="text-center"><a class="fs-9 fw-bold" href="{{ route('register') }}">Create an
                        account</a>
                </div>
            </div>
        </div>
    </div>




</x-auth.layout>
