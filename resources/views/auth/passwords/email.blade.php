@extends('layouts.app')

@section('content')
<v-row class="align-center justify-center flex-column">
    <v-col
        cols="12"
        sm="8"
        md="4"
    >
        <v-card>
            <v-card-title
                class="justify-center"
            >
                Restablecer la contraseña
            </v-card-title>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <v-form method="POST" action="{{ route('password.email') }}">
                @csrf
                <v-card-text>
                    <v-text-field
                        label="Correo electrónico"
                        prepend-inner-icon="mdi-at"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        autofocus
                        outlined
                        dense
                        :error="@error('email') true @else false @enderror"
                        error-messages="@error('email') {{ $message }} @enderror"
                    ></v-text-field>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue-grey darken-1" dark type="submit">Enviar enlace</v-btn>
                </v-card-actions>
            </v-form>
        </v-card>
    </v-col>
    <v-col
        cols="12"
        sm="8"
        md="4"
        class="text-center"
    >
        <a class="btn btn-link" href="{{ route('login') }}">
            {{ __('Inicia sesión') }}
        </a>
    </v-col>
</v-row>
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection
