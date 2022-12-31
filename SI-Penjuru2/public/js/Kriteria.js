// fetchkriteria();
// function fetchkriteria() {
//   $.ajax({
//     type: "GET",
//     url: "/fetch-kriteria",
//     dataType: "json",
//     success: function(response){
//       // console.log(response.user);
//       $('tbody').html("");
//       $.each(response.kriteria, function(key, item){
//         $('tbody').append('<tr>\
//           <td>'+(key+1)+'</td>\
//           <td>'+item.kode_kriteria+'</td>\
//           <td>'+item.nama_kriteria+'</td>\
//           <td>\
//           <button value="' +item.kode_kriteria + '" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1 edit_kriteria" type="button" data-bs-placement="top" titte data-bs-original-title="Edit" data-bs-toggle="tooltip">\
//           <i class="fa-solid fa-pen-to-square"></i>\
//           </button>\
//             <button value="'+item.kode_kriteria+'" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1 delete_kriteria" type="button" data-bs-toggle="tooltip" data-bs-placement="top" titte data-bs-original-title="Hapus">\
//             <i class="fa-solid fa-trash-can"></i>\
//             </button>\
//             <a href="/show-subkriteria/'+item.kode_kriteria +'" value="'+item.kode_kriteria +'" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1 view_kriteria" data-bs-toggle="tooltip" data-bs-placement="top" titte data-bs-original-title="View">\
//             <i class="fa-regular fa-eye"></i>\
//             </a>\
//           </td>\
//         </tr>'
//         );
//       });
//     }
    
//   });      
// }


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
            $('#AddKriteriaModal').modal('hide');
            $('#AddKriteriaModal').find('input').val("");
            fetchkriteria();
            setTimeout(function(){
              window.location.reload();
           }, 2000);

          }

        }
      });
    });
  });


  /* Edit Data Pengguna */
$(document).on('click', '.edit_kriteria', function(e){
    e.preventDefault();
    var kriteria_id = $(this).val();
   /*  console.log(user_id); */
  
  
   $('#editModal').modal('show');
   $.ajax({
    type: "GET",
    url: "/edit-kriteria/"+kriteria_id,
    success: function(response){
      console.log(response);
      if(response.status == 404){
        $('#success_message').html("");
        $('#success_message').addClass("alert alert-danger");
        $('#success_message').text(response.message);
      }else{
        $('#edit_id').val(kriteria_id);
        $('#hidden_id').val(kriteria_id);
        $('#edit_namakriteria').val(response.kriteria[0].nama_kriteria);
      }
    }
   });
  });


  /* Update Data Pengguna */
$(document).on("submit", "#kriteria_form", function (e) {
  e.preventDefault();
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  var kriteria_id = $("#hidden_id").val();
  let EditformData = new FormData($("#kriteria_form")[0]);

  $.ajax({
      type: "POST",
      url: "/update-kriteria/" + kriteria_id,
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
              // fetchkriteria();
              setTimeout(function(){
                window.location.reload();
             }, 2000);
          }
      },
  });
});


/* Delete Data Pengguna */
// $(document).on("click", ".delete_kriteria", function (e) {
//   e.preventDefault();
//   var kriteria_id = $(this).val();
//   /* alert(user_id); */
//   $("#delete_kriteria_id").val(kriteria_id);
//   $("#deleteModal").modal("show");
// });
// $(document).on("click", ".delete_kriteria_btn", function (e) {
//   e.preventDefault();
//   var kriteria_id = $("#delete_kriteria_id").val();

//   $.ajaxSetup({
//       headers: {
//           "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
//       },
//   });
//   $.ajax({
//       type: "DELETE",
//       url: "/delete-kriteria/" + kriteria_id,
//       success: function (response) {
//           console.log(response);
//           $("#success_message").addClass("alert alert-success");
//           $("#success_message").text(response.message);
//           $("#deleteModal").modal("hide");
//           fetchkriteria();
//       },
//   });
// });

$(document).on("click", ".delete_kriteria", function (e) {
  e.preventDefault();
  var kriteria_id = $(this).val();
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
        url: "/delete-kriteria/" + kriteria_id,
        success: function (response) {
            console.log(response);
            // $("#success_message").addClass("alert alert-success");
            // $("#success_message").text(response.message);
            // $("#deleteModal").modal("hide");
            // fetchkriteria();
            setTimeout(function(){
              window.location.reload();
           }, 2000);
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
