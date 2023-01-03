<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

  <style>
    .hideSection {
      display: none;
    }

    .flex-row {
      display: flex;
      flex-direction: row;
    }
    
    input[type="text"],
    input[type="number"],
    input[type="date"],
    select {
      height: 25px;
    }

    .list-group-item {
      display: flex;
      height: 50px;
      align-items: center;
    }

    p {
      margin: 0 5px 0 0;
    }

    .input-width-100 {
      width: 100px;
    }
   
    .input-width-250 {
      width: 250px;
    }

    .jumbotron {
        text-align: center;
    }
  </style>

</head>

<body>
    <div class="container">
        <div class="row">
    <div class="jumbotron">
      <h1>Travel Overview</h1>
    </div>

    <div class="col-md-12">
      
      
    </div>
  </div>   
    <br><br>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script>

$( document ).ready(function() {
    getAllRides();
});

function getAllRides() {
    fetch ("../backend/get_all_rides.php", {
        method: 'POST',

    })
        .then((result) => {
            if (result.status != 200) { throw new Error("Bad Server Response");}
            return result.text();
        })
        .then((response) => {
            let data = JSON.parse(response);
            if (data.success) {
                console.log(data.allTravels);
                for (var i = 0; i < data.allTravels.length; i++) {
                 
                }
            } else {
                console.error(data.error);
                alert("Er ging iets fout");
            }

        })
  }

</script>

<script defer
    src="https://maps.googleapis.com/maps/api/js?libraries=places&language=en&key=AIzaSyDhegrPYuPBDUuTq72h2tsDcosFFJzYksM"
    type="text/javascript"></script>

<script src="../assets/js/mapsAPI.js"></script>

</html>