@extends('front.layout')
@section('title','Cart') 
@section('container')
    
 <!-- Cart view section -->
 <section id="cart-view">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="cart-view-area">
            <div class="cart-view-table">
              <form action="">
                @if (isset($cartList[0]))
                    <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($cartList as $item)
                            <tr id="cart_item_{{$item->attrId}}">
                                <td><a class="remove" href="javascript:void(0)"  onclick="deleteCartItem('{{$item->pid}}','{{$item->size}}','{{$item->attrId}}')">
                                    <fa class="fa fa-close"></fa></a></td>
                                <td><a href="{{url('product/'.$item->slug)}}"><img src="{{asset('storage/media/'.$item->image)}}" alt="img"></a></td>
                                <td><a class="aa-cart-title" href="{{url('product/'.$item->slug)}}">{{$item->name}}</a>
                                    @if ($item->size!= '')
                                        <br/> {{$item->size}}
                                    @endif
                                    @if ($item->color!= '')
                                    <br/> COLOR: {{$item->color}}
                                    @endif  
                                </td>
                                <td>{{$item->price}}</td>
                                <td><input class="aa-cart-quantity" id="qty{{$item->attrId}}" 
                                    type="number" value="{{$item->qty}}" 
                                    onchange="updateQty('{{$item->pid}}','{{$item->size}}','{{$item->attrId}}','{{$item->price}}')"></td>
                                <td id="total_price_{{$item->attrId}}">{{$item->qty*$item->price}}</td>
                            </tr>
                        @endforeach
                            <tr>
                                <td colspan="6" class="aa-cart-view-bottom">
                                <div class="aa-cart-coupon">
                                    <input class="aa-coupon-code" type="text" placeholder="Coupon">
                                    <input class="aa-cart-view-btn" type="submit" value="Apply Coupon">
                                </div>
                                <input class="aa-cart-view-btn" type="button" value="Checkout">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </div> 
                @else
                    <h3>Cart is empty</h3>
                @endif
                </form>
                <!-- Cart Total view -->
                {{-- <div class="cart-view-total">
                    <h4>Cart Totals</h4>
                    <table class="aa-totals-table">
                    <tbody>
                        <tr>
                        <th>Subtotal</th>
                        <td>$450</td>
                        </tr>
                        <tr>
                        <th>Total</th>
                        <td>$450</td>
                        </tr>
                    </tbody>
                    </table>
                    <a href="#" class="aa-cart-view-btn">Proced to Checkout</a>
                </div> --}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- / Cart view section -->
  <input type="hidden" id="qty" value="">
  <form id="addToCartForm">
    <input type="hidden" id="size_id" name="size_id">
    <input type="hidden" id="productQty" name="productQty">
    <input type="hidden" id="product_id" name="product_id">
    @csrf
  </form>  
@endsection