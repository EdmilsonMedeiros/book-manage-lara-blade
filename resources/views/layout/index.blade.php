@extends('app')

@section('content')

<div class="container mt-1">
    <div class="card bg-primary text-white">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <span class="text-white-50">Bem-vindo,</span>
                <span class="fw-bold ms-1">{{ Auth::user()->name }}</span>
            </div>
            <form action="{{ route('logOut') }}" method="GET" class="m-0">
                <button type="submit" class="btn btn-outline-light">
                    <i class="bi bi-box-arrow-right me-2"></i>Sair
                </button>
            </form>
        </div>
    </div>
</div>

<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light mt-2">
        <div class="p-1">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
    
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <span class="bi bi-house"></span> Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('authors.*') ? 'active' : '' }}" href="{{ route('authors.index') }}">
                            <span class="bi bi-file-earmark-person"></span> Gerenciar Autores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}"> 
                            <span class="bi bi-person-gear"></span> Gerenciar Permissões</a>
                    </li>
                </ul>
            </div>
            
    
        </div>
    </nav>
</div>

@if(session('error'))
    <div class="container mt-4">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@if(session('success'))
    <div class="container mt-4">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@yield('subcontent')

@endsection
