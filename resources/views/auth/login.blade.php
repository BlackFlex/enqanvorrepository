@extends('front.layout')

@section('main')
   <section id="content-wrap">
        <div class="row">
            <div class="col-twelve">
                <div class="primary-content">
                    @if (session('confirmation-success'))
                        @component('front.components.alert')
                            @slot('type')
                                success
                            @endslot
                            {!! session('confirmation-success') !!}
                        @endcomponent
                    @endif
                    @if (session('confirmation-danger'))
                        @component('front.components.alert')
                            @slot('type')
                                error
                            @endslot
                            {!! session('confirmation-danger') !!}
                        @endcomponent
                    @endif
                    <h3>@lang('Login')</h3>
                    <form role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        @if ($errors->has('email'))
                            @component('front.components.error')
                                {{ $errors->first('email') }}
                            @endcomponent
                        @endif   
                        <input id="email" type="text" placeholder="@lang('Login')" class="full-width" name="email" value="{{ old('email') }}" required autofocus>
                        <input id="password" type="password" placeholder="@lang('Password')" class="full-width" name="password" required>
                        <label class="add-bottom">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> 
                            <span class="label-text">@lang('Remember me')</span>
                        </label>
                        <input class="button-primary full-width-on-mobile" type="submit" value="@lang('Login')">
                        <label class="add-bottom">
                            <a href="{{ route('password.request') }}">
                                @lang('Forgot Your Password?')
                            </a><br>
                            <a href="{{ route('register') }}">
                                @lang('Not registered?')
                            </a>
                        </label>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
