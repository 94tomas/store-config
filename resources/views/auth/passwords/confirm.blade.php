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
                Confirmar contraseña
            </v-card-title>
            <v-card-text>Por favor confirme su contraseña antes de continuar.</v-card-text>
            <v-form method="POST" action="{{ route('password.confirm') }}">
                @csrf
                <v-card-text>
                    <v-text-field
                        label="Contraseña"
                        prepend-inner-icon="mdi-lock"
                        type="password"
                        name="password"
                        outlined
                        dense
                        :error="@error('password') true @else false @enderror"
                        error-messages="@error('password') {{ $message }} @enderror"
                    ></v-text-field>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue-grey darken-1" dark type="submit">Confirmar contraseña</v-btn>
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
        @if (Route::has('password.request'))
            <a class="btn btn-link" href="{{ route('password.request') }}">
                {{ __('¿Olvidaste tu contraseña?') }}
            </a>
        @endif
    </v-col>
</v-row>
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Confirm Password') }}</div>

                <div class="card-body">
                    {{ __('Please confirm your password before continuing.') }}

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Confirm Password') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection
