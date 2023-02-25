/* Tambah Data Kriteia */
$(function(){
    $("#main_form").on('submit', function(e){
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
          } else {
            
            $('#saveform_errList').html("")
            // $('#success_message').addClass('alert alert-success')
            // $('#success_message').text(response.message)
            const swalWithBootstrapButtons = Swal.mixin({
              customClass: {
                confirmButton: 'btn btn-success',
                
              },
              buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
              title: 'Berhasil',
              text: "Data Telah Di Tambahkan !!!",
              icon: 'success',
              confirmButtonText: 'Ok',
              reverseButtons: true
            })
            $('#AddDetailKelasModal').modal('hide');
            $('#AddDetailKelasModal').find('input').val("");
            setTimeout(function(){
              window.location.reload();
           }, 2000);
  
          }
  
        }
      });
    });
  });
  
  /* Edit Data Pengguna */
 $(document).on('click', '.edit_detailkelas', function(e){
    e.preventDefault();
    var detailkelas_id = $(this).val();
    // var kriteriaID = $(this).val();
   /*  console.log(user_id); */
  
  
   $('#editModal').modal('show');
   $.ajax({
    type: "GET",
    url: "/edit-detailkelas/"+detailkelas_id,
    success: function(response){
      console.log(response);
      if(response.status == 404){
        $('#success_message').html("");
        $('#success_message').addClass("alert alert-danger");
        $('#success_message').text(response.message);
      }else{
        $('#edit_id').val(detailkelas_id);
        $('#edit_kodedetailkelas').val(response.detail_kelas[0].kode_detail_kelas);
        $('#edit_user_id').val(response.detail_kelas[0].user_id).trigger('change');
        // $('#edit_user_id').trigger('change');
      }
    }
   });
  });