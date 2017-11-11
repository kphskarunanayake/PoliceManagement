<?php
session_start();
include_once('./dbcon.php');

if (!isset($_SESSION['username'])) {
    header('location: index.php');
}

$error = FALSE;
if (isset($_POST['send'])) {
    //clean user input to prevent sql injection
    $date = $_POST['date'];
    $date = strip_tags($date);
    $date = htmlspecialchars($date);

    $vno = $_POST['vno'];
    $vno = strip_tags($vno);
    $vno = htmlspecialchars($vno);

    $province = $_POST['province'];
    $province = strip_tags($province);
    $province = htmlspecialchars($province);

    $licenno = $_POST['licenno'];
    $licenno = strip_tags($licenno);
    $licenno = htmlspecialchars($licenno);

    $offence = $_POST['offence'];
    $offence = strip_tags($offence);
    $offence = htmlspecialchars($offence);

    $location = $_POST['location'];
    $location = strip_tags($location);
    $location = htmlspecialchars($location);

    $pstation = $_POST['pstation'];
    $pstation = strip_tags($pstation);
    $pstation = htmlspecialchars($pstation);

    $svc = $_POST['svc'];
    $svc = strip_tags($svc);
    $svc = htmlspecialchars($svc);

    $fine = $_POST['fine'];
    $fine = strip_tags($fine);
    $fine = htmlspecialchars($fine);

    $vtype = $_POST['vtype'];
    $vtype = strip_tags($vtype);
    $vtype = htmlspecialchars($vtype);

    
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    //validate
    if (empty($date)) {
        $error = TRUE;
        $errDate = 'Please select Date';
    }
    if (empty($vno)) {
        $error = TRUE;
        $errVno = 'Please input Vehicle Number';
    }
    if (empty($province)) {
        $error = TRUE;
        $errProvince = 'Please select Registered Province';
    }
    if (empty($licenno)) {
        $error = TRUE;
        $errLicenno = 'Please input Drivers Licen Number';
    }
    if (empty($offence)) {
        $error = TRUE;
        $errOffence = 'Please input offence';
    }    
    if (empty($pstation)) {
        $error = TRUE;
        $errPstation = 'Please input Police Station';
    }
    if (empty($svc)) {
        $error = TRUE;
        $errSvc = 'Please input SVC Number';
    }
    if (empty($fine)) {
        $error = TRUE;
        $errFine = 'Please input Amount of fine';
    }
    if (empty($vtype)) {
        $error = TRUE;
        $errVtype = 'Please select Vehicle type';
    }

    if (!$error) {
        $sql = "INSERT INTO data_table(date,vno,province,licenno,offence,pstation,svc,fine,vtype, latitude, longitude) VALUES('$date','$vno','$province','$licenno','$offence','$pstation','$svc','$fine','$vtype' , '$lat', '$lng')";

        if (mysqli_query($con, $sql)) {
            echo "<script type='text/javascript'>alert('submitted successfully! <a href='tbl_data.php'>View Data Table</a>)</script>";
        } else {
            echo "<script type='text/javascript'>alert('failed!')</script>";
        }
    }
}
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/normalize.min.css">
        <script src='js/jquery-ui.js'></script>
        <style>
            form{
                margin: auto 150px auto 350px;
            }
            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
                position: relative;
                padding-right: 190px;
            }
            button.ui-tabs{
                position: absolute;
                padding: .2em;
                float: right;
                margin-left: 885px;
                margin-top: -10px;
            }

            td, th {
                text-align: left;
            }
            .label{
                margin-right: 5px;
                padding: 2px;
            }
            .inputData{
                margin-right: 50px;
                padding-right: 200px;
            }
            select{
                margin-right: 50px;
                padding-right: 200px;
            }

            .submit{
                margin-right: 25px;
            }

            <!--down table-->
            table.down{
                border-collapse: collapse;
                border-spacing: 0;
                width: 100%;
                border: 1px solid #ddd;
            }
            th.down, td.down{
                border: none;
                text-align: left;
                padding: 8px;
            }
            tr.down:nth-child(even){background-color: #f2f2f2}

            #map {
                width: 100%;
                height: 400px;
                background-color: grey;
            }
        </style>
        <script>
            $(function() {
                $("#datepicker").datepicker();

                $("#province").selectmenu();

                $("#offence").selectmenu();

                $("#vtype").selectmenu();
            });
        </script>

        <script>
            function initMap() {
                var uluru = {lat: 7.1439, lng: 80.0957};
                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 16,
                    center: uluru
                });
                var marker = new google.maps.Marker({
                    draggable: true,
                    position: uluru,
                    map: map
                });
                google.maps.event.addListener(marker, "dragend", function(event) {
                    var lat = event.latLng.lat();
                    var lng = event.latLng.lng();
                    console.log(lat);
                    console.log(lng);
                    $("#lat").val(lat);
                    $("#lng").val(lng);
                });
            }
        </script>
        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDIPDfEDMQ6fVAQtYseDZqClF-6GfZKGUk&callback=initMap">
        </script>
    </head>
    <body>
        <h1>Driver Fault Management & Prediction System</h1><br/>

        <button class="ui-tabs"><a href="logout.php">Logout <?php echo $_SESSION['username']; ?></a></button>

        <br/>
        <br/>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">

            <table>
                <tr field-wrap>
                    <td class="label">Date</td>
                    <td class="inputData">
                        <input type="text" class="form-control" name="date" id="datepicker">
                        <span class="text-danger"><?php if (isset($errDate)) echo $errDate; ?></span>
                    </td>
                    <td class="label">Location
                        <input type="hidden" name="lat" id="lat" />
                        <input type="hidden" name="lng" id="lng" />
                        <div id="map"></div>
                        
                    </td>

                </tr>
                <tr>
                    <td class="label">Vehicle Number</td>
                    <td class="inputData">
                        <input type="text" class="form-control" name="vno" id="vno">
                        <span class="text-danger"><?php if (isset($errVno)) echo $errVno; ?></span>
                    </td>
                   <td class="inputData" rowspan="8">

                        <input type="text" class="form-control" name="location" id="location">
                        <span class="text-danger"><?php if (isset($errLocation)) echo $errLocation; ?></span> 

                    </td>
                </tr>
                <tr>
                    <td class="label">Registered Province</td>
                    <td class="inputData">
                        <select class="form-control" name="province" id="province">
                            <option disabled selected>Please pick one</option>
                            <option value="Central">Central</option>
                            <option value="Eastern">Eastern</option>
                            <option value="North Central">North Central</option>
                            <option value="Northern">Northern</option>
                            <option value="North Western">North Western</option>
                            <option value="Sabaragamuwa">Sabaragamuwa</option>
                            <option value="Southern">Southern</option>
                            <option value="Uva">Uva</option>
                            <option value="Western">Western</option>
                        </select>
                        <span class="text-danger"><?php if (isset($errProvince)) echo $errProvince; ?></span>
                    </td>
                </tr>
                <tr>
                    <td class="label">Drivers' Licen Number</td>
                    <td class="inputData">
                        <input type="text" class="form-control" name="licenno" id="licenno">
                        <span class="text-danger"><?php if (isset($errLicenno)) echo $errLicenno; ?></span>
                    </td>
                </tr>
                <tr>
                    <td class="label">Offence</td>
                    <td class="inputData">
                        <select class="form-control" name="offence" id="offence">
                            <option disabled selected>Please pick one</option>
                            <option value="Driving a motor vehicle on a road recklessly or in a dangerous manner at a dangerous speed.">Driving a motor vehicle on a road recklessly or in a dangerous manner at a dangerous speed.</option>
                            <option value="Driving a motor vehicle negligently or without reasonable consideration">Driving a motor vehicle negligently or without reasonable consideration</option>
                            <option value="Failing to stop after accident on road and furnish relevant information">Failing to stop after accident on road and furnish relevant information</option>
                            <option value="Failing to report an accident forthwith to the nearest police station">Failing to report an accident forthwith to the nearest police station</option>
                            <option value="Exceeding the prescribed speed limit on a road">Exceeding the prescribed speed limit on a road</option>
                            <option value="Road Rules">Road Rules</option>
                            <option value="Reversing or permitting the vehicle to travel backwards on a road for a long distance">Reversing or permitting the vehicle to travel backwards on a road for a long distance</option>
                            <option value="Failing to comply with prohibitory, restrictive, mandatory or priority signs">Failing to comply with prohibitory, restrictive, mandatory or priority signs</option>
                            <option value="Failing to comply with the oral directions or hand signals given by a police officer or a traffic warden.">Failing to comply with the oral directions or hand signals given by a police officer or a traffic warden.</option>
                            <option value="Driver failing to wear the seat belt or failing to ensure the front passenger wears seat belt.">Driver failing to wear the seat belt or failing to ensure the front passenger wears seat belt.</option>
                            <option value="Failing to stop before the give way line of a zebra i crossing while pedestrian is at a pedestrian crossing.">Failing to stop before the give way line of a zebra i crossing while pedestrian is at a pedestrian crossing.</option>
                            <option value="Ride of a motor cycle carrying more than one person or falling to wear a safety helmet. ">Ride of a motor cycle carrying more than one person or falling to wear a safety helmet. </option>
                            <option value="Using hand held communication equipment while driving">Using hand held communication equipment while driving</option>

                        </select>
                        <span class="text-danger"><?php if (isset($errOffence)) echo $errOffence; ?></span>
                    </td>
                </tr>
                <tr>
                    <td class="label">Location</td>
                    <td class="inputData">
                        <input type="text" class="form-control" name="location" id="location">
                        <span class="text-danger"><?php
                            //if (isset($errLocation)) echo $errLocation;
                            ?></span> 




                    </td>
                </tr>
                <tr>

                </tr>
                <tr>
                    <td class="label">Police Station</td>
                    <td class="inputData">
                        <input type="text" class="form-control" name="pstation" id="pstation">
                        <span class="text-danger"><?php if (isset($errPstation)) echo $errPstation; ?></span>
                    </td>

                </tr>
                <tr>
                    <td class="label">Officers' SVC Number</td>
                    <td class="inputData">
                        <input type="text" class="form-control" name="svc" id="svc">
                        <span class="text-danger"><?php if (isset($errSvc)) echo $errSvc; ?></span>
                    </td>
                </tr>
                <tr>
                    <td class="label">Amount of fine(Rs.)</td>
                    <td class="inputData">
                        <input type="text" class="form-control" name="fine" id="fine">
                        <span class="text-danger"><?php if (isset($errFine)) echo $errFine; ?></span>
                    </td>
                </tr>
                <tr>
                    <td class="label">Vehicle type</td>
                    <td class="inputData">
                        <select class="form-control" name="vtype" id="vtype">
                            <option disabled selected>Please pick one</option>
                            <option value="Heavy">Heavy</option>
                            <option value="Dual Purpose">Dual Purpose</option>
                            <option value="3 - wheel">3 - wheel</option>
                            <option value="Mortorbike">Mortorbike</option>
                        </select>
                        <span class="text-danger"><?php if (isset($errVtype)) echo $errVtype; ?></span>
                    </td>
                </tr>

                <tr>
                    <td class="inputData" colspan="3"><input type="submit" class="button button-block" name="send" id="send" /></td>
                </tr>
            </table>

        </form>
        <br/><br/><br/>
        <hr/>

        <div style="overflow-x:auto;">

            <?php
            include ('./dbcon.php');

            $sqlget = "SELECT * FROM data_table";
            $sqldata = mysqli_query($con, $sqlget) or die('Error getting data');

            echo '<table class="down">';
            echo '<tr class="down"><th>Date</th><th>Vehicle Number</th><th>Registered Province</th><th>Drivers Licen Number</th><th>Offence</th><th>Police Station</th><th>OfficersSVC Number</th><th>Amount of fine(Rs.)</th><th>Vehicle type</th></tr>';

            while ($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)) {
                echo '<tr class="down"><td class="down">';
                echo $row['date'];
                echo '</td><td class="down">';
                echo $row['vno'];
                echo '</td><td class="down">';
                echo $row['province'];
                echo '</td><td class="down">';
                echo $row['licenno'];
                echo '</td><td class="down">';
                echo $row['offence'];
                echo '</td><td class="down">';
                echo $row['pstation'];
                echo '</td><td class="down">';
                echo $row['svc'];
                echo '</td><td class="down">';
                echo $row['fine'];
                echo '</td><td class="down">';
                echo $row['vtype'];
                echo '</td><tr>';
            }
            echo '</table>';
            ?>

        </div>
    </body>
</html>