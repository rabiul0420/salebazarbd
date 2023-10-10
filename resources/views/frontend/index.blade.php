@extends('frontend.layouts.app')

@section('content')

    <section class="home-banner-area mb-2 mb-lg-3">
        <div class="container">
            <div class="row no-gutters position-relative">
                <div class="col-lg-2 position-static order-2 order-lg-0 d-none d-lg-block">
                    <div class="category-sidebar">
                        <div class="title text-center p-2 ctry-bg d-none d-lg-block">
                            <h3 class="heading-6 mb-0">
                            {{__('Categories')}}</h3>


                        </div>

                        <ul class="categories no-scrollbar">
                            <li class="d-lg-none">
                                <a href="{{ route('categories.all') }}">
                                    <img class="cat-image lazyload" src="{{ asset('frontend/images/placeholder.jpg') }}" data-src="{{ asset('frontend/images/icons/list.png') }}" width="30" alt="{{ __('All Category') }}">
                                    <span class="cat-name">{{__('All')}} <br> {{__('Categories her')}}</span>
                                </a>
                            </li>
                            @foreach (\App\Category::all()->sortBy('sort_n')->take(11) as $key => $category)
                                @php
                                    $brands = array();
                                @endphp
                                <li class="category-nav-element" data-id="{{ $category->id }}">
                                    <a href="{{ route('products.category', $category->slug) }}">
                                        <img class="cat-image lazyload" src="{{ asset('frontend/images/placeholder.jpg') }}" data-src="{{ asset($category->icon) }}" width="30" alt="{{ __($category->name) }}">
                                        <span class="cat-name">{{ __($category->name) }}</span>
                                        <span class="d-none d-lg-inline-block d-md-inline-block" style="float: right;">
                                            <i class="fa fa-angle-right" style="font-size: 15px;font-weight: 700;"></i>
                                        </span>
                                    </a>
                                    @if(count($category->subcategories)>0)
                                        <div class="sub-cat-menu c-scrollbar">
                                            <div class="c-preloader">
                                                <i class="fa fa-spin fa-spinner"></i>
                                            </div>
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                            <li class="category-nav-element">
                                <a href="{{ route('categories.all') }}">
                                    <img class="cat-image lazyload" src="{{ asset('frontend/images/placeholder.jpg') }}" data-src="{{ asset('frontend/images/icons/list.png') }}" width="30" alt="{{ __('All Category') }}">
                                    <span class="cat-name">{{__('All')}} {{__('Categories')}}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                @php
                $num_todays_deal = count(filter_products(\App\Product::where('published', 1)->where('todays_deal', 1 )->where('is_approved', 1))->get());
                @endphp

                <div class="@if($num_todays_deal > 0) col-lg-8 @else col-lg-8 @endif order-1 order-lg-0 bg-white">
                       <div class="col-lg-12 position-static order-2 order-lg-0 stry-bg d-none d-lg-block">
<div id="menu">
     <ul>
        @foreach (\App\Menu::where('featured', 1)->get() as $key => $menu)
          <li><a href="{{ $menu->slug}}">{{ $menu->name}}</a></li>
        @endforeach
     </ul>
