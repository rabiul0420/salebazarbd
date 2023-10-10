@extends('frontend.layouts.app')

@if(isset($subsubcategory_id))
    @php
        $meta_title = \App\SubSubCategory::find($subsubcategory_id)->meta_title;
        $meta_description = \App\SubSubCategory::find($subsubcategory_id)->meta_description;
    @endphp
@elseif (isset($subcategory_id))
    @php
        $meta_title = \App\SubCategory::find($subcategory_id)->meta_title;
        $meta_description = \App\SubCategory::find($subcategory_id)->meta_description;
    @endphp
@elseif (isset($category_id))
    @php
        $meta_title = \App\Category::find($category_id)->meta_title;
        $meta_description = \App\Category::find($category_id)->meta_description;
    @endphp
@elseif (isset($brand_id))
    @php
        $meta_title = \App\Brand::find($brand_id)->meta_title;
        $meta_description = \App\Brand::find($brand_id)->meta_description;
    @endphp
@else
    @php
        $meta_title = env('APP_NAME');
        $meta_description = \App\SeoSetting::first()->description;
    @endphp
@endif

@section('meta_title'){{ $meta_title }}@stop
@section('meta_description'){{ $meta_description }}@stop

@section('meta')
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $meta_title }}">
    <meta itemprop="description" content="{{ $meta_description }}">

    <!-- Twitter Card data -->
    <meta name="twitter:title" content="{{ $meta_title }}">
    <meta name="twitter:description" content="{{ $meta_description }}">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $meta_title }}" />
    <meta property="og:description" content="{{ $meta_description }}" />
@endsection

@section('content')
    
    <div class="breadcrumb-area">
        <div class="container">

            <div class="row">
                <div class="col">
                    <ul class="breadcrumb">
                        <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                        <li><a href="{{ route('products') }}">{{__('All Categories')}}</a></li>
                        @if(isset($category_id))
                            <li class="active"><a href="{{ route('products.category', \App\Category::find($category_id)->slug) }}">{{ \App\Category::find($category_id)->name }}</a></li>
                        @endif
                        @if(isset($subcategory_id))
                            <li ><a href="{{ route('products.category', \App\SubCategory::find($subcategory_id)->category->slug) }}">{{ \App\SubCategory::find($subcategory_id)->category->name }}</a></li>
                            <li class="active"><a href="{{ route('products.subcategory', \App\SubCategory::find($subcategory_id)->slug) }}">{{ \App\SubCategory::find($subcategory_id)->name }}</a></li>
                        @endif
                        @if(isset($subsubcategory_id))
                            <li ><a href="{{ route('products.category', \App\SubSubCategory::find($subsubcategory_id)->subcategory->category->slug) }}">{{ \App\SubSubCategory::find($subsubcategory_id)->subcategory->category->name }}</a></li>
                            <li ><a href="{{ route('products.subcategory', \App\SubsubCategory::find($subsubcategory_id)->subcategory->slug) }}">{{ \App\SubsubCategory::find($subsubcategory_id)->subcategory->name }}</a></li>
                            <li class="active"><a href="{{ route('products.subsubcategory', \App\SubSubCategory::find($subsubcategory_id)->slug) }}">{{ \App\SubSubCategory::find($subsubcategory_id)->name }}</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @if(!isset($category_id) || !isset($category_id) || !isset($subcategory_id) || !isset($subsubcategory_id))
    <section class="mt-2">
        <div class="container">
            <div class="px-2 py-2 p-md-3 bg-white shadow-sm">
            
                <div class="caorusel-box arrow-round gutters-5">
                    <div class="slick-carousel" data-slick-items="8" data-slick-lg-items="2"  data-slick-md-items="8" data-slick-sm-items="6" data-slick-xs-items="6" data-slick-rows="1">
                         @if(!isset($category_id) && !isset($category_id) && !isset($subcategory_id) && !isset($subsubcategory_id))
                        
                                            @foreach(\App\Category::all() as $category)
                            <div class="caorusel-card cat-bo">
                                <div class="row no-gutters product-box-2 align-items-center" style="border:none">
                                    <div class="col-12">
                                        <div class="position-relative overflow-hidden h-100">
                                            <a href="{{ route('products.category', $category->slug) }}" class="d-block h-100">
                                                <img class="img-fit lazyload mx-auto" src="{{ asset('frontend/images/placeholder.jpg') }}" data-src="{{ asset($category->banner ?? '') }}" alt="{{ __($category->name) }}">
                                            </a>
                                           
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="p-1">
                                            <h2 class="product-title mb-0 p-0 text-truncate-2">
                                                <a href="{{ route('products.category', $category->slug) }}">{{ __($category->name) }} </a>
                                            </h2>
                                            
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                         @endforeach
                        @endif
                        @if(isset($category_id))
                           @foreach (\App\Category::find($category_id)->subcategories as $key2 => $subcategory)
                            <div class="caorusel-card my-1">
                                <div class="row no-gutters product-box-2 cat-bo align-items-center">
                                    <div class="col-12">
                                        <div class="position-relative overflow-hidden h-100">
                                            <a href="{{ route('products.subcategory', $subcategory->slug) }}" class="d-block  h-100">
                                                <img class="img-fit lazyload mx-auto" src="{{ asset('frontend/images/placeholder.jpg') }}" data-src="{{ asset($subcategory->icon ?? 'frontend/images/placeholder.jpg') }}" alt="{{ __($subcategory->name) }}">
                                            </a>
                                           
                                        </div>
                                    </div>
                                    <div class="col-12 border-left">
                                        <div class="p-1">
                                            <h2 class="product-title mb-0 p-0 text-truncate-2">
                                                <a href="{{ route('products.subcategory', $subcategory->slug) }}">{{ __($subcategory->name) }} </a>
                                            </h2>
                                            
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                         @endforeach

                        @endif
                         @if(isset($subcategory_id))
                           @foreach (\App\SubCategory::find($subcategory_id)->subsubcategories as $key3 => $subsubcategory)
                            <div class="caorusel-card my-1">
                                <div class="row no-gutters product-box-2 align-items-center">
                                    <div class="col-12">
                                        <div class="position-relative overflow-hidden h-100">
                                            <a href="{{ route('products.subsubcategory', $subsubcategory->slug) }}" class="d-block h-100">
                                                <img class="img-fit lazyload mx-auto" src="{{ asset('frontend/images/placeholder.jpg') }}" data-src="{{ asset($subsubcategory->icon ?? 'frontend/images/placeholder.jpg') }}" alt="{{ __($subsubcategory->name) }}">
                                            </a>
                                           
                                        </div>
                                    </div>
                                    <div class="col-12 border-left">
                                        <div class="p-1">
                                            <h2 class="product-title mb-0 p-0 text-truncate-2">
                                                <a href="{{ route('products.subsubcategory', $subsubcategory->slug) }}">{{ __(@\App\SubsubCategory::find($subsubcategory_id)->name) }} </a>
                                            </h2>
                                            
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                         @endforeach

                      @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
      @endif

    <section class="gry-bg py-2">
        <div class="container sm-px-0">
            <form class="" id="search-form" action="{{ route('search') }}" method="GET">
                <input type="hidden" name="ajax" value="1">
                <div class="row">
                <div class="col-xl-3 side-filter d-xl-block">
                    <div class="filter-overlay filter-close"></div>
                    <div class="filter-wrapper c-scrollbar">
                        <div class="filter-title d-flex d-xl-none justify-content-between pb-3 align-items-center">
                            <h3 class="h6">Filters</h3>
                            <button type="button" class="close filter-close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        
                        <div class="bg-white sidebar-box mb-3">
                            <div class="box-title text-center">
                                {{__('Price range')}}
                            </div>
                            <div class="box-content">
                                <div class="range-slider-wrapper mt-3">
                                    <!-- Range slider container -->
                                    <div id="input-slider-range" data-range-value-min="{{ filter_products(\App\Product::query())->get()->min('unit_price') }}" data-range-value-max="{{ filter_products(\App\Product::query())->get()->max('unit_price') }}"></div>

                                    <!-- Range slider values -->
                                    <div class="row">
                                        <div class="col-6">
                                            <span class="range-slider-value value-low"
                                                @if (isset($min_price))
                                                    data-range-value-low="{{ $min_price }}"
                                                @elseif($products->min('unit_price') > 0)
                                                    data-range-value-low="{{ $products->min('unit_price') }}"
                                                @else
                                                    data-range-value-low="0"
                                                @endif
                                                id="input-slider-range-value-low">
                                        </div>

                                        <div class="col-6 text-right">
                                            <span class="range-slider-value value-high"
                                                @if (isset($max_price))
                                                    data-range-value-high="{{ $max_price }}"
                                                @elseif($products->max('unit_price') > 0)
                                                    data-range-value-high="{{ $products->max('unit_price') }}"
                                                @else
                                                    data-range-value-high="0"
                                                @endif
                                                id="input-slider-range-value-high">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white sidebar-box mb-3">
                            <div class="box-title text-center">
                                {{__('Filter by color')}}
                            </div>
                            <div class="box-content">
                                <!-- Filter by color -->
                                <ul class="list-inline checkbox-color checkbox-color-circle mb-0">
                                    @foreach ($all_colors as $key => $color)
                                        <li>
                                            <input type="radio" id="color-{{ $key }}" name="color" value="{{ $color }}" @if(isset($selected_color) && $selected_color == $color) checked @endif onchange="filter()">
                                            <label style="background: {{ $color }};" for="color-{{ $key }}" data-toggle="tooltip" data-original-title="{{ \App\Color::where('code', $color)->first()->name }}"></label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        @foreach ($attributes as $key => $attribute)
                            @if (\App\Attribute::find($attribute['id']) != null)
                                <div class="bg-white sidebar-box mb-3">
                                    <div class="box-title text-center">
                                        Filter by {{ \App\Attribute::find($attribute['id'])->name }}
                                    </div>
                                    <div class="box-content">
                                        <!-- Filter by others -->
                                        <div class="filter-checkbox">
                                            @if(array_key_exists('values', $attribute))
                                                @foreach ($attribute['values'] as $key => $value)
                                                    @php
                                                        $flag = false;
                                                        if(isset($selected_attributes)){
                                                            foreach ($selected_attributes as $key => $selected_attribute) {
                                                                if($selected_attribute['id'] == $attribute['id']){
                                                                    if(in_array($value, $selected_attribute['values'])){
                                                                        $flag = true;
                                                                        break;
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    @endphp
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="attribute_{{ $attribute['id'] }}_value_{{ $value }}" name="attribute_{{ $attribute['id'] }}[]" value="{{ $value }}" @if ($flag) checked @endif onchange="filter()">
                                                        <label for="attribute_{{ $attribute['id'] }}_value_{{ $value }}">{{ $value }}</label>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                        {{-- <button type="submit" class="btn btn-styled btn-block btn-base-4">Apply filter</button> --}}
                    </div>
                </div>

                <div class="col-xl-9">
                    <div class="col-12">
                        <div class="d-lg-none d-block sort-by-box flex-grow-1">
                                    <div class="form-group" style="margin-bottom: 10px">
                                        
                                        <div class="search-widget">
                                            <input class="form-control input-lg" type="text" name="q" placeholder="{{__('Search products')}}" @isset($query) value="{{ $query }}" @endisset>
                                            <button onclick="filter(); return false;" type="submit" class="btn-inner">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                    </div>
                    
                  
                    <!-- <div class="bg-white"> -->
                        @isset($category_id)
                            <input type="hidden" name="category" value="{{ \App\Category::find($category_id)->slug }}">
                        @endisset
                        @isset($subcategory_id)
                            <input type="hidden" name="subcategory" value="{{ \App\SubCategory::find($subcategory_id)->slug }}">
                        @endisset
                        @isset($subsubcategory_id)
                            <input type="hidden" name="subsubcategory" value="{{ \App\SubSubCategory::find($subsubcategory_id)->slug }}">
                        @endisset

                        <div class="sort-by-bar row no-gutters bg-white mb-1 px-3 pt-2">
                            <div class="col-xl-4 d-flex d-xl-block justify-content-between align-items-end ">
                                <div class="d-none d-lg-block sort-by-box flex-grow-1">
                                    <div class="form-group">
                                        <label>{{__('Search')}}</label>
                                        <div class="search-widget">
                                            <input class="form-control input-lg" type="text" name="q" placeholder="{{__('Search products')}}" @isset($query) value="{{ $query }}" @endisset>
                                            <button onclick="filter(); return false;" type="submit" class="btn-inner">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-xl-none ml-3">
                                    <div class="form-group">
                                        <label>
                                    Found  {{ count($products) }} Items
                                </label></div>
                                </div>
                                <div class="d-block d-lg-none sort-by-box px-1">
                                    <span class="d-xl-none ml-3 form-group"><i style="margin-top: 10px" class="fa fa-sort-alpha-desc" aria-hidden="true"></i></span>
                                            <div style="float: right;" class="form-group">
                                          
                                                

                                            
                                                <select class="form-control sortSelect" data-minimum-results-for-search="Infinity" name="sort_by" onchange="filter()">
                                                    <option selected> Sort By &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp; </option>
                                                    <option value="1" @isset($sort_by) @if ($sort_by == '1') selected @endif @endisset><i></i>{{__('Newest')}}</option>
                                                    <option value="2" @isset($sort_by) @if ($sort_by == '2') selected @endif @endisset>{{__('Oldest')}}</option>
                                                    <option value="3" @isset($sort_by) @if ($sort_by == '3') selected @endif @endisset>{{__('Price low to high')}}</option>
                                                    <option value="4" @isset($sort_by) @if ($sort_by == '4') selected @endif @endisset>{{__('Price high to low')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                <div class="d-xl-none ml-3 form-group">
                                    <button type="button" class="btn p-1 btn-sm" id="side-filter">
                                        <i class="la la-filter la-2x"></i>
                                    </button> <span>Filter</span>
                                </div>
                            </div>
                            <div class="d-none d-lg-block col-xl-7 offset-xl-1">
                                <div class="row no-gutters">
                                    <div class="col-4">
                                        <div class="sort-by-box px-1">
                                            <div class="form-group">
                                                <label>{{__('Sort by')}}</label>
                                                <select class="form-control sortSelect" data-minimum-results-for-search="Infinity" name="sort_by" onchange="filter()">
                                                    <option value="1" @isset($sort_by) @if ($sort_by == '1') selected @endif @endisset>{{__('Newest')}}</option>
                                                    <option value="2" @isset($sort_by) @if ($sort_by == '2') selected @endif @endisset>{{__('Oldest')}}</option>
                                                    <option value="3" @isset($sort_by) @if ($sort_by == '3') selected @endif @endisset>{{__('Price low to high')}}</option>
                                                    <option value="4" @isset($sort_by) @if ($sort_by == '4') selected @endif @endisset>{{__('Price high to low')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 d-none d-lg-block">
                                        <div class="sort-by-box px-1">
                                            <div class="form-group">
                                                <label>{{__('Brands')}}</label>
                                                <select class="form-control sortSelect" data-placeholder="{{__('All Brands')}}" name="brand" onchange="filter()">
                                                    <option value="">{{__('All Brands')}}</option>
                                                    @foreach (\App\Brand::all() as $brand)
                                                        <option value="{{ $brand->slug }}" @isset($brand_id) @if ($brand_id == $brand->id) selected @endif @endisset>{{ $brand->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 d-none d-lg-block">

                                        <div class="sort-by-box px-1">
                                            <div class="form-group">
                                                <label>{{__('Select')}}</label>
                                                <select class="form-control sortSelect" data-placeholder="{{__('Offer Zone')}}" name="offer_id" onchange="filter()">
                                                    <option value="0" >{{__('Select One')}}</option>
                                                     <option value="1" >{{__('Offer Zone')}}</option>
                                                      <option value="2" >{{__('Best Sell')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="min_price" value="">
                        <input type="hidden" name="max_price" value="">
                        <!-- <hr class=""> -->
                        <div class="products-box-bar p-1 bg-white rep">
                            <div class="row gutters-5 infinite-scroll">
                                @if(count($products)>0)
                                @foreach ($products as $key => $product)
                                    {{-- <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-6"> --}}
                                    
                                   

                                        <div class="product-box-2 bg-white alt-box my-md-2 product-hover ml-lg-1 mr-lg-1 p-list-sc" style="width: 24%;float: left;">
                                            <div class="position-relative overflow-hidden">
                                                <a href="{{ route('product', $product->slug) }}" class="d-block product-image h-100 text-center" tabindex="0">
                                                    <img style="height:150px !important;" class="img-fit lazyload resp-img" src="{{ asset('frontend/images/placeholder.jpg') }}" data-src="{{ asset($product->featured_img) }}" alt="{{ __($product->name) }}">
                                                </a>
                                                <div class="product-btns clearfix">
                                                    <button class="btn add-wishlist" title="Add to Wishlist" onclick="addToWishList({{ $product->id }})" type="button">
                                                        <i class="la la-heart-o"></i>
                                                    </button>
                                                    <button class="btn add-compare" title="Add to Compare" onclick="addToCompare({{ $product->id }})" type="button">
                                                        <i class="la la-refresh"></i>
                                                    </button>
                                                    <button class="btn quick-view" title="Quick view" onclick="showAddToCartModal({{ $product->id }})" type="button">
                                                        <i class="la la-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="p-md-3 p-2">
                                                <h2 class="product-title p-0">
                                                    <a href="{{ route('product', $product->slug) }}" class=" text-truncate">{{ __($product->name) }}</a>
                                                </h2>
                                                 @auth
                                    <div class="price-box">

                                        @if(auth()->user()->user_type=='seller')
                                        <span class="product-price strong-600">
                                            {{ home_base_price($product->id) }}
                                        </span>
                                        @else
                                        @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                            <del class="old-product-price strong-400">{{ home_base_price($product->id) }}</del>
                                        @endif
                                        <span class="product-price strong-600">{{ home_discounted_base_price($product->id) }}</span>

                                        @endif
                                      
                                    </div>
                                    
                                    @if(auth()->user()->user_type=='seller')
                                    @if(home_base_price($product->id) != home_reseller_discounted_base_price($product->id))
                                    <div class="price-box">
                                       Wholesale:<span class="product-price strong-600">  {{ home_reseller_discounted_base_price($product->id) }}
                                       </span>
                                    </div>
                                    @endif
                                    @endif
                                    @endauth
                                    @guest
                                    <div class="price-box">
                                        @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                            <del class="old-product-price strong-400">{{ home_base_price($product->id) }}</del>
                                        @endif
                                        <span class="product-price strong-600">{{ home_discounted_base_price($product->id) }}</span>
                                    </div>
                                    @endguest
                                                {{-- <div class="star-rating star-rating-sm mt-1">
                                                    {{ renderStarRating($product->rating) }}
                                                </div> --}}
                                                
                                                @if (\App\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Addon::where('unique_identifier', 'club_point')->first()->activated)
                                                    <div class="club-point mt-2 bg-soft-base-1 border-light-base-1 border">
                                                        {{ __('Club Point') }}:
                                                        <span class="strong-700 float-right">{{ $product->earn_point }}</span>
                                                    </div>
                                                @endif
                                                 <div class="padding_0 get_quote_link addclist" style=""><a itemprop="url"  onclick="addToListCart({{ $product->id }})" title="Add to cart" style="font-size: 12px;padding: 3px;color: #fff" class="btn btn-styled btn-base-1 btn-icon-left strong-700 hov-bounce hov-shaddow buy-now">Add to cart</a></div>
                                            </div>
                                           
                                        </div>
                                    
                                @endforeach
                                {{ $products->links() }}
                                @else
                                <div class="col-12" style="text-align: center;padding: 50px">
                                    No products found
                                </div>
                                @endif
                            </div>
                        </div>
                        {{-- <div class="products-pagination bg-white p-3">
                            <nav aria-label="Center aligned pagination">
                                <ul class="pagination justify-content-center">
                                    {{ $products->links() }}
                                </ul>
                            </nav>
                        </div> --}}

                    <!-- </div> -->
                </div>
            </div>
            </form>
        </div>
    </section>

@endsection

@section('script')
<script src="{{ asset('frontend/js/jquery.jscroll.min.js')}}"></script>
  <script type="text/javascript">
    $('ul.pagination').hide();
    $(function() {
        $('.infinite-scroll').jscroll({
            autoTrigger: true,
            loadingHtml: '<img style="width:200px" class="center-block" src="{{asset('img/load.gif')}}" alt="Loading..." />',
            padding: 0,
            nextSelector: '.pagination li.active + li a',
            contentSelector: 'div.infinite-scroll',
            callback: function() {
                $('ul.pagination').remove();
            }
        });
    });
</script>

    <script type="text/javascript">


        function filter(){

           var a=$('#search-form').serialize();
    // console.log(a);
    // var a=$('#yourform').serialize();
$.ajax({
    type:'get',
    url:'{{ route('search') }}?'+a,
    // data:a,
    beforeSend:function(){
        // launchpreloader();
    },
    complete:function(){
        // console.log()
        // stopPreloader();
    },
    success:function(data){
         // console.log(data);
         $( ".rep" ).replaceWith( data );
         if ($(".side-filter").hasClass("open")) {
            $(".side-filter").removeClass("open");
        } else {
            $(".side-filter").addClass("open");
        }
    }
});
//            $('form#search-form').submit(function() {
//     // $(this).ajaxSubmit();
//     // var a=$('#search-form').serialize();
//     alert(424);
//             //validation and other stuff
//         // return false; 
// });
            // return false; 
            // $('#search-form').submit();
        }
        function rangefilter(arg){
            $('input[name=min_price]').val(arg[0]);
            $('input[name=max_price]').val(arg[1]);
            filter();
        }
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
    </script>
@endsection
