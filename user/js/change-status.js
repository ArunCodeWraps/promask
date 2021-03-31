  
  $("#check_all").click(function(){
     $('.checkall').not(this).prop('checked', this.checked); 
  });
  
$('.chkstatus').click(function() {
    if ($(this).is(':checked')) {
        var status=1;
    }else{
       status=0;
    }


    var id=$(this).val();
    var tableName=$(this).data('one');
    $.ajax({
      type: "POST",
      url: "ajax/change-status.php",
      data:'id='+id+'&tableName='+tableName+'&status='+status,
      success: function(data){
          console.log(data);
      }
    });

  });

function changeStatus(id,chk,tableName){
  //alert(chk);

  if (chk) {
        var status=1;
    }else{
       var status=0;
    }
   val = id.split(' ');

    $.ajax({
      type: "POST",
      url: "ajax/change-status.php",
      data:'id='+val[0]+'&tableName='+val[1]+'&status='+status,
      success: function(data){
          console.log(data);
      }
    });

}

function makeMonthlySpecial(id,chk){
  $.ajax({
    url:"makeMonthSpecial.php",
    data:{id:id,chk:chk},
    success:function(data){
      //alert(data);
    }
    
    })
}

function makeExOffer(id,chk){
  $.ajax({
    url:"MakeExOffer.php",
    data:{id:id,chk:chk},
    success:function(data){
      //alert(data);
    }
    
    })
}