</div>
</div>

                    <div class="home-slide">
                        <div class="home-slide">
                            <div class="slick-carousel e-scroll" data-slick-arrows="true" data-slick-dots="true" data-slick-autoplay="true">
                                @foreach (\App\Slider::where('published', 1)->get() as $key => $slider)
                                    <div class="" style="height:360px;">
                                        <a href="{{ $slider->link }}" target="_blank">
                                        <img class="d-block w-100 h-100 lazyload" src="{{ asset('frontend/images/placeholder-rect.jpg') }}" data-src="{{ asset($slider->photo) }}" alt="{{ env('APP_NAME')}} promo">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="trending-category  d-none d-lg-block">
                        <div class="row no-gutters">

                            <div class="col-lg-12 p-0">
                                <div class="info-big-box">
                                    <div class="row">
                                     <div class="info-box">
                                                    <div class="icon ico1">
                                                        <img src="{{ asset('img/1561348133service1.png')}}">
                                                    </div>
                                                    <div class="info">
                                                        <div class="details">
                                                            <h4 class="title">FAST SHIPPING</h4>
                                                            <p class="text">
                                                                Shipping in 1-3 Days
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>



                                            <div class="info-box">
                                                    <div class="icon ico2">
                                                        <img src="{{ asset('img/1561348143service3.png')}}">
                                                    </div>
                                                    <div class="info">
                                                        <div class="details">
                                                            <h4 class="title">EASY RETURNS</h4>
                                                            <p class="text">
                                                                Return in 7 Days
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                            <div class="info-box">
                                                    <div class="icon ico3">
                                                        <img src="{{ asset('img/1561348138service2.png')}}">
                                                    </div>
                                                    <div class="info">
                                                        <div class="details">
                                                            <h4 class="title">PAYMENT METHOD</h4>
                                                            <p class="text">
                                                               Secure Payment
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                @php
            $generalsetting = \App\GeneralSetting::first();
        @endphp
                                                <div class="info-box">
                                                    <div class="icon ico4">
                                                        <img src="{{ asset('img/1561348147service4.png')}}">
                                                    </div>
                                                    <div class="info">
                                                        <div class="details">
                                                            <h4 class="title">HELP CENTER</h4>
                                                            <p class="text">
                                                               {{ $generalsetting->phone }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                            </div>


                        </div>
                    </div>
                </div>
                 @if($num_todays_deal > 0)
                <div class="col-lg-2 d-none d-lg-block">
                    <div class="flash-deal-box bg-white h-100">
                        <div class="title text-center p-2 ctry-bg">
                            <h3 class="heading-6 mb-0">
                                {{ __('Todays Deal') }}
                                <span class="badge badge-danger">{{__('Hot')}}</span>
                            </h3>
                        </div>
                        <div class="flash-content c-scrollbar c-height" style="background-color: #fff">
                            @if (count(filter_products(\App\Product::where('published', 1)->where('todays_deal', '1')->where('is_approved', 1))->get()) > 0)
                            @foreach (filter_products(\App\Product::where('published', 1)->where('todays_deal', '1')->where('is_approved', 1))->get() as $key => $product)
                                @if ($product != null)
                                    <a href="{{ route('product', $product->slug) }}" class="d-block flash-deal-item">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-5">
                                                <div class="img">
                                                    <img class="lazyload img-fit" src="{{ asset('frontend/images/placeholder.jpg') }}" data-src="{{ asset($product->flash_deal_img ?? $product->featured_img) }}" alt="{{ __($product->name) }}">
                                                </div>
                                            </div>
                                            <div class="col-7">

                                                <div class="price">
                                                    <span class="d-block">{{ home_discounted_base_price($product->id) }}</span>
                                                    @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                                        <del class="d-block">{{ home_base_price($product->id) }}</del>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endif
                            @endforeach
                            @else
                            No Products Found...
                            @endif
                        </div>
                    </div>
                </div>
                @endif



            </div>
        </div>
    </section>
{{-- category section --}}
    <section class="mb-2 mb-lg-3">
        <div class="container">
            <div class="col-12 px-2 py-2 p-md-3 bg-white shadow-sm d-block d-lg-inline-block d-md-inline-block">
                <div class="clearfix">
                    <h3 class="heading-5 strong-700 mb-2 float-left">
                        <span class="mr-4">Categories</span>
                    </h3>
                    <ul class="inline-links float-right">
                        <li style="margin-top: 7px"><a style="" href="{{ route('categories.all') }}" class="h-cat active">See More</a></li>
                    </ul>
                </div>



                <div class="caorusel-box arrow-round gutters-5">
                    <div class="slick-carousel" data-slick-items="8" data-slick-lg-items="2"  data-slick-md-items="8" data-slick-sm-items="3" data-slick-xs-items="4" data-slick-rows="2">

                                            @foreach(\App\Category::where('featured',1)->get() as $category)
                            <div class="caorusel-card category-list cat-bo">
                                <div class="row no-gutters product-box-2 align-items-center cat-before" style="border:none">
                                    <div class="col-12">
                                        <div class="position-relative overflow-hidden h-100">
                                            <a href="{{ route('products.category', $category->slug) }}" class="d-block h-100">
                                                <img style="width: 60%;padding: 10px" class="img-fit lazyload mx-auto" src="{{ asset('frontend/images/placeholder.jpg') }}" data-src="{{ asset($category->banner) }}" alt="{{ __($category->name) }}">
                                            </a>

                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="p-1">
                                            <h2 style="text-align: center;" class="product-title mb-0 p-0 text-truncate-2">
                                                <a href="{{ route('products.category', $category->slug) }}">{{ __($category->name) }} </a>
                                            </h2>



                                        </div>
                                    </div>
                                </div>
                            </div>
                         @endforeach
                         @foreach(\App\SubCategory::where('featured',1)->get() as $category)
                            <div class="caorusel-card cat-bo">
                                <div class="row no-gutters product-box-2 align-items-center cat-before" style="border:none">
                                    <div class="col-12">
                                        <div class="position-relative overflow-hidden h-100">
                                            <a href="{{ route('products.subcategory', $category->slug) }}" class="d-block h-100">
                                                <img style="width: 60%;padding: 10px" class="img-fit lazyload mx-auto" src="{{ asset('frontend/images/placeholder.jpg') }}" data-src="{{ asset($category->icon) }}" alt="{{ __($category->name) }}">
                                            </a>

                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="p-1">
                                            <h2 style="text-align: center;" class="product-title mb-0 p-0 text-truncate-2">
                                                <a href="{{ route('products.subcategory', $category->slug) }}">{{ __($category->name) }} </a>
                                            </h2>



                                        </div>
                                    </div>
                                </div>
                            </div>
                         @endforeach
                         @foreach(\App\SubSubCategory::where('featured',1)->get() as $category)
                            <div class="caorusel-card cat-bo">
                                <div class="row no-gutters product-box-2 align-items-center cat-before" style="border:none">
                                    <div class="col-12">
                                        <div class="position-relative overflow-hidden h-100">
                                            <a href="{{ route('products.subsubcategory', $category->slug) }}" class="d-block h-100">
                                                <img style="width: 60%;padding: 10px" class="img-fit lazyload mx-auto" src="{{ asset('frontend/images/placeholder.jpg') }}" data-src="{{ asset($category->icon) }}" alt="{{ __($category->name) }}">
                                            </a>

                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="p-1">
                                            <h2 style="text-align: center;" class="product-title mb-0 p-0 text-truncate-2">
                                                <a href="{{ route('products.subsubcategory', $category->slug) }}">{{ __($category->name) }} </a>
                                            </h2>



                                        </div>
                                    </div>
                                </div>
                            </div>
                         @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>

    @php
        $flash_deal = \App\FlashDeal::where('status', 1)->where('featured', 1)->first();
    @endphp
    @if($flash_deal != null && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date)
    <section class="mb-2 mb-lg-3">
        <div class="container">
            <div class="px-2 py-2 p-md-4 bg-flush shadow-sm">
                <div class="section-title-1 clearfix ">
                    <h3 class="heading-5 strong-700 mb-0 float-left">
                        {{__('Flash Sale')}}
                    </h3>
                    <div class="flash-deal-box float-left">
                        <div class="countdown countdown--style-1 countdown--style-1-v1 " data-countdown-date="{{ date('m/d/Y', $flash_deal->end_date) }}" data-countdown-label="show"></div>
                    </div>
                    <ul class="inline-links float-right mt-2">
                        <li><a href="{{ route('flash-deal-details', $flash_deal->slug) }}" class="active">View More</a></li>
                    </ul>
                </div>
                <style>


                </style>
                <div class="caorusel-box arrow-round gutters-5 ">
                    <div class="slick-carousel" data-slick-items="6" data-slick-xl-items="6" data-slick-lg-items="6"  data-slick-md-items="3" data-slick-sm-items="3" data-slick-xs-items="2">
                    @foreach ($flash_deal->flash_deal_products as $key => $flash_deal_product)
                        @php
                            $product = \App\Product::find($flash_deal_product->product_id);
                        @endphp
                        @if ($product != null && $product->published != 0 && $product->is_approved == 1)

                                <div class="product-card-2 flash-card card card-product my-2 mx-1 mx-sm-2 shop-cards shop-tech" >
                                    <div class="card-body p-0">
                                        <div class="card-image">
                                            <a href="{{ route('product', $product->slug) }}" class="d-block d-block mobile-view-img">
                                                <img style="width:100%;height:220px;"  class="img-fit lazyload mx-auto flash-sale-img" src="{{ asset('frontend/images/placeholder.jpg') }}" data-src="{{ asset($product->featured_img ?? $product->featured_img) }}" alt="{{ __($product->name) }}">
                                            </a>
                                        </div>

                                        <div class="p-md-3 p-2">
                                            <div class="price-box">
                                                @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                                    <del class="old-product-price strong-400">{{ home_base_price($product->id) }}</del>
                                                @endif
                                                <span class="product-price strong-600">{{ home_discounted_base_price($product->id) }}</span>
                                            </div>
                                            <div class="star-rating star-rating-sm mt-1">
                                                {{ renderStarRating($product->rating) }}
                                            </div>
                                            <h2 class="product-title p-0">
                                                <a href="{{ route('product', $product->slug) }}" class=" text-truncate">{{ __($product->name) }}</a>
                                            </h2>
                                            @if (\App\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Addon::where('unique_identifier', 'club_point')->first()->activated)
                                                <div class="club-point mt-2 bg-soft-base-1 border-light-base-1 border">
                                                    {{ __('Club Point') }}:
                                                    <span class="strong-700 float-right">{{ $product->earn_point }}</span>
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                </div>

                        @else
                        <div class="caorusel-card mb-1 width-big" >
                            No Products Found...
                        </div>
                        @endif
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <div class="mb-2 mb-lg-3  d-lg-block">
        <div class="container">
            <div class="row gutters-10">
                @foreach (\App\Banner::where('position', 1)->where('published', 1)->get() as $key => $banner)
                    <div class="col-lg-{{ 12/count(\App\Banner::where('position', 1)->where('published', 1)->get()) }} col-6">
                        <div class="media-banner mb-1 mb-lg-0">
                            <a href="{{ $banner->url }}" target="_blank" class="banner-container">
                                <img src="{{ asset('frontend/images/placeholder-rect.jpg') }}" data-src="{{ asset($banner->photo) }}" alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload">
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div id="section_featured">

    </div>

    <div id="section_best_selling">

    </div>



    <div id="section_home_categories">

    </div>

    @if(\App\BusinessSetting::where('type', 'classified_product')->first()->value == 1)
        @php
            $customer_products = \App\CustomerProduct::where('status', '1')->where('published', '1')->take(10)->get();
        @endphp
       @if (count($customer_products) > 0)
           <section class="mb-3">
               <div class="container">
                   <div class="px-2 py-4 p-md-4 bg-white shadow-sm">
                       <div class="section-title-1 clearfix">
                           <h3 class="heading-5 strong-700 mb-0 float-left">
                               <span class="mr-4">{{__('Classified Ads')}}</span>
                           </h3>
                           <ul class="inline-links float-right">
                               <li><a href="{{ route('customer.products') }}" class="active">{{__('View More')}}</a></li>
                           </ul>
                       </div>
                       <div class="caorusel-box arrow-round">
                           <div class="slick-carousel" data-slick-items="6" data-slick-xl-items="5" data-slick-lg-items="4"  data-slick-md-items="3" data-slick-sm-items="2" data-slick-xs-items="2">
                               @foreach ($customer_products as $key => $customer_product)
                                   <div class="product-card-2 card card-product my-2 mx-1 mx-sm-2 shop-cards shop-tech">
                                       <div class="card-body p-0">
                                           <div class="card-image">
                                               <a href="{{ route('customer.product', $customer_product->slug) }}" class="d-block">
                                                   <img style="width:100%;height:220px;" class="img-fit lazyload mx-auto" src="{{ asset('frontend/images/placeholder.jpg') }}" data-src="{{ asset($customer_product->featured_img) }}" alt="{{ __($customer_product->name) }}">
                                               </a>
                                           </div>

                                           <div class="p-sm-3 p-2">
                                               <div class="price-box">
                                                   <span class="product-price strong-600">{{ single_price($customer_product->unit_price) }}</span>
                                               </div>
                                               <h2 class="product-title p-0 text-truncate-1">
                                                   <a href="{{ route('customer.product', $customer_product->slug) }}">{{ __($customer_product->name) }}</a>
                                               </h2>
                                               <div>
                                                   @if($customer_product->conditon == 'new')
                                                       <span class="product-label label-hot">{{__('new')}}</span>
                                                   @elseif($customer_product->conditon == 'used')
                                                       <span class="product-label label-hot">{{__('Used')}}</span>
                                                   @endif
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               @endforeach
                           </div>
                       </div>
                   </div>
               </div>
           </section>
       @endif
   @endif

    <div class="mb-2 mb-lg-3">
        <div class="container">
            <div class="row gutters-10">
                @foreach (\App\Banner::where('position', 2)->where('published', 1)->get() as $key => $banner)
                    <div class="col-lg-{{ 12/count(\App\Banner::where('position', 2)->where('published', 1)->get()) }} col-6 ">
                        <div class="media-banner mb-1 mb-lg-0">
                            <a href="{{ $banner->url }}" target="_blank" class="banner-container">
                                <img src="{{ asset('frontend/images/placeholder-rect.jpg') }}" data-src="{{ asset($banner->photo) }}" alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload">
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div id="section_best_sellers">

    </div>

    <section class="mb-2 mb-lg-3">
        <div class="container d-lg-block">
            <div class="row gutters-10">
                <div class="col-lg-6">
                    <div class="section-title-1 clearfix">
                        <h3 class="heading-5 strong-700 mb-0 float-left">
                            <span class="mr-4">{{__('Top 10 Catogories')}}</span>
                        </h3>
                        <ul class="float-right inline-links">
                            <li>
                                <a href="{{ route('categories.all') }}" class="active">{{__('View All Catogories')}}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="row gutters-5">
                        @foreach (\App\Category::where('top', 1)->get() as $category)
                            <div class="mb-3 col-6">
                                <a href="{{ route('products.category', $category->slug) }}" class="bg-white border d-block c-base-2 box-2 icon-anim pl-2">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col-3 text-center">
                                            <img src="{{ asset('frontend/images/placeholder.jpg') }}" data-src="{{ asset($category->banner) }}" alt="{{ __($category->name) }}" class="img-fluid img lazyload">
                                        </div>
                                        <div class="info col-7">
                                            <div class="name text-truncate pl-3 py-4">{{ __($category->name) }}</div>
                                        </div>
                                        <div class="col-2 text-center">
                                            <i class="la la-angle-right c-base-1"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="section-title-1 clearfix">
                        <h3 class="heading-5 strong-700 mb-0 float-left">
                            <span class="mr-4">{{__('Top 10 Brands')}}</span>
                        </h3>
                        <ul class="float-right inline-links">
                            <li>
                                <a href="{{ route('brands.all') }}" class="active">{{__('View All Brands')}}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="row gutters-5">
                        @foreach (\App\Brand::where('top', 1)->get() as $brand)
                            <div class="mb-3 col-6">
                                <a href="{{ route('products.brand', $brand->slug) }}" class="bg-white border d-block c-base-2 box-2 icon-anim pl-2">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col-3 text-center">
                                            <img src="{{ asset('frontend/images/placeholder.jpg') }}" data-src="{{ asset($brand->logo) }}" alt="{{ __($brand->name) }}" class="img-fluid img lazyload">
                                        </div>
                                        <div class="info col-7">
                                            <div class="name text-truncate pl-3 py-4">{{ __($brand->name) }}</div>
                                        </div>
                                        <div class="col-2 text-center">
                                            <i class="la la-angle-right c-base-1"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trigger the modal with a button -->
<button type="button" class="btn btn-info btn-lg" id="notice_msg_popup" data-toggle="modal" data-target="#myModal" style="display:none;">Open Modal</button>

@if(!empty($login_type) || $login_type == "0")

@if($notice->notice_show == "1" && $login_type == "0" || $notice->notice_show == "0" && $notice->only_customer == "1" && $login_type == "customer" ||$notice->notice_show == "0" && $notice->only_seller == "1" && $login_type == "seller")
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title text-center">{{$notice->title}}</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">

        <p><?php echo $content = stripslashes($notice->content); ?></p>
      </div>
     <!-- <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>-->
    </div>

  </div>
</div>
   @endif
   @endif
@endsection

@section('script')
    <script>
        $('.e-scroll').slick({
    slidesToScroll: 1,
    autoplay: true,
                    dots: true,
                    arrows: true,
                    prevArrow:
                        '<button type="button" class="slick-prev"><i class="la la-angle-left"></i></button>',
                    nextArrow:
                        '<button type="button" class="slick-next"><i class="la la-angle-right"></i></button>'
   });
        $(document).ready(function(){
            $.post('{{ route('home.section.featured') }}', {_token:'{{ csrf_token() }}'}, function(data){
                $('#section_featured').html(data);
                slickInit();
            });

            $.post('{{ route('home.section.best_selling') }}', {_token:'{{ csrf_token() }}'}, function(data){
                $('#section_best_selling').html(data);
                slickInit();
            });

            $.post('{{ route('home.section.home_categories') }}', {_token:'{{ csrf_token() }}'}, function(data){
                $('#section_home_categories').html(data);
                slickInit();
            });

            $.post('{{ route('home.section.best_sellers') }}', {_token:'{{ csrf_token() }}'}, function(data){
                $('#section_best_sellers').html(data);
                slickInit();
            });

        });

        $(document).on({
        mouseover:function(e){
            $('.get_quote_link').hide();
            $(this).children().children('.get_quote_link').show();
        }
    },'.product-hover');
    $(document).on({
        mouseout:function(e){
            $('.get_quote_link').hide();
        }
    },'.product-hover');
    $("document").ready(function() {
    $("#notice_msg_popup").trigger('click');
});
    </script>
@endsection
