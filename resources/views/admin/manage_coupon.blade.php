@extends('admin/layout')
@section('title','Manage Coupon')
@section('coupon_select','active')
@section('container')
<h1 class="mb20">Add Coupon</h1>
<a href="{{url('admin/coupon')}}">
    <button type="button" class="btn btn-success">Back</button>
</a>
<div class="row m-t-30">
    <div class="col-md-12">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('coupon.manage_coupon_process')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="title" class="control-label mb-1">Title</label>
                                    <input id="title"  value = "{{$title}}" name="title" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                    @error('title')
                                        <div class="alert alert-danger">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="code" class="control-label mb-1">Code</label>
                                    <input id="code"  value = "{{$code}}" name="code" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                    @error('code')
                                        <div class="alert alert-danger">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="value" class="control-label mb-1">Value</label>
                                    <input id="value" name="value" value = "{{$value}}"  type="text" class="form-control cc-name valid" required/>
                                    @error('value')
                                    <div class="alert alert-danger">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="type" class="control-label mb-1">Type</label>
                                    <select name="type" id="type" class="form-control" required>
                                        @if($type=='val')
                                            <option value="val" selected>Value</option>
                                            <option value="per">Percentage</option>
                                        @elseif($type == 'per')
                                            <option value="val">Value</option>
                                            <option value="per" selected>Percentage</option>
                                        @else
                                        <option value="val">Value</option>
                                        <option value="per">Percentage</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="min_order_amt" class="control-label mb-1">Minimum Order Amount</label>
                                    <input id="min_order_amt"  value = "{{$min_order_amt}}" name="min_order_amount" type="text" class="form-control" aria-required="true" aria-invalid="false">
                                    @error('min_order_amount')
                                        <div class="alert alert-danger">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="is_one_time" class="control-label mb-1">Is one time?</label>
                                    <select name="is_one_time" id="is_one_time" class="form-control" required>
                                        @if($is_one_time=='1')
                                            <option value="1" selected>Yes</option>
                                            <option value="0">No</option>
                                        @else
                                            <option value="1">Yes</option>
                                            <option value="0" selected>No</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                               Submit
                            </button>
                        </div>
                        <input type="hidden" name="id" value="{{$id}}">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
