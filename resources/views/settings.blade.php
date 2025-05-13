@extends('layouts.app')

@section('content')
<div class="container-fluid vh-100">
    <div class="row vh-100">
        <div class="col-12 vh-100">
            <div class="row">
                @include("layouts.navbar")
            </div>

            <form id="company-setting-update-form" method="POST" action="{{ route('company.settings.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <p><span class="badge bg-warning">Company Settings</span></p>
                        </div>
                        <div class="row px-3">
                            <div class="mb-3 col-12 col-sm-6 col-lg-3">
                                <label for="companyName" class="form-label">Company Name</label>
                                <input type="text" class="form-control" id="companyName" name="companyName" placeholder="Enter company name" value="{{ $company_name->content }}">
                            </div>
                            <div class="mb-3 col-12 col-sm-6 col-lg-3">
                                <label for="contactNumber" class="form-label">Contact Number</label>
                                <input type="tel" class="form-control" id="contactNumber" name="contactNumber" placeholder="Enter contact number" value="{{ $company_contact->content}}">
                            </div>
                            <div class="mb-3 col-12 col-sm-6 col-lg-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="address" class="form-control" id="address" name="address" placeholder="Enter address" value="{{ $company_address->content }}">
                            </div>
                            <div class="mb-3 col-12 col-sm-6 col-lg-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" value="{{ $company_email->content }}">
                            </div>
                            <div class="mb-3 col-12 col-sm-6 col-lg-3">
                                <label for="logo" class="form-label">Logo</label>
                                <input type="file" class="form-control" id="logo" name="logo">
                                @if($company_logo)
                                <img src="{{ asset($company_logo->content) }}" alt="Company Logo" style="max-width: 100px; height: auto;">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <button type="submit" class="btn common-coral-btn-bordered-small">Update Settings</button>
                    </div>
                </div>
            </form>

            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <p><span class="badge bg-info">Invoice Settings</span></p>
                    </div>
                    <div class="row  px-3">
                        <form id="settings-notes-form" action="{{ route('settings.notes.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <textarea class="form-control" id="noteContent" name="content" rows="5" placeholder="Enter your note here...">{{ $invoice_note != "" ? $invoice_note->content : ""}}</textarea>
                            </div>
                            <button type="submit" class="btn common-coral-btn-bordered-small">{{ __('main.save') ." ".__('main.note') }}</button>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection