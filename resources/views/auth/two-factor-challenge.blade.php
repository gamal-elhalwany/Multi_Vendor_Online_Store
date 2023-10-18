<x-front-layout>
    <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <form class="card login-form" method="post" action="{{ route('two-factor.login') }}">
                        @csrf
                        <div class="card-body">
                            <div class="title">
                                <h3>Two Factor Challenge</h3>
                                <p>You Must Enter The Two Factor Code.</p>
                            </div>
                            @error('code')
                                <p class="alert alert-danger">{{ $message }}</p>
                            @enderror

                            <div class="form-group input-group">
                                <label for="code">2FA Code</label>
                                <input type="text" class="form-control" name="code" />
                            </div>
                            <div class="form-group input-group">
                                <label for="recovery_code">Recovery Code</label>
                                <input type="text" class="form-control" name="recovery_code" />
                            </div>
                            <div class="button">
                                <button class="btn" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-front-layout>
