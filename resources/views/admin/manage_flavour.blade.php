@extends('admin/layout')
@section('title','Manage Flavour')
@section('flavour_select','active')
@section('container')
<h1 class="mb20">Add Flavour</h1>
<a href="{{url('admin/flavour')}}">
    <button type="button" class="btn btn-success">Back</button>
</a>
<div class="row m-t-30">
    <div class="col-md-12">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('flavour.manage_flavour_process')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="flavour" class="control-label mb-1">Flavour</label>
                            <input id="flavour"  value = "{{$flavour}}" name="flavour" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                            @error('flavour')
                                <div class="alert alert-danger">
                                    {{$message}}
                                </div>
                            @enderror
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
    