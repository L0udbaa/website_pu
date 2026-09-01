@extends('layouts.app')

@section('title', 'Tambah Progres Fisik')

@section('content')
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-tools" aria-hidden="true"></i></span>
            <div>
                <p class="eyebrow mb-1">Monitoring</p>
                <h1 class="h3 mb-1">Tambah Progres Fisik</h1>
                <p class="text-muted mb-0">Input rencana dan realisasi progres fisik kegiatan.</p>
            </div>
        </div>
    </div>

    <section class="panel mt-3">
        <div class="panel-header">
            <div>
                <h2 class="h5 mb-1 section-title"><i class="bi bi-pencil-square" aria-hidden="true"></i><span>Form Progres Fisik</span></h2>
            </div>
        </div>

        <div class="p-3">
            <form action="{{ route('progres-fisik.store') }}" method="POST">
                @include('progres_fisik._form')
            </form>
        </div>
    </section>
@endsection
