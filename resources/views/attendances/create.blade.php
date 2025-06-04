@extends('layouts.attendance')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">E-Presensi</div>
        <div class="right"></div>
    </div>

    <style>
        .webcam,
        .webcam video {
            display: inline-block;
            width: 100% !important;
            margin: auto;
            height: auto !important;
            border-radius: 15px;
        }

        #map {
            height: 200px;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <!-- * App Header -->
@endsection
@section('content')
    <div class="row" style='margin-top: 100px'>
        <div class="col">
            <input type="hidden" id="location">
            <div class="webcam"></div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            @if ($check > 0)
                <button id="takeData" class="btn btn-danger btn-block">
                    <ion-icon name="camera-outline"></ion-icon>
                    Absen Pulang
                </button>
            @else
                <button id="takeData" class="btn btn-primary btn-block">
                    <ion-icon name="camera-outline"></ion-icon>
                    Absen Masuk
                </button>
            @endif
        </div>
    </div>

    </div>
    <div class="row mt-2">
        <div class="col">
            <div id="map"></div>
        </div>
    </div>

    <audio id="notification_in">
        <source src="{{ asset('assets/sound/presensi-masuk.mp3') }}" type="audio/mpeg">
    </audio>
    <audio id="notification_out">
        <source src="{{ asset('assets/sound/presensi-pulang.mp3') }}" type="audio/mpeg">
    </audio>
    <audio id="radius_notification">
        <source src="{{ asset('assets/sound/radius.mp3') }}" type="audio/mpeg">
    </audio>
@endsection

@push('script')
    <script>
        var notification_in = document.getElementById('notification_in');
        var notification_out = document.getElementById('notification_out');
        var radius_notification = document.getElementById('radius_notification');
        Webcam.set({
            width: 480,
            height: 640,
            image_format: 'jpeg',
            jpeg_quality: 90
        });
        Webcam.attach('.webcam');

        var locationInput = document.getElementById('location');
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(succesCallback, errorCallback);
        }

        function succesCallback(position) {
            locationInput.value = position.coords.latitude + ',' + position.coords.longitude;
            var map = L.map('map').setView([position.coords.latitude, position.coords.longitude],
                20); // L.map('map').setView([51.505, -0.09], 13);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 22,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
            var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(
                map); // L.marker([51.5, -0.09]).addTo(map);
            var circle = L.circle([-6.914744, 107.609810], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 100
            }).addTo(map);
        }

        function errorCallback(error) {
            console.log(error);
        }

        $('#takeData').click(function(e) {
            Webcam.snap(function(uri) {
                image = uri;
            });
            var locationInput = $('#location').val();
            $.ajax({
                type: 'POST',
                url: '/attendances/store',
                data: {
                    _token: "{{ csrf_token() }}",
                    image: image,
                    location: locationInput
                },
                cache: false,
                success: function(respond) {
                    var status = respond.split("|");
                    if (status[0] == 'success') {
                        if (status[2] == 'in') {
                            notification_in.play();
                        } else {
                            notification_out.play();
                        }
                        Swal.fire({
                            title: 'Berhasil!',
                            text: status[1],
                            icon: 'success'
                        });
                        setTimeout("location.href='/dashboard'", 3000);
                    } else {
                        if (status[2] == 'radius') {
                            radius_notification.play();
                        }
                        Swal.fire({
                            title: 'Error!',
                            text: status[1],
                            icon: 'error',
                        })
                    }

                }
            })
        });
    </script>
@endpush
