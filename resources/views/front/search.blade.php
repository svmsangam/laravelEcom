@extends('front.layout')
@section('title','Search')
@section('container')
    
<section id="aa-product-category">
    <div class="container">
      <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-8">
          <div class="aa-product-catg-content">
            <div class="aa-product-catg-body">
              <ul class="aa-product-catg">
                <!-- start single product item -->
                @if(isset($search_product[0]))
                @foreach($search_product as $productArr)
                 <li>
                   <figure>
                     <a class="aa-product-img" href="{{url('product/'.$productArr->slug)}}">
                         <img src="{{asset('storage/media/'.$productArr->image)}}" style="height:300px;width:300px;" alt="{{$productArr->name}}"></a>
                     <a class="aa-add-card-btn" href="javascript:void(0)" 
                        onclick="add_to_home_cart('{{$productArr->id}}','{{$product_attrib[$productArr->id][0]->size}}')">
                        <span class="fa fa-shopping-cart"></span>Add To Cart</a>
                     <figcaption>
                       <h4 class="aa-product-title"><a href="{{url('product/'.$productArr->slug)}}">{{$productArr->name}}</a></h4>
                       <span class="aa-product-price"><del>Rs {{$product_attrib[$productArr->id][0]->mrp}}</del></span><span class="aa-product-price">
                         Rs {{$product_attrib[$productArr->id][0]->price}}</span>
                         <p class="aa-product-descrip">{!! $productArr->desc !!}</p>  
                     </figcaption>
                   </figure>                          
                 </li>  
                 @endforeach    
                 @else
                 <li>
                   <figure>
                     No product found
                   <figure>
                 <li>
                 @endif                  
              </ul> 
            </div>
            <div class="aa-product-catg-pagination">
              <nav>
                <ul class="pagination">
                  <li>
                    <a href="#" aria-label="Previous">
                      <span aria-hidden="true">&laquo;</span>
                    </a>
                  </li>
                  <li><a href="#">1</a></li>
                  <li><a href="#">2</a></li>
                  <li><a href="#">3</a></li>
                  <li><a href="#">4</a></li>
                  <li><a href="#">5</a></li>
                  <li>
                    <a href="#" aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                    </a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
        {{-- <div class="col-lg-3 col-md-3 col-sm-4 col-md-pull-9">
          <aside class="aa-sidebar">
            <!-- single sidebar -->
            <div class="aa-sidebar-widget">
              <h3>Category</h3>
              <ul class="aa-catg-nav">
                @foreach ($categories_left as $item)
                  @if ($slug == $item->slug)
                    <li><a href="{{url('category/'.$item->slug)}}" class="cat-left-nav">{{$item->category_name}}</a></li> 
                  @else
                    <li><a href="{{url('category/'.$item->slug)}}">{{$item->category_name}}</a></li>       
                  @endif
                
                @endforeach
              </ul>
            </div>
            <!-- single sidebar -->
            <div class="aa-sidebar-widget">
              <h3>Tags</h3>
              <div class="tag-cloud">
                <a href="#">Fashion</a>
              </div>
            </div>
            <!-- single sidebar -->
            <div class="aa-sidebar-widget">
              <h3>Shop By Price</h3>              
              <!-- price range -->
              <div class="aa-sidebar-price-range">
               <form action="">
                  <div id="skipstep" class="noUi-target noUi-ltr noUi-horizontal noUi-background">
                  </div>
                  <span id="skip-value-lower" class="example-val">30.00</span>
                 <span id="skip-value-upper" class="example-val">100.00</span>
                 <button class="aa-filter-btn" type="button" onclick="filter_price()">Filter</button>
               </form>
              </div>              

            </div>
          </aside>
        </div> --}}
       
      </div>
    </div>
  </section>
  <input type="hidden" id="qty" value="1">
  <form id="addToCartForm">
    <input type="hidden" id="size_id" name="size_id">
    <input type="hidden" id="productQty" name="productQty">
    <input type="hidden" id="product_id" name="product_id">
    @csrf
  </form>
@endsection