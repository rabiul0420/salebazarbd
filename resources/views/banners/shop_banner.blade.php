@extends('layouts.app')

@section('content')

<div class="col-lg-6 col-lg-offset-3">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Shop Defult banner')}}</h3>
        </div>

    <!--Horizontal Form-->
    <!--===================================================-->
    <form class="form-horizontal" action="{{ route('shop_default_slider_post',$seller->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="panel-body">
            
            {{-- <div class="form-group">
                <label class="col-sm-3" for="url">{{__('Banner Position')}}</label>
                <div class="col-sm-9">
                    <select class="form-control demo-select2" name="position" required>
                        <option value="1">{{__('Banner Position 1')}}</option>
                        <option value="2">{{__('Banner Position 2')}}</option>
                    </select>
                </div>
            </div> --}}
            <div class="form-group">
                <div class="col-sm-3">
                    <label class="control-label">{{__('Banner Images')}}</label>
                    <strong>(1400px*400px)</strong>
                </div>
                <div class="col-sm-9">
                    @if ($seller->position == '100')
                        <div class="col-md-4 col-sm-9 col-xs-6">
                            <div class="img-upload-preview">
                                <img loading="lazy"  src="{{ asset($seller->photo) }}" alt="" class="img-responsive">
                                <input type="hidden" name="previous_photo" value="{{ $seller->photo }}">
                                <button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                    @endif
                    <div id="photo">

                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer text-right">
            <button class="btn btn-purple" type="submit">{{__('Save')}}</button>
        </div>
    </form>
    <!--===================================================-->
    <!--End Horizontal Form-->

</div>
</div>
@endsection

@section('script')
<script type="text/javascript">

    $(document).ready(function(){
        $('.remove-files').on('click', function(){
            $(this).parents(".col-md-4").remove();
        });
        $('.demo-select2').select2();

        $("#photo").spartanMultiImagePicker({
            fieldName:        'photo',
            maxCount:         1,
            rowHeight:        '200px',
            groupClassName:   'col-md-4 col-sm-3 col-xs-6',
            maxFileSize:      '',
            dropFileLabel : "Drop Here",
            onExtensionErr : function(index, file){
                console.log(index, file,  'extension err');
                alert('Please only input png or jpg type file')
            },
            onSizeErr : function(index, file){
                console.log(index, file,  'file size too big');
                alert('File size too big');
            }
        });
    });

</script>
@endsection