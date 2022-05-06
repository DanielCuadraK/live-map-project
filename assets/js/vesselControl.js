function showVesselDetails(id){
    
    $.ajax({
        data: {"action" : "getVesselById", "vesselId": id },
        type: "POST",
        dataType: "json",
        url: "scripts/vesselControl.php",
      }).done(function(data, textStatus, jqXHR) {
        $("#vessel-color").spectrum({
            color: data[0].routeColor
        });
        $('#vessel-id').val(data[0].id);
        $('#vessel-name').val(data[0].name);
        $('#vessel-imo').val(data[0].imo);
        $('#vessel-mmsi').val(data[0].mmsi);
        $('#vessel-media-folder').val(data[0].mediaFolder);
        $('#vessel-status').prop("checked", data[0].status);
        $("#vesselDetails").modal();
        $('#btn-update-vessel').show();
        $('#btn-create-vessel').hide();
      });
}

function newVessel(){
    $("#vessel-color").spectrum({
        color: "#000000"
    });
    $('#vessel-id').val("");
    $('#vessel-name').val("");
    $('#vessel-imo').val("");
    $('#vessel-mmsi').val("");
    $('#vessel-media-folder').val("");
    $('#vessel-status').prop("checked", "");
    $("#vesselDetails").modal();
    $('#btn-update-vessel').hide();
    $('#btn-create-vessel').show();
}

function deleteVessel(id) {
    if (confirm('Are you sure you want to save delete this Vessel?')) {
        $.ajax({
            data: {"action" : "deleteVessel", "vesselId": id },
            type: "POST",
            dataType: "text",
            url: "scripts/vesselControl.php",
          }).done(function(data, textStatus, jqXHR) {
            alert("Vessel Deleted");
            drawVesselTable();
          });
      } else {

      }

}

function updateWebService() {
    if (confirm('Are you sure you want to send updates to web service')) {

      $.ajax({
            data: {"action" : "updateList"},
            type: "POST",
            dataType: "json",
          url: "scripts/vesselControl.php",
          }).done(function(data, textStatus, jqXHR) {
            console.log(data.nbrVessels);
            data.forEach(showResults)
            function showResults(value){
                alert("Vessels Added:" + value.nbrVessels + ", Failed to add: " + value.nbrFailedToAdd);

            }

          });
      } else {

      }

}

function updateVessel(action){
    var vesselId = $('#vessel-id').val();
    var vesselName = $('#vessel-name').val();
    var vesselIMO = $('#vessel-imo').val();
    var vesselMMSI = $('#vessel-mmsi').val();
    var vesselMediaFolder = $('#vessel-media-folder').val();
    var vesselStatus = $('#vessel-status').prop('checked');
    var vesselColor = $("#vessel-color").spectrum("get").toHexString();
    $.ajax({
        data: {"action" : action, "vesselId": vesselId,
                "vesselName" : vesselName,
                "vesselIMO" : vesselIMO,
                "vesselMMSI" : vesselMMSI,
                "vesselStatus" : vesselStatus,
                "vesselColor" : vesselColor,
                "vesselMediaFolder" : vesselMediaFolder},
        type: "POST",
        dataType: "text",
        url: "scripts/vesselControl.php",
      }).done(function(data, textStatus, jqXHR) {
        alert("Vessel Updated");
        drawVesselTable();
        $("#vesselDetails").modal('hide');
    });
}
function drawVesselTable() {
$.ajax({
    data: {"action" : "getVessels"},
    type: "POST",
    dataType: "json",
    url: "scripts/vesselControl.php",
})
 .done(function( data, textStatus, jqXHR ) {
    var headers = '<td>NAME</td><td>IMO</td><td>MMSI</td><td>STATUS</td><td>ACTIONS</td>'
    var html= '<table class="table-bordered">'+'<tr>'+headers+'</tr>';
    data.forEach(drawTable);
    html +='</table>';
    $('#vessel-table').html(html);


    function drawTable(value){
    var status;
    if (value.status == 1)
        status = "active";
    else   
        status= "inactive";
    html +='<tr>'
    +'<td>'+value.name+'</td>'+'<td>'+value.imo+'</td>'
    +'<td>'+value.mmsi+'</td>'+'<td>'+status+'</td>'
    +'<td><button class="btn btn-primary" onclick="showVesselDetails('+value.id+')">Edit</button>'
    //+'<button class="btn btn-danger" onclick="deleteVessel('+value.id+')">Delete</button>'
    +'</tr>';
    }
 })
 .fail(function( jqXHR, textStatus, errorThrown ) {
    if ( console && console.log ) {
        console.log( "La solicitud a fallado: " +  textStatus);
    }
});
}

drawVesselTable();