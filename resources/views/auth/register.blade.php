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
                Registrate
            </v-card-title>
            <v-form method="POST" action="{{ route('register') }}">
                @csrf
                <v-card-text>
                    <v-text-field
                        label="Nombre"
                        prepend-inner-icon="mdi-account"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        outlined
                        dense
                        :error="@error('name') true @else false @enderror"
                        error-messages="@error('name') {{ $message }} @enderror"
                    ></v-text-field>
                    <v-text-field
                        label="Correo electrónico"
                        prepend-inner-icon="mdi-at"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        outlined
                        dense
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
                    <v-text-field
                        label="Confirmar contraseña"
                        prepend-inner-icon="mdi-lock-check"
                        type="password"
                        name="password_confirmation"
                        outlined
                        dense
                    ></v-text-field>
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
        ¿Ya tienes una cuenta?
        <a class="btn btn-link" href="{{ route('login') }}">
            {{ __('Inicia sesión') }}
        </a>
    </v-col>
</v-row>
@endsection
