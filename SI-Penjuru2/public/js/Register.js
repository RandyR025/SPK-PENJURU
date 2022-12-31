$(function(){
    $("registerForm").on('submit', function(e){
      e.preventDefault();
    //   $.ajaxSetup({
    //     headers: {
    //       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    // });

      $.ajax({
        url:$(this).attr('action'),
        method:$(this).attr('method'),
        data:new FormData(this),
        processData:false,
        dataType: "json",
        contentType:false,
        beforeSend:function(){
          $(document).find('span.error-text').text('');
        },
        success:function(response){
          console.log(response);
          if (response.status == 400) {
            $('#saveform_errList').html("");
            $('#saveform_errList').addClass('alert alert-danger');
            $.each(response.errors, function(prefix, val) {
              $('span.'+prefix+'_error').text(val[0]);
            });
          } 
        }
      });
    });
  });