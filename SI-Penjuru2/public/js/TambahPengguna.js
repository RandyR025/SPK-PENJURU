//   $(document).ready(function() {

//     $(document).on('click', '.add_pengguna', function(e) {
//       e.preventDefault();
//       /* console.log("dian cantik"); */
//       var data = {
//         'name': $('.namapengguna').val(),
//         'email': $('.email').val(),
//         'password': $('.password').val(),
//       }
//       console.log(data);

//       $.ajaxSetup({
//         headers: {
//           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//       });
//       $.ajax({
//         type: "POST",
//         url: "/datapengguna",
//         data: data,
//         dataType: "json",
//         success: function(response) {
//           /* console.log(response); */

//           if (response.status == 400) {
//             $('#saveform_errList').html("");
//             $('#saveform_errList').addClass('alert alert-danger');
//             $.each(response.errors, function(prefix, val) {
//               $('span.'+prefix+'_error').text(val[0]);
//             });
//           } else {
//             $('#saveform_errList').html("")
//             $('#success_message').addClass('alert alert-success')
//             $('#success_message').text(response.message)
//             $('#AddPenggunaModal').modal('hide');
//             $('#AddPenggunaModal').find('input').val("");

//           }
//         }
//       });
//     });
//   });



/* Fetch Pengguna */
fetchuser();
function fetchuser() {
  $.ajax({
    type: "GET",
    url: "/fetch-user",
    dataType: "json",
    success: function(response){
      // console.log(response.user);
      $('tbody').html("");
      $.each(response.user, function(key, item){
        $('tbody').append('<tr>\
          <td>'+(key+1)+'</td>\
          <td>'+item.name+'</td>\
          <td>'+item.email+'</td>\
          <td>'+item.level+'</td>\
          <td>\
            <button value="'+item.id+'" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1 edit_user" type="button" data-bs-placement="top" titte data-bs-original-title="Edit" data-bs-toggle="modal">\
              <i class="fa-solid fa-pen-to-square"></i>\
            </button>\
            <button value="'+item.id+'" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1 delete_user" type="button" data-bs-toggle="tooltip" data-bs-placement="top" titte data-bs-original-title="Hapus">\
            <i class="fa-solid fa-trash-can"></i>\
            </button>\
          </td>\
        </tr>'
        );
      });
    }
    
  });      
}

/* Delete Data Pengguna */
// $(document).on('click', '.delete_user', function(e){
//   e.preventDefault();
//   var user_id = $(this).val();
//   /* alert(user_id); */
//   $('#delete_user_id').val(user_id);
//   $('#deleteModal').modal('show');
// });
// $(document).on('click', '.delete_user_btn', function(e){
//   e.preventDefault();
//   var user_id = $('#delete_user_id').val();

//   $.ajaxSetup({
//     headers: {
//       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     }
// });
//   $.ajax({
//     type: "DELETE",
//     url: "/delete-user/"+user_id,
//     success: function (response){
//       console.log(response);
//       $('#success_message').addClass('alert alert-success');
//       $('#success_message').text(response.message);
//       $('#deleteModal').modal('hide');
//       fetchuser();
//     }

//   })
// });


$(document).on('click', '.delete_user', function(e){
  e.preventDefault();
  var user_id = $(this).val();
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
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
      $.ajax({
        type: "DELETE",
        url: "/delete-user/"+user_id,
        success: function (response){
          console.log(response);
          // $('#success_message').addClass('alert alert-success');
          // $('#success_message').text(response.message);
          // $('#deleteModal').modal('hide');
          fetchuser();
        }
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


/* Edit Data Pengguna */
$(document).on('click', '.edit_user', function(e){
  e.preventDefault();
  var user_id = $(this).val();
 /*  console.log(user_id); */


 $('#editModal').modal('show');
 $.ajax({
  type: "GET",
  url: "/edit-user/"+user_id,
  success: function(response){
    console.log(response);
    if(response.status == 404){
      $('#success_message').html("");
      $('#success_message').addClass("alert alert-danger");
      $('#success_message').text(response.message);
    }else{
      $('#edit_name').val(response.user.name);
      $('#edit_email').val(response.user.email);
      $('#edit_id').val(user_id);
      $('#edit_password').val(response.user.password);
      $('#edit_level').val(response.user.level);
    }
  }
 });
});


/* Update Data Pengguna */
$(document).on('click', '.update_user', function(e){
  e.preventDefault();
  var user_id = $('#edit_id').val();
  var data = {
    'name' : $('#edit_name').val(),
    'email': $('#edit_email').val(),
    'level': $('#edit_level').val(),
    'password': $('#edit_password').val(),
  }
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
  $.ajax({
    type: "PUT",
    url: "/update-user/"+user_id,
    data: data,
    dataType: "json",
    beforeSend:function(){
      $(document).find('span.error-text').text('');
    },
    success: function (response){
      // console.log(response)
      if (response.status == 400) {
        $('#updateform_errList').html("");
            $('#updateform_errList').addClass('alert alert-danger');
            $.each(response.errors, function(prefix, val) {
              $('span.'+prefix+'_error').text(val[0]);
            });
      }else if (response.status == 404) {
        $('#updateform_errList').html("")
            $('#success_message').addClass('alert alert-success')
            $('#success_message').text(response.message)
      }else{
        $('#updateform_errList').html("")
        $('#success_message').html("")
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
              text: "Data Telah Di Perbarui !!!",
              icon: 'success',
              confirmButtonText: 'Ok',
              reverseButtons: true
            })
            $('#editModal').modal('hide');
            fetchuser();
      }
    }
  })
});


/* Tambah Data Pengguna */
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
            $('#AddPenggunaModal').modal('hide');
            $('#AddPenggunaModal').find('input').val("");
            fetchuser();

          }

        }
      });
    });
  });
  