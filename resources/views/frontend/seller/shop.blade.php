@extends('frontend.layouts.app')

@section('content')

    <section class="gry-bg py-4 profile">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-lg-3 d-none d-lg-block">
                    @include('frontend.inc.seller_side_nav')
                </div>

                <div class="col-lg-9">
                    <div class="main-content">
                        <!-- Page title -->
                        <div class="page-title">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h2 class="heading heading-6 text-capitalize strong-600 mb-0">
                                        {{ __('Shop Settings') }}
                                        <a href="{{ route('shop.visit', $shop->slug) }}" class="btn btn-link btn-sm"
                                            target="_blank">({{ __('Visit Shop') }})<i class="la la-external-link"></i>)</a>
                                    </h2>
                                </div>
                                <div class="col-md-6">
                                    <div class="float-md-right">
                                        <ul class="breadcrumb">
                                            <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                                            <li><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                                            <li class="active"><a
                                                    href="{{ route('shops.index') }}">{{ __('Shop Settings') }}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id" id="sid" value="{{ $shop->id }}">
                        <form class="" action="{{ route('shops.update', $shop->id) }}" method="POST"
                            enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="PATCH">
                            @csrf
                            <div class="form-box bg-white mt-4">
                                <div class="form-box-title px-3 py-2">
                                    {{ __('Basic info') }}
                                </div>
                                <div class="form-box-content p-3">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{ __('Shop Name') }} <span class="required-star">*</span></label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3"
                                                placeholder="{{ __('Shop Name') }}" name="name"
                                                value="{{ $shop->name }}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{ __('Shop URL') }} <span class="required-star">*</span></label>
                                        </div>
                                        <div class="col-md-10">
                                            <span class="snotice" style="display: none;">Already exist please try
                                                another</span>
                                            <input id="sample_search" type="text" class="form-control mb-3"
                                                placeholder="{{ __('Shop url') }}" name="slug"
                                                value="{{ $shop->slug }}" required>

                                        </div>
                                    </div>
                                    @if (\App\BusinessSetting::where('type', 'shipping_type')->first()->value == 'seller_wise_shipping')
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>{{ __('Shipping Cost') }} <span
                                                        class="required-star">*</span></label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="number" min="0" class="form-control mb-3"
                                                    placeholder="{{ __('Shipping Cost') }}" name="shipping_cost"
                                                    value="{{ $shop->shipping_cost }}" required>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row mb-3">
                                        <div class="col-md-2">
                                            <label>{{ __('Pickup Points') }} <span class="required-star"></span></label>
                                        </div>
                                        <div class="col-md-10">
                                            <select class="form-control mb-3 selectpicker"
                                                data-placeholder="Select Pickup Point" id="pick_up_point"
                                                name="pick_up_point_id[]" multiple>
                                                @foreach (\App\PickupPoint::all() as $pick_up_point)
                                                    @if (Auth::user()->shop->pick_up_point_id != null)
                                                        <option value="{{ $pick_up_point->id }}"
                                                            @if (in_array($pick_up_point->id, json_decode(Auth::user()->shop->pick_up_point_id))) selected @endif>
                                                            {{ $pick_up_point->name }}</option>
                                                    @else
                                                        <option value="{{ $pick_up_point->id }}">
                                                            {{ $pick_up_point->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{ __('Logo') }} <small>(120x120)</small></label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="file" name="logo" id="file-2"
                                                class="custom-input-file custom-input-file--4"
                                                data-multiple-caption="{count} files selected" accept="image/*" />
                                            <label for="file-2" class="mw-100 mb-3">
                                                <span></span>
                                                <strong>
                                                    <i class="fa fa-upload"></i>
                                                    {{ __('Choose image') }}
                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                    {{-- <div class="row">
                                        <div class="col-md-2">
                                            <label>{{ __('Address') }} <span class="required-star">*</span></label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3"
                                                placeholder="{{ __('Address') }}" name="address"
                                                value="{{ $shop->address }}" required>
                                        </div>
                                    </div> --}}
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{ __('Meta Title') }} <span class="required-star">*</span></label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3"
                                                placeholder="{{ __('Meta Title') }}" name="meta_title"
                                                value="{{ $shop->meta_title }}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{ __('Meta Description') }} <span
                                                    class="required-star">*</span></label>
                                        </div>
                                        <div class="col-md-10">
                                            <textarea name="meta_description" rows="6" class="form-control mb-3" required>{{ $shop->meta_description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right mt-4">
                                <button type="submit" id="shopb"
                                    class="btn btn-styled btn-base-1 shopbt">{{ __('Save') }}</button>
                            </div>
                        </form>

                        <div class="form-box bg-white mt-4">
                            <div class="form-box-title px-3 py-2">
                                {{ __('Addresses') }}
                            </div>
                            <div class="form-box-content p-3">
                                <div class="row gutters-10">
                                    @php
                                        $is_shop_add = false;
                                    @endphp
                                    @foreach (Auth::user()->addresses as $key => $address)
                                        @if ($address->type == 'shop')
                                            @php
                                                $is_shop_add = true;
                                            @endphp
                                            <div class="col-lg-6">
                                                <div class="border p-3 pr-5 rounded mb-3 position-relative">
                                                    <div>
                                                        <span class="alpha-6">Street:</span>
                                                        <span class="strong-600 ml-2">{{ $address->address }}</span>
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
                                                        <span class="strong-600 ml-2">{{ $address->district }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="alpha-6">Division:</span>
                                                        <span class="strong-600 ml-2">{{ $address->division }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="alpha-6">Country:</span>
                                                        <span class="strong-600 ml-2">{{ $address->country }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="alpha-6">Phone:</span>
                                                        <span class="strong-600 ml-2">{{ $address->phone }}</span>
                                                    </div>
                                                    @if ($address->set_default)
                                                        <div class="position-absolute right-0 bottom-0 pr-2 pb-3">
                                                            <span class="badge badge-primary bg-base-1">Default</span>
                                                        </div>
                                                    @endif
                                                    <div class="dropdown position-absolute right-0 top-0">
                                                        <button class="btn bg-gray px-2" type="button"
                                                            data-toggle="dropdown">
                                                            <i class="la la-ellipsis-v"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right"
                                                            aria-labelledby="dropdownMenuButton">
                                                            {{-- @if (!$address->set_default)
                                                                <a class="dropdown-item"
                                                                    href="{{ route('addresses.set_default', $address->id) }}">Make
                                                                    This Default</a>
                                                            @endif --}}
                                                            {{-- <a class="dropdown-item" href="">Edit</a> --}}
                                                            <a class="dropdown-item"
                                                                href="{{ route('addresses.destroy', $address->id) }}">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                    @if (!$is_shop_add)
                                        <div class="col-lg-6 mx-auto" onclick="add_new_address()">
                                            <div class="border p-3 rounded mb-3 c-pointer text-center bg-light">
                                                <i class="la la-plus la-2x"></i>
                                                <div class="alpha-7">Add New Address</div>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>

                        <form class="" action="{{ route('shops.update', $shop->id) }}" method="POST"
                            enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="PATCH">
                            @csrf
                            <div class="form-box bg-white mt-4">
                                <div class="form-box-title px-3 py-2">
                                    {{ __('Slider Settings') }}
                                </div>
                                <div class="form-box-content p-3">
                                    <div id="shop-slider-images">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>{{ __('Slider Images') }} <small>(1400x400)</small></label>
                                            </div>
                                            <div class="offset-2 offset-md-0 col-10 col-md-10">
                                                <div class="row">
                                                    @if ($shop->sliders != null)
                                                        @foreach (json_decode($shop->sliders) as $key => $sliders)
                                                            <div class="col-md-6">
                                                                <div class="img-upload-preview">
                                                                    <img loading="lazy" src="{{ asset($sliders) }}"
                                                                        alt="" class="img-fluid">
                                                                    <input type="hidden" name="previous_sliders[]"
                                                                        value="{{ $sliders }}">
                                                                    <button type="button"
                                                                        class="btn btn-danger close-btn remove-files"><i
                                                                            class="fa fa-times"></i></button>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <input type="file" name="sliders[]" id="slide-0"
                                                    class="custom-input-file custom-input-file--4"
                                                    data-multiple-caption="{count} files selected" multiple
                                                    accept="image/*" />
                                                <label for="slide-0" class="mw-100 mb-3">
                                                    <span></span>
                                                    <strong>
                                                        <i class="fa fa-upload"></i>
                                                        {{ __('Choose image') }}
                                                    </strong>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button type="button" class="btn btn-info mb-3"
                                            onclick="add_more_slider_image()">{{ __('Add More') }}</button>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right mt-4">
                                <button type="submit" class="btn btn-styled btn-base-1">{{ __('Save') }}</button>
                            </div>
                        </form>

                        <form class="" action="{{ route('shops.update', $shop->id) }}" method="POST"
                            enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="PATCH">
                            @csrf
                            <div class="form-box bg-white mt-4">
                                <div class="form-box-title px-3 py-2">
                                    {{ __('Social Media Link') }}
                                </div>
                                <div class="form-box-content p-3">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label><i
                                                    class="line-height-1_8 size-24 mr-2 fa fa-facebook bg-facebook c-white text-center"></i>{{ __('Facebook') }}
                                            </label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3"
                                                placeholder="{{ __('Facebook') }}" name="facebook"
                                                value="{{ $shop->facebook }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label><i
                                                    class="line-height-1_8 size-24 mr-2 fa fa-twitter bg-twitter c-white text-center"></i>{{ __('Twitter') }}
                                            </label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3"
                                                placeholder="{{ __('Twitter') }}" name="twitter"
                                                value="{{ $shop->twitter }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label><i
                                                    class="line-height-1_8 size-24 mr-2 fa fa-google bg-google c-white text-center"></i>{{ __('Google') }}
                                            </label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3"
                                                placeholder="{{ __('Google') }}" name="google"
                                                value="{{ $shop->google }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label><i
                                                    class="line-height-1_8 size-24 mr-2 fa fa-youtube bg-youtube c-white text-center"></i>{{ __('Youtube') }}
                                            </label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3"
                                                placeholder="{{ __('Youtube') }}" name="youtube"
                                                value="{{ $shop->youtube }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right mt-4">
                                <button type="submit" class="btn btn-styled btn-base-1">{{ __('Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                    <input type="hidden" name="type" value="shop">
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
    <script>
        function add_new_address() {
            $('#new-address-modal').modal('show');
        }
        var slide_id = 1;

        function add_more_slider_image() {
            var shopSliderAdd = '<div class="row">';
            shopSliderAdd += '<div class="col-2">';
            shopSliderAdd +=
                '<button type="button" onclick="delete_this_row(this)" class="btn btn-link btn-icon text-danger"><i class="fa fa-trash-o"></i></button>';
            shopSliderAdd += '</div>';
            shopSliderAdd += '<div class="col-10">';
            shopSliderAdd += '<input type="file" name="sliders[]" id="slide-' + slide_id +
                '" class="custom-input-file custom-input-file--4" data-multiple-caption="{count} files selected" multiple accept="image/*" />';
            shopSliderAdd += '<label for="slide-' + slide_id + '" class="mw-100 mb-3">';
            shopSliderAdd += '<span></span>';
            shopSliderAdd += '<strong>';
            shopSliderAdd += '<i class="fa fa-upload"></i>';
            shopSliderAdd += "{{ __('Choose image') }}";
            shopSliderAdd += '</strong>';
            shopSliderAdd += '</label>';
            shopSliderAdd += '</div>';
            shopSliderAdd += '</div>';
            $('#shop-slider-images').append(shopSliderAdd);

            slide_id++;
            imageInputInitialize();
        }

        function delete_this_row(em) {
            $(em).closest('.row').remove();
        }


        $(document).ready(function() {
            $('.remove-files').on('click', function() {
                $(this).parents(".col-md-6").remove();
            });
        });
        var searchRequest = null;

        $(function() {
            var minlength = 3;

            $("#sample_search").keyup(function() {
                var that = this,
                    value = $(this).val();

                if (value.length >= minlength) {
                    if (searchRequest != null)
                        searchRequest.abort();
                    searchRequest = $.ajax({
                        type: "POST",
                        url: "{{ route('shop_url.check') }}",
                        data: {
                            'search_keyword': value,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: "text",
                        success: function(data) {
                            // alert(data);
                            //we need to check if the value is the same
                            if (data == 0) {
                                //Receiving the result of search here
                                $(".snotice").css({
                                    "color": "red",
                                    "display": "none"
                                });

                                $('#shopb').prop('disabled', false);
                            } else {
                                $(".snotice").css({
                                    "color": "red",
                                    "display": "block"
                                });
                                $("#sample_search").css({
                                    "border-color": "#e62e04"
                                });
                                $('#shopb').prop('disabled', true);
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection
