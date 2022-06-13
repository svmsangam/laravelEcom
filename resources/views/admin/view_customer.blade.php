@extends('admin/layout')
@section('title','View Customer')
@section('customer_select','active')
@section('container')
  <h1>View Customer</h1>  
{{-- <a href="{{url('admin/user/manage_user')}}" class="mb20">
    <button type="button" class="btn btn-success">Users</button>
</a> --}}
<div class="row m-t-30">
    <div class="offset-md-3 col-md-6">
        <!-- DATA TABLE-->
        <div class="table-responsive m-b-40">
            <table class="table table-borderless table-data3">
                <tbody>
                    <tr>
                        <td class="font-weight-bold">Name</td>
                        <td class="text-left font-weight-normal">{{$customer_details->name}}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Email</td>
                        <td class="text-left font-weight-normal">{{$customer_details->email}}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Phone</td>
                        <td class="text-left font-weight-normal">{{$customer_details->mobile}}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Address</td>
                        <td class="text-left font-weight-normal">{{$customer_details->address}}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">City</td>
                        <td class="text-left font-weight-normal">{{$customer_details->city}}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Status</td>
                            @if($customer_details->name == '0')
                                <td class="text-left font-weight-normal">Deactive</td>
                            @else
                                <td class="text-left font-weight-normal">Deactive</td>
                            @endif    
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Created On</td>
                        <td class="text-left font-weight-normal">
                            {{\Carbon\Carbon::parse($customer_details->created_at)->format('d-m-Y h:i:s')}}
                        </td>
                    </tr>
                </tbody>  
            </table>
        </div>
        <!-- END DATA TABLE-->
    </div>
</div>
@endsection