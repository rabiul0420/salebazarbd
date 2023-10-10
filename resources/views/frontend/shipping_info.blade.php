@extends('frontend.layouts.app')

@section('content')

    <div id="page-content">
        <section class="slice-xs sct-color-2 border-bottom">
            <div class="container container-sm">
                <div class="row cols-delimited justify-content-center">
                    <div class="col">
                        <div class="icon-block icon-block--style-1-v5 text-center ">
                            <div class="block-icon c-gray-light mb-0">
                                <i class="la la-shopping-cart"></i>
                            </div>
                            <div class="block-content d-none d-md-block">
                                <h3 class="heading heading-sm strong-300 c-gray-light text-capitalize">1. {{ __('My Cart') }}
                                </h3>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="icon-block icon-block--style-1-v5 text-center active">
                            <div class="block-icon mb-0">
                                <i class="la la-map-o"></i>
                            </div>
                            <div class="block-content d-none d-md-block">
                                <h3 class="heading heading-sm strong-300 c-gray-light text-capitalize">2.
                                    {{ __('Shipping info') }}</h3>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="col">
                        <div class="icon-block icon-block-style-1-v5 text-center">
                            <div class="block-icon mb-0 c-gray-light">
                                <i class="la la-truck"></i>
                            </div>
                            <div class="block-content d-none d-md-block">
                                <h3 class="heading heading-sm strong-300 c-gray-light text-capitalize">3. {{__('Delivery info')}}</h3>
                            </div>
                        </div>
                    </div> --}}

                    <div class="col">
                        <div class="icon-block icon-block--style-1-v5 text-center">
                            <div class="block-icon c-gray-light mb-0">
                                <i class="la la-credit-card"></i>
                            </div>
                            <div class="block-content d-none d-md-block">
                                <h3 class="heading heading-sm strong-300 c-gray-light text-capitalize">4.
                                    {{ __('Payment') }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="icon-block icon-block--style-1-v5 text-center">
                            <div class="block-icon c-gray-light mb-0">
                                <i class="la la-check-circle"></i>
                            </div>
                            <div class="block-content d-none d-md-block">
                                <h3 class="heading heading-sm strong-300 c-gray-light text-capitalize">5.
                                    {{ __('Confirmation') }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-4 gry-bg">
            <div class="container">
                <div class="row cols-xs-space cols-sm-space cols-md-space">
                    <div class="col-lg-8">
                        <form class="form-default" data-toggle="validator"
                            action="{{ route('checkout.store_shipping_infostore') }}" role="form" method="POST">
                            @csrf
                            @if (Auth::check())
                                {{-- @if (auth()->user()->user_type == 'seller') --}}
                                <div class="row gutters-5">
                                    @foreach (Auth::user()->addresses as $key => $address)
                                        @if ($address->type != 'shop')
                                            <div class="col-md-6">
                                                <label class="aiz-megabox d-block bg-white">
                                                    <input type="radio" name="address_id" value="{{ $address->id }}"
                                                        @if ($address->set_default) checked @endif required
                                                        onclick="updateShipping({{ $key }}, this)">
                                                    <span class="d-flex p-3 aiz-megabox-elem">
                                                        <span class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                                        <span class="flex-grow-1 pl-3">
                                                            <div>
                                                                <span class="alpha-6">Street:</span>
                                                                <span
                                                                    class="strong-600 ml-2">{{ $address->address }}</span>
                                                            </div>
                                                            <div>
                                                                <span class="alpha-6">Upazilla /Thana /PS:</span>
                                                                <span class="strong-600 ml-2">{{ $address->postal_code }}</span>
                                                            </div>
                                                            <div>
                                                                <span class="alpha-6">City:</span>
                                                                <span class="strong-600 ml-2">{{ $address->city }}</span>
                                                            </div>
                                                            <div>
                                                                <span class="alpha-6">District:</span>
                                                                <span
                                                                    class="strong-600 ml-2">{{ $address->district }}</span>
                                                            </div>
                                                            <div>
                                                                <span class="alpha-6">Division:</span>
                                                                <span
                                                                    class="strong-600 ml-2">{{ $address->division }}</span>
                                                            </div>
                                                            <div>
                                                                <span class="alpha-6">Country:</span>
                                                                <span
                                                                    class="strong-600 ml-2">{{ $address->country }}</span>
                                                            </div>
                                                            <div>
                                                                <span class="alpha-6">Phone:</span>
                                                                <span class="strong-600 ml-2">{{ $address->phone }}</span>
                                                            </div>
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                    <input type="hidden" name="checkout_type" value="logged">
                                    <div class="col-md-6 mx-auto" onclick="add_new_address()">
                                        <div class="border p-3 rounded mb-3 c-pointer text-center bg-white">
                                            <i class="la la-plus la-2x"></i>
                                            <div class="alpha-7">Add New Address</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-2">
                                                        <label>
                                                            Delivery option
                                                        </label>
                                                    </div>
                                                    <div class="col-5">
                                                        <label
                                                            class="d-flex align-items-center p-3 border rounded gry-bg c-pointer">
                                                            <input type="radio" name="shipping_type_admin"
                                                                value="home_delivery" checked class="d-none"
                                                                onchange="show_pickup_point(this)"
                                                                data-target=".pickup_point_id_admin">
                                                            <span class="radio-box"></span>
                                                            <span class="d-block ml-2 strong-600">
                                                                {{ __('Home Delivery') }}
                                                            </span>
                                                        </label>
                                                    </div>
                                                    @if (\App\BusinessSetting::where('type', 'pickup_point')->first()->value == 1)
                                                        <div class="col-5">
                                                            <label
                                                                class="d-flex align-items-center p-3 border rounded gry-bg c-pointer">
                                                                <input type="radio" name="shipping_type_admin"
                                                                    value="pickup_point" class="d-none"
                                                                    onchange="show_pickup_point(this)"
                                                                    data-target=".pickup_point_id_admin">
                                                                <span class="radio-box"></span>
                                                                <span class="d-block ml-2 strong-600">
                                                                    {{ __('Courier Service') }}
                                                                </span>
                                                            </label>
                                                        </div>
                                                    @endif
                                                </div>

                                                @if (\App\BusinessSetting::where('type', 'pickup_point')->first()->value == 1)
                                                    <div class="mt-3 pickup_point_id_admin d-none">
                                                        <select class="pickup-select form-control-lg w-100"
                                                            name="pickup_point_id_admin"
                                                            data-placeholder="Select a courier point" multiple="multiple">
                                                            <option>{{ __('Select your nearest pickup point') }}
                                                            </option>
                                                            @foreach (\App\PickupPoint::where('pick_up_status', 1)->get() as $key => $pick_up_point)
                                                                <option value="{{ $pick_up_point->id }}"
                                                                    data-address="{{ $pick_up_point->address }}"
                                                                    data-phone="{{ $pick_up_point->phone }}">
                                                                    {{ $pick_up_point->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">{{ __('Name') }}</label>
                                                        <input type="text" class="form-control" name="name"
                                                            placeholder="{{ __('Name') }}" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="control-label">{{ __('Phone') }}</label>
                                                            <input type="number" min="0" class="form-control"
                                                                placeholder="{{ __('Phone') }}" name="phone" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">{{ __('Address') }}</label>
                                                        <input type="text" class="form-control" name="address"
                                                            placeholder="{{ __('Address') }}" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label>{{ __('Country') }}</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <div class="mb-3">
                                                        <select class="form-control mb-3 selectpicker division"
                                                            data-placeholder="{{ __('Select your Country') }}"
                                                            id="country" name="country" required>
                                                            <option>
                                                                Select Your Country
                                                            </option>
                                                            @foreach (\App\Country::orderBy('name', 'asc')->get() as $key => $country)
                                                                <option value="{{ $country->name }}">{{ $country->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label>{{ __('City') }}</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <div class="mb-3">
                                                        <input class="form-control" type="text" name="city"
                                                            placeholder="City">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">

                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label>
                                                                Delivery option
                                                            </label>
                                                        </div>
                                                        <div class="col-5">
                                                            <label
                                                                class="d-flex align-items-center p-3 border rounded gry-bg c-pointer">
                                                                <input type="radio" name="shipping_type_admin"
                                                                    value="home_delivery" checked class="d-none"
                                                                    onchange="show_pickup_point(this)"
                                                                    data-target=".pickup_point_id_admin">
                                                                <span class="radio-box"></span>
                                                                <span class="d-block ml-2 strong-600">
                                                                    {{ __('Home Delivery') }}
                                                                </span>
                                                            </label>
                                                        </div>
                                                        @if (\App\BusinessSetting::where('type', 'pickup_point')->first()->value == 1)
                                                            <div class="col-5">
                                                                <label
                                                                    class="d-flex align-items-center p-3 border rounded gry-bg c-pointer">
                                                                    <input type="radio" name="shipping_type_admin"
                                                                        value="pickup_point" class="d-none"
                                                                        onchange="show_pickup_point(this)"
                                                                        data-target=".pickup_point_id_admin">
                                                                    <span class="radio-box"></span>
                                                                    <span class="d-block ml-2 strong-600">
                                                                        {{ __('Courier Service') }}
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    @if (\App\BusinessSetting::where('type', 'pickup_point')->first()->value == 1)
                                                        <div class="mt-3 pickup_point_id_admin d-none">
                                                            <select class="pickup-select form-control-lg w-100"
                                                                name="pickup_point_id_admin"
                                                                data-placeholder="Select a courier point"
                                                                multiple="multiple">
                                                                <option>{{ __('Select your nearest pickup point') }}
                                                                </option>
                                                                @foreach (\App\PickupPoint::where('pick_up_status', 1)->get() as $key => $pick_up_point)
                                                                    <option value="{{ $pick_up_point->id }}"
                                                                        data-address="{{ $pick_up_point->address }}"
                                                                        data-phone="{{ $pick_up_point->phone }}">
                                                                        {{ $pick_up_point->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    @endif

                                                </div>
                                            </div>
                                            <input type="hidden" name="checkout_type" value="seller">
                                        </div>
                                    </div> --}}
                                {{-- @else
                                    <div class="row gutters-5">
                                        @foreach (Auth::user()->addresses as $key => $address)
                                            <div class="col-md-6">
                                                <label class="aiz-megabox d-block bg-white">
                                                    <input type="radio" name="address_id" value="{{ $address->id }}"
                                                        @if ($address->set_default) checked @endif required
                                                        onclick="updateShipping({{ $key }}, this)">
                                                    <span class="d-flex p-3 aiz-megabox-elem">
                                                        <span class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                                        <span class="flex-grow-1 pl-3">
                                                            <div>
                                                                <span class="alpha-6">Address:</span>
                                                                <span
                                                                    class="strong-600 ml-2">{{ $address->address }}</span>
                                                            </div>
                                                            <div>
                                                                <span class="alpha-6">Country:</span>
                                                                <span
                                                                    class="strong-600 ml-2">{{ $address->country }}</span>
                                                            </div>
                                                            <div>
                                                                <span class="alpha-6">City:</span>
                                                                <span class="strong-600 ml-2">{{ $address->city }}</span>
                                                            </div>
                                                            <div>
                                                                <span class="alpha-6">Postal Code:</span>
                                                                <span
                                                                    class="strong-600 ml-2">{{ $address->postal_code }}</span>
                                                            </div>
                                                            <div>
                                                                <span class="alpha-6">Phone:</span>
                                                                <span class="strong-600 ml-2">{{ $address->phone }}</span>
                                                            </div>
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                                        @endforeach
                                        <input type="hidden" name="checkout_type" value="logged">
                                        <div class="col-md-6 mx-auto" onclick="add_new_address()">
                                            <div class="border p-3 rounded mb-3 c-pointer text-center bg-white">
                                                <i class="la la-plus la-2x"></i>
                                                <div class="alpha-7">Add New Address</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif --}}
                            @else
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">{{ __('Name') }}</label>
                                                    <input type="text" class="form-control" name="name"
                                                        placeholder="{{ __('Name') }}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">{{ __('Phone') }}</label>
                                                    <input type="number" min="0" class="form-control"
                                                        placeholder="{{ __('Phone') }}" name="phone" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">{{ __('Address') }}</label>
                                                    <input type="text" class="form-control" name="address"
                                                        placeholder="{{ __('Address') }}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>{{ __('Country') }}</label>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="mb-3">
                                                    <select class="form-control mb-3 selectpicker division"
                                                        data-placeholder="{{ __('Select your Country') }}" id="country"
                                                        name="country" required>
                                                        <option>
                                                            Select Your Country
                                                        </option>
                                                        @foreach (\App\Country::orderBy('name', 'asc')->get() as $key => $country)
                                                            <option value="{{ $country->name }}">{{ $country->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>{{ __('City') }}</label>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="mb-3">
                                                    <input class="form-control" type="text" name="city"
                                                        placeholder="City">
                                                </div>
                                            </div>
                                        </div>


                                        <input type="hidden" name="checkout_type" value="guest">
                                    </div>
                                </div>
                            @endif
                            <div class="row align-items-center pt-4">
                                <div class="col-md-6 col-6">
                                    <a href="{{ route('home') }}" class="link link--style-3">
                                        <i class="ion-android-arrow-back"></i>
                                        {{ __('Return to shop') }}
                                    </a>
                                </div>
                                <div class="col-md-6 col-6 text-right">
                                    <button type="submit"
                                        class="btn btn-styled btn-base-1">{{ __('Continue to Payment') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-4 ml-lg-auto">
                        @include('frontend.partials.cart_summary')
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" id="new-address-modal" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-zoom" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">{{ __('New Address') }}</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-default" role="form" action="{{ route('addresses.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="p-3">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ __('Country') }}</label>
                                </div>
                                <div class="col-md-10">
                                    <div class="mb-3">
                                        <select class="form-control mb-3 selectpicker division"
                                            data-placeholder="{{ __('Select your Country') }}" id="country"
                                            name="country" required>
                                            <option>
                                                Select Your Country
                                            </option>
                                            @foreach (\App\Country::orderBy('name', 'asc')->get() as $key => $country)
                                                <option value="{{ $country->name }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ __('Division') }}</label>
                                </div>
                                <div class="col-md-10">
                                    <div class="mb-3">
                                        <input class="form-control" type="text" name="division"
                                            placeholder="Division">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ __('District') }}</label>
                                </div>
                                <div class="col-md-10">
                                    <div class="mb-3">
                                        <input class="form-control" type="text" name="district"
                                            placeholder="District">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ __('City') }}</label>
                                </div>
                                <div class="col-md-10">
                                    <div class="mb-3">
                                        <input class="form-control" type="text" name="city" placeholder="City">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ __('Upazilla /Thana /PS') }}</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control mb-3"
                                        placeholder="{{ __('Upazilla /Thana /PS') }}" name="postal_code" value=""
                                        required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ __('Street') }}</label>
                                </div>
                                <div class="col-md-10">
                                    <textarea class="form-control textarea-autogrow mb-3" placeholder="{{ __('Street') }}" rows="2"
                                        name="address" required></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ __('Phone') }}</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control mb-3" placeholder="{{ __('880') }}"
                                        name="phone" value="" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-base-1">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        function add_new_address() {
            $('#new-address-modal').modal('show');
        }

        function updateShipping(key, element) {
            var city = $('#city').val();
            $.post('{{ route('cart.updateShipping') }}', {
                _token: '{{ csrf_token() }}',
                key: key,
                shipping: element.value,
                city: city
            }, function(data) {
                updateNavCart();
                $('#cart-summary').html(data);
            });
        }

        function get_subcategories_by_category() {
            var region = $('#region').val();
            $.post('{{ route('region.city_by_region') }}', {
                _token: '{{ csrf_token() }}',
                region: region
            }, function(data) {
                $('#city').html(null);
                // alert(data);
                $('#city').append($('<option>', {
                    value: null,
                    text: null
                }));
                for (var i = 0; i < data.length; i++) {
                    $('#city').append($('<option>', {
                        value: data[i].name,
                        text: data[i].name
                    }));
                    $('.demo-select2').select2();
                }
                // get_subsubcategories_by_subcategory();
            });
        }

        function get_subsubcategories_by_subcategory() {
            var city = $('#city').val();
            $.post('{{ route('city.area_by_city') }}', {
                _token: '{{ csrf_token() }}',
                city: city
            }, function(data) {
                $('#area').html(null);
                $('#area').append($('<option>', {
                    value: null,
                    text: null
                }));
                for (var i = 0; i < data.length; i++) {
                    $('#area').append($('<option>', {
                        value: data[i].name,
                        text: data[i].name
                    }));
                    $('.demo-select2').select2();
                }
                //get_brands_by_subsubcategory();
                //get_attributes_by_subsubcategory();
            });
        }

        function get_brands_by_subsubcategory() {
            var subsubcategory_id = $('#subsubcategory_id').val();
            $.post('{{ route('subsubcategories.get_brands_by_subsubcategory') }}', {
                _token: '{{ csrf_token() }}',
                subsubcategory_id: subsubcategory_id
            }, function(data) {
                $('#brand_id').html(null);
                for (var i = 0; i < data.length; i++) {
                    $('#brand_id').append($('<option>', {
                        value: data[i].id,
                        text: data[i].name
                    }));
                    $('.demo-select2').select2();
                }
            });
        }

        $('#region').on('change', function() {
            get_subcategories_by_category();
        });

        $('#city').on('change', function() {
            get_subsubcategories_by_subcategory();
        });

        $('#area').on('change', function() {
            // get_brands_by_subsubcategory();
            //get_attributes_by_subsubcategory();
        });
    </script>
    <script type="text/javascript">
        function display_option(key) {

        }

        function show_pickup_point(el) {
            var value = $(el).val();
            var target = $(el).data('target');

            console.log(value);

            if (value == 'home_delivery') {
                if (!$(target).hasClass('d-none')) {
                    $(target).addClass('d-none');
                }
            } else {
                $(target).removeClass('d-none');
            }
        }
    </script>
@endsection
