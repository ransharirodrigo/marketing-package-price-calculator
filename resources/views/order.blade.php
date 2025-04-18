@extends('layouts.app')

@section('content')
<div class="container-fluid vh-100">
    <div class="row vh-100">
        <div class="col-12 vh-100">
            <div class="row">
                @include("layouts.navbar")
            </div>

            <div class="row mt-4 d-flex justify-content-center">
                <div class="col-10">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="sortType" class="form-label">{{ __('main.type') }}</label>
                            <select class="form-select" id="sortType">
                                <option value="">{{ __('main.select') ." ".__('main.type') }}</option>
                                <option value="business">{{ __('main.business') }}</option>
                                <option value="inventory">{{ __('main.inventory') }}</option>
                                <option value="metrics">{{ __('main.metrics') }}</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="sortValue" class="form-label">{{ __('main.value') }}</label>
                            <select class="form-select" id="sortValue" disabled>
                                <option value="">{{ __('main.select') ." ".__('main.value') }}</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end justify-content-start">
                            <button class="btn common-coral-btn-bordered-small" id="applySort">{{ __('main.apply') }}</button>
                        </div>
                    </div>
                    <table id="order_table" data-url="{{ url("orders-list") }}" class="table table-bordered table-hover table-responsive">
                        <thead>
                            <tr>
                                <th scope="col">{{__("main.no")}}</th>
                                <th scope="col">{{__("main.customer") ." ".__("main.name") }}</th>
                                <th scope="col">{{__("main.customer")." ".__("main.mobile")}}</th>
                                <th scope="col">{{__("main.customer")." ".__("main.email")}}</th>
                                <th scope="col">{{__("main.customer")." ".__("main.address")}}</th>
                                <th scope="col">{{__("main.proforma")." ".__("main.invoice")." ".__("main.number")}}</th>
                                <th scope="col">{{__("main.action")}}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="invoiceItemModal" tabindex="-1" aria-labelledby="invoiceItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invoiceItemModalLabel">Invoice Items</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               
            </div>
            <div class="modal-body">
                <h5 id="business_name"></h5>
                <div id="invoice-items-container">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

<script src="{{asset("js/table.js")  }}"></script>

<!-- ORDER TABLE DATA LOAD -->
<script>
    const orderListUrl = "{{ url('orders-list') }}";
    $(document).ready(function() {
        loadOrderTable();
    });
</script>
@endsection