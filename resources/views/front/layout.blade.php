<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <title>@yield('title')</title>
    
    <!-- Font awesome -->
    <link href="{{asset('front_assets/css/font-awesome.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.5.0/css/all.min.css">
    <!-- Bootstrap -->
    <link href="{{asset('front_assets/css/bootstrap.css')}}" rel="stylesheet">   
    <!-- SmartMenus jQuery Bootstrap Addon CSS -->
    <link href="{{asset('front_assets/css/jquery.smartmenus.bootstrap.css')}}" rel="stylesheet">
    <!-- Product view slider -->
    <link rel="stylesheet" type="text/css" href="{{asset('front_assets/css/jquery.simpleLens.css')}}">    
    <!-- slick slider -->
    <link rel="stylesheet" type="text/css" href="{{asset('front_assets/css/slick.css')}}">
    <!-- price picker slider -->
    <link rel="stylesheet" type="text/css" href="{{asset('front_assets/css/nouislider.css')}}">
    <!-- Theme color -->
    <link id="switcher" href="{{asset('front_assets/css/theme-color/default-theme.css')}}" rel="stylesheet">
     <link id="switcher" href="{{asset('front_assets/css/theme-color/bridge-theme.css')}}" rel="stylesheet"> 
    <!-- Top Slider CSS -->
    <link href="{{asset('front_assets/css/sequence-theme.modern-slide-in.css')}}" rel="stylesheet" media="all">

    <!-- Main style sheet -->
    <link href="{{asset('front_assets/css/style.css')}}" rel="stylesheet">    

    <!-- Google Font -->
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
    <script src="https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.17.0.0.0/khalti-checkout.iffe.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  <script>
    var PRODUCT_IMAGE = "{{asset('storage/media')}}";
  </script>
  @php
      if(isset($_COOKIE['login_email']) && isset($_COOKIE['login_pwd'])){
        $loginEmail = $_COOKIE['login_email'];
        $loginPassword = $_COOKIE['login_pwd'];
        $is_remember = "checked= 'checked'";
      }else{
        $loginEmail ="";
        $loginPassword ="";
        $is_remember = "";
      }
  @endphp
  </head>

  <body class="productPage">
    @if (session()->has('error'))
    <div class="sufee-alert alert with-close alert-danger alert-dismissable fade show" role="alert">
        <span class="badge badge-pill badge-danger">Failed</span>
            {{session('error')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
    </div>    
    @endif
   <!-- wpf loader Two -->
    <div id="wpf-loader-two">          
      <div class="wpf-loader-two-inner">
        <span>Loading</span>
      </div>
    </div> 
    <!-- / wpf loader Two -->       
  <!-- SCROLL TOP BUTTON -->
    <a class="scrollToTop" href="#"><i class="fa fa-chevron-up"></i></a>
  <!-- END SCROLL TOP BUTTON -->


  <!-- Start header section -->
  <header id="aa-header">
    <!-- start header top  -->
    <div class="aa-header-top">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="aa-header-top-area">
              <!-- start header top left -->
              <div class="aa-header-top-left">
                <!-- start language -->
                {{-- <div class="aa-language">
                  <div class="dropdown">
                    <a class="btn dropdown-toggle" href="#" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                      <img src="{{asset('front_assets/img/flag/english.jpg')}}" alt="english flag">ENGLISH
                      <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                      <li><a href="#"><img src="{{asset('front_assets/img/flag/french.jpg')}}" alt="">FRENCH</a></li>
                      <li><a href="#"><img src="{{asset('front_assets/img/flag/english.jpg')}}" alt="">ENGLISH</a></li>
                    </ul>
                  </div>
                </div> --}}
                <!-- / language -->

                <!-- start currency -->
                {{-- <div class="aa-currency">
                  <div class="dropdown">
                    <a class="btn dropdown-toggle" href="#" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                      <i class="fa fa-usd"></i>USD
                      <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                      <li><a href="#"><i class="fa fa-euro"></i>EURO</a></li>
                      <li><a href="#"><i class="fa fa-jpy"></i>YEN</a></li>
                    </ul>
                  </div>
                </div> --}}
                <!-- / currency -->
                <!-- start cellphone -->
                <div class="cellphone hidden-xs">
                  <p><span class="fa fa-phone"></span>XXXXXXXXXXX</p>
                </div>
                <!-- / cellphone -->
              </div>
              <!-- / header top left -->
              <div class="aa-header-top-right">
                <ul class="aa-head-top-nav-right">
                  {{-- <li class="hidden-xs"><a href="javascript:void(0)">Wishlist</a></li> --}}
                  <li class="hidden-xs"><a href="{{url('/cart')}}">My Cart</a></li>
                  @if (session()->has('USER_LOGIN')!=null)
                  <li><a href="{{url('/order')}}">My Orders</a></li>
                  <li><a href="{{url('/logout')}}">Logout</a></li>
                  @else
                  <li><a href="" data-toggle="modal" data-target="#login-modal">Login</a></li>
                  @endif
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- / header top  -->

    <!-- start header bottom  -->
    <div class="aa-header-bottom">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="aa-header-bottom-area">
              <!-- logo  -->
              <div class="aa-logo">
                <!-- Text based logo -->
                <a href="{{url('/')}}">
                  <span class="fa fa-shopping-cart"></span>
                  <p><strong>{{Config::get('constants.SITE_NAME')}}</strong></p>
                  {{-- <img src="{{asset('logo/CakeSewa.png')}}" alt="{{Config::get('constants.SITE_NAME')}}"> --}}
                </a>
                <!-- img based logo -->
                <!-- <a href="index.html"><img src="{{asset('front_assets/img/logo.jpg')}}" alt="logo img"></a> -->
              </div>
              <!-- / logo  -->
               <!-- cart box -->
               @php
                   $getCartItems = getCartItems();
                   $getCartItemsCount = count($getCartItems);
                   $totalPrice = 0;
               @endphp
              <div class="aa-cartbox">
                <a class="aa-cart-link" href="{{url('/cart')}}">
                  <span class="fa fa-shopping-basket"></span>
                  <span class="aa-cart-title">SHOPPING CART</span>
                  <span class="aa-cart-notify">{{$getCartItemsCount}}</span>
                </a>
                <div class="aa-cartbox-summary">
                  @if ($getCartItemsCount>0)
                      <ul>
                        @foreach ($getCartItems as $item)
                        @php
                          $totalPrice = $totalPrice + ($item->qty*$item->price);    
                        @endphp       
                        <li>
                          <a class="aa-cartbox-img" href="#"><img src="{{asset('storage/media/'.$item->image)}}" 
                            alt="{{$item->name}}"></a>
                          <div class="aa-cartbox-info">
                            <h4><a href="#">{{$item->name}}</a></h4>
                            <p>{{$item->qty}}* Rs.{{$item->price}}</p>
                          </div>
                        </li>
                        @endforeach    
                        <li>
                          <span class="aa-cartbox-total-title">
                            Total
                          </span>
                          <span class="aa-cartbox-total-price">
                            Rs.{{$totalPrice}}
                          </span>
                        </li>
                      </ul>
                      <a class="aa-cartbox-checkout aa-primary-btn" href="{{url('/cart')}}">Cart</a>                 
                  @endif
              </div>
              </div>
              <!-- / cart box -->
              <!-- search box -->
              <div class="aa-search-box">
                <form action="">
                  <input type="text"  id="search_str" placeholder="Search Products ">
                  <button type="button" onclick="prodSearch()"><span class="fa fa-search"></span></button>
                </form>
              </div>
              <!-- / search box -->             
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- / header bottom  -->
  </header>
  <!-- / header section -->
  <!-- menu -->
  <section id="menu">
    <div class="container">
      <div class="menu-area">
        <!-- Navbar -->
        <div class="navbar navbar-default" role="navigation">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>          
          </div>
          <div class="navbar-collapse collapse">
            <!-- Left nav -->
           {!! getTopNav() !!}
          </div><!--/.nav-collapse -->
        </div>
      </div>       
    </div>
  </section>
  <!-- / menu -->
    @section('container')
    @show

  <!-- / slider -->
  <!-- footer -->  
  <footer id="aa-footer">
    <!-- footer bottom -->
    <div class="aa-footer-top">
     <div class="container">
        <div class="row">
        <div class="col-md-12">
          <div class="aa-footer-top-area">
            <div class="row">
              <div class="col-md-3 col-sm-6">
                <div class="aa-footer-widget">
                  <h3>Main Menu</h3>
                  <ul class="aa-footer-nav">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Our Services</a></li>
                    <li><a href="#">Our Products</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact Us</a></li>
                  </ul>
                </div>
              </div>
              <div class="col-md-3 col-sm-6">
                <div class="aa-footer-widget">
                  <div class="aa-footer-widget">
                    <h3>Knowledge Base</h3>
                    <ul class="aa-footer-nav">
                      <li><a href="#">Delivery</a></li>
                      <li><a href="#">Returns</a></li>
                      <li><a href="#">Services</a></li>
                      <li><a href="#">Discount</a></li>
                      <li><a href="#">Special Offer</a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6">
                <div class="aa-footer-widget">
                  <div class="aa-footer-widget">
                    <h3>Useful Links</h3>
                    <ul class="aa-footer-nav">
                      <li><a href="#">Site Map</a></li>
                      <li><a href="#">Search</a></li>
                      <li><a href="#">Advanced Search</a></li>
                      <li><a href="#">Suppliers</a></li>
                      <li><a href="#">FAQ</a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6">
                <div class="aa-footer-widget">
                  <div class="aa-footer-widget">
                    <h3>Contact Us</h3>
                    <address>
                      <p> 25 Astor Pl, NY 10003, USA</p>
                      <p><span class="fa fa-phone"></span>+1 212-982-4589</p>
                      <p><span class="fa fa-envelope"></span>dailyshop@gmail.com</p>
                    </address>
                    <div class="aa-footer-social">
                      <a href="#"><span class="fa fa-facebook"></span></a>
                      <a href="#"><span class="fa fa-twitter"></span></a>
                      <a href="#"><span class="fa fa-google-plus"></span></a>
                      <a href="#"><span class="fa fa-youtube"></span></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
     </div>
    </div>
    <!-- footer-bottom -->
    <div class="aa-footer-bottom">
      <div class="container">
        <div class="row">
        <div class="col-md-12">
          <div class="aa-footer-bottom-area">
            <p>Designed by <a href="http://www.markups.io/">MarkUps.io</a></p>
            <div class="aa-footer-payment">
              <span class="fa fa-cc-mastercard"></span>
              <span class="fa fa-cc-visa"></span>
              <span class="fa fa-paypal"></span>
              <span class="fa fa-cc-discover"></span>
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>
  </footer>
  <!-- / footer -->

  <!-- Login Modal -->  
  <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">                      
        <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <div id="popup-login">
            <h4>Login</h4>
            <form class="aa-login-form" action="" id="userLoginForm">
              <label for="">Email<span>*</span></label>
              <input type="text" name="loginEmail" placeholder="Email" value = "{{$loginEmail}}" required>
              <label for="">Password<span>*</span></label>
              <input type="password" name="loginPassword" placeholder="Password" value = "{{$loginPassword}}" required>
              <div class="login_msg"></div>
              <button class="aa-browse-btn" type="submit" id="btnLogin">Login</button>
              <label for="rememberme" class="rememberme"><input type="checkbox" id="rememberme" name="rememberme" {{$is_remember}}> 
                Remember me 
              </label>
              <p class="aa-lost-password"><a href="javascript:void(0)" onclick="forgotPassword()">Lost your password?</a></p>
              <div class="aa-register-now">
                Don't have an account?<a href="{{url('/register')}}">Register now!</a>
              </div>
              @csrf
            </form>
          </div>
          <div id="popup-forgotPassword" style="display: none">
            <h4>Forgot Password</h4>
            <form class="aa-login-form" action="" id="userForgotPassword">
              <label for="">Email<span>*</span></label>
              <input type="text" name="forgotPasswordEmail" placeholder="Email" required>
              <div class="forgot_msg"></div>
              <button class="aa-browse-btn" type="submit" id="btnForgotPassword">Submit</button>
              <br/><br/>
              <div class="aa-register-now">
                <a href="javascript:void(0)" onclick="login()">Login Instead?</a>
              </div>
              @csrf
            </form>
          </div>
        </div>                        
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div>    

  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="{{asset('front_assets/js/bootstrap.js')}}"></script>  
  <!-- SmartMenus jQuery plugin -->
  <script type="text/javascript" src="{{asset('front_assets/js/jquery.smartmenus.js')}}"></script>
  <!-- SmartMenus jQuery Bootstrap Addon -->
  <script type="text/javascript" src="{{asset('front_assets/js/jquery.smartmenus.bootstrap.js')}}"></script>  
  <!-- To Slider JS -->
  <script src="{{asset('front_assets/js/sequence.js')}}"></script>
  <script src="{{asset('front_assets/js/sequence-theme.modern-slide-in.js')}}"></script>  
  <!-- Product view slider -->
  <script type="text/javascript" src="{{asset('front_assets/js/jquery.simpleGallery.js')}}"></script>
  <script type="text/javascript" src="{{asset('front_assets/js/jquery.simpleLens.js')}}"></script>
  <!-- slick slider -->
  <script type="text/javascript" src="{{asset('front_assets/js/slick.js')}}"></script>
  <!-- Price picker slider -->
  <script type="text/javascript" src="{{asset('front_assets/js/nouislider.js')}}"></script>
  <!-- Custom js -->
  <script src="{{asset('front_assets/js/custom.js')}}"></script> 
  <script type="text/javascript">
    $(function(){
        @yield('script')
    });
</script>
{{-- <script type="text/javascript">
  $(window).on('load', function() {
      $('#myModal').modal('show');
  });
</script> --}}
  </body>
</html>