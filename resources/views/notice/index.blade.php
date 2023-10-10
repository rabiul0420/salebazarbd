@extends('layouts.app')

@section('content')
<?php //echo "<pre>"; print_r($notice); echo $notice->title; ?>
<div class="col-sm-12">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Send Notice')}}</h3>
        </div>
        <!--Horizontal Form-->
        <!--===================================================-->
        <form class="form-horizontal" action="{{route('notices.send')}}" method="POST" enctype="multipart/form-data">
        	@csrf
            <div class="panel-body">
               
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="title">{{__('Title')}}</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="title" id="notice_title" value="{{$notice->title}}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">{{__(' Content')}}</label>
                    <div class="col-sm-10">
                            <textarea class="editor" id="notice_content" name="content"  required>{{$notice->content}}</textarea>
                    </div>
                </div>
               <div class="form-group">
                      <label class="col-sm-2 control-label" for="name">{{__('Published')}}</label>
                    <div class="col-sm-10">
                    <label class="switch">
                        
                        <input type="checkbox" name="show_hide" @if($notice->notice_show == "1") checked @endif>
                        <span class="slider round"></span>
                    </label>
                    </div>
                </div>
                <div class="form-group">
                      <label class="col-sm-2 control-label" for="name">{{__('Show for Customer')}}</label>
                    <div class="col-sm-10">
                    <label class="switch">
                        
                        <input type="checkbox" name="only_customer" @if($notice->only_customer == "1") checked @endif>
                        <span class="slider round"></span>
                    </label>
                    </div>
                </div>
                <div class="form-group">
                      <label class="col-sm-2 control-label" for="name">{{__('Show for Seller')}}</label>
                    <div class="col-sm-10">
                    <label class="switch">
                        
                        <input type="checkbox" name="only_seller" @if($notice->only_seller  == "1") checked @endif>
                        <span class="slider round"></span>
                    </label>
                    </div>
                </div>
            </div>
            <div class="panel-footer text-right">
                <button class="btn btn-purple" type="submit">{{__('Send')}}</button>
            </div>
        </form>
        <!--===================================================-->
        <!--End Horizontal Form-->

    </div>
</div>

@endsection
