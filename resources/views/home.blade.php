@extends('layouts.app')

@section('content')
<div class="container-fluid vh-100">
    <div class="row vh-100">
        <div class="col-12 vh-100">
            <div class="row">
                @include("layouts.navbar")
            </div>

            <div class="row mt-4">
                <div class="col-12 col-md-6 ">
                    <h3 class="common-heading">{{__('main.business')." ".__('main.type')." ".__('main.management')}}</h3>

                    <div class="row ms-1">
                        <div class="col-6 col-sm-4 col-lg-2">
                            <div class="row">
                                <button class="btn common-coral-btn-bordered-small" id="addBusiness"><i class="fa-solid fa-plus"></i> {{__('main.add')}}</button>
                            </div>
                        </div>
                    </div>

                    <div class="row px-3 mt-5">
                        <table id="business_type_table" data-url="{{ url("business-list") }}" class="table table-bordered table-hover table-responsive">
                            <thead>
                                <tr>
                                    <th scope="col">{{__("main.no")}}</th>
                                    <th scope="col">{{__("main.business")}}</th>
                                    <th scope="col">{{__("main.action")}}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="col-12 col-md-6 ">
                    <h3 class="common-heading">{{__('main.price')." ".__('main.metrics')." ".__('main.management')}}</h3>

                    <div class="row ms-1">
                        <div class="col-6 col-sm-4 col-lg-2">
                            <div class="row">
                                <button class="btn common-coral-btn-bordered-small" id="addPriceMetrics"><i class="fa-solid fa-plus"></i> {{__('main.add')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addBusinessModal" tabindex="-1" role="dialog" aria-labelledby="addBusinessModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title" id="addBusinessModalLabel">{{ __('main.add_business') }}</h5>
            </div>
            <div class="modal-body">
                <form id="addBusinessForm">
                    @csrf
                    <div class="form-group">
                        <label for="businessName">{{ __('main.business_name') }}</label>
                        <input type="text" class="form-control common-form-control" id="businessName" name="businessName" placeholder="{{ __('main.enter_business_name') }}" value="">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn common-coral-btn-bordered-small" id="closeBusinessModal" data-dismiss="modal">{{ __('main.close') }}</button>
                <button type="button" class="btn common-gradient-btn-small" id="saveBusiness">{{ __('main.save') }}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addPriceMetricsModal" tabindex="-1" role="dialog" aria-labelledby="addPriceMetricsModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title" id="addBusinessModalLabel">{{ __('main.add_business') }}</h5>
            </div>
            <div class="modal-body">
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn common-coral-btn-bordered-small" id="closePriceMetricsModal" data-dismiss="modal">{{ __('main.close') }}</button>
                <button type="button" class="btn common-gradient-btn-small" id="savePriceMetrics">{{ __('main.save') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

<script src="{{asset("js/table.js")  }}"></script>

<!-- BUSINESS TABLE DATA LOAD -->
<script>
    const businessListUrl = "{{ url('business-list') }}";
    $(document).ready(function() {
        loadBusinessTypeTableData();
    });
</script>

@endsection