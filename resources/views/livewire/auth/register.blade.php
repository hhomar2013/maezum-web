@section('title',__('Register'))
<div class="authincation h-100">
    <div class="container-fluid h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-4">
                <div class="authincation-content">
                    <div class="row no-gutters">
                        <div class="col-xl-12">
                            <div class="auth-form">
                                <h4 class="text-center mb-4">{{ __('Register Your Account') }} {{ getAppSetting('app_name') }}</h4>
                                <form wire:submit.prevent="register">
                                    <div class="form-group">
                                        <label><strong>{{ __('Name') }}</strong></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name"/>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Email</strong></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror {{ session()->has('error') ? 'is-invalid' : '' }}" wire:model="email"/>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                        @if(session()->has('error'))
                                        <span class="text-danger " role="alert">
                                           <small><b> {{ session()->get('error') }}</b></small>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Password</strong></label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" wire:model="password"/>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-block">
                                                Sign up


                                      </button>
                                      @include('tools.spinner',['action'=>'register'])

                                    </div>
                                </form>
                                <div class="new-account mt-3">
                                    {{-- <p>Don't have an account? <a class="text-primary" href="./page-register.html">Sign up</a></p> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

