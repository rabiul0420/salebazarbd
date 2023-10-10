<section class="mb-2 mb-lg-3">
    <div class="container">
        <div class="px-2 py-2 p-md-4 bg-white shadow-sm">
            <div class="section-title-1 clearfix">
                <h3 class="heading-5 strong-700 mb-0 float-left">
                    <span class="mr-4">{{__('Featured Products')}}</span>
                </h3>
            </div>
            <div class="caorusel-box arrow-round gutters-5">
                <div class="slick-carousel" data-slick-items="6" data-slick-xl-items="6" data-slick-lg-items="6"  data-slick-md-items="3" data-slick-sm-items="3" data-slick-xs-items="2">
                    @if (count(filter_products(\App\Product::where('published', 1)->where('featured', '1')->where('is_approved', 1))->limit(12)->get()) > 0)
                    @foreach (filter_products(\App\Product::where('published', 1)->where('featured', '1')->where('is_approved', 1))->limit(12)->get() as $key => $product)
                    <div class="caorusel-card mb-1">
                        <div class="product-card-2 card card-product shop-cards shop-tech product-hover">
                            <div class="card-body p-0">
                                @if($product->discount>0)
                                <span class="percentage-span-new"><font class="percentage-amount-new">

                                    {{ __(intval($product->discount)) }}%</font><br/>
                                    
                                    <p style="line-height: 0.5rem;"><font class="percentage-discount-amount-new">ছাড়</font></p>
                                    </span>
                                    @endif


                                <div class="card-image">
                                    <a href="{{ route('product', $product->slug) }}" class="d-block mobile-view-img">
                                        <img class="img-fit lazyload mx-auto" src="{{ asset('frontend/images/placeholder.jpg') }}" data-src="{{ asset($product->featured_img ?? $product->thumbnail_img ) }}" alt="{{ __($product->name) }}">
                                    </a>
                                </div>


                                <div class="p-md-3 p-2">
                                    <h2 class="product-title p-0 text-truncate">
                                        <a href="{{ route('product', $product->slug) }}">{{ __($product->name) }}</a>
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

                                    
                                </div>
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
