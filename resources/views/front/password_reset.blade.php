@extends('front.layout')
@section('title','Password Reset') 
@section('container')
<section id="aa-myaccount">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
         <div class="aa-myaccount-area">         
             <div class="row">
               <div class="col-md-6">
                 <div class="aa-myaccount-register">                 
                  <h4>Reset Password</h4>
                  <form action="" class="aa-login-form" id="userUpdatePassword">
                    <div class="passwordUpdate"></div>
                     <label for="">Password<span>*</span></label>
                     <input type="password" name="passwordReset" placeholder="Password" required>
                     <div id="password_error" class="field_error"></div>
                     <button id="btnUpdatePassword" type="submit" class="aa-browse-btn">Update Password</button>
                     @csrf                    
                   </form>
                 </div>
               </div>
             </div>          
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection