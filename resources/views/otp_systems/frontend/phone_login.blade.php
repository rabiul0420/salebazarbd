@extends('frontend.layouts.app')

@section('content')
    <section class="gry-bg py-4">
        <div class="profile">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="card">
                            <div class="text-center px-35 pt-5">
                                <h3 class="heading heading-4 strong-500">
                                    {{__('Phone Verification')}}
                                </h3>
                                <p>We've sent a 6-digit one time PIN in your phone {{ $user->phone}}</p>
                                <input type="hidden" id="phone" value="{{$user->id}}" name="">
                                <a class="resend-code" href="#">{{__('Resend Code')}}</a>
                            </div>
                            <div class="px-5 py-lg-5">
                                <div class="row align-items-center">
                                    <div class="col-12 col-lg">
                                        <form class="form-default" role="form" action="{{ route('login.verification.submit') }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <!-- <label>{{ __('name') }}</label> -->
                                                <div class="input-group input-group--style-1">
                                                    <input placeholder="Please enter 6-digit one time pin" type="text" class="form-control" name="verification_code">
                                                    <span class="input-group-addon">
                                                        <i class="text-md la la-key"></i>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="row align-items-center">
                                                <div class="col-12 text-right">
                                                    <button type="submit" class="btn btn-styled btn-base-1 w-100 btn-md">{{ __('Enter') }}</button>


                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
        $('.resend-code').click(function(e) {
            e.preventDefault();
            var input = $("#phone").val();
            var url = '{{ route('phone.code.resend') }}';

        $.post(url, {_token:'{{ csrf_token() }}', status:input, _method:'POST'}, function(data){
            if(data == 1){
                showAlert('success', 'Resend success');
            }
            else{
                showAlert('danger', 'Something went wrong');
            }
        });
            

        });
    });

    </script>
@endsection
