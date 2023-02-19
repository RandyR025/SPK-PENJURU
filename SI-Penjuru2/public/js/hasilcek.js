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
  function handleClick(myRadio, myPengisian) {
    //  alert(myPengisian);
    var userID = myRadio.value;
    var penilaianID = myPengisian;
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
            url: "/delete-cekjawaban/" + userID+ "/penilaian/" + penilaianID,
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
  }