@if(Session::has('cart'))
                @if(count($cart = Session::get('cart')) > 0)
                    <div class="dc-header">
                        <h3 class="heading heading-6 strong-700">{{__('Cart Items')}}</h3>
                    </div>
                    <div class="added-tov dropdown-cart-items c-scrollbar " id="cart_items">
                        @php
                            $total = 0;
                        @endphp
                        @foreach($cart as $key => $cartItem)
                            @php
                                $product = \App\Product::find($cartItem['id']);
                                $total = $total + $cartItem['price']*$cartItem['quantity'];
                            @endphp
                            <div class="dc-item" id="rmpro">
                                <div class="d-flex align-items-center">
                                    <div class="dc-image">
                                        <a href="{{ route('product', $product->slug) }}">
                                            <img loading="lazy"  src="{{ asset($product->featured_img) }}" class="img-fluid" alt="">
                                        </a>
                                    </div>
                                    <div class="dc-content">
                                        <span class="d-block dc-product-name text-capitalize strong-600 mb-1">
                                            <a href="{{ route('product', $product->slug) }}">
                                                {{ __($product->name) }}
                                            </a>
                                        </span>

                                        <span class="dc-quantity">x{{ $cartItem['quantity'] }}</span>
                                        <span class="dc-price">{{ single_price($cartItem['price']*$cartItem['quantity']) }}</span>
                                    </div>
                                    <div class="dc-actions">
                                        <button onclick="removeFromCart({{ $key }})">
                                            <i class="la la-close"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="dc-item py-3">
                        <span class="subtotal-text">{{__('Subtotal')}}</span>
                        <span class="subtotal-amount">{{ single_price($total) }}</span>
                    </div>
                   
                @else
                    <div class="dc-header">
                        <h3 class="heading heading-6 strong-700">{{__('Your Cart is empty')}}</h3>
                    </div>
                @endif
            @else
                <div class="dc-header">
                    <h3 class="heading heading-6 strong-700">{{__('Your Cart is empty')}}</h3>
                </div>
            @endif