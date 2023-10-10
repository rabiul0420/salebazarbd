<form class="form-horizontal" action="{{ route('sellers.slug.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="myModalLabel">{{__('Shop Url Edit')}}</h4>
    </div>

    <div class="modal-body">
       

            <input type="hidden" id="sid" name="shop_id" value="{{ $seller->id }}">
            <div class="form-group">
                <label class="col-sm-3 control-label" for="amount">{{__('URL')}}</label>
                <div class="col-sm-9">
                    <input id="sample_search" name="slug" value="{{ $seller->slug }}" class="form-control" required>
                    <span class="snotice" style="display: none;">Already exist please try another</span>
                </div>
            </div>

           
    </div>
    <div class="modal-footer">
        <div class="panel-footer text-right">
                <button class="btn btn-purple" id="shopb" type="submit">{{__('Submit')}}</button>
            <button class="btn btn-default" data-dismiss="modal">{{__('Cancel')}}</button>
        </div>
    </div>
</form>
<script>
var searchRequest = null;

$(function () {
    var minlength = 3;

    $("#sample_search").keyup(function () {
        var that = this,
        value = $(this).val();

        if (value.length >= minlength ) {
            if (searchRequest != null) 
                searchRequest.abort();
            searchRequest = $.ajax({
                type: "POST",
                url: "{{ route('shop_url.check') }}",
                data: {
                    'search_keyword' : value,
                    _token: '{{csrf_token()}}'
                },
                dataType: "text",
                success: function(data){
                    // alert(data);
                    //we need to check if the value is the same
                    if (data==0) {
                    //Receiving the result of search here
                    $(".snotice").css({"color":"red","display":"none"});
                        
                        $('#shopb').prop('disabled', false);
                    }
                    else{
                        $(".snotice").css({"color":"red","display":"block"});
                        $("#sample_search").css({"border-color":"#e62e04"});
                        $('#shopb').prop('disabled', true);
                    }
                }
            });
        }
    });
});
</script>
