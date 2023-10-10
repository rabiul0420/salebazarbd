@if (\App\BusinessSetting::where('type', 'best_selling')->first()->value == 1)
    <section class="mb-2 mb-lg-3">
        <div class="container">
            <div class="px-2 py-2 p-md-4 bg-white shadow-sm">
                <div class="section-title-1 clearfix">
                    <h3 class="heading-5 strong-700 mb-0 float-left">
                        <span class="mr-4">{{__('Best Selling')}}</span>
                    </h3>
                    <ul class="inline-links float-right mt-2">
                        {{-- <li><a  class="active">{{__('Top 20')}}</a></li> --}}
                    </ul>
                </div>
                <div class="caorusel-box arrow-round gutters-5">
                    <div class="slick-carousel" data-slick-items="3" data-slick-lg-items="3"  data-slick-md-items="3" data-slick-sm-items="2" data-slick-xs-items="1" data-slick-rows="2">
                        @if (count(filter_products(\App\Product::where('published', 1)->orderBy('num_of_sale', 'desc')->where('is_approved', 1))->limit(20)->get()) > 0)
                        @foreach (filter_products(\App\Product::where('published', 1)->orderBy('num_of_sale', 'desc')->where('is_approved', 1))->limit(20)->get() as $key => $product)
                            <div class="caorusel-card my-1">
                                <div class="row no-gutters product-box-2 align-items-center">
                                    <div class="col-5">
                                        <div class="position-relative overflow-hidden h-100">
                                            <a href="{{ route('product', $product->slug) }}" class="d-block product-image mobile-view-img">
                                                <img class="img-fit lazyload mx-auto" src="{{ asset('frontend/images/placeholder.jpg') }}" data-src="{{ asset($product->featured_img) }}" alt="{{ __($product->name) }}">
                                            </a>
                                            <div class="product-btns">
                                                <button class="btn add-wishlist" title="Add to Wishlist" onclick="addToWishList({{ $product->id }})">
                                                    <i class="la la-heart-o"></i>
                                                </button>
                                                <button class="btn add-compare" title="Add to Compare" onclick="addToCompare({{ $product->id }})">
                                                    <i class="la la-refresh"></i>
                                                </button>
                                                <button class="btn quick-view" title="Quick view" onclick="showAddToCartModal({{ $product->id }})">
                                                    <i class="la la-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-7 border-left">
                                        <div class="p-3">
                                            <h2 class="product-title mb-0 p-0 text-truncate-2">
                                                <a href="{{ route('product', $product->slug) }}">{{ __($product->name) }}</a>
                                            </h2>
                                           {{--  <div class="star-rating star-rating-sm mb-2">
                                                {{ renderStarRating($product->rating) }}
                                            </div> --}}
                                            <div class="clearfix">
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
@endif
