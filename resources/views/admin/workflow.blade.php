@extends('layouts.admin')

@section('title', $title)

@section('content')
    <div class="workflow-page-header">
        <a
            href="{{ route('admin.dashboard') }}"
            class="workflow-back-button"
            aria-label="Kembali ke Dashboard"
        >
            <iconify-icon icon="lucide:chevron-left" width="24" height="24" aria-hidden="true"></iconify-icon>
        </a>
        <div class="page-top">
            <div>
                <h1>{{ $title }}</h1>
                <p>{{ $description }}</p>
            </div>
        </div>
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
