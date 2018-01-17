<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-sm-8">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title"><span class="glyphicon glyphicon-globe"></span>Peta</h3>
              </div>
              <div class="panel-body">
                <div style="height:300px;" id="map-canvas">
                    
                </div>
              </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-4">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title"><span class="glyphicon glyphicon-map-marker"></span> Form Marker agen</h3>
              </div>
              <div class="panel-body">
                <form>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="latitude">latitude</label>
                                <input type="text" class="form-control" id="latitude" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="longitude">longitude</label>
                                <input type="text" class="form-control" id="longitude" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="agen_id">Nama agen</label>
                        <select class="form-control" name="id_agen" id="id_agen">
                            <option value="">Pilih Nama agen</option>
                            <?php foreach ($itemagen->result() as $agen) {
                               ?> 
                               <option value="<?php echo $agen->id_agen;?>"><?php echo $agen->namaagen ?></option>
                               <?php
                            } ?>
                        </select>
                    </div>
                    <div class="form-group">
                      <button type="button" class="btn btn-primary" id="simpan" name="simpan">Simpan</button>
                      <button type="button" class="btn btn-warning" id="reset" name="reset">Reset</button>
                    </div>
                </form>
              </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                   <h3 class="panel-title"><span class="glyphicon glyphicon-list"></span>Daftar Marker agen</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <th>No</th>
                        <th>Nama agen</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Keterangan</th>
                        <th></th>
                        <tbody id="daftarmarker">
                            <?php
                            $no = 1;
                            foreach ($itemkoordinat->result() as $koordinat) {
                                 ?>
                                 <tr>
                                     <td><?php echo $no;?></td>
                                     <td><?php echo $koordinat->namaagen;?></td>
                                     <td><?php echo $koordinat->latitude;?></td>
                                     <td><?php echo $koordinat->longitude;?></td>
                                     <td><?php echo $koordinat->keterangan;?></td>
                                     <td><button type="button" id="viewmarker" data-idkoordinatagen="<?php echo $koordinat->id_koordinatagen;?>" class="btn btn-sm btn-info" name="button" title="view marker agen"><span class="glyphicon glyphicon-eye-open"></span></button>
                                     <button type="button" id="deletemarker" data-idkoordinatagen="<?php echo $koordinat->id_koordinatagen;?>" class="btn btn-sm btn-danger" name="button" title="hapus marker agen"><span class="glyphicon glyphicon-trash"></span></button></td>
                                 </tr>
                                 <?php 
                                 $no++;
                             } 
                             ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBpcb0I5_aZNkSOjQcbRcmMxAqm2Xveaow&callback=initMap"></script>
<script>
var map;
var markers = [];
 
function initialize() {
    var mapOptions = {
    zoom: 14,
    // Center di kantor kabupaten kudus
    center: new google.maps.LatLng(-6.728456158613311, 110.71789741516113)
    };

    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

    // Add a listener for the click event
    google.maps.event.addListener(map, 'rightclick', addLatLng);
    google.maps.event.addListener(map, "rightclick", function(event) {
      var lat = event.latLng.lat();
      var lng = event.latLng.lng();
      $('#latitude').val(lat);
      $('#longitude').val(lng);
      //alert(lat +" dan "+lng);
    });
}
function addLatLng(event) {
    var marker = new google.maps.Marker({
    position: event.latLng,
    title: 'Lokasi',
    map: map
    });
    markers.push(marker);
}
// Menampilkan marker lokasi agen
function addMarker(nama,location) {
    var marker = new google.maps.Marker({
        position: location,
        map: map,
        title : nama
    });
    markers.push(marker);
}
function clearmap(){
        $('#latitude').val('');
        $('#longitude').val('');
        setMapOnAll(null);
    }
    //buat hapus marker
function setMapOnAll(map) {
  for (var i = 0; i < markers.length; i++) {
    markers[i].setMap(map);
  }
  markers = [];
}
google.maps.event.addDomListener(window, 'load', initialize);
$(document).on('click','#simpan',simpan)
.on('click','#viewmarker',viewmarker)
.on('click','#deletemarker',deletemarker)
.on('click','#reset',reset);
function simpan(){
  var datamarker = {'id_agen':$('#id_agen').val(),
  'latitude':$('#latitude').val(),
  'longitude':$('#longitude').val()};console.log(datamarker);
  $.ajax({
    url : '<?php echo site_url("admin/koordinatagen/create");?>',
    data : datamarker,
    dataType : 'json',
    type : 'POST',
    success : function(data,status){
      if (data.status!='error'){
        reset();
        $('#daftarmarker').load('<?php echo current_url()." #daftarmarker > *";?>');
      }else{
        alert(data.msg);
      }
    },
    errot : function(x,t,m){
      alert(x.responseText);
    }
  })
}
function reset(){
  $('#id_agen').val('');
  $('#latitude').val('');
  $('#longitude').val('');
  clearmap();
}
function viewmarker(){
  var id = $(this).data('idkoordinatagen');
  var datamarker = {'id_koordinatagen':id};console.log(datamarker);
  $.ajax({
      url : '<?php echo site_url("admin/koordinatagen/read");?>',
      data : datamarker,
      dataType : 'json',
      type : 'POST',
      success : function(data,status){
        if (data.status!='error'){
          //reset();
          //$('#daftarmarker').load('<?php echo current_url()." #daftarmarker > *";?>');
          $.each(data.msg,function(k,v){
            $('#latitude').val(v['latitude']);
            $('#longitude').val(v['longitude']);
            $('#id_agen').val(v['id_agen']);
            var myLatLng = {lat: parseFloat(v["latitude"]), lng: parseFloat(v["longitude"])};
            addMarker(v['namaagen'],myLatLng);
          })
        }else{
          alert(data.msg);
        }
      },
      errot : function(x,t,m){
        alert(x.responseText);
      }
    })
}
function deletemarker(){
  if (confirm("Anda yakin mau hapus ??")){
    var id = $(this).data('idkoordinatagen');
    var datamarker = {'id_koordinatagen':id};console.log(datamarker);
    $.ajax({
      url : '<?php echo site_url("admin/koordinatagen/delete");?>',
      data : datamarker,
      dataType : 'json',
      type : 'POST',
      success : function(data,status){
        if (data.status!='error'){
          //reset();
          $('#daftarmarker').load('<?php echo current_url()." #daftarmarker > *";?>');
        }else{
          alert(data.msg);
        }
      },
      errot : function(x,t,m){
        alert(x.responseText);
      }
    })
  }
}
</script>
