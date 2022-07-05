@extends('front.layout')
@section('title','Register') 
@section('container')
<section id="aa-myaccount">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
         <div class="aa-myaccount-area">         
             <div class="row">
               <div class="col-md-6">
                 <div class="aa-myaccount-register">                 
                  <h4>Register</h4>
                  <form action="" class="aa-login-form" id="userRegisterForm">
                    <div class="registerSuccess field_error"></div>
                     <label for="">Name<span>*</span></label>
                     <input type="text" name="name" placeholder="Name" required>
                     <div id="name_error" class="field_error"></div>
                     <label for="">Email address<span>*</span></label>
                     <input type="email" name="email" placeholder="xyz@gmail.com" required>
                     <div id="email_error" class="field_error"></div>
                     <label for="">Mobile<span>*</span></label>
                     <input type="text" name="mobile" placeholder="98XXXXXXXX" required>
                     <div id="mobile_error" class="field_error"></div>
                     <label for="">Password<span>*</span></label>
                     <input type="password" name="password" placeholder="Password" required>
                     <div id="password_error" class="field_error"></div>
                     <label for="">Confirm Password<span>*</span></label>
                     <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                     <button id="btnUserRegister" type="submit" class="aa-browse-btn">Register</button>
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