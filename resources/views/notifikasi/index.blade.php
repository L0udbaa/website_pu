@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')

<div class="page-heading mb-4">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

        <div>
            <h3 class="mb-1">
                Notifikasi
            </h3>

            <p class="text-muted mb-0">
                Daftar pemberitahuan aktivitas sistem.
            </p>
        </div>

        @if(auth()->user()->unreadNotifications()->count() > 0)

            <form
                method="POST"
                action="{{ route('notifikasi.read-all') }}"
            >

                @csrf

                <button
                    type="submit"
                    class="btn btn-outline-primary"
                >
                    <i class="bi bi-check2-all me-1"></i>
                    Tandai Semua Sudah Dibaca
                </button>

            </form>

        @endif

    </div>

</div>


<div class="card border-0 shadow-sm">

    <div class="card-body p-0">

        @forelse($notifications as $notification)

            @php

                $data = $notification->data;

                $jenis = $data['jenis'] ?? 'info';

                $icon = $data['icon'] ?? 'bi-bell';

                if ($jenis === 'warning') {

                    $iconClass = 'text-warning';

                    $bgClass = 'bg-warning-subtle';

                } elseif ($jenis === 'success') {

                    $iconClass = 'text-success';

                    $bgClass = 'bg-success-subtle';

                } else {

                    $iconClass = 'text-primary';

                    $bgClass = 'bg-primary-subtle';

                }

            @endphp


            <div
                class="p-3 border-bottom
                {{ is_null($notification->read_at) ? 'bg-light' : '' }}"
            >

                <div class="d-flex gap-3">

                    {{-- ICON --}}

                    <div class="flex-shrink-0">

                        <div
                            class="rounded-circle {{ $bgClass }}
                            d-flex align-items-center justify-content-center"
                            style="width: 48px; height: 48px;"
                        >

                            <i
                                class="bi {{ $icon }}
                                {{ $iconClass }} fs-5"
                            ></i>

                        </div>

                    </div>


                    {{-- ISI NOTIFIKASI --}}

                    <div class="flex-grow-1">

                        <div
                            class="d-flex justify-content-between
                            align-items-start gap-2"
                        >

                            <div>

                                <h6 class="mb-1 fw-bold">

                                    {{ $data['judul'] ?? 'Notifikasi' }}

                                    @if(is_null($notification->read_at))

                                        <span
                                            class="badge bg-primary ms-1"
                                        >
                                            Baru
                                        </span>

                                    @endif

                                </h6>

                                <p class="text-muted mb-1">

                                    {{ $data['pesan'] ?? '' }}

                                </p>

                            </div>


                            <small class="text-muted text-nowrap">

                                {{ $notification->created_at->diffForHumans() }}

                            </small>

                        </div>


                        {{-- AKSI --}}

                        <div class="d-flex align-items-center gap-3 mt-2">

                            @if(!empty($data['url']))

                                <a
                                    href="{{ $data['url'] }}"
                                    class="text-primary text-decoration-none small"
                                >

                                    <i class="bi bi-eye me-1"></i>

                                    Lihat Data

                                </a>

                            @endif


                            @if(is_null($notification->read_at))

                                <form
                                    method="POST"
                                    action="{{ route(
                                        'notifikasi.read',
                                        $notification->id
                                    ) }}"
                                    class="m-0"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn btn-link btn-sm
                                        text-success p-0 text-decoration-none"
                                    >

                                        <i class="bi bi-check2 me-1"></i>

                                        Tandai Sudah Dibaca

                                    </button>

                                </form>

                            @else

                                <span class="text-muted small">

                                    <i class="bi bi-check2-all me-1"></i>

                                    Sudah dibaca

                                </span>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

        @empty

            {{-- TIDAK ADA NOTIFIKASI --}}

            <div class="text-center py-5">

                <i
                    class="bi bi-bell-slash text-muted"
                    style="font-size: 50px;"
                ></i>

                <h5 class="mt-3">
                    Belum Ada Notifikasi
                </h5>

                <p class="text-muted mb-0">

                    Notifikasi kegiatan dan progres
                    akan muncul di halaman ini.

                </p>

            </div>

        @endforelse

    </div>

</div>


{{-- PAGINATION --}}

@if($notifications->hasPages())

    <div class="d-flex justify-content-center mt-4">

        {{ $notifications->links() }}

    </div>

@endif

@endsection