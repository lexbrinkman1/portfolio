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
  </style>

</head>

<body>
    <div class="container">
        <div class="row">
    <div class="jumbotron">
      <h1>Time & Distance Calculator Between Two Locations & Addresses</h1>
    </div>

    <div class="col-md-12">
      <form id="distance_form">
        <div class="form-group">
          <label>Vertrekplaats: </label>
          <input
            class="form-control"
            id="from_places"
            placeholder="Vul locatie in"
          />
          <p style="color:red;" id="resultOrigin"></p>
          <input id="origin" name="origin" required="" type="hidden" />
        </div>

        <div class="form-group">
          <label>Bestemming: </label>
          <input
            class="form-control"
            id="to_places"
            placeholder="Vul locatie in"
          />
          <p style="color:red;" id="resultDestination"></p>
          <input
            id="destination"
            name="destination"
            required=""
            type="hidden"
          />
        </div>
        <div class="form-group">
          <input class="btn btn-primary" type="submit" value="Bereken reis" />
        </div>
      </form>

      <div class="hideSection" id="result">
        <ul class="list-group">
          <li
            class="
              list-group-item
              d-flex
              justify-content-between
              align-items-center
            "
          >
            <p>Vertrekplaats:</p> 
            <p id="originResult"></p>
          </li>
          <li
            class="
              list-group-item
              d-flex
              justify-content-between
              align-items-center
            "
          >
            <p>Bestemming:</p> 
            <p id="destinationResult"></p>
          </li>
          <li
            class="
              list-group-item
              d-flex
              justify-content-between
              align-items-center
            "
          >
            <p>Reistijd:</p> 
            <input class="input-width-100 form-control pac-target-input" id="duration" type="number">

          </li>
          <li
            class="
              inputNumber
              list-group-item
              d-flex
              justify-content-between
              align-items-center
            "
          >
            <p>Afstand in km:</p> 
            <input class="input-width-100 form-control pac-target-input" id="distance" type="number">
          </li>
       
          <li
            class="
              list-group-item
              d-flex
              justify-content-between
              align-items-center
            "
          >
            <p>Bestemming naam:</p> 
            <input class="input-width-250 form-control pac-target-input" id="destinationName" type="text" />
          </li>
          <li
            class=" 
              inputNumber
              list-group-item
              d-flex
              justify-content-between
              align-items-center
            "
          >
          <p>Beginstand kilometers:</p> 
          <input class="input-width-100 form-control pac-target-input" id="oldTotal" type="number">
          </li>
          <li
          class="
            list-group-item
            d-flex
            justify-content-between
            align-items-center
          "
          >
          <p>Eindstand kilometers:</p> 
          <p id="newTotal"></p>

          </li>
          <li
          class="
            list-group-item
            d-flex
            justify-content-between
            align-items-center
          "
          >
          <p>Type rit:</p>
          <select class="input-width-250 form-control pac-target-input" id="travelType" type="text">
            <option selected disabled value="">Kies een optie</option>
            <option value="0">Zakelijk</option>
            <option value="1">Privé</option>
          </select>
          </li>
          <li
          class="
            list-group-item
            d-flex
            justify-content-between
            align-items-center
          "
          >
          <p>Type datum:</p> 
          <input class="input-width-250 form-control pac-target-input" type="date" id="travelDate">
          </li>
        </ul>

        <div class="form-group">
          <input onclick="createNewRide()" class="btn btn-primary" type="submit" value="Voeg rit toe!" />
        </div>

      </div>
      
      
    </div>
  </div>   
    <br><br>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script>
$(".inputNumber input[type='number']").keyup(function() {
  let oldTotal = parseFloat($("#oldTotal").val());
  let distance = parseFloat($("#distance").val());
  let newTotal = oldTotal + distance;
  $("#newTotal").html(`${newTotal}`);
});

function checkIfAddressExists(address, addressName) {
  const form_data = new FormData();

  form_data.append('address', address);
  form_data.append('addressName', addressName);

  fetch ("../backend/check_address.php", {
    method: 'POST',
    body: form_data,
  })
  .then((result) => {
    if (result.status != 200) { throw new Error("Bad Server Response");}
    return result.text();
  })
  .then((response) => {
      let data = JSON.parse(response);
      if (data.success && data.exists === false) {
          createNewAddress(data.address, data.addressName);
      } else {
        console.error(data.error);
      }
  })
}

function createNewAddress(address, addressName) {
  const form_data = new FormData();

  form_data.append('address', address);
  form_data.append('addressName', addressName);

  fetch ("../backend/create_new_address.php", {
    method: 'POST',
    body: form_data,
  })
  .then((result) => {
    if (result.status != 200) { throw new Error("Bad Server Response");}
    return result.text();
  })
  .then((response) => {
      let data = JSON.parse(response);
      if (data.success) {
        return;
      } else {
        console.error(data.error);
      }
  })
}

function createNewRide() {
  const form_data = new FormData();

  form_data.append('distance', $("#distance").val());
  form_data.append('travelDuration', $("#duration").val());
  form_data.append('origin', $("#originResult").text());
  form_data.append('destination', $("#destinationResult").text());
  form_data.append('destinationName', $("#destinationName").val());
  form_data.append('oldTotal', $("#oldTotal").val());
  form_data.append('newTotal', $("#newTotal").text());
  form_data.append('travelType', $("#travelType").val());
  form_data.append('travelDate', $("#travelDate").val());

  // for (const value of form_data.values()) {
  //   console.log(value);
  // }

  fetch ("../backend/create_new_ride.php", {
        method: 'POST',
        body: form_data,
    })
        .then((result) => {
            if (result.status != 200) { throw new Error("Bad Server Response");}
            return result.text();
        })
        .then((response) => {
            let data = JSON.parse(response);

            if (data.success) {
              console.log(data.address, data.addressName);
              checkIfAddressExists(data.address, data.addressName);
            } else {
              console.error(data.error);
            }
        })
}

</script>

<script defer
    src="https://maps.googleapis.com/maps/api/js?libraries=places&language=en&key=AIzaSyDhegrPYuPBDUuTq72h2tsDcosFFJzYksM"
    type="text/javascript"></script>

<script src="../assets/js/mapsAPI.js"></script>

</html>