@extends('layouts.app')

@section('content')
<div class="container-fluid vh-100 py-5 py-sm-0">

    <div class="row  vh-100 d-lg-flex justify-content-center align-items-xxl-center">
        <div class="col-12 col-lg-10">
            <div class="calculator-page bg-white rounded-4 shadow-lg p-0">

                <div class="row g-0">

                    <div class="col-lg-8">
                        <form id="price-calculate-form" method="POST">
                            @csrf
                            <div class="p-4 p-lg-5">
                                <div class="mb-4">
                                    <label for="businessType" class="common-form-label">{{ __("main.business")." ".__("main.type") }}</label>
                                    <select id="businessType" name="businessType" class="form-select common-form-control">
                                        @foreach($business as $businessItem)
                                        <option value="{{ $businessItem->id }}">{{ $businessItem->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="common-form-label">{{ __("main.select")." ".__("main.inventory")." ".__("main.platform") }}</label>
                                    <div>
                                        @foreach($inventory as $inventoryItem)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="{{ $inventoryItem->name }}" name="{{ $inventoryItem->name }}" value="{{ $inventoryItem->name }}">
                                            <label class="common-text">{{ $inventoryItem->name }}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    @foreach($metrics as $metric)
                                    <div class="col-md-6 mb-3">
                                        <label class="common-form-label">{{ $metric->name }}</label>
                                        <div class="input-group">
                                            <span class="input-group-text common-gradient"><i class="fas fa-{{ $metric->icon }} text-white"></i></span>
                                            <input type="number" id="{{ $metric->id }}" name="{{ $metric->id }}" class="form-control  common-form-control" placeholder="{{ $metric->name }} Count" min="0" autocomplete="off">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <div class="calculator-actions d-flex mb-4">
                                    <button onclick="calculateTotal()" type="button" class="btn common-gradient-btn me-2 flex-grow-1">Calculate</button>
                                    <button onclick="openDownloadModal()" type="button" class="btn common-green-btn-bordered flex-grow-1" disabled="true" id="downloadPdfBtn">Download PDF</button>
                                </div>

                                <div id="totalResult" class="mt-4">

                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-4">
                        <div class="calculator-sidebar p-4 h-100">
                            <div class="d-flex align-items-center mb-4">
                                <img src="{{ asset('images/web-app-logo.png') }}" class="agency-logo-for-navbar " style="width: 60px; height: 60px;">
                                <h1 class="common-heading text-white fs-4 mb-0 ms-3">{{ __("main.package")." ".__("main.price") ." ".__("main.calculator") }}</h1>
                            </div>
                            <div class="sidebar-info">
                                <div class="common-text-2-light-grey mt-4">
                                    <p>{{__("messages.calculator_sidebar_tag_line")}}</p>
                                </div>
                            </div>

                            <div class="mt-4 ps-4">
                                <h5 class="text-white fw-semibold mb-3">Steps to Calculate:</h5>
                                <ol class="text-white ps-3">
                                    <li>Select your Business Type</li>
                                    <li>Choose Inventory Platforms</li>
                                    <li>Enter Metrics values</li>
                                    <li>Click Calculate</li>
                                    <li>View total and optionally Download PDF</li>
                                </ol>
                            </div>
                            <div class="mt-4">
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
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="downloadModal" tabindex="-1" aria-labelledby="downloadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="downloadModalLabel">Download PDF</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="clientName" class="form-label">Client Name</label>
                    <input type="text" class="form-control common-form-control" id="clientName" autocomplete="off" placeholder="Enter client name">
                </div>
                <div class="mb-3">
                    <label for="clientAddress" class="form-label">Client Address</label>
                    <textarea class="form-control common-form-control" id="clientAddress" rows="3" placeholder="Enter client address"></textarea>
                </div>
                <div class="mb-3">
                    <label for="clientMobileNumber" class="form-label">Client Mobile Number</label>
                    <input class="form-control common-form-control" id="clientMobileNumber" rows="3" placeholder="Enter client mobile number" type="text"></input>
                </div>
                <div class="mb-3">
                    <label for="clientEmail" class="form-label">Client Email</label>
                    <input class="form-control common-form-control" id="clientEmail" rows="3" placeholder="Enter client email" type="email"></input>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn common-green-btn-bordered-small me-2" onclick="previewPDF()">Preview</button>
                <button type="button" class="btn common-gradient-btn-small" onclick="downloadPDF()">Download</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section("script")
<script>
    function openDownloadModal() {
        $('#downloadModal').modal('show');
    }

    function downloadPDF() {
        let clientName = $('#clientName').val();
        let clientAddress = $('#clientAddress').val();
        let clientMobileNumber = $('#clientMobileNumber').val();
        let clientEmail = $('#clientEmail').val();
        let totalResultHtml = $('#totalResult').html();
        let total;
        let businessId;

        if (clientName == "") {
            toastr.error("Client name is required", "Error");
        } else if (clientMobileNumber == "") {
            toastr.error("Client mobile number is required", "Error");
        } else if (!isValidSriLankanMobile(clientMobileNumber)) {
            toastr.error("Invalid mobile number.", "Error");
        } else {
            let calculatedPricesHtml = '';

            let businessIdStart = totalResultHtml.indexOf('<input type="hidden" id="business_id" class="business_id" value="');
            if (businessIdStart !== -1) {
                let startIndex = businessIdStart + '<input type="hidden" id="business_id" class="business_id" value="'.length;
                let endIndex = totalResultHtml.indexOf('"', startIndex);
                if (endIndex !== -1) {
                    businessId = totalResultHtml.substring(startIndex, endIndex);
                }
            }


            if (totalResultHtml.includes('Calculated Prices')) {

                let start = totalResultHtml.indexOf('<table');
                let end = totalResultHtml.lastIndexOf('</table>');

                if (start !== -1 && end !== -1) {
                    calculatedPricesHtml = totalResultHtml.substring(start, end + '</table>'.length);
                }

                let totalStart = totalResultHtml.lastIndexOf('<strong>Total:');
                let totalEnd = totalResultHtml.lastIndexOf('</strong></h3>');

                if (totalStart !== -1 && totalEnd !== -1) {
                    total = totalResultHtml.substring(totalStart + '<strong>Total:'.length, totalEnd).trim();
                }

            }

            let formData = new FormData();
            formData.append('clientName', clientName);
            formData.append('clientAddress', clientAddress);
            formData.append('clientMobileNumber', clientMobileNumber);
            formData.append('clientEmail', clientEmail);
            formData.append('totalResultHtml', calculatedPricesHtml);
            formData.append('total', total);
            formData.append('business_id', businessId);
            formData.append('_token', $('input[name="_token"]').val());

            $.ajax({
                url: "{{ route('generate.pdf') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(blob) {
                    let link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = 'price_calculation.pdf';
                    link.click();

                    $('#downloadModal').modal('hide');
                },

            });
        }
    }


    function previewPDF() {
        let clientName = $('#clientName').val();
        let clientAddress = $('#clientAddress').val();
        let clientMobileNumber = $('#clientMobileNumber').val();
        let clientEmail = $('#clientEmail').val();
        let totalResultHtml = $('#totalResult').html();
        let total;
        let businessId;

        if (clientName == "") {
            toastr.error("Client name is required", "Error");
        } else if (clientMobileNumber == "") {
            toastr.error("Client mobile number is required", "Error");
        } else if (!isValidSriLankanMobile(clientMobileNumber)) {
            toastr.error("Invalid mobile number.", "Error");
        } else {
            let calculatedPricesHtml = '';

            let businessIdStart = totalResultHtml.indexOf('<input type="hidden" id="business_id" class="business_id" value="');
            if (businessIdStart !== -1) {
                let startIndex = businessIdStart + '<input type="hidden" id="business_id" class="business_id" value="'.length;
                let endIndex = totalResultHtml.indexOf('"', startIndex);
                if (endIndex !== -1) {
                    businessId = totalResultHtml.substring(startIndex, endIndex);
                }
            }


            if (totalResultHtml.includes('Calculated Prices')) {

                let start = totalResultHtml.indexOf('<table');
                let end = totalResultHtml.lastIndexOf('</table>');

                if (start !== -1 && end !== -1) {
                    calculatedPricesHtml = totalResultHtml.substring(start, end + '</table>'.length);
                }

                let totalStart = totalResultHtml.lastIndexOf('<strong>Total:');
                let totalEnd = totalResultHtml.lastIndexOf('</strong></h3>');

                if (totalStart !== -1 && totalEnd !== -1) {
                    total = totalResultHtml.substring(totalStart + '<strong>Total:'.length, totalEnd).trim();
                }

            }

            let formData = new FormData();
            formData.append('clientName', clientName);
            formData.append('clientAddress', clientAddress);
            formData.append('clientMobileNumber', clientMobileNumber);
            formData.append('clientEmail', clientEmail);
            formData.append('totalResultHtml', calculatedPricesHtml);
            formData.append('total', total);
            formData.append('business_id', businessId);
            formData.append('_token', $('input[name="_token"]').val());

            $.ajax({
                url: "{{ route('preview.pdf') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(blob) {
                    const url = window.URL.createObjectURL(blob);
                    window.open(url, '_blank');

                    // $('#downloadModal').modal('hide');
                },

            });
        }
    }
</script>
@endsection