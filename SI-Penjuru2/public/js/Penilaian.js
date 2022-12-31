fetchpenilaian();
function fetchpenilaian() {
  $.ajax({
    type: "GET",
    url: "/fetch-penilaian",
    dataType: "json",
    success: function(response){
      // console.log(response.user);
      $('tbody').html("");
      $.each(response.penilaian, function(key, item){
        $('tbody').append('<tr>\
          <td>'+(key+1)+'</td>\
          <td>'+item.id_penilaian+'</td>\
          <td>'+item.nama_penilaian+'</td>\
          <td>\
          <button value="' +item.id_penilaian + '" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1 edit_penilaian" type="button" data-bs-placement="top" titte data-bs-original-title="Edit" data-bs-toggle="tooltip">\
          <i class="fa-solid fa-pen-to-square"></i>\
          </button>\
            <button value="'+item.id_penilaian+'" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1 delete_penilaian" type="button" data-bs-toggle="tooltip" data-bs-placement="top" titte data-bs-original-title="Hapus">\
            <i class="fa-solid fa-trash-can"></i>\
            </button>\
            <a href="/show-pengisian/'+item.id_penilaian +'" value="'+item.id_penilaian +'" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1 view_penilaian" data-bs-toggle="tooltip" data-bs-placement="top" titte data-bs-original-title="View">\
            <i class="fa-regular fa-eye"></i>\
            </a>\
          </td>\
        </tr>'
        );
      });
    }
    
  });      
}


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
            $('#AddPenilaianModal').modal('hide');
            $('#AddPenilaianModal').find('input').val("");
            fetchpenilaian();

          }

        }
      });
    });
  });


  /* Edit Data Pengguna */
$(document).on('click', '.edit_penilaian', function(e){
    e.preventDefault();
    var penilaian_id = $(this).val();
   /*  console.log(user_id); */
  
  
   $('#editModal').modal('show');
   $.ajax({
    type: "GET",
    url: "/edit-penilaian/"+penilaian_id,
    success: function(response){
      console.log(response);
      if(response.status == 404){
        $('#success_message').html("");
        $('#success_message').addClass("alert alert-danger");
        $('#success_message').text(response.message);
      }else{
        $('#edit_id').val(penilaian_id);
        $('#hidden_id').val(penilaian_id);
        $('#edit_namapenilaian').val(response.penilaian[0].nama_penilaian);
      }
    }
   });
  });


  /* Update Data Pengguna */
$(document).on("submit", "#penilaian_form", function (e) {
  e.preventDefault();
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  var penilaian_id = $("#hidden_id").val();
  let EditformData = new FormData($("#penilaian_form")[0]);

  $.ajax({
      type: "POST",
      url: "/update-penilaian/" + penilaian_id,
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
              fetchpenilaian();
          }
      },
  });
});


/* Delete Data Pengguna */
// $(document).on("click", ".delete_penilaian", function (e) {
//   e.preventDefault();
//   var penilaian_id = $(this).val();
//   /* alert(user_id); */
//   $("#delete_penilaian_id").val(penilaian_id);
//   $("#deleteModal").modal("show");
// });
// $(document).on("click", ".delete_penilaian_btn", function (e) {
//   e.preventDefault();
//   var penilaian_id = $("#delete_penilaian_id").val();

//   $.ajaxSetup({
//       headers: {
//           "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
//       },
//   });
//   $.ajax({
//       type: "DELETE",
//       url: "/delete-penilaian/" + penilaian_id,
//       success: function (response) {
//           console.log(response);
//           $("#success_message").addClass("alert alert-success");
//           $("#success_message").text(response.message);
//           $("#deleteModal").modal("hide");
//           fetchpenilaian();
//       },
//   });
// });


$(document).on("click", ".delete_penilaian", function (e) {
  e.preventDefault();
  var penilaian_id = $(this).val();
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
        url: "/delete-penilaian/" + penilaian_id,
        success: function (response) {
            console.log(response);
            // $("#success_message").addClass("alert alert-success");
            // $("#success_message").text(response.message);
            $("#deleteModal").modal("hide");
            fetchpenilaian();
        },
    });
      
      swalWithBootstrapButtons.fire(
        'Berhasil!',
        'Data Telah Di Hapus',
        'success'
      )
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