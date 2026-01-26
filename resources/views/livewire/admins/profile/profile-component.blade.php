<div>
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="profile">
                <div class="profile-head">
                    <div class="photo-content">
                        <div class="cover-photo"></div>
                        <div class="profile-photo">
                            <label for="image">
                                <input type="file" name="" id="image" wire:model="image" hidden>

                                @if ($image)
                                    <img src="{{ $image->temporaryUrl() }}"
                                        style="width: 300px;height:150px;background-color: white; border: 5px solid #f1f1f3"
                                        class="img-fluid rounded-circle" alt="no image" />
                                @elseif($user->image)
                                    <img src="{{ asset('storage/' . $user->image) }}"
                                        style="width: 300px;height:150px;background-color: white; border: 5px solid #f1f1f3"
                                        class="img-fluid rounded-circle" alt="no image" />
                                @else
                                    <img src="{{ asset('assets/images/avatar/1.png') }}"
                                        style="width: 300px;height:150px;background-color: white; border: 5px solid #f1f1f3"
                                        class="img-fluid rounded-circle" alt="no image" />
                                @endif




                            </label>
                            @if ($image)
                                <button style="position: absolute;right: 50px;bottom: 15px;" type="submit"
                                    class="btn btn-primary btn-rounded" wire:click="ImageStore"><i
                                        class="fa fa-save"></i></button>
                            @endif
                        </div>

                    </div>

                    <div class="profile-info">
                        <div class="row justify-content-center">
                            <div class="col-xl-8">
                                <div class="row">
                                    <div class="col-xl-4 col-sm-4 border-right-1 prf-col">
                                        <div class="profile-name">
                                            <h4 class="text-primary">{{ Str::upper(Auth::user()->name) }}</h4>
                                            @foreach (Auth::user()->roles as $role)
                                                <p>{{ Str::upper($role->name) }}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-4 border-right-1 prf-col">
                                        <div class="profile-email">
                                            <h4 class="text-muted">{{ Auth::user()->email }}</h4>
                                            <p>{{ __('Email Address') }}</p>
                                        </div>
                                    </div>
                                    <!-- <div class="col-xl-4 col-sm-4 prf-col">
                                        <div class="profile-call">
                                            <h4 class="text-muted">(+1) 321-837-1030</h4>
                                            <p>Phone No.</p>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="profile-statistics">
                        <div class="text-center mt-4 border-bottom-1 pb-3">
                            <div class="row">
                                <div class="col">
                                    <h3 class="m-b-0"></h3><span>{{ __('No Current Data') }}</span>
                                </div>

                            </div>
                            {{-- <div class="mt-4"><a href="javascript:void()" class="btn btn-primary pl-5 pr-5 mr-3 mb-4">Follow</a> <a href="javascript:void()" class="btn btn-dark pl-5 pr-5 mb-4">Send
                                    Message</a>
                            </div> --}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="profile-tab">
                        <div class="custom-tab-1">
                            <ul class="nav nav-tabs">
                                <li class="nav-item"><a href="#profile-settings" data-toggle="tab"
                                        class="nav-link">{{ __('Settings') }}</a>
                                </li>
                            </ul>
                            <div class="tab-content">

                                <div id="profile-settings" class="tab-pane fade active show">
                                    <div class="pt-3">
                                        <div class="settings-form">
                                            <h4 class="text-primary">{{ __('Account Setting') }}</h4>
                                            <form wire:submit.prevent="store">
                                                <div class="form">
                                                    <div class="form-group col-md-6">
                                                        <label>{{ __('Email Address') }}</label>
                                                        <input type="email" value="{{ $user->email }}" placeholder="{{ __('Email Address') }}" class="form-control" readonly>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>{{ __('Name') }}</label>
                                                        <input type="text" placeholder="{{ __('Name') }}" class="form-control" wire:model="name">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>{{ __('Password') }}</label>
                                                        <input type="password" placeholder="Password"
                                                            class="form-control" wire:model="pasasword">
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label>{{ __('Confirm Password') }}</label>
                                                        <input type="password" placeholder="Password"
                                                            class="form-control" wire:model="re_pasasword">
                                                    </div>
                                                </div>

                                        </div>
                                        <button class="btn btn-primary" type="submit">
                                            {{ __('Save') }}
                                        </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@script
    @include('tools.message')
@endscript
