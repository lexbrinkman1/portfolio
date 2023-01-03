$(function () {
    // add input listeners
    google.maps.event.addDomListener(window, "load", function () {
      var from_places = new google.maps.places.Autocomplete(
        document.getElementById("from_places")
      );
      var to_places = new google.maps.places.Autocomplete(
        document.getElementById("to_places")
      );

      google.maps.event.addListener(
        from_places,
        "place_changed",
        function () {
          var from_place = from_places.getPlace();
          var from_address = from_place.formatted_address;
          $("#origin").val(from_address);
          $("#resultOrigin").html("");
        }
      );
      google.maps.event.addListener(
        to_places,
        "place_changed",
        function () {
          var to_place = to_places.getPlace();
          var to_address = to_place.formatted_address;
          $("#destination").val(to_address);
          $("#resultDestination").html("");
        }
      );

    });
    // calculate distance
    function calculateDistance() {
      if ($("#origin").val() != "") {
        var origin = $("#origin").val();
      } else if ($("#fromAddress").val() != null) {
        var origin = $("#fromAddress").val();
      }
      if ($("#destination").val() != "") {
        var destination = $("#destination").val();
      } else if ($("#toAddress").val() != null) {
        var destination = $("#toAddress").val();
      }
      var service = new google.maps.DistanceMatrixService();
      service.getDistanceMatrix(
        {
          origins: [origin],
          destinations: [destination],
          travelMode: google.maps.TravelMode.DRIVING,
          unitSystem: google.maps.UnitSystem.IMPERIAL, // miles and feet.
          // unitSystem: google.maps.UnitSystem.metric, // kilometers and meters.
          avoidHighways: false,
          avoidTolls: false,
        },
        callback
      );
    }

    // get distance results
    function callback(response, status) {
      if (status != google.maps.DistanceMatrixStatus.OK) {
        $("#result").html(err);
      } else {
        if (response.originAddresses[0] === "" && $("#fromAddress").val() == null) {
          $("#resultOrigin").html("Geen vertrekplaats ingevuld");
          return;
        }
        if (response.destinationAddresses[0] === "" && $("#toAddress").val() == null) {
          $("#resultDestination").html("Geen bestemming ingevuld");
          return;
        } 

        $("#result").removeClass("hideSection");


        var origin = response.originAddresses[0];
        var destination = response.destinationAddresses[0];
        if (response.rows[0].elements[0].status === "ZERO_RESULTS") {
          $("#result").html(
            "Better get on a plane. There are no roads between " +
            origin +
            " and " +
            destination
          );
        } else {
          var distance = response.rows[0].elements[0].distance.value / 1000;
          var duration = response.rows[0].elements[0].duration.text
          duration = duration.replace(' mins', '');
          let oldTotal = 100;
          $("#distance").val(Math.ceil(distance));
          $("#duration").val(duration);
          $("#originResult").html(origin);
          $("#destinationResult").text(destination);
          $("#oldTotal").val(Math.ceil(oldTotal));
          $("#newTotal").text(oldTotal + Math.ceil(distance));
        }
      }
    }
    // print results on submit the form
    $("#distance_form").submit(function (e) {
      e.preventDefault();
      calculateDistance();
    });
  });