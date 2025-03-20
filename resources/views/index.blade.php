@extends('layouts.app')

@section('content')
<div class="container-fluid vh-100 py-5 py-sm-0">

    <div class="row  vh-100 d-lg-flex justify-content-center align-items-xxl-center">
        <div class="col-12 col-lg-10">
            <div class="calculator-page bg-white rounded-4 shadow-lg p-0">

                <div class="row g-0">
                    <div class="col-lg-4">
                        <div class="calculator-sidebar p-4 h-100">
                            <div class="d-flex align-items-center mb-4">
                                <svg class="calculator-logo me-3" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M4 2h16a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2zm0 2v16h16V4H4zm2 2h12v2H6V6zm0 4h4v2H6v-2zm0 4h4v2H6v-2zm0 4h4v2H6v-2zm6-8h6v2h-6v-2zm0 4h6v2h-6v-2zm0 4h6v2h-6v-2z" />
                                </svg>
                                <h1 class="common-heading text-white fs-4 mb-0">{{ __("main.package")." ".__("main.price") ." ".__("main.calculator") }}</h1>
                            </div>
                            <div class="sidebar-info">
                                <div class="common-text-2-light-grey mt-4">
                                    <p>{{__("messages.calculator_sidebar_tag_line")}}</p>
                                </div>
                            </div>
                            <div>
                                @if (Auth::check())
                                <a href="{{ route('admin.dashboard') }}" class="btn common-gradient-btn">
                                    <i class="fas fa-tachometer-alt me-2"></i>{{ __("main.admin")." ".__("main.dashboard") }}
                                </a>
                                @else

                                <a href="{{ route('login') }}" class="btn common-gradient-btn">
                                    <i class="fas fa-lock me-2"></i>{{ __("main.admin")." ".__("main.login") }}
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="p-4 p-lg-5">
                            <div class="mb-4">
                                <label for="businessType" class="common-form-label">{{ __("main.business")." ".__("main.type") }}</label>
                                <select id="businessType" class="form-select common-form-control">

                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="common-form-label">{{ __("main.select")." ".__("main.inventory")." ".__("main.platform") }}</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="facebook" value="Facebook">
                                        <label class="common-text" for="facebook">Facebook</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="youtube" value="Youtube">
                                        <label class="common-text" for="youtube">Youtube</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="tiktok" value="TikTok">
                                        <label class="common-text" for="tiktok">TikTok</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="instagram" value="Insta">
                                        <label class="common-text" for="instagram">Instagram</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="twitter" value="Twitter">
                                        <label class="common-text" for="twitter">Twitter</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="webPagesTamil" value="Web Pages-Tamil">
                                        <label class="common-text" for="webPagesTamil">Web Pages-Tamil</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="webPagesSinhala" value="Web Pages-Sinhala">
                                        <label class="common-text" for="webPagesSinhala">Web Pages-Sinhala</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="impressions" class="common-form-label">{{ __("main.impressions") }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text common-gradient"><i class="fas fa-eye text-white"></i></span>
                                        <input type="number" id="impressions" class="form-control  common-form-control" placeholder="Count" min="0">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="views" class="common-form-label">{{ __("main.views") }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text common-gradient"><i class="fas fa-tv text-white"></i></span>
                                        <input type="number" id="views" class="form-control  common-form-control" placeholder="Count" min="0">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="clicks" class="common-form-label">{{ __("main.clicks") }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text common-gradient "><i class="fas fa-mouse-pointer text-white"></i></span>
                                        <input type="number" id="clicks" class="form-control  common-form-control" placeholder="Count" min="0">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="videoViews" class="common-form-label">{{ __("main.video_views") }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text common-gradient"><i class="fas fa-video text-white"></i></span>
                                        <input type="number" id="videoViews" class="form-control  common-form-control" placeholder="Count" min="0">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="calls" class="common-form-label">{{ __("main.calls") }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text common-gradient"><i class="fas fa-phone text-white"></i></span>
                                        <input type="number" id="calls" class="form-control  common-form-control" placeholder="Count" min="0">
                                    </div>
                                </div>
                            </div>

                            <div class="calculator-actions d-flex mb-4">
                                <button onclick="calculateTotal()" class="btn common-gradient-btn me-2 flex-grow-1">Calculate</button>
                                <button onclick="generatePDF()" class="btn common-coral-btn-bordered flex-grow-1">Download PDF</button>
                            </div>

                            <!-- <div id="totalResult" class="mt-4">
                                <p>
                                    <strong>Rs 123000.00</strong>
                                </p>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection