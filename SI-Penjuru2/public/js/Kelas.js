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
            $('#AddKelasModal').modal('hide');
            $('#AddKelasModal').find('input').val("");
            // fetchpenilaian();
            setTimeout(function(){
              window.location.reload();
           }, 2000);

          }

        }
      });
    });
  });

  /* Edit Data Pengguna */
 $(document).on('click', '.edit_kelas', function(e){
    e.preventDefault();
    var kelas_id = $(this).val();
    // var kriteriaID = $(this).val();
   /*  console.log(user_id); */
  
  
   $('#editModal').modal('show');
   $.ajax({
    type: "GET",
    url: "/edit-kelas/"+kelas_id,
    success: function(response){
      console.log(response);
      if(response.status == 404){
        $('#success_message').html("");
        $('#success_message').addClass("alert alert-danger");
        $('#success_message').text(response.message);
      }else{
        $('#edit_id').val(kelas_id);
        $('#edit_kodekelas').val(response.kelas[0].kode_kelas);
        $('#edit_namakelas').val(response.kelas[0].nama_kelas);
      }
    }
   });
  });

  /* Update Data Pengguna */
  $(document).on("submit", "#kelas_form", function (e) {
    e.preventDefault();
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  
    var kelas_id = $("#edit_id").val();
    let EditformData = new FormData($("#kelas_form")[0]);
  
    $.ajax({
        type: "POST",
        url: "/update-kelas/" + kelas_id,
        data: EditformData,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $(document).find("span.error-text").text("");
        },
        success: function (response) {
            console.log(response);
            if (response.status == 400) {
                $("#saveform_errList").html("");
                $("#saveform_errList").addClass("alert alert-danger");
                $.each(response.errors, function (prefix, val) {
                    $("span." + prefix + "_error").text(val[0]);
                });
              } else {
                $("#saveform_errList").html("");
                // $("#success_message").addClass("alert alert-success");
                // $("#success_message").text(response.message);
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    
                  },
                  buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                  title: 'Berhasil',
                  text: "Data Telah Di Perbarui !!!",
                  icon: 'success',
                  confirmButtonText: 'Ok',
                  reverseButtons: true
                })
                $("#editModal").modal("hide");
                $("#editModal").find("input").val("");
                setTimeout(function(){
                  window.location.reload();
               }, 2000);
                // fetchkriteria();
            }
        },
    });
  });

  $(document).on("click", ".delete_kelas", function (e) {
    e.preventDefault();
    var kelas_id = $(this).val();


    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger',
      },
      buttonsStyling: true
    })
    
    swalWithBootstrapButtons.fire({
      title: 'Yakin Hapus Data?',
      text: "Anda Tidak Akan Dapat Mengembalikan Data Ini!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, Hapus!',
      cancelButtonText: 'Batal!',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajaxSetup({
          headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          },
      });
      $.ajax({
          type: "DELETE",
          url: "/delete-kelas/" + kelas_id,
          success: function (response) {
              console.log(response);
              // $("#success_message").addClass("alert alert-success");
              // $("#success_message").text(response.message);
              $("#deleteModal").modal("hide");
          },
      });
        
        swalWithBootstrapButtons.fire(
          'Berhasil!',
          'Data Telah Di Hapus',
          'success'
        )
        setTimeout(function(){
          window.location.reload();
       }, 2000);
      } else if (
        /* Read more about handling dismissals below */
        result.dismiss === Swal.DismissReason.cancel
      ) {
        swalWithBootstrapButtons.fire(
          'Batal',
          'Data Anda Aman :D',
          'error'
        )
      }
    })
    
  });