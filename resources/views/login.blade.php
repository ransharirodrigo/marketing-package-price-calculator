@extends('layouts.app')

@section('content')
<div class="container-fluid vh-100">
    <div class="row vh-100 d-flex align-items-center justify-content-center py-5">
        <div class="login-container bg-white rounded-4 shadow-lg overflow-hidden col-12 col-sm-8 col-lg-6 col-xl-4">
            <div class="common-gradient text-center p-4 mt-3">
                <svg class="agency-logo mb-3" viewBox="0 0 24 24" fill="white">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
                </svg>
                <h1 class="common-heading-light fs-4">{{ __("main.admin")." ".__("main.portal") }}</h1>
            </div>
            <form id="login_form" method="post" action="{{ route('admin.login') }}">
                @csrf
                <div class="p-4 p-md-3">
                    <div class="mb-4">
                        <label for="email" class="common-form-label">{{ __("main.email")}}</label>
                        <input type="email" class="form-control common-form-control" id="email" name="email" required placeholder="{{ __("main.enter")." ".__("main.your")." ".__("main.email") }}" value="">
                    </div>

                    <div class="mb-4">
                        <label for="password" class="common-form-label">{{ __("main.password")}}</label>
                        <input type="password" class="form-control common-form-control" id="password" name="password" required placeholder="{{ __("main.enter")." ".__("main.your")." ".__("main.password") }}" value="">
                    </div>

                    <button class="common-gradient-btn w-100 py-3">{{ __("main.sign_in")}}</button>

                    <p class="common-text text-center mt-4">© 2025 Digital Marketing Agency</p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection