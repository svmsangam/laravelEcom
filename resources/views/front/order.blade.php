@extends('front/layout')
@section('page_title','Order')
@section('container')

<!-- catg header banner section -->
<section id="aa-catg-head-banner">
   <div class="aa-catg-head-banner-area">
     <div class="container">
      
     </div>
   </div>
  </section>
  <!-- / catg header banner section -->         

  <section id="cart-view">
   <div class="container">
     <div class="row">
       <div class="col-md-12">
         <div class="cart-view-area">
           <div class="cart-view-table">
             <form action="">          
               <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Order Id</th>
                        <th>Order Status</th>
                        <th>Payment Status</th>
                        <th>Total Amt</th>
                        <th>Payment ID</th>
                        <th>Placed At</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $list)
                        <tr>
                          <td>{{$list->id}}</td>
                          <td>{{$list->status}}</td>
                          <td>{{$list->payment_status}}</td>
                          <td>{{$list->total_amt}}</td>
                          @if($list->payment_id == 0)
                          <td>-</td>
                          @else
                          <td>{{$list->payment_id}}</td>
                          @endif
                          <td>{{$list->added_on}}</td>
                          <td class="order_id_btn"><a href="{{url('order_detail')}}/{{$list->id}}">View Details</a></td>
                        </tr>
                        @endforeach
                      </tbody>
                  </table>
                </div>
             </form>
             <!-- Cart Total view -->          
		   </div>
         </div>
       </div>
     </div>
   </div>
 </section> 
@endsection