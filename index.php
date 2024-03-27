<?php
    require 'koneksi.php';

    $hasil = mysqli_query($koneksi, 'SELECT * FROM tb_data_rs');

    $data = [];
    while($d = mysqli_fetch_assoc($hasil)){
        $data[] = $d;
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>sig_2105551054</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
            #map {
                height: 550px;
            }
        </style>
    </head>
    <body>
        <div class="d-flex" id="wrapper">
            <!-- Sidebar-->
            <div class="border-end bg-white" id="sidebar-wrapper">
                <div class="sidebar-heading border-bottom bg-light">sig_2105551054</div>
                <div class="list-group list-group-flush">
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="index.php">Dashboard</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="data.php">Data</a>
                </div>
            </div>
            <!-- Page content wrapper-->
            <div id="page-content-wrapper">
                <!-- Top navigation-->
                <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                    <div class="container-fluid">
                        <button class="btn btn-primary" id="sidebarToggle">Menu</button>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                                <li class="nav-item active"><a class="nav-link" href="#!">Home</a></li>
                                <li class="nav-item"><a class="nav-link" href="#!">Link</a></li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="#!">Action</a>
                                        <a class="dropdown-item" href="#!">Another action</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#!">Something else here</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <!-- Page content-->
                <div class="container-fluid">
                    <h1>Leaflet Map</h1>
                    <div id="map"></div>
                </div>
            </div>
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>

        <script>
            getLocation()

            function getLocation(){
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition);
                } else {
                    document.getElementById("demo").innerHTML =
                    "Geolocation is not supported by this browser.";
                }
            }

            function showPosition(position) {
            // initialize the map on the "map" div with a given center and zoom
            var map = L.map('map', {
                center: [position.coords.latitude, position.coords.longitude],
                zoom: 11
            });

            var myIcon = L.icon({
                iconUrl: 'icon.png',
                iconSize: [30, 30],
                iconAnchor: [22, 94],
                popupAnchor: [-3, -76],
            });

            L.marker([position.coords.latitude, position.coords.longitude]).addTo(map).bindPopup('Posisi Saat Ini');

            let data = <?php echo json_encode($data); ?>;

            data.map(function(d){

                L.marker([d.latitude, d.longitude], {
                    icon : myIcon
                }).addTo(map).bindPopup(`
                    <p>
                        <i class="fa-solid fa-hospital"></i>
                        <b>Nama Rumah Sakit</b>: ${d.nama_rs}
                    </p>
                    <p>
                        <i class="fa-solid fa-hospital"></i>
                        <b>Alamat</b>: ${d.alamat}
                    </p>
                    <p>
                        <i class="fa-solid fa-hospital"></i>
                        <b>Website</b>: ${d.website}
                    </p>
                    <p>
                        <i class="fa-solid fa-hospital"></i>
                        <b>Latitude</b>: ${d.latitude}
                    </p>
                    <p>
                        <i class="fa-solid fa-hospital"></i>
                        <b>Longitude</b>: ${d.longitude}
                    </p>
                `);
            })

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png?{foo}', {foo: 'bar', attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'}).addTo(map);
            }

        </script>
    </body>
</html>
