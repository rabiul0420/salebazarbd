@extends('frontend.layouts.app')

@section('content')
    <section class="gry-bg py-4 profile">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-lg-3 d-none d-lg-block">
                    @if (Auth::user()->user_type == 'seller')
                        @include('frontend.inc.seller_side_nav')
                    @elseif(Auth::user()->user_type == 'customer')
                        @include('frontend.inc.customer_side_nav')
                    @endif
                </div>

                <div class="col-lg-9">
                    <div class="main-content">
                        <!-- Page title -->
                        <div class="page-title">
                            <div class="row align-items-center">
                                <div class="col-md-6 col-12">
                                    <h2 class="heading heading-6 text-capitalize strong-600 mb-0">
                                        {{ __('Manage Profile') }}
                                    </h2>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="float-md-right">
                                        <ul class="breadcrumb">
                                            <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                                            <li><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                                            <li class="active"><a
                                                    href="{{ route('profile') }}">{{ __('Manage Profile') }}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form class="" action="{{ route('customer.profile.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-box bg-white mt-4">
                                <div class="form-box-title px-3 py-2">
                                    {{ __('Basic info') }}
                                </div>
                                <div class="form-box-content p-3">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{ __('Your Name') }}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3"
                                                placeholder="{{ __('Your Name') }}" name="name"
                                                value="{{ Auth::user()->name }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{ __('Your Email') }}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="email" class="form-control mb-3"
                                                placeholder="{{ __('Your Email') }}" name="email"
                                                value="{{ Auth::user()->email }}" disabled>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{ __('Photo') }}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="file" name="photo" id="file-3"
                                                class="custom-input-file custom-input-file--4"
                                                data-multiple-caption="{count} files selected" accept="image/*" />
                                            <label for="file-3" class="mw-100 mb-3">
                                                <span></span>
                                                <strong>
                                                    <i class="fa fa-upload"></i>
                                                    {{ __('Choose image') }}
                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{ __('Phone') }}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3" value="{{ Auth::user()->phone ?? '' }}" placeholder="{{ __('Phone') }}"
                                                   name="phone">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{ __('Your Password') }}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="password" class="form-control mb-3"
                                                placeholder="{{ __('New Password') }}" name="new_password">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{ __('Confirm Password') }}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="password" class="form-control mb-3"
                                                placeholder="{{ __('Confirm Password') }}" name="confirm_password">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-right mt-4">
                                <button type="submit"
                                    class="btn btn-styled btn-base-1">{{ __('Update Profile') }}</button>
                            </div>

                            <div class="form-box bg-white mt-4">
                                <div class="form-box-title px-3 py-2">
                                    {{ __('Addresses') }}
                                </div>
                                <div class="form-box-content p-3">
                                    <div class="row gutters-10">
                                        {{-- @dd(Auth::user()->addresses) --}}
                                        @foreach (Auth::user()->addresses as $key => $address)
                                            @if ($address->type != 'shop')
                                                <div class="col-lg-6">
                                                    <div class="border p-3 pr-5 rounded mb-3 position-relative">
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
                                                                @if (!$address->set_default)
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('addresses.set_default', $address->id) }}">Make
                                                                        This Default</a>
                                                                @endif
                                                                {{-- <a class="dropdown-item" href="">Edit</a> --}}
                                                                <a class="dropdown-item"
                                                                    href="{{ route('addresses.destroy', $address->id) }}">Delete</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        <div class="col-lg-6 mx-auto" onclick="add_new_address()">
                                            <div class="border p-3 rounded mb-3 c-pointer text-center bg-light">
                                                <i class="la la-plus la-2x"></i>
                                                <div class="alpha-7">Add New Address</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

        function get_subcategories_by_category() {
            var region = $('#region').val();
            $.post('{{ route('region.city_by_region') }}', {
                _token: '{{ csrf_token() }}',
                region: region
            }, function(data) {
                $('#city').html(null);
                // alert(data);
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
@endsection
