@extends('admin/layout')
@section('title','Manage Banner')
@section('banner_select','active')
@section('container')
<h1 class="mb20">Add Banner</h1>
<a href="{{url('admin/banner')}}">
    <button type="button" class="btn btn-success">Back</button>
</a>
<div class="row m-t-30">
    <div class="col-md-12">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('banner.manage_banner_process')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="btn_text" class="control-label mb-1">Button Text</label>
                                    <input id="btn_text"  value = "{{$btn_text}}" name="btn_text" type="text" class="form-control" aria-required="true" aria-invalid="false">
                                    @error('btn_text')
                                        <div class="alert alert-danger">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="btn_link" class="control-label mb-1">Banner Link</label>
                                    <input id="btn_link" name="btn_link" value = "{{$btn_link}}"  type="text" class="form-control cc-name valid"/>
                                    @error('btn_link')
                                    <div class="alert alert-danger">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <label for="image" class="control-label mb-1">Image</label>
                                    <input id="image" name="image"  type="file" class="form-control cc-name valid"/>
                                    <div class="mt-2">
                                        @if($image !='')
                                        <img width="100px" src="{{asset('storage/media/banners/'.$image )}}" alt="{{$btn_text}}"/>
                                        @endif
                                    </div>
                                    @error('image')
                                        <div class="alert alert-danger">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                {{-- <div class="col-md-4">
                                    <div class="form-group has-success">
                                        <div class="form-check form-switch mt-5">
                                            <input class="form-check-input" type="checkbox" name="showOnHome" id="showOnHome" {{$checkHome}}>
                                            <label class="form-check-label" for="hasEgg">Show on Home?</label>
                                        </div>
                                    </div>
                                </div> --}}
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
    