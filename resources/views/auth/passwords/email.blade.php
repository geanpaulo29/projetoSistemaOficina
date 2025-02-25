@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">{{ __('Esqueceu sua senha?') }}</div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Campo de Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required autofocus>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3">Enviar link de recuperação</button>
            </form>
        </div>
    </div>
@endsection
