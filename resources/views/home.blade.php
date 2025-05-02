@extends('layouts.app')

@section('content')
<div class="container-fluid vh-100">
    <div class="row vh-100">
        <div class="col-12 vh-100">
            <div class="row">
                @include("layouts.navbar")
            </div>

            <div class="row mt-4">
                <div class="col-12 col-xl-6 ">
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
                <div class="col-12 col-xl-6">
                    <h3 class="common-heading">{{__('main.inventory')." ".__('main.management')}}</h3>

                    <div class="row ms-1">
                        <div class="col-6 col-sm-4 col-lg-2">
                            <div class="row">
                                <button class="btn common-coral-btn-bordered-small" id="addInventory"><i class="fa-solid fa-plus"></i> {{__('main.add')}}</button>
                            </div>
                        </div>
                    </div>

                    <div class="row px-3 mt-5">
                        <table id="inventory_table" data-url="{{ url("inventory-list") }}" class="table table-bordered table-hover table-responsive">
                            <thead>
                                <tr>
                                    <th scope="col">{{__("main.no")}}</th>
                                    <th scope="col">{{__("main.inventory")}}</th>
                                    <th scope="col">{{__("main.action")}}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <div class="col-12 col-xl-6 ">
                    <h3 class="common-heading">{{__('main.price')." ".__('main.metrics')." ".__('main.management')}}</h3>

                    <div class="row ms-1">
                        <div class="col-6 col-sm-4 col-lg-2">
                            <div class="row">
                                <button class="btn common-coral-btn-bordered-small" id="addPriceMetrics"><i class="fa-solid fa-plus"></i> {{__('main.add')}}</button>
                            </div>
                        </div>
                    </div>

                    <div class="row px-3 mt-5">
                        <table id="price_metric_table" data-url="{{ url("price-list") }}" class="table table-bordered table-hover table-responsive">
                            <thead>
                                <tr>
                                    <th scope="col">{{__("main.no")}}</th>
                                    <th scope="col">{{__("main.business")}}</th>
                                    <th scope="col">{{__("main.inventory")}}</th>
                                    <th scope="col">{{__("main.metric")}}</th>
                                    <th scope="col">{{__("main.price")}}</th>
                                    <th scope="col">{{__("main.action")}}</th>
                                </tr>
                            </thead>
                        </table>
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
                <h5 class="modal-title" id="addBusinessModalLabel">{{ __('main.add')." ".__('main.price')." ".__('main.metrics') }}</h5>
            </div>
            <div class="modal-body">
                <form id="addPriceMetricsForm">
                    @csrf
                    <div class="form-group">
                        <label for="businessId">{{ __('main.business') }}</label>
                        <select class="form-control common-form-control" id="business_id" name="business_id">
                            <option value="">{{ __('main.select')." ".__('main.business') }}</option>
                            @foreach($businesses_for_price_updates as $business)
                            <option value="{{ $business->id }}">{{ $business->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label>{{ __('main.inventory') }}</label>
                        <select class="form-control common-form-control" id="inventory_id" name="inventory_id">
                            <option value="">{{ __('main.select') ." ".__('main.inventory')   }}</option>

                        </select>
                    </div>
                    @foreach ($metrics as $metric)
                    <div class="form-group mt-3">
                        <label>{{ $metric->name }}</label>
                        <input type="text" class="form-control common-form-control" id="{{ $metric->name }}" name="{{ $metric->name }}" placeholder="{{ $metric->name." ".__('main.price') }}" oninput="validateDoubleValues(this)">
                    </div>
                    @endforeach
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn common-coral-btn-bordered-small" id="closePriceMetricsModal" data-dismiss="modal">{{ __('main.close') }}</button>
                <button type="button" class="btn common-gradient-btn-small" id="savePriceMetrics">{{ __('main.save') }}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addInventoryModal" tabindex="-1" role="dialog" aria-labelledby="addInventoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title" id="addInventoryModalLabel">{{ __('main.add')." ".__('main.inventory') }}</h5>
            </div>
            <div class="modal-body">
                <form id="addInventoryForm">
                    @csrf
                    <div class="form-group">
                        <label for="name">{{ __('main.inventory')." ".__('main.name') }}</label>
                        <input type="text" class="form-control common-form-control" id="inventoryName" name="inventoryName" placeholder="{{ __('main.enter_inventory_name') }}" value="">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn common-coral-btn-bordered-small" id="closeInventoryModal" data-dismiss="modal">{{ __('main.close') }}</button>
                <button type="button" class="btn common-gradient-btn-small" id="saveInventory">{{ __('main.save') }}</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="updatePriceModal" tabindex="-1" aria-labelledby="updatePriceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Price</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updatePriceForm">
                    @csrf
                    <input type="hidden" name="id">

                    <div class="mb-3">
                        <label class="form-label">Business:</label>
                        <b><label id="business_label"></label></b>
                        <input type="hidden" name="business_id" id="business_id">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Inventory:</label>
                        <b><label id="inventory_label"></label></b>
                        <input type="hidden" name="inventory_id" id="inventory_id">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Metric:</label>
                        <b><label id="metrics_label"></label></b>
                        <input type="hidden" name="metrics_id" id="metrics_id">
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="" name="price" class="form-control" oninput="validateDoubleValues(this)">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn common-coral-btn-bordered-small" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn common-gradient-btn-small" id="update_price_metrics">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="updateBusinessModal" tabindex="-1" aria-labelledby="updateBusinessModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateBusinessModalLabel">Update Business Name</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateBusinessForm">
                    @csrf
                    <input type="hidden" name="id">

                    <div class="mb-3">
                        <label for="name" class="form-label">Business Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn common-coral-btn-bordered-small" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn common-gradient-btn-small" id="updateBusinessSubmit">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="updateInventoryModal" tabindex="-1" aria-labelledby="updateInventoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateInventoryModalLabel">Update Inventory</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateInventoryForm">
                    @csrf
                    <input type="hidden" name="id">
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Inventory Name</label>
                        <input type="text" name="updatedInventoryName" class="form-control">
                    </div>
                   
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn common-coral-btn-bordered-small" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn common-gradient-btn-small" id="updateInventorySubmit">Save changes</button>
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

<!-- PRICE METRIC TABLE DATA LOAD -->
<script>
    const priceListUrl = "{{ url('price-list') }}";
    $(document).ready(function() {
        loadPriceMetricsTable();
    });
</script>

<!-- INVENTORY TABLE DATA LOAD (NEW) -->
<script>
    const inventoryListUrl = "{{ url('inventory-list') }}";
    $(document).ready(function() {
        loadInventoryTable();
    });
</script>

@endsection