@foreach (\App\HomeCategory::where('status', 1)->get() as $key => $homeCategory)
    @if ($homeCategory->category != null)
        <section class="mb-2 mb-lg-3">
            <div class="container">
                <div class="px-2 py-2 p-md-4 bg-white shadow-sm">
                    <div class="section-title-1 clearfix">
                        <h3 class="heading-5 strong-700 mb-0 float-left">
                            <span class="mr-4 here">{{ __($homeCategory->category->name) }}</span>
                        </h3>
                        <ul class="inline-links float-right nav mt-2 mb-2 m-lg-0">
                            <li><a href="{{ route('products.category', $homeCategory->category->slug) }}" class="active">View More</a></li>
                        </ul>
                    </div>
                   

                    <div class="caorusel-box arrow-round gutters-5">
                        <div class="slick-carousel" data-slick-items="6" data-slick-xl-items="6" data-slick-lg-items="6"  data-slick-md-items="3" data-slick-sm-items="3" data-slick-xs-items="2">
                        @if (count(filter_products(\App\Product::where('published', 1)->where('category_id', $homeCategory->category->id)->where('is_approved', 1))->latest()->limit(12)->get()) > 0)
                        @foreach (filter_products(\App\Product::where('published', 1)->where('category_id', $homeCategory->category->id)->where('is_approved', 1))->latest()->limit(12)->get() as $key => $product)
                            <div class="caorusel-card mb-1">
                                <div class="product-box-2 alt-box my-0 product-hover" style="min-height:120px;">
                                    <div class="position-relative overflow-hidden">
                                        <a href="{{ route('product', $product->slug) }}" class="d-block product-image h-100 text-center mobile-view-img">
                                            <img class="img-fit lazyload" src="{{ asset('frontend/images/placeholder.jpg') }}" data-src="{{ asset($product->featured_img) }}" alt="{{ __($product->name) }}">
                                        </a>
                                        <div class="product-btns clearfix">
                                            <button class="btn add-wishlist" title="Add to Wishlist" onclick="addToWishList({{ $product->id }})" tabindex="0">
                                                <i class="la la-heart-o"></i>
                                            </button>
                                            <button class="btn add-compare" title="Add to Compare" onclick="addToCompare({{ $product->id }})" tabindex="0">
                                                <i class="la la-refresh"></i>
                                            </button>
                                            <button class="btn quick-view" title="Quick view" onclick="showAddToCartModal({{ $product->id }})" tabindex="0">
                                                <i class="la la-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="p-md-3 p-2">
                                        <h2 class="product-title p-0">
                                            <a href="{{ route('product', $product->slug) }}" class=" text-truncate">{{ __($product->name) }}</a>
                                        </h2>
                                        {{-- <div class="star-rating star-rating-sm mt-1">
                                            {{ renderStarRating($product->rating) }}
                                        </div> --}}
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
                                        
                                        
                                        @if (\App\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Addon::where('unique_identifier', 'club_point')->first()->activated)
                                            <div class="club-point mt-2 bg-soft-base-1 border-light-base-1 border">
                                                {{ __('Club Point') }}:
                                                <span class="strong-700 float-right">{{ $product->earn_point }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @else
                        No Products Found...
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script>
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
    @endif
@endforeach
