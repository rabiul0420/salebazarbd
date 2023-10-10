<div class="products-box-bar p-3 bg-white rep">
                            <div class="row gutters-5 infinite-scroll">
                                @foreach ($products as $key => $product)
                                    <!--<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-6"> -->
                                    
                                   

                                        <div class="product-box-2 bg-white alt-box my-md-2 product-hover ml-lg-1 mr-lg-1 p-list-sc" style="width: 24%;float: left">
                                            <div class="position-relative overflow-hidden">
                                                <a href="{{ route('product', $product->slug) }}" class="d-block product-image h-100 text-center" tabindex="0">
                                                    <img class="img-fit lazyload resp-img" src="{{ asset('frontend/images/placeholder.jpg') }}" data-src="{{ asset($product->featured_img) }}" alt="{{ __($product->name) }}">
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
                                                 <div class="padding_0 get_quote_link" style="    text-align: center;
    padding-bottom: 4px;
    position: absolute;
    z-index: 2147483647;
    background: rgb(255, 255, 255);
    width: 100%;
    left: 0px;box-shadow: 2px 4px 6px #aaa;"><a itemprop="url"  onclick="addToListCart({{ $product->id }})" title="Add to cart" style="width: 90%;font-size: 14px;padding: 5px;color: #fff" class="btn btn-styled btn-base-1 btn-icon-left strong-700 hov-bounce hov-shaddow buy-now">Add to cart</a></div>
                                            </div>
                                           
                                        </div>
                                    
                                @endforeach
                                {{ $products->links() }}
                            </div>
                        </div>

 <script type="text/javascript">

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