/** 
  * Template Name: Daily Shop
  * Version: 1.0  
  * Template Scripts
  * Author: MarkUps
  * Author URI: http://www.markups.io/

  Custom JS
  

  1. CARTBOX
  2. TOOLTIP
  3. PRODUCT VIEW SLIDER 
  4. POPULAR PRODUCT SLIDER (SLICK SLIDER) 
  5. FEATURED PRODUCT SLIDER (SLICK SLIDER)
  6. LATEST PRODUCT SLIDER (SLICK SLIDER) 
  7. TESTIMONIAL SLIDER (SLICK SLIDER)
  8. CLIENT BRAND SLIDER (SLICK SLIDER)
  9. PRICE SLIDER  (noUiSlider SLIDER)
  10. SCROLL TOP BUTTON
  11. PRELOADER
  12. GRID AND LIST LAYOUT CHANGER 
  13. RELATED ITEM SLIDER (SLICK SLIDER)

  
**/

jQuery(function($){


  /* ----------------------------------------------------------- */
  /*  1. CARTBOX 
  /* ----------------------------------------------------------- */
    
     jQuery(".aa-cartbox").hover(function(){
      jQuery(this).find(".aa-cartbox-summary").fadeIn(500);
    }
      ,function(){
          jQuery(this).find(".aa-cartbox-summary").fadeOut(500);
      }
     );   
  
  /* ----------------------------------------------------------- */
  /*  2. TOOLTIP
  /* ----------------------------------------------------------- */    
    jQuery('[data-toggle="tooltip"]').tooltip();
    jQuery('[data-toggle2="tooltip"]').tooltip();

  /* ----------------------------------------------------------- */
  /*  3. PRODUCT VIEW SLIDER 
  /* ----------------------------------------------------------- */    

    jQuery('#demo-1 .simpleLens-thumbnails-container img').simpleGallery({
        loading_image: 'demo/images/loading.gif'
    });

    jQuery('#demo-1 .simpleLens-big-image').simpleLens({
        loading_image: 'demo/images/loading.gif'
    });

  /* ----------------------------------------------------------- */
  /*  4. POPULAR PRODUCT SLIDER (SLICK SLIDER)
  /* ----------------------------------------------------------- */      

    jQuery('.aa-popular-slider').slick({
      dots: false,
      infinite: false,
      speed: 300,
      slidesToShow: 4,
      slidesToScroll: 4,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            infinite: true,
            dots: true
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
      ]
    }); 

  
  /* ----------------------------------------------------------- */
  /*  5. FEATURED PRODUCT SLIDER (SLICK SLIDER)
  /* ----------------------------------------------------------- */      

    jQuery('.aa-featured-slider').slick({
        dots: false,
        infinite: false,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 4,
        responsive: [
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 3,
              infinite: true,
              dots: true
            }
          },
          {
            breakpoint: 600,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2
            }
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }
          // You can unslick at a given breakpoint now by adding:
          // settings: "unslick"
          // instead of a settings object
        ]
    });
    
  /* ----------------------------------------------------------- */
  /*  6. LATEST PRODUCT SLIDER (SLICK SLIDER)
  /* ----------------------------------------------------------- */      
    jQuery('.aa-latest-slider').slick({
        dots: false,
        infinite: false,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 4,
        responsive: [
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 3,
              infinite: true,
              dots: true
            }
          },
          {
            breakpoint: 600,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2
            }
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }
          // You can unslick at a given breakpoint now by adding:
          // settings: "unslick"
          // instead of a settings object
        ]
    });

  /* ----------------------------------------------------------- */
  /*  7. TESTIMONIAL SLIDER (SLICK SLIDER)
  /* ----------------------------------------------------------- */     
    
    jQuery('.aa-testimonial-slider').slick({
      dots: true,
      infinite: true,
      arrows: false,
      speed: 300,
      slidesToShow: 1,
      adaptiveHeight: true
    });

  /* ----------------------------------------------------------- */
  /*  8. CLIENT BRAND SLIDER (SLICK SLIDER)
  /* ----------------------------------------------------------- */  

    jQuery('.aa-client-brand-slider').slick({
        dots: false,
        infinite: false,
        speed: 300,
        autoplay: true,
        autoplaySpeed: 2000,
        slidesToShow: 5,
        slidesToScroll: 1,
        responsive: [
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 4,
              slidesToScroll: 4,
              infinite: true,
              dots: true
            }
          },
          {
            breakpoint: 600,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2
            }
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }
          // You can unslick at a given breakpoint now by adding:
          // settings: "unslick"
          // instead of a settings object
        ]
    });

  /* ----------------------------------------------------------- */
  /*  9. PRICE SLIDER  (noUiSlider SLIDER)
  /* ----------------------------------------------------------- */        

    jQuery(function(){
      if($('body').is('.productPage')){
       var skipSlider = document.getElementById('skipstep');
       var filter_price_start = jQuery('#filter_price_min').val();
       var filter_price_end = jQuery('#filter_price_max').val();
       if(filter_price_start == '' || filter_price_end == ''){
          filter_price_start = 100;
          filter_price_end = 1000;
       }
        noUiSlider.create(skipSlider, {
            range: {
                'min': 0,
                '10%': 100,
                '20%': 400,
                '30%': 700,
                '40%': 1000,
                '50%': 1300,
                '60%': 1600,
                '70%': 1900,
                '80%': 2200,
                '90%': 2500,
                'max': 2700
            },
            snap: true,
            connect: true,
            start: [filter_price_start, filter_price_end]
        });
        // for value print
        var skipValues = [
          document.getElementById('skip-value-lower'),
          document.getElementById('skip-value-upper')
        ];

        skipSlider.noUiSlider.on('update', function( values, handle ) {
          skipValues[handle].innerHTML = values[handle];
        });
      }
    });


    
  /* ----------------------------------------------------------- */
  /*  10. SCROLL TOP BUTTON
  /* ----------------------------------------------------------- */

  //Check to see if the window is top if not then display button

    jQuery(window).scroll(function(){
      if ($(this).scrollTop() > 300) {
        $('.scrollToTop').fadeIn();
      } else {
        $('.scrollToTop').fadeOut();
      }
    });
     
    //Click event to scroll to top

    jQuery('.scrollToTop').click(function(){
      $('html, body').animate({scrollTop : 0},800);
      return false;
    });
  
  /* ----------------------------------------------------------- */
  /*  11. PRELOADER
  /* ----------------------------------------------------------- */

    jQuery(window).load(function() { // makes sure the whole site is loaded      
      jQuery('#wpf-loader-two').delay(200).fadeOut('slow'); // will fade out      
    })

  /* ----------------------------------------------------------- */
  /*  12. GRID AND LIST LAYOUT CHANGER 
  /* ----------------------------------------------------------- */

  jQuery("#list-catg").click(function(e){
    e.preventDefault(e);
    jQuery(".aa-product-catg").addClass("list");
  });
  jQuery("#grid-catg").click(function(e){
    e.preventDefault(e);
    jQuery(".aa-product-catg").removeClass("list");
  });


  /* ----------------------------------------------------------- */
  /*  13. RELATED ITEM SLIDER (SLICK SLIDER)
  /* ----------------------------------------------------------- */      

    jQuery('.aa-related-item-slider').slick({
      dots: false,
      infinite: false,
      speed: 300,
      slidesToShow: 4,
      slidesToScroll: 4,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            infinite: true,
            dots: true
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
      ]
    }); 
    
});
function showColor(size){
  jQuery('#size_id').val(size);
  jQuery('.product_color').hide();
  jQuery('.size_'+size).show();
  jQuery('.size_link').css('border','1px solid #ddd');
  jQuery('#size_'+size).css('border','1px solid black');
}
// function setSingleSize(size){
//   jQuery('#size_id').val(size);
// }
function add_to_home_cart(product_id, size){
  jQuery('#product_id').val(product_id);
  jQuery('#size_id').val(size);
  add_to_cart(product_id,size);
}
function add_to_cart(id,size_str){
  size_str = size_str || jQuery('#size_id').val(); 
  jQuery('#atc_message').html('');
  var size_id = size_str;
  if(size_id === ''){
    jQuery('#atc_message').html('<div class="alert alert-danger" role="alert">Please select size.</div>');
  }else{
    jQuery('#product_id').val(id);
    jQuery('#productQty').val(jQuery('#qty').val());
     jQuery.ajax({
        url:'/add_to_cart',
        data:jQuery("#addToCartForm").serialize(),
        type:'post',
        success:function(result){
          var totalPrice=0;
  
          if(result.msg=='not_avaliable'){
            alert(result.data);
          }else{
            alert("Product "+result.msg);
            if(result.totalItemCount==0){
              jQuery('.aa-cart-notify').html('0'); 
              jQuery('.aa-cartbox-summary').remove();
           }else{    
             jQuery('.aa-cart-notify').html(result.totalItemCount); 
             var html='<ul>';
             jQuery.each(result.data, function(arrKey,arrVal){
               totalPrice=parseInt(totalPrice)+(parseInt(arrVal.qty)*parseInt(arrVal.price));
               html+='<li><a class="aa-cartbox-img" href="#"><img src="'+PRODUCT_IMAGE+'/'+arrVal.image+'" alt="img"></a><div class="aa-cartbox-info"><h4><a href="#">'+arrVal.name+'</a></h4><p> '+arrVal.qty+' * Rs  '+arrVal.price+'</p></div></li>';
             });
            
           }
           html+='<li><span class="aa-cartbox-total-title">Total</span><span class="aa-cartbox-total-price">Rs '+totalPrice+'</span></li>';
           html+='</ul><a class="aa-cartbox-checkout aa-primary-btn" href="cart">Cart</a>';
           jQuery('.aa-cartbox-summary').html(html);
          }
        }
     });
  }
}
function updateQty(pid,size,attr_id,price){
  jQuery('#size_id').val(size);
  var qty = jQuery('#qty'+attr_id).val();
  jQuery('#qty').val(qty);
  add_to_cart(pid,size);
  jQuery('#total_price_'+attr_id).html(qty*price);
}
function deleteCartItem(pid,size,attr_id){
  jQuery('#size_id').val(size);
  // var qty = jQuery('#qty'+attr_id).val();
  jQuery('#qty').val(0);
  add_to_cart(pid,size);
  jQuery('#cart_item_'+attr_id).remove(); 
}
function sortProducts(){
  var sort_by_val= jQuery('#sort_by').val();
  jQuery('#sort').val(sort_by_val);
  jQuery('#categoryFilter').submit();
}
function filter_price(){
  
  jQuery('#filter_price_min').val(jQuery('#skip-value-lower').html());
  jQuery('#filter_price_max').val(jQuery('#skip-value-upper').html());
  jQuery('#categoryFilter').submit();

}
function prodSearch(){
  var search_str = jQuery('#search_str').val();
  if(search_str !='' && search_str.length>3){
    window.location.href = '/search/'+search_str;
  }
}
jQuery('#userRegisterForm').submit(function (e){
  e.preventDefault();
  jQuery('.field_error').html('');
  jQuery.ajax({
      url:'user_register_process',
      data:jQuery('#userRegisterForm').serialize(),
      type:'post',
      success:function(result){
        if(result.status == "error"){
          jQuery.each(result.error , function(key,val){
              jQuery('#'+key+'_error').html(val);
          });
        }
        if(result.status == "success"){
            jQuery('#userRegisterForm')[0].reset();
            jQuery('.registerSuccess').html(result.msg);
        }
      }
  });
});
jQuery('#userLoginForm').submit(function (e){
  e.preventDefault();
  jQuery('.login_msg').html('');
  jQuery.ajax({
      url:'/user_login_process',
      data:jQuery('#userLoginForm').serialize(),
      type:'post',
      success:function(result){
        if(result.status == "error"){
          jQuery('.login_msg').html(result.msg);
        }
        if(result.status == "success"){
          window.location.href =  window.location.href;
        }
      }
  });
});
function forgotPassword(){
  jQuery('#popup-forgotPassword').css('display','block');
  jQuery('#popup-login').hide();
}
function login(){
  jQuery('#popup-forgotPassword').hide();
  jQuery('#popup-login').show();
}
jQuery('#userForgotPassword').submit(function (e){
  e.preventDefault();
  jQuery('.forgot_msg').html('');
  jQuery.ajax({
      url:'/user_forgot_password_process',
      data:jQuery('#userForgotPassword').serialize(),
      type:'post',
      success:function(result){
        if(result.status != ""){
          jQuery('.forgot_msg').html(result.msg);
        }
      }
  });
});
jQuery('#userUpdatePassword').submit(function (e){
  e.preventDefault();
  jQuery('.passwordUpdate').html('');
  jQuery.ajax({
      url:'/user_reset_password_process',
      data:jQuery('#userUpdatePassword').serialize(),
      type:'post',
      success:function(result){
        if(result.status != ""){
          jQuery('#userUpdatePassword')[0].reset();
          jQuery('.passwordUpdate').html(result.msg);
        }
      }
  });
});
function applyCouponCode(){
  jQuery('#coupon_code_msg').html('');
  jQuery('#order_place_msg').html('');
  var coupon_code = jQuery('#coupon_code').val();

  if(coupon_code!=''){
    jQuery.ajax({
      type:'post',
      url:'/apply_coupon_code',
      data:'coupon_code='+coupon_code+'&_token='+jQuery("[name='_token']").val(),
      success:function(res){
        if(res.status == 'success'){
          jQuery('.apply_coupon_code_box').hide();
          jQuery('#coupon_code_msg').css('color','#a5d549');
          jQuery('.show_coupon_box').removeClass('hide');
          jQuery('#coupon_code_str').html(coupon_code);
          jQuery('#total_price').html('NPR '+res.totalPrice)
          jQuery('#coupon_code_msg').html(res.msg);
        }else{
          jQuery('#coupon_code_msg').css('color','#ff6666');
          jQuery('#coupon_code_msg').html(res.msg);
        }
      }
    })
  }else{
    jQuery('#coupon_code_msg').html('Please eneter a coupon code');
  }
}
function removeCouponCode(){
  jQuery('#coupon_code_msg').html('');
  var coupon_code = jQuery('#coupon_code').val();
  if(coupon_code!=''){
    jQuery.ajax({
      type:'post',
      url:'/remove_coupon_code',
      data:'coupon_code='+coupon_code+'&_token='+jQuery("[name='_token']").val(),
      success:function(res){
        if(res.status == 'success'){
          jQuery('#coupon_code').val('');
          jQuery('.apply_coupon_code_box').show();
          jQuery('#coupon_code_msg').css('color','#a5d549');
          jQuery('.show_coupon_box').addClass('hide');
          jQuery('#coupon_code_str').html('');
          jQuery('#total_price').html('NPR '+res.totalPrice)
          jQuery('#coupon_code_msg').html(res.msg);
        }else{
          jQuery('#coupon_code_msg').css('color','#ff6666');
          jQuery('#coupon_code_msg').html(res.msg);
          jQuery('#coupon_code').val('');
        }
      }
    });
  }
}
jQuery('#frmPlaceOrder').submit(function (e){
  e.preventDefault();
  jQuery('#order_place_msg').html("Please wait...")
  var payment_type = jQuery('input[name=payment_type]:checked', '#frmPlaceOrder').val(); 
  jQuery.ajax({
      url:'/place_order',
      data:jQuery('#frmPlaceOrder').serialize(),
      type:'post',
      success:function(result){
          if(result.status == "success"){
              window.location.href = "/order_placed";
              jQuery('#order_place_msg').html(result.msg);
          }
          if(result.status == "error"){
            jQuery('#order_place_msg').html(result.msg);
          }
         if(result.status == "khalti"){
          pay_with_khalti(result.totalAmt,result.order_details);
         }
        }
      
  });
});
function pay_with_khalti(totalAmt,order_details){
  var config = {
      // replace the publicKey with yours
      "publicKey": "test_public_key_30c12c3272744045b36db2c0c3321e21",
      "productIdentity": "1234567890",
      "productName": "Dragon",
      "productUrl": "http://gameofthrones.wikia.com/wiki/Dragons",
      "paymentPreference": [
          "KHALTI",
          ],
      "eventHandler": {
          onSuccess (payload) {
              //hit merchant api for initiating verfication
              jQuery.ajax({
                type:'POST',
                url:'/khalti/payment/verify',
                data:{
                  token: payload.token,
                  amount: payload.amount,
                  payment_id: payload.idx,
                  mobile: payload.mobile, 
                  order_info:order_details,
                  '_token':jQuery("[name='_token']").val()
                },
                success:function(result){
                  if(result.status == "success"){
                      // window.location.href = "/order_placed";
                      jQuery('#order_place_msg').html(result.msg);
                      jQuery.ajax({
                        type:'POST',
                          url:'/khalti/store/payment',
                          data:{
                            payment_id: payload.idx,
                            order_info:order_details,
                            '_token':jQuery("[name='_token']").val()
                          },
                          success:function(result){
                            if(result.status == "success"){
                                window.location.href = "/order_placed";
                                
                            }
                          }
                      });
                  }
                 if(result.status == "error"){
                  jQuery('#order_place_msg').html(result.msg);
                 }
                }
              });
              // console.log(order_details);
              // console.log(payload);
          },
          onError (error) {
              console.log(error);
          },
          onClose () {
              console.log('widget is closing');
          }
      }
  };

  var checkout = new KhaltiCheckout(config);
  checkout.show({amount: (totalAmt*100)});
}