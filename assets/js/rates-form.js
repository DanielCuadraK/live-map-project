$( "#port-of-loading" ).change(function() {

    switch ($( "#port-of-loading option:selected" ).text()) {
        case 'PORT MANATEE': 
            var items = [
                [1, 'COATZACOALCOS'],
                [3, 'TAMPICO'],
                [4, 'TUXPAN'],
            ];
        break;
        default:
            var items = [
                [1, 'PORT MANATEE'],
            ];
        break;
    }
    $('#port-of-discharge').html('<option selected disabled>Port of Discharge</option>');
    $.each(items, function (i, item) {
        $('#port-of-discharge').append($('<option>', { 
            value: item[0],
            text : item[1] 
        }));
    });
  });

  function validateFields1(){

    var valid = true;
    $(".required").each(function( index ) {
      $(this).removeClass('is-invalid');
      if($(this).val() == "") {
        $(this).addClass('is-invalid');
        valid = false;
      }
   });
   if ($( "#container-type option:selected" ).val() == "Container Type *") {
      $( "#container-type" ).addClass('is-invalid');
      valid = false;
   }
  if(valid)
    $('#rateRequestForm').submit();
  }