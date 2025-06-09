@extends('layouts.attendance')
@section('content')
    <!-- App Capsule -->
    <div class="section" id="user-section">
        <div id="user-detail">
            <div class="avatar">
                @if (Auth::guard('employee')->user()->photo != null)
                    @php
                        $path = Storage::url('public/' . Auth::guard('employee')->user()->photo);
                    @endphp
                    <img src="{{ $path }}" alt="avatar" class="imaged w64" style="height: 75px;">
                @else
                    <img src="assets/img/sample/avatar/avatar1.jpg" alt="avatar" class="imaged w64 rounded">
                @endif
            </div>
            <div id="user-info">
                <h2 id="user-name">{{ Auth::guard('employee')->user()->fullname }}</h2>
                <span id="user-role">{{ Auth::guard('employee')->user()->positions }}</span>
            </div>
        </div>
    </div>

    <div class="section" id="menu-section">
        <div class="card">
            <div class="card-body text-center">
                <div class="list-menu">
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="" class="green" style="font-size: 40px;">
                                <ion-icon name="person-sharp"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Profil</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="" class="danger" style="font-size: 40px;">
                                <ion-icon name="calendar-number"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Cuti</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="" class="warning" style="font-size: 40px;">
                                <ion-icon name="document-text"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Histori</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="" class="orange" style="font-size: 40px;">
                                <ion-icon name="location"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            Lokasi
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section mt-2" id="presence-section">
        <div class="todaypresence">
            <div class="row">
                <div class="col-6">
                    <div class="card gradasigreen">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if ($todayAttendance != null)
                                        @php
                                            $path = Storage::url(
                                                'public/uploads/attendance/' . $todayAttendance->check_in_photo,
                                            );
                                        @endphp
                                        <img src="{{ $path }}" alt="image" class="imaged w48">
                                    @else
                                        <ion-icon name="camera"></ion-icon>
                                    @endif
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Masuk</h4>
                                    <span>{{ $todayAttendance != null ? $todayAttendance->check_in_time : '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card gradasired">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if ($todayAttendance != null && $todayAttendance->check_out_photo != null)
                                        @php
                                            $path = Storage::url(
                                                'public/uploads/attendance/' . $todayAttendance->check_out_photo,
                                            );
                                        @endphp
                                        <img src="{{ $path }}" alt="image" class="imaged w48">
                                    @else
                                        <ion-icon name="camera"></ion-icon>
                                    @endif
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Pulang</h4>
                                    <span>{{ $todayAttendance != null && $todayAttendance->check_out_time != null ? $todayAttendance->check_out_time : '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="recap">
            <h3>Rekap Kehadiran {{ $month }} {{ $year }}</h3>
            <div class="row">
                <div class="col-3">
                    <div class="card rounded-2 shadow-sm" style="aspect-ratio: 1 / 1;">
                        <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                            <span class="badge bg-danger"
                                style="position: absolute; top: 3px; right: 10px; font-size: 0.6rem; z-index: 999; ">
                                {{ $recapMonth->total_kehadiran }}
                            </span>
                            <ion-icon name="accessibility-outline"
                                style="text-align: center; font-size: 1.6rem; ! important padding: 18px 12px; line-height: 0.5rem; margin-top: -10px;"
                                class="text-primary"></ion-icon>
                            <span style="font-size: 0.8rem; margin-top: 5px ;margin-bottom: -15px">Hadir</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card rounded-2 shadow-sm" style="aspect-ratio: 1 / 1;">
                        <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                            <span class="badge bg-danger"
                                style="position: absolute; top: 3px; right: 10px; font-size: 0.6rem; z-index: 999; ">2</span>
                            <ion-icon name="newspaper-outline"
                                style="text-align: center; font-size: 1.6rem; ! important padding: 18px 12px; line-height: 0.5rem; margin-top: -10px;"
                                class="text-success"></ion-icon>
                            <span style="font-size: 0.8rem; margin-top: 5px ;margin-bottom: -15px">Cuti</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card rounded-2 shadow-sm " style="aspect-ratio: 1 / 1;">
                        <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                            <span class="badge bg-danger"
                                style="position: absolute; top: 3px; right: 10px; font-size: 0.6rem; z-index: 999; ">2</span>
                            <ion-icon name="medkit-outline"
                                style="text-align: center; font-size: 1.6rem; ! important padding: 18px 12px; line-height: 0.5rem; margin-top: -10px;"
                                class="text-warning"></ion-icon>
                            <span style="font-size: 0.8rem; margin-top: 5px ;margin-bottom: -15px">Sakit</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card rounded-2 shadow-sm" style="aspect-ratio: 1 / 1;">
                        <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                            <span class="badge bg-danger"
                                style="position: absolute; top: 3px; right: 10px; font-size: 0.6rem; z-index: 999; ">
                                {{ $recapMonth->total_terlambat }}
                            </span>
                            <ion-icon name="alarm-outline"
                                style="text-align: center; font-size: 1.6rem; ! important padding: 18px 12px; line-height: 0.5rem; margin-top: -10px;"
                                class="text-danger"></ion-icon>
                            <span style="font-size: 0.8rem; margin-top: 5px ;margin-bottom: -15px">Telat</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="presencetab mt-2">
            <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                <ul class="nav nav-tabs style1" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                            Bulan Ini
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                            Leaderboard
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content mt-2" style="margin-bottom:100px;">
                <div class="tab-pane fade show active" id="home" role="tabpanel">
                    <ul class="listview image-listview">
                        @foreach ($historyMonth as $d)
                            @php
                                $path = Storage::url('public/uploads/attendance/' . $d->check_in_photo);
                            @endphp
                            <li>
                                <div class="item">
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="finger-print-outline"></ion-icon>
                                    </div>
                                    <div class="in">
                                        <div>{{ date('d M Y') }}</div>
                                        <span class="badge badge-success square ">{{ $d->check_in_time }}</span>
                                        <td style="width: 100%; max-width: 100%; white-space: normal;">
                                            <span class="badge badge-danger">
                                                {{ $todayAttendance != null && $todayAttendance->check_out_time != null
                                                    ? $todayAttendance->check_out_time
                                                    : 'Belum Presensi' }}
                                            </span>
                                        </td>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="tab-pane fade" id="profile" role="tabpanel">
                    @foreach ($leaderboard as $d)
                        <ul class="listview image-listview">
                            <li>
                                <div class="item">
                                    <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                                    <div class="in">
                                        <div>
                                            {{ $d->fullname }}
                                            <p>
                                                <small class="text-muted"><b>{{ $d->positions }}</b></small>
                                            </p>

                                        </div>
                                        <span
                                            class=" {{ $d->check_in_time < '08:00' ? 'text-muted' : 'text-danger' }}">Jam:
                                            {{ $d->check_in_time }}</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
    <!-- * App Capsule -->
@endsection
