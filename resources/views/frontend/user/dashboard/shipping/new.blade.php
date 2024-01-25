@extends('frontend.user.dashboard.user-master')
@section('style')
    <x-loader.css />
@endsection
@section('section')
    <div class="dashboard__card">
        <div class="dashboard__card__header">
            <h5 class="dashboard__card__title">{{ __('Add Shipping Address') }}</h5>
            <div class="btn-wrapper">
                <a href="{{ route('user.shipping.address.all') }}"
                    class="cmn_btn btn_bg_2">{{ __('All Shipping Address') }}</a>
            </div>
        </div>
        <div class="dashboard__card__body custom__form mt-4">
            <form action="{{ route('user.shipping.address.new') }}" method="POST" id="new_user_shipping_address_form">
                @csrf
                <div class="form-row row g-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">{{ __('Name') }}</label>
                            <input type="text" class="form-control" name="name" id="name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">{{ __('Email') }}</label>
                            <input type="text" class="form-control" name="email" id="email">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone">{{ __('Phone') }}</label>
                            <input type="text" class="form-control" name="phone" id="phone">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="country">{{ __('Country') }}</label>
                            <select class="form-control" name="country" id="country">
                                <option value="">{{ __('Select Country') }}</option>
                                @foreach ($all_country as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="state">{{ __('State') }}</label>
                            <select class="form-control" name="state" id="state">
                                <option value="">{{ __('Select State') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="city">{{ __('City') }}</label>
                            <input type="text" class="form-control" name="city" id="city">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="zipcode">{{ __('Zipcode') }}</label>
                            <input type="text" class="form-control" name="zipcode" id="zipcode">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="address">{{ __('Address') }}</label>
                            <input type="text" class="form-control" name="address" id="address" cols="30"
                                rows="5">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="btn-wrapper">
                            <button class="cmn_btn btn_bg_2">{{ __('Submit') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <x-loader.html />
@endsection
@section('script')
    <script>
        (function($) {
            "use strict";
            $(document).ready(function($) {
                $(document).on('click', '.bodyUser_overlay', function() {
                    $('.user-dashboard-wrapper, .bodyUser_overlay').removeClass('show');
                });
                $(document).on('click', '.mobile_nav', function() {
                    $('.user-dashboard-wrapper, .bodyUser_overlay').addClass('show');
                });
                $('#country').on('change', function() {
                    let id = $(this).val();
                    $('.lds-ellipsis').show();
                    $.get('{{ route('country.info.ajax') }}', {
                        id: id
                    }).then(function(data) {
                        $('.lds-ellipsis').hide();
                        $('#state').html('<option value="">{{ __('Select State') }}</option>');
                        data.states.map(function(e) {
                            $('#state').append('<option value="' + e.id + '">' + e
                                .name + '</option>');
                        });
                    });
                });
            });
        })(jQuery);
    </script>
@endsection
