@extends('backend.admin-master')
@section('site-title', __('Refund request declined Email'))
@section('style')
    <x-summernote.css />
@endsection
@section('content')
    <div class="card">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <div class="customMarkup__single__item">
                        <div class="customMarkup__single__item__flex">
                            <h4 class="customMarkup__single__title">{{ __('Refund request declined Email') }}</h4>
                        </div>
                        <div class="search_delete_wrapper"><a class="btn-profile btn-bg-1" href="{{ route('admin.email-template.email.template.all') }}">{{ __('All Templates') }}</a></div>
                        <div class="customMarkup__single__inner mt-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="col-md-3">
                                        <div class="d-flex justify-content-between">
                                            <span>{{ __("Placeholder") }}</span>
                                            <span>{reason}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('admin.email-template.refund.request-declined') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <x-form.text
                                    :title="__('Email Subject')"
                                    :type="__('text')" :name="'refund_request_declined_mail_subject'" :id="'refund_request_declined_mail_subject'"
                                    :value="get_static_option('refund_request_declined_mail_subject') ?? __('Refund request send')" />

                                <x-form.summernote
                                    :title="__('Email Message')" :name="'refund_request_declined_mail_body'" :id="'refund_request_declined_mail_body'"
                                    :value="get_static_option('refund_request_declined_mail_body') ??
                                    '</p>Your refund request successfully submitted.</p><p>We will notify you as soon as possible.</p>'"
                                />

                                <button type="submit" class="btn btn-info mt-3">{{ __("Update") }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <x-summernote.js />
@endsection
