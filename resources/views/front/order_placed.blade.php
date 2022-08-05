@extends('front/layout')
@section('title','Order Placed')
@section('container')
 
   <!-- product category -->
   <section id="aa-product-details">
     <div class="container">
       <div class="row" style="text-align: center">
        <br/><br/>
            <h2>Your order has been placed. Order ID: {{session()->get('ORDER_ID')}}</h2>
        <br/><br/>    
       </div>
     </div>
   </section>
   <!-- / product category -->
@endsection