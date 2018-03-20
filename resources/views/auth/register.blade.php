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
                    <h3>@lang('Register')</h3>
                    <form role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
                        
                        @if ($errors->has('email'))
                            @component('front.components.error')
                                {{ $errors->first('email') }}
                            @endcomponent
                        @endif 
						<h4>@lang('Email')</h4>						
                        <input id="email" placeholder="@lang('Email')" type="email" class="full-width"  name="email" value="{{ old('email') }}" required>
                        @if ($errors->has('password'))
                            @component('front.components.error')
                                {{ $errors->first('password') }}
                            @endcomponent
                        @endif 
						
						<h4>@lang('Password')</h4>	
                        <input id="password" placeholder="@lang('Password')" type="password" class="full-width"  name="password" required>
						<h4>@lang('Confirm Password')</h4>	
                        <input id="password-confirm" placeholder="@lang('Confirm your password')" type="password" class="full-width" name="password_confirmation" required>
						
						<h4>@lang('Screen name')</h4>	
						@if ($errors->has('screen_name'))
                            @component('front.components.error')
                                {{ $errors->first('screen_name') }}
                            @endcomponent
                        @endif 
                        <input id="screen_name" placeholder="@lang('screen name')" type="text" class="full-width"  name="screen_name" value="{{ old('screen_name') }}" required autofocus>
						
						
						
						<h4>@lang('Horoscope')</h4>	
						@if ($errors->has('horo_sign'))
                            @component('front.components.error')
                                {{ $errors->first('horo_sign') }}
                            @endcomponent
                        @endif 
                        <select id="horo_sign" placeholder="@lang('horoscope name')"  class="full-width"  name="horo_sign" value="{{ old('horo_sign') }}" required autofocus>
						<option value="0">Without Sign</option>
						<option value="Aries">Aries</option>
						<option value="Leo">Leo</option>
						<option value="Sagittarius">Sagittarius</option>
						<option value="Taurus">Taurus</option>
						<option value="Virgo">Virgo</option>
						<option value="Capricorn">Capricorn</option>
						<option value="Gemini">Gemini</option>
						<option value="Libra">Libra</option>
						<option value="Aquarius">Aquarius</option>
						<option value="Cancer">Cancer</option>
						<option value="Scorpio">Scorpio</option>
						<option value="Pisces">Pisces</option>					
						</select>
						
						
						
						<h4>@lang('Subscribe Newletter')</h4>	
						@if ($errors->has('newsletter'))
                            @component('front.components.error')
                                {{ $errors->first('newsletter') }}
                            @endcomponent
                        @endif 
                        <input id="newsletter" placeholder="@lang('screen name')" type="checkbox" class="full-width"  name="newsletter" required autofocus>
						
						
						
						
						
						<h4>@lang('Brief Intoduction')</h4>	
						@if ($errors->has('brief_intro'))
                            @component('front.components.error')
                                {{ $errors->first('brief_intro') }}
                            @endcomponent
                        @endif 
                        <textarea id="brief_intro" placeholder="" class="full-width"  name="brief_intro" value="{{ old('brief_intro') }}" required autofocus></textarea>
						
						
						<h4>@lang('About My Service')</h4>	
						@if ($errors->has('my_service'))
                            @component('front.components.error')
                                {{ $errors->first('my_service') }}
                            @endcomponent
                        @endif 
                        <textarea id="my_service" placeholder="" class="full-width"  name="my_service" value="{{ old('my_service') }}" required autofocus></textarea>
						
						
						<h4>@lang('Experience & Qualification')</h4>	
						@if ($errors->has('exp'))
                            @component('front.components.error')
                                {{ $errors->first('exp') }}
                            @endcomponent
                        @endif 
                        <textarea id="exp" placeholder="" class="full-width"  name="exp" value="{{ old('exp') }}" required autofocus></textarea>
						
						<h4>@lang('Degree')</h4>	
						@if ($errors->has('degree'))
                            @component('front.components.error')
                                {{ $errors->first('degree') }}
                            @endcomponent
                        @endif 
                        <textarea id="degree" placeholder="" class="full-width"  name="degree" value="{{ old('degree') }}" required autofocus></textarea>
						
						<h4>@lang('language')</h4>	
						@if ($errors->has('language'))
                            @component('front.components.error')
                                {{ $errors->first('language') }}
                            @endcomponent
                        @endif 
                        <select id="language" placeholder="@lang('language')"  class="full-width"  name="language" value="{{ old('language') }}" required autofocus>
						<option value="en">English</option>
						<option value="hi">hindi</option>
						</select>
						<h4>@lang('Fee on chat')</h4>	
						@if ($errors->has('fee_chat'))
                            @component('front.components.error')
                                {{ $errors->first('fee_chat') }}
                            @endcomponent
                        @endif 
                        <input id="fee_chat" placeholder="@lang('Fee on chat')" type="text" class="full-width"  name="fee_chat" value="{{ old('fee_chat') }}" required autofocus>
						
						
						<h4>@lang('Fee on Email')</h4>	
						@if ($errors->has('fee_email'))
                            @component('front.components.error')
                                {{ $errors->first('fee_email') }}
                            @endcomponent
                        @endif 
                        <input id="fee_email" placeholder="@lang('Fee on Email')" type="text" class="full-width"  name="fee_email" value="{{ old('fee_email') }}" required autofocus>
						
                        <input class="button-primary full-width-on-mobile" type="submit" value="@lang('Register')">
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
