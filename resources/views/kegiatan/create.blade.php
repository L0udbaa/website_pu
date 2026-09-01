@extends('layouts.app')

@section('title', 'Tambah Kegiatan')

@section('content')
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-diagram-3" aria-hidden="true"></i></span>
            <div>
                <p class="eyebrow mb-1">Master Data</p>
                <h1 class="h3 mb-1">Tambah Kegiatan</h1>
                <p class="text-muted mb-0">Lengkapi data kegiatan baru.</p>
            </div>
        </div>
    </div>

    <section class="panel mt-3">
        <div class="panel-header">
            <div>
                <h2 class="h5 mb-1 section-title"><i class="bi bi-pencil-square" aria-hidden="true"></i><span>Form Kegiatan</span></h2>
            </div>
        </div>

        <div class="p-3">
            <form action="{{ route('kegiatan.store') }}" method="POST">
                @include('kegiatan._form')
            </form>
        </div>
    </section>
@endsection
