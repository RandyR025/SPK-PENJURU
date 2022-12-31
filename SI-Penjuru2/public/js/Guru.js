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
fetchguru();
function fetchguru() {
    $.ajax({
        type: "GET",
        url: "/fetch-guru",
        dataType: "json",
        success: function (response) {
            console.log(response.guru);
            $("tbody").html("");
            $.each(response.guru, function (key, item) {
                if(item.image == null){
                    $("tbody").append(
                        "<tr>\
              <td>" +
                            (key + 1) +
                            '</td>\
              <td><image src="backend/img/profile/profile-11.jpg" width="100px" height="100px" alt="image"></td>\
              <td>' +
                            item.nik +
                            "</td>\
              <td>" +
                            item.name +
                            "</td>\
              <td>" +
                            item.tanggal_lahir +
                            "</td>\
              <td>" +
                            item.tempat_lahir +
                            "</td>\
              <td>" +
                            item.jenis_kelamin +
                            "</td>\
              <td>" +
                            item.alamat +
                            "</td>\
              <td>" +
                            item.no_telp +
                            '</td>\
              <td>\
                <button value="' +
                            item.id +
                            '" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1 edit_guru" type="button" data-bs-placement="top" titte data-bs-original-title="Edit" data-bs-toggle="tooltip">\
                  <i class="fa-solid fa-pen-to-square"></i>\
                </button>\
                <button value="' +
                            item.id +
                            '" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1 delete_guru" type="button" data-bs-toggle="tooltip" data-bs-placement="top" titte data-bs-original-title="Hapus">\
                <i class="fa-solid fa-trash-can"></i>\
                </button>\
                <button value="' +
                            item.id +
                            '" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1 view_guru" type="button" data-bs-toggle="tooltip" data-bs-placement="top" titte data-bs-original-title="View">\
                <i class="fa-regular fa-eye"></i>\
                </button>\
              </td>\
            </tr>'
                    );
                }else{
                    $("tbody").append(
                        "<tr>\
              <td>" +
                            (key + 1) +
                            '</td>\
              <td><image src="images/' +
                            item.image +
                            '" width="100px" height="100px" alt="image"></td>\
              <td>' +
                            item.nik +
                            "</td>\
              <td>" +
                            item.name +
                            "</td>\
              <td>" +
                            item.tanggal_lahir +
                            "</td>\
              <td>" +
                            item.tempat_lahir +
                            "</td>\
              <td>" +
                            item.jenis_kelamin +
                            "</td>\
              <td>" +
                            item.alamat +
                            "</td>\
              <td>" +
                            item.no_telp +
                            '</td>\
              <td>\
                <button value="' +
                            item.id +
                            '" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1 edit_guru" type="button" data-bs-placement="top" titte data-bs-original-title="Edit" data-bs-toggle="tooltip">\
                  <i class="fa-solid fa-pen-to-square"></i>\
                </button>\
                <button value="' +
                            item.id +
                            '" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1 delete_guru" type="button" data-bs-toggle="tooltip" data-bs-placement="top" titte data-bs-original-title="Hapus">\
                <i class="fa-solid fa-trash-can"></i>\
                </button>\
                <button value="' +
                            item.id +
                            '" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1 view_guru" type="button" data-bs-toggle="tooltip" data-bs-placement="top" titte data-bs-original-title="View">\
                <i class="fa-regular fa-eye"></i>\
                </button>\
              </td>\
            </tr>'
                    );
                }
            });
        },
    });
}

/* Delete Data Pengguna */
// $(document).on("click", ".delete_guru", function (e) {
//     e.preventDefault();
//     var guru_id = $(this).val();
//     /* alert(user_id); */
//     $("#delete_guru_id").val(guru_id);
//     $("#deleteModal").modal("show");
// });
// $(document).on("click", ".delete_guru_btn", function (e) {
//     e.preventDefault();
//     var guru_id = $("#delete_guru_id").val();

//     $.ajaxSetup({
//         headers: {
//             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
//         },
//     });
//     $.ajax({
//         type: "DELETE",
//         url: "/delete-guru/" + guru_id,
//         success: function (response) {
//             console.log(response);
//             $("#success_message").addClass("alert alert-success");
//             $("#success_message").text(response.message);
//             $("#deleteModal").modal("hide");
//             fetchguru();
//         },
//     });
// });


$(document).on("click", ".delete_guru", function (e) {
    e.preventDefault();
    var guru_id = $(this).val();
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
                url: "/delete-guru/" + guru_id,
                success: function (response) {
                    console.log(response);
                    // $("#success_message").addClass("alert alert-success");
                    // $("#success_message").text(response.message);
                    $("#deleteModal").modal("hide");
                    fetchguru();
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


/* Edit Data Pengguna */
$(document).on("click", ".edit_guru", function (e) {
    e.preventDefault();
    var guru_id = $(this).val();
    /*  console.log(user_id); */

    $("#editModal").modal("show");
    $.ajax({
        type: "GET",
        url: "/edit-guru/" + guru_id,
        success: function (response) {
            console.log(response);
            if (response.status == 404) {
                $("#success_message").html("");
                $("#success_message").addClass("alert alert-danger");
                $("#success_message").text(response.message);
            } else {
                $("#edit_nik").val(response.guru[0].nik);
                $("#edit_name").val(response.guru[0].name);
                $("#edit_id").val(guru_id);
                $("#edit_tanggallahir").val(response.guru[0].tanggal_lahir);
                $("#edit_tempatlahir").val(response.guru[0].tempat_lahir);
                $("#edit_jeniskelamin").val(response.guru[0].jenis_kelamin);
                $("#edit_alamat").val(response.guru[0].alamat);
                $("#edit_notelp").val(response.guru[0].no_telp);
                if (response.guru[0].image == null) {
                    $(".img-holder-update").html('<img src="backend/img/profile/profile-11.jpg" alt="user" class="rounded-xl border border-separator-light border-4 sw-11 sh-11" />');
                }else{
                    $(".img-holder-update").html('<img src="images/'+response.guru[0].image+'" alt="user" class="rounded-xl border border-separator-light border-4 sw-11 sh-11" />');
                }
                $('input[type="file"]').attr('data-value','<img src="images/'+response.guru[0].image+'" alt="user" class="rounded-xl border border-separator-light border-4 sw-11 sh-11" />');
                $('input[type="file"]').val('');
            }
        },
    });
    $('input[type="file"][name="image"]').on('change', function(){
        var img_path = $(this)[0].value;
        var img_holder = $('.img-holder-update');
        var currentImagePath = $(this).data('value');
        var extension = img_path.substring(img_path.lastIndexOf('.')+1).toLowerCase();
        if(extension == 'jpg' || extension == 'jpeg' || extension == 'png'){
            if(typeof(FileReader) != 'undefined'){
                img_holder.empty();
                var reader = new FileReader();
                reader.onload = function(e){
                    $('<img/>', {'src': e.target.result, 'class': 'rounded-xl border border-separator-light border-4 sw-11 sh-11'}).appendTo(img_holder);
                }
                img_holder.show();
                reader.readAsDataURL($(this)[0].files[0]);
            }else{
                $(img_holder).html('This Browser Not Support File Reader');
            }
        }else{
            $(img_holder).html(currentImagePath);
        }
    });
});

/* Update Data Pengguna */
// $(document).on('click', '.update_guru', function(e){
//   e.preventDefault();
//   var guru_id = $('#edit_id').val();
//   var data = {
//     'name' : $('#edit_name').val(),
//     'nik': $('#edit_nik').val(),
//     'tanggal_lahir': $('#edit_tanggallahir').val(),
//     'tempat_lahir': $('#edit_tempatlahir').val(),
//     'jenis_kelamin': $('#edit_jeniskelamin').val(),
//     'alamat': $('#edit_alamat').val(),
//     'no_telp': $('#edit_notelp').val(),
//   }
//   $.ajaxSetup({
//     headers: {
//       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     }
// });
//   $.ajax({
//     type: "PUT",
//     url: "/update-guru/"+guru_id,
//     data: data,
//     dataType: "json",
//     beforeSend:function(){
//       $(document).find('span.error-text').text('');
//     },
//     success: function (response){
//       // console.log(response)
//       if (response.status == 400) {
//         $('#updateform_errList').html("");
//             $('#updateform_errList').addClass('alert alert-danger');
//             $.each(response.errors, function(prefix, val) {
//               $('span.'+prefix+'_error').text(val[0]);
//             });
//       }else if (response.status == 404) {
//         $('#updateform_errList').html("")
//             $('#success_message').addClass('alert alert-success')
//             $('#success_message').text(response.message)
//       }else{
//         $('#updateform_errList').html("")
//         $('#success_message').html("")
//             $('#success_message').addClass('alert alert-success')
//             $('#success_message').text(response.message)
//             $('#editModal').modal('hide');
//             fetchguru();
//       }
//     }
//   })
// });

/* Tambah Data Pengguna */
$(document).on("submit", "#guru_form", function (e) {
    e.preventDefault();
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var guru_id = $("#edit_id").val();
    let EditformData = new FormData($("#guru_form")[0]);

    $.ajax({
        type: "POST",
        url: "/update-guru/" + guru_id,
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
                fetchguru();
            }
        },
    });
});
