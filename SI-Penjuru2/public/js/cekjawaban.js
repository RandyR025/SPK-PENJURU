// $(document).ready(function() {
//     $(".option").on('change', function() {
//        var optionID = $(this).val();
//        $.ajaxSetup({
//         headers: {
//           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//     });
//             $.ajax({
//               url: '/gethasilpenilaian',
//               method: "POST",
//               data:{optionID: optionID},
//               dataType: "json",
//               contentType: false,
//               processData: false,
//                success:function(data)
//                {
//                   console.log(data);

//              }
//            });
//     });
//     });

function handleClick(myRadio, myPengisian, myUser) {
    //  alert(myPengisian);
    
    $.ajaxSetup({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
    });
    var optionID = myRadio.value;
    var pengisianID = myPengisian;
    var userID = myUser;
    var s = {
      "option_id":optionID,
      "pengisian_id":pengisianID,
      "user_id":userID
    }
    $.ajax({
          url: "/penilaiancek",
          type: "POST",
          data: s,
          success: function (data) {
              console.log(data);
          },
      });
  }
  