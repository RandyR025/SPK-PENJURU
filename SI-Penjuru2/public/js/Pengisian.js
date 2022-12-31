// fetchsubkriteria();
// function fetchsubkriteria() {
//   $.ajax({
//     type: "GET",
//     url: "/fetch-subkriteria/" + kriteria_id,
//     dataType: "json",
//     success: function(response){
//       // console.log(response.subkriteria);
//       $('tbody').html("");
//       $.each(response.subkriteria, function(key, item){
//         $('tbody').append('<tr>\
//           <td>'+(key+1)+'</td>\
//           <td>'+item.kode_subkriteria+'</td>\
//           <td>'+item.nama_subkriteria+'</td>\
//           <td>\
//           <button value="' +item.kode_kriteria + '" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1 edit_kriteria" type="button" data-bs-placement="top" titte data-bs-original-title="Edit" data-bs-toggle="tooltip">\
//           <i class="fa-solid fa-pen-to-square"></i>\
//           </button>\
//             <button value="'+item.kode_kriteria+'" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1 delete_kriteria" type="button" data-bs-toggle="tooltip" data-bs-placement="top" titte data-bs-original-title="Hapus">\
//             <i class="fa-solid fa-trash-can"></i>\
//             </button>\
//             <a href="/show-subkriteria/'+item.kode_kriteria +'" value="'+item.kode_kriteria +'" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1 view_guru" data-bs-toggle="tooltip" data-bs-placement="top" titte data-bs-original-title="View">\
//             <i class="fa-regular fa-eye"></i>\
//             </a>\
//           </td>\
//         </tr>'
//         );
//       });
//     }
    
//   });      
// }


 /* Edit Data Pengguna */
 $(document).on('click', '.edit_pengisian', function(e){
    e.preventDefault();
    var penilaian_id = $(this).val();
   /*  console.log(user_id); */
  
  
   $('#editModal').modal('show');
   $.ajax({
    type: "GET",
    url: "/edit-pengisian/"+penilaian_id,
    success: function(response){
      console.log(response);
      if(response.status == 404){
        $('#success_message').html("");
        $('#success_message').addClass("alert alert-danger");
        $('#success_message').text(response.message);
      }else{
        $('#edit_id').val(penilaian_id);
        $('#edit_kodepengisian').val(response.pengisian[0].kode_pengisian);
        $('#edit_namapengisian').val(response.pengisian[0].nama_pengisian);
        $('#edit_kodesubkriteria').val(response.pengisian[0].kode_subkriteria);
      }
    }
   });
  });
  
  
  /* Update Data Pengguna */
  $(document).on("submit", "#pengisian_form", function (e) {
    e.preventDefault();
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  
    var penilaian_id = $("#edit_id").val();
    let EditformData = new FormData($("#pengisian_form")[0]);
  
    $.ajax({
        type: "POST",
        url: "/update-pengisian/" + penilaian_id,
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
            $('#AddPengisianModal').modal('hide');
            $('#AddPengisianModal').find('input').val("");
            setTimeout(function(){
              window.location.reload();
           }, 2000);
  
          }
  
        }
      });
    });
  });
  /* Delete Data Pengguna */
  // $(document).on("click", ".delete_pengisian", function (e) {
  //   e.preventDefault();
  //   var subkriteria_id = $(this).val();
  //   /* alert(user_id); */
  //   $("#delete_pengisian_id").val(subkriteria_id);
  //   $("#deleteModal").modal("show");
  // });
  // $(document).on("click", ".delete_pengisian_btn", function (e) {
  //   e.preventDefault();
  //   var pengisian_id = $("#delete_pengisian_id").val();
  
  //   $.ajaxSetup({
  //       headers: {
  //           "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
  //       },
  //   });
  //   $.ajax({
  //       type: "DELETE",
  //       url: "/delete-pengisian/" + pengisian_id,
  //       success: function (response) {
  //           window.location.reload();
  //           console.log(response);
  //           $("#success_message").addClass("alert alert-success");
  //           $("#success_message").text(response.message);
  //           $("#deleteModal").modal("hide");
  //       },
  //   });
  // });


  $(document).on("click", ".delete_pengisian", function (e) {
    e.preventDefault();
    var pengisian_id = $(this).val();


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
          url: "/delete-pengisian/" + pengisian_id,
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


  // $('#kode_kriteria').change(function () {
  //   var kriID = $(this).val();
  //   if (kriID) {
  //     $.ajax({
  //       type:"GET",
  //       url:"/getSubkriteria/"+kriID,
  //       data:{"_token":"{{ csrf_token() }}"},
  //       dataType: 'json',
  //       success:function (data) {
  //         if (data) {
  //           $("#kode_subkriteria").empty();
  //           $("#kode_subkriteria").append('<option>--------Pilih Subkriteria-------</option>');
  //           $.each(data,function (key, subkriteria) {
  //             $('select[name="kode_subkriteria"]').append('<option value="'+key+'">'+subkriteria.nama_subkriteria+'</option>');
  //           });
  //         }else{
  //           $("#kode_subkriteria").empty();
  //         }
  //       }
  //     });
  //   }else{
  //     $("#kode_subkriteria").empty();
  //   }
  // });

  $(document).ready(function() {
    $('#kode_kriteria').on('change', function() {
       var kriteriaID = $(this).val();
       $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
       if(kriteriaID) {
           $.ajax({
               url: '/getsubkriteria/'+kriteriaID,
               type: "GET",
               dataType: "json",
               success:function(response)
               {
                 if(response){
                    $('#kode_subkriteria').empty();
                    $('#kode_subkriteria').append('<option hidden>Choose Course</option>'); 
                    $.each(response, function(key, subkriteria){
                      // console.log(subkriteria);
                      $.each(subkriteria, function (key, value) {
                        $('select[name="kode_subkriteria"]').append('<option value="'+ value.kode_subkriteria +'">' + value.nama_subkriteria+ '</option>');
                      });
                    });
                }else{
                    $('#kode_subkriteria').empty();
                }
             }
           });
       }else{
         $('#kode_subkriteria').empty();
       }
    });
    });