@extends('layouts.app')
@section('styles')
<style>
    .c-rating > label {
        color: #d9dbdc;
        float: right;
        margin-bottom: 0;
    }
    
    .c-rating > label:before {
        margin: 0 2px;
        font-size: 16px;
        font-family: FontAwesome;
        content: "\f005";
        display: inline-block;
    }
    
    .c-rating > input {
        display: none;
    }
    
    .c-rating > input:checked ~ label,
    .c-rating:not(:checked) > label:hover,
    .c-rating:not(:checked) > label:hover ~ label {
        color: #ffcc00;
    }
    
    .c-rating > input:checked + label:hover,
    .c-rating > input:checked ~ label:hover,
    .c-rating > label:hover ~ input:checked ~ label,
    .c-rating > input:checked ~ label:hover ~ label {
        color: #ffcc00;
    }
</style>
@endsection
@section('content')

<div class="col-lg-6 col-lg-offset-3">
    <form class="form-horizontal" action="{{ route('reviews.update', $review->id) }}" method="POST" enctype="multipart/form-data">
        <input name="_method" type="hidden" value="PATCH">
    	@csrf
        <div class="panel">
            <div class="panel-heading bord-btm">
                <h3 class="panel-title">{{__('Product Review Information')}}</h3>
            </div>
            <div class="panel-body">
                
                <div class="form-group">
                    <label class="col-12 control-label">Rating</label>
                    <div class="col-sm-12">
                        <div class="c-rating mt-1 mb-1 clearfix d-inline-block" style="float:left;">
                            <input type="radio" id="star5" name="rating" value="5" {{ $review->rating == 5 ? 'checked' : '' }} required/>
                            <label class="star" for="star5" title="Awesome" aria-hidden="true"></label>
                            <input type="radio" id="star4" name="rating" value="4" {{ $review->rating == 4 ? 'checked' : '' }} required/>
                            <label class="star" for="star4" title="Great" aria-hidden="true"></label>
                            <input type="radio" id="star3" name="rating" value="3" {{ $review->rating == 3 ? 'checked' : '' }} required/>
                            <label class="star" for="star3" title="Very good" aria-hidden="true"></label>
                            <input type="radio" id="star2" name="rating" value="2" {{ $review->rating == 2 ? 'checked' : '' }} required/>
                            <label class="star" for="star2" title="Good" aria-hidden="true"></label>
                            <input type="radio" id="star1" name="rating" value="1" {{ $review->rating == 1 ? 'checked' : '' }} required/>
                            <label class="star" for="star1" title="Bad" aria-hidden="true"></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-12 control-label">Comment</label>
                    <div class="col-sm-12">
                        <textarea class="form-control" rows="4" name="comment" placeholder="{{__('Your review')}}" required>{{ $review->comment }}</textarea>
                    </div>
                </div>
            </div>
            <div class="panel-footer text-right">
                <button class="btn btn-info" type="submit">{{__('Save')}}</button>
            </div>
        </div>
    </form>
</div>

@endsection
