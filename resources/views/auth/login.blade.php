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
                Iniciar sesión
            </v-card-title>
            <v-form method="POST" action="{{ route('login') }}">
                @csrf
                <v-card-text>
                    <v-text-field
                        label="Correo electrónico"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        autofocus
                        outlined
                        dense
                        prepend-inner-icon="mdi-at"
                        :error="@error('email') true @else false @enderror"
                        error-messages="@error('email') {{ $message }} @enderror"
                    ></v-text-field>
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

                    {{-- <v-checkbox
                        name="remember"
                        label="Recuérdame"
                    ></v-checkbox> --}}
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue-grey darken-1" dark type="submit">Ingresar</v-btn>
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
        <div>
            ¿Aun no tienes una cuenta?
            <a class="btn btn-link" href="{{ route('register') }}">
                {{ __('Regístrate') }}
            </a>
        </div>
    </v-col>
</v-row>
@endsection
