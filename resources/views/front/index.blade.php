@extends('front/layout')
@section('container')
 <!-- Start slider -->
 <section id="aa-slider">
    <div class="aa-slider-area">
      <div id="sequence" class="seq">
        <div class="seq-screen">
          <ul class="seq-canvas">
            <!-- single slide item -->
            <li>
              <div class="seq-model">
                <img data-seq src="{{asset('front_assets/img/slider/1.jpg')}}" alt="Men slide img" />
              </div>
              <div class="seq-title">
               <span data-seq>Save Up to 75% Off</span>                
                <h2 data-seq>Men Collection</h2>                
                <p data-seq>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minus, illum.</p>
                <a data-seq href="#" class="aa-shop-now-btn aa-secondary-btn">SHOP NOW</a>
              </div>
            </li>
            <!-- single slide item -->
            <li>
              <div class="seq-model">
                <img data-seq src="{{asset('front_assets/img/slider/2.jpg')}}" alt="Wristwatch slide img" />
              </div>
              <div class="seq-title">
                <span data-seq>Save Up to 40% Off</span>                
                <h2 data-seq>Wristwatch Collection</h2>                
                <p data-seq>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minus, illum.</p>
                <a data-seq href="#" class="aa-shop-now-btn aa-secondary-btn">SHOP NOW</a>
              </div>
            </li>
            <!-- single slide item -->
            <li>
              <div class="seq-model">
                <img data-seq src="{{asset('front_assets/img/slider/3.jpg')}}" alt="Women Jeans slide img" />
              </div>
              <div class="seq-title">
                <span data-seq>Save Up to 75% Off</span>                
                <h2 data-seq>Jeans Collection</h2>                
                <p data-seq>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minus, illum.</p>
                <a data-seq href="#" class="aa-shop-now-btn aa-secondary-btn">SHOP NOW</a>
              </div>
            </li>
            <!-- single slide item -->           
            <li>
              <div class="seq-model">
                <img data-seq src="{{asset('front_assets/img/slider/4.jpg')}}" alt="Shoes slide img" />
              </div>
              <div class="seq-title">
                <span data-seq>Save Up to 75% Off</span>                
                <h2 data-seq>Exclusive Shoes</h2>                
                <p data-seq>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minus, illum.</p>
                <a data-seq href="#" class="aa-shop-now-btn aa-secondary-btn">SHOP NOW</a>
              </div>
            </li>
            <!-- single slide item -->  
             <li>
              <div class="seq-model">
                <img data-seq src="{{asset('front_assets/img/slider/5.jpg')}}" alt="Male Female slide img" />
              </div>
              <div class="seq-title">
                <span data-seq>Save Up to 50% Off</span>                
                <h2 data-seq>Best Collection</h2>                
                <p data-seq>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minus, illum.</p>
                <a data-seq href="#" class="aa-shop-now-btn aa-secondary-btn">SHOP NOW</a>
              </div>
            </li>                   
          </ul>
        </div>
        <!-- slider navigation btn -->
        <fieldset class="seq-nav" aria-controls="sequence" aria-label="Slider buttons">
          <a type="button" class="seq-prev" aria-label="Previous"><span class="fa fa-angle-left"></span></a>
          <a type="button" class="seq-next" aria-label="Next"><span class="fa fa-angle-right"></span></a>
        </fieldset>
      </div>
    </div>
  </section>
    <!-- Start Promo section -->
  <section id="aa-promo">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="aa-promo-area">
            <div class="row">
              <!-- promo right -->
              <div class="col-md-12 no-padding">
                <div class="aa-promo-right">
                    @foreach ($home_categories as $item)
                        <div class="aa-single-promo-right">
                            <div class="aa-promo-banner">                      
                            <img src="{{asset('storage/media/categories/'.$item->category_image)}}" style="object-fit: inherit" alt="{{$item->category_name}}">                      
                            <div class="aa-prom-content">
                                <h4><a href="{{url('category/'.$item->slug)}}">{{$item->category_name}}</a></h4>                        
                            </div>
                            </div>
                        </div>  
                    @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- / Promo section -->
  <!-- Products section -->

  <section id="aa-product">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="aa-product-area">
              <div class="aa-product-inner">
                <!-- start prduct navigation -->
                 <ul class="nav nav-tabs aa-products-tab">
                 @foreach($home_categories as $list)
                    <li class=""><a href="#cat{{$list->id}}" data-toggle="tab">{{$list->category_name}}</a></li>
                 @endforeach
                  </ul>
                  <!-- Tab panes -->
                  <div class="tab-content">
                    <!-- Start men product category -->
                    @php
                    $loop_count=1;
                    @endphp
                    @foreach($home_categories as $list)
                    @php
                    $cat_class="";
                    if($loop_count==1){
                      $cat_class="in active"; 
                      $loop_count++;
                    }
                    @endphp
                    <div class="tab-pane fade {{$cat_class}}" id="cat{{$list->id}}">
                      <ul class="aa-product-catg">
                      @if(isset($home_categories_product[$list->id][0]))
                       @foreach($home_categories_product[$list->id] as $productArr)
                        <li>
                          <figure>
                            <a class="aa-product-img" href="{{url('product/'.$productArr->slug)}}">
                                <img src="{{asset('storage/media/'.$productArr->image)}}" style="height:300px;width:300px;" alt="{{$productArr->name}}"></a>
                            <a class="aa-add-card-btn" href="javascript:void(0)"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                            <figcaption>
                              <h4 class="aa-product-title"><a href="{{url('product/'.$productArr->slug)}}">{{$productArr->name}}</a></h4>
                              <span class="aa-product-price">Rs {{$home_product_attrib[$productArr->id][0]->mrp}}</span><span class="aa-product-price">
                                <del>Rs {{$home_product_attrib[$productArr->id][0]->price}}</del></span>
                            </figcaption>
                          </figure>                          
                        </li>  
                        @endforeach    
                        @else
                        <li>
                          <figure>
                            No data found
                          <figure>
                        <li>
                        @endif
                      </ul>
                    </div>
                    @endforeach
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- / Products section -->
  <!-- popular section -->
  <section id="aa-popular-category">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="aa-popular-category-area">
              <!-- start prduct navigation -->
             <ul class="nav nav-tabs aa-products-tab">
                <li class="active"><a href="#trending" data-toggle="tab">Trending</a></li>
                <li><a href="#featured1" data-toggle="tab">Featured</a></li>
                <li><a href="#discounted" data-toggle="tab">Discounted</a></li>                    
              </ul>
              <!-- Tab panes -->
              <div class="tab-content">
                <!-- Start men popular category -->
                <div class="tab-pane fade in active" id="trending">
                  <ul class="aa-product-catg aa-trending-slider">
                    <!-- start single product item -->
                    @if(isset($home_trending_product[$list->id][0]))
                    @foreach($home_trending_product[$list->id] as $productArr)
                     <li>
                       <figure>
                         <a class="aa-product-img" href="{{url('product/'.$productArr->slug)}}">
                             <img src="{{asset('storage/media/'.$productArr->image)}}" style="height:300px;width:300px;" alt="{{$productArr->name}}"></a>
                         <a class="aa-add-card-btn" href="javascript:void(0)"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                         <figcaption>
                           <h4 class="aa-product-title"><a href="{{url('product/'.$productArr->slug)}}">{{$productArr->name}}</a></h4>
                           <span class="aa-product-price">Rs {{$home_trending_product_attrib[$productArr->id][0]->mrp}}</span><span class="aa-product-price">
                             <del>Rs {{$home_trending_product_attrib[$productArr->id][0]->price}}</del></span>
                         </figcaption>
                       </figure>                          
                     </li>  
                     @endforeach    
                     @else
                     <li>
                       <figure>
                         No data found
                       <figure>
                     <li>
                     @endif                                                                                     
                  </ul>
                </div>
                <!-- / popular product category -->
                
                <!-- start featured product category -->
                <div class="tab-pane fade" id="featured1">
                    <ul class="aa-product-catg aa-featured1-slider">
                      <!-- start single product item -->
                      @if(isset($home_featured_product[$list->id][0]))
                         @foreach($home_featured_product[$list->id] as $productArr)
                          <li>
                            <figure>
                              <a class="aa-product-img" href="{{url('product/'.$productArr->slug)}}">
                                  <img src="{{asset('storage/media/'.$productArr->image)}}" style="height:300px;width:300px;" alt="{{$productArr->name}}"></a>
                              <a class="aa-add-card-btn" href="javascript:void(0)"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                              <figcaption>
                                <h4 class="aa-product-title"><a href="{{url('product/'.$productArr->slug)}}">{{$productArr->name}}</a></h4>
                                <span class="aa-product-price">Rs {{$home_featured_product_attrib[$productArr->id][0]->mrp}}</span><span class="aa-product-price">
                                  <del>Rs {{$home_featured_product_attrib[$productArr->id][0]->price}}</del></span>
                              </figcaption>
                            </figure>                          
                          </li>  
                          @endforeach    
                          @else
                          <li>
                            <figure>
                              No data found
                            <figure>
                          <li>
                          @endif                                                                                 
                    </ul>
                  </div>
                <!-- / featured product category -->

                <!-- start latest product category -->
                <div class="tab-pane fade" id="discounted">
                  <ul class="aa-product-catg aa-discounted-slider">
                    <!-- start single product item -->
                    @if(isset($home_discounted_product[$list->id][0]))
                       @foreach($home_discounted_product[$list->id] as $productArr)
                        <li>
                          <figure>
                            <a class="aa-product-img" href="{{url('product/'.$productArr->slug)}}">
                                <img src="{{asset('storage/media/'.$productArr->image)}}" style="height:300px;width:300px;" alt="{{$productArr->name}}"></a>
                            <a class="aa-add-card-btn" href="javascript:void(0)"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                            <figcaption>
                              <h4 class="aa-product-title"><a href="{{url('product/'.$productArr->slug)}}">{{$productArr->name}}</a></h4>
                              <span class="aa-product-price">Rs {{$home_discounted_product_attrib[$productArr->id][0]->mrp}}</span><span class="aa-product-price">
                                <del>Rs {{$home_discounted_product_attrib[$productArr->id][0]->price}}</del></span>
                            </figcaption>
                          </figure>                          
                        </li>  
                        @endforeach    
                        @else
                        <li>
                          <figure>
                            No data found
                          <figure>
                        <li>
                        @endif                                                                                 
                  </ul>
                </div>
                <!-- / latest product category -->              
              </div>
            </div>
          </div> 
        </div>
      </div>
    </div>
  </section>
  <!-- / popular section --> 
  <!-- / popular section --> 
  @endsection   