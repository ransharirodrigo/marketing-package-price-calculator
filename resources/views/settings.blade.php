@extends('layouts.app')

@section('content')
<div class="container-fluid vh-100">
    <div class="row vh-100">
        <div class="col-12 vh-100">
            <div class="row">
                @include("layouts.navbar")
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
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
@endsection