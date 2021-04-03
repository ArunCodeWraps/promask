<?php
include("../include/config.php");
include("../include/functions.php");
include("../include/simpleimage.php"); 
validate_admin();

if($_REQUEST['submitForm']=='yes'){
	$name=$obj->escapestring($_REQUEST['name']);
	$email=$obj->escapestring($_REQUEST['email']);
	$password=$obj->escapestring($_REQUEST['password']);
	$cpassword=$obj->escapestring($_REQUEST['cpassword']);
	$address=$obj->escapestring($_REQUEST['address']);
	$lat=$obj->escapestring($_REQUEST['lat']);
	$lng=$obj->escapestring($_REQUEST['lng']);


	if($_REQUEST['id']==''){
		$obj->query("insert into $tbl_user set seller_id='".$_SESSION['sess_user_id']."',name='$name',email='$email',password='$password',address='$address',lat='$lat',lng='$lng',type='user'",$debug=-1);
		$_SESSION['sess_msg']='User added sucessfully';
	}else{     
		$obj->query("update $tbl_user set name='$name',email='$email',address='$address',lat='$lat',lng='$lng' where id='".$_REQUEST['id']."'",$debug=-1);
		$obj->query($sql);
		$_SESSION['sess_msg']='User updated successfully';   
	}
	header("location:user-list.php");
	exit();
}
if($_REQUEST['id']!=''){
$sql=$obj->query("select * from $tbl_user where id=".$_REQUEST['id']);
$result=$obj->fetchNextObject($sql);
}    
?>
<!DOCTYPE html>
<html>
<?php include("head.php"); ?>
<body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
<?php include("header.php"); ?>
<?php include("menu.php"); ?>
<div class="app-content content">
<div class="content-wrapper">
<div class="content-body">
<section id="basic-vertical-layouts " class="simple-validation">
<div class="row match-height">
<div class="col-md-12 col-12">
<div class="card">
<div class="card-header">
<h4 class="card-title"><?php if($_REQUEST['id']==''){?> Add <?php }else{?> Update <?php }?> User</h4>
</div>
<div class="card-content">
<div class="card-body">
<form name="frm" method="POST" enctype="multipart/form-data" action="" class="form-horizontal" novalidate>
<input type="hidden" name="submitForm" value="yes" />
<input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
<div class="form-body">
	<div class="row">
		<div class="col-6">
			<div class="form-group">
				<div class="controls">	
					<label for="first-name-vertical">Name</label>
					<input type="text" id="first-name-vertical" class="form-control" name="name" placeholder="Name" required data-validation-required-message="This Name field is required" value="<?php echo stripslashes($result->name);?>">	
				</div>  	                                           
			</div>
		</div>	
		<div class="col-6">
			<div class="form-group">
				<div class="controls">	
					<label for="first-name-vertical">Email</label>
					<input type="text" id="first-name-vertical" class="form-control" name="email" placeholder="Email" required data-validation-required-message="This Email field is required" value="<?php echo stripslashes($result->email);?>">	
				</div>  	                                           
			</div>
		</div>	
	</div>
	<?php
	if($_REQUEST['id']==''){?>
	<div class="row">
		<div class="col-6">
			<div class="form-group">
				<div class="controls">	
					<label for="first-name-vertical">Password</label>
					<input type="password" id="password" class="form-control" name="password" placeholder="Password" required data-validation-required-message="This Password field is required" value="">	
				</div>  	                                           
			</div>
		</div>	
		<div class="col-6">
			<div class="form-group">
				<div class="controls">	
					<label for="first-name-vertical">Confirm Password</label>
					<input type="password" id="cpassword" class="form-control" name="cpassword" placeholder="Confirm Password" required data-validation-required-message="This Confirm Password field is required" value="">		
				</div>
				<span id="cpassmessage"></span>  	                                           
			</div>
		</div>	
	</div>
<?php }?>

	<div class="row">
			<div class="col-12">
				<div class="form-group">
					<div class="controls">	
						<label for="first-name-vertical">Address</label>
						<input type="text" id="address" class="form-control" name="address" placeholder="Address" required data-validation-required-message="This address field is required" value="<?php echo stripslashes($result->address);?>">	
						<input type="hidden" id="latitude" name="lat" class="form-control" value="<?php echo $result->lat ?>">
                		<input type="hidden" id="longitude" name="lng" class="form-control" value="<?php echo $result->lng ?>">
					</div>  	                                           
				</div>
			</div>
			<div class="col-12">
				<div class="form-group">
              	 <div id="map" style="height: 300px;"></div>
             </div>	
              </div>	
		</div>
	<div class="row">
		<div class="col-12">
			<button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Submit</button>
			<button type="reset" class="btn btn-outline-warning mr-1 mb-1 waves-effect waves-light">Reset</button>
		</div>
	</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</section>
</div>
</div>
</div>
<div class="sidenav-overlay"></div>
<div class="drag-target"></div>
<?php include("footer.php"); ?>
<script type="text/javascript">
	$('#cpassword').on('keyup', function () {
		if ($('#password').val() == $('#cpassword').val()) {
			$('#cpassmessage').html('Matching').css('color', 'green');
		} else 
			$('#cpassmessage').html('Not Matching').css('color', 'red');
	});
</script>


<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWJvw_MNycP_WYaTnYWOhSlzHMu9kPmM0&libraries=places"></script>

<script type="text/javascript">

  $('#address').keyup(function(){  

    var places = new google.maps.places.Autocomplete($(this)[0]);

    google.maps.event.addListener(places, 'place_changed', function () 
    {
      var place = places.getPlace();
      var address = place.formatted_address;
      var latitude = place.geometry.location.lat();
      var longitude = place.geometry.location.lng();


      var mesg = "Address: " + address;
      mesg += "\nLatitude: " + latitude;
      mesg += "\nLongitude: " + longitude;

      $('input[type="text"][name="address"]').val(address);
      $('input[type="hidden"][name="lat"]').val(latitude);
      $('input[type="hidden"][name="lng"]').val(longitude);


      codeAddress(address);    
    });

  });
</script>
<script>
  var geocoder;
  var map;
  var infowindow;
  var marker;
    //define the basic color of your map, plus a value for saturation and brightness
  var main_color = '#2d313f',
    saturation_value= -20,
    brightness_value= 5;

  //we define here the style of the map
  var style= [ 
    {
      //set saturation for the labels on the map
      elementType: "labels",
      stylers: [
        {saturation: saturation_value}
      ]
    },  
      { //poi stands for point of interest - don't show these lables on the map 
      featureType: "poi",
      elementType: "labels",
      stylers: [
        {visibility: "off"}
      ]
    },
    {
      //don't show highways lables on the map
          featureType: 'road.highway',
          elementType: 'labels',
          stylers: [
              {visibility: "off"}
          ]
      }, 
    {   
      //don't show local road lables on the map
      featureType: "road.local", 
      elementType: "labels.icon", 
      stylers: [
        {visibility: "off"} 
      ] 
    },
    { 
      //don't show arterial road lables on the map
      featureType: "road.arterial", 
      elementType: "labels.icon", 
      stylers: [
        {visibility: "off"}
      ] 
    },
    {
      //don't show road lables on the map
      featureType: "road",
      elementType: "geometry.stroke",
      stylers: [
        {visibility: "off"}
      ]
    }, 
    //style different elements on the map
    { 
      featureType: "transit", 
      elementType: "geometry.fill", 
      stylers: [
        { hue: main_color },
        { visibility: "on" }, 
        { lightness: brightness_value }, 
        { saturation: saturation_value }
      ]
    }, 
    {
      featureType: "poi",
      elementType: "geometry.fill",
      stylers: [
        { hue: main_color },
        { visibility: "on" }, 
        { lightness: brightness_value }, 
        { saturation: saturation_value }
      ]
    },
    {
      featureType: "poi.government",
      elementType: "geometry.fill",
      stylers: [
        { hue: main_color },
        { visibility: "on" }, 
        { lightness: brightness_value }, 
        { saturation: saturation_value }
      ]
    },
    {
      featureType: "poi.sport_complex",
      elementType: "geometry.fill",
      stylers: [
        { hue: main_color },
        { visibility: "on" }, 
        { lightness: brightness_value }, 
        { saturation: saturation_value }
      ]
    },
    {
      featureType: "poi.attraction",
      elementType: "geometry.fill",
      stylers: [
        { hue: main_color },
        { visibility: "on" }, 
        { lightness: brightness_value }, 
        { saturation: saturation_value }
      ]
    },
    {
      featureType: "poi.business",
      elementType: "geometry.fill",
      stylers: [
        { hue: main_color },
        { visibility: "on" }, 
        { lightness: brightness_value }, 
        { saturation: saturation_value }
      ]
    },
    {
      featureType: "transit",
      elementType: "geometry.fill",
      stylers: [
        { hue: main_color },
        { visibility: "on" }, 
        { lightness: brightness_value }, 
        { saturation: saturation_value }
      ]
    },
    {
      featureType: "transit.station",
      elementType: "geometry.fill",
      stylers: [
        { hue: main_color },
        { visibility: "on" }, 
        { lightness: brightness_value }, 
        { saturation: saturation_value }
      ]
    },
    {
      featureType: "landscape",
      stylers: [
        { hue: main_color },
        { visibility: "on" }, 
        { lightness: brightness_value }, 
        { saturation: saturation_value }
      ]
      
    },
    {
      featureType: "road",
      elementType: "geometry.fill",
      stylers: [
        { hue: main_color },
        { visibility: "on" }, 
        { lightness: brightness_value }, 
        { saturation: saturation_value }
      ]
    },
    {
      featureType: "road.highway",
      elementType: "geometry.fill",
      stylers: [
        { hue: main_color },
        { visibility: "on" }, 
        { lightness: brightness_value }, 
        { saturation: saturation_value }
      ]
    }, 
    {
      featureType: "water",
      elementType: "geometry",
      stylers: [
        { hue: main_color },
        { visibility: "on" }, 
        { lightness: brightness_value }, 
        { saturation: saturation_value }
      ]
    }
  ];
    
  
  
  <?php if(!empty($result->lat) && !empty($result->lng)){ ?>
    var center = new google.maps.LatLng('<?php echo $result->lat ?>', '<?php echo $result->lng ?>');
  <?php } else{?>
   var center = new google.maps.LatLng('4.624335', '-74.063644');
 <?php } ?>
 geocoder = new google.maps.Geocoder();
 //var center = new google.maps.LatLng('28.7041', '77.1025');
 function initialize() 
 {
    // console.log("dsfdasf");

    var mapOptions = { 
      zoom: 10,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      center: center,
    styles: style,
    disableDefaultUI: true,
    };

    map = new google.maps.Map(document.getElementById('map'), mapOptions);

    marker = new google.maps.Marker({ map: map, position: center, draggable: true});


    google.maps.event.addListener(marker, 'dragend', function() {
      geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) 
        {

          if (results[0]) 
          {
            $('input[type="text"][name="address"]').val(results[0].formatted_address);
            $('input[type="hidden"][name="lat"]').val(marker.getPosition().lat());
            $('input[type="hidden"][name="lng"]').val(marker.getPosition().lng());
            console.log(results);
          }
        }
      });
    }); 
  }
  function codeAddress(address) 
  {
  // var address = document.getElementById("address").value;

  $.ajax({
    type: "GET",
    dataType: "json",
    url: "http://maps.googleapis.com/maps/api/geocode/json",
    data: {'address': address,'sensor':false},
    success: function(data){
      if(data.results.length){
        $('#latitude').val(data.results[0].geometry.location.lat);
        $('#longitude').val(data.results[0].geometry.location.lng);
      }else{
        // $('#latitude').val('invalid address');
        // $('#longitude').val('invalid address');
      }
    }
  }); 
  geocoder.geocode({
    'address': address
  }, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      map.setCenter(results[0].geometry.location);
      var marker = new google.maps.Marker({
        map: map,
        position: results[0].geometry.location,
        draggable: true 
      });


      google.maps.event.addListener(marker, 'dragend', function() {
        geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) 
          {
            if (results[0]) 
            {
              $('input[type="text"][name="location"]').val(results[0].formatted_address);
              $('input[type="hidden"][name="lat"]').val(marker.getPosition().lat());
              $('input[type="hidden"][name="lng"]').val(marker.getPosition().lng());
            }
          }
        });
      });
    } 
  else { /* alert("Geocode was not successful for the following reason: " + status); */   }
});
}

function callback(results, status) 
{
  if (status == google.maps.places.PlacesServiceStatus.OK) 
  {
    for (var i = 0; i < results.length; i++) 
    {
      createMarker(results[i]);
    }
  }
}

function createMarker(place) 
{
  var placeLoc = place.geometry.location;
  var marker = new google.mapps.Marker({
    map: map,
    position: place.geometry.location
  });

  google.maps.event.addListener(marker, 'mouseover', function() {
    infowindow.setContent(place.name);
    infowindow.open(map, this);
  });
}

function moveBus( map, marker ) {
  marker.setPosition( new google.maps.LatLng( 0, 0 ) );
  map.panTo( new google.maps.LatLng( 0, 0 ) );

};

function geocodePosition(pos) 
{
  geocoder.geocode({
    latLng: pos
  }, function(responses) {
    if (responses && responses.length > 0) {
      return marker.formatted_address = responses[0].formatted_address; console.log(responses[0].formatted_address);
    } else {
      return marker.formatted_address = 'Cannot determine address at this location.';
    }
//      infowindow.setContent(marker.formatted_address + "<br>coordinates: " + marker.getPosition().toUrlValue(6));
//      infowindow.open(map, marker);
});
}
$(function(){
  /* Check the user membership status*/
  // console.log("dasfdasfdasf");
  initialize();  
});
// initialize();
</script>
</body>
</html>
