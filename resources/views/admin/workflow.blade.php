@extends('layouts.admin')

@section('title', $title)

@section('content')
    <div class="page-top">
        <div>
            <div class="breadcrumb">SIMPUL / Admin / {{ $title }}</div>
            <h1>{{ $title }}</h1>
            <p>{{ $description }}</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">← Dashboard</a>
    </div>

    @if (session('success'))
        <div class="notice notice-success" role="status">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="notice notice-error" role="alert">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div class="notice notice-error" role="alert">
            <strong>Data belum dapat disimpan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @include('admin.workflows.' . $section)
@endsection
