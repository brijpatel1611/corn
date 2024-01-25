@extends('vendor.vendor-master')
@section('site-title')
    {{ __('Page Settings') }}
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12">
        <div class="row">
            <div class="col-12">
                <x-msg.flash />
                <x-msg.error />
                <div class="dashboard__card">
                    <div class="dashboard__card__header">
                        <h4 class="dashboard__card__title">{{ __('Page Settings') }}</h4>
                    </div>
                    <div class="dashboard__card__body custom__form mt-4">
                        <form action="{{ route('vendor.support.ticket.page.settings') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="support_ticket_login_notice">{{ __('Login Notice') }}</label>
                                <input type="text" name="support_ticket_login_notice" class="form-control"
                                    value="{{ get_static_option('support_ticket_login_notice') }}">
                            </div>
                            <div class="form-group">
                                <label for="support_ticket_form_title">{{ __('Form Title') }}</label>
                                <input type="text" name="support_ticket_form_title" class="form-control"
                                    value="{{ get_static_option('support_ticket_form_title') }}">
                            </div>
                            <div class="form-group">
                                <label for="support_ticket_button_text">{{ __('Button Text') }}</label>
                                <input type="text" name="support_ticket_button_text" class="form-control"
                                    value="{{ get_static_option('support_ticket_button_text') }}">
                            </div>
                            <div class="form-group">
                                <label for="support_ticket_success_message">{{ __('Success Message') }}</label>
                                <input type="text" name="support_ticket_success_message" class="form-control"
                                    value="{{ get_static_option('support_ticket_success_message') }}">
                            </div>

                            <button type="submit"
                                class="btn btn-primary mt-4 pr-4 pl-4">{{ __('Update Changes') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
