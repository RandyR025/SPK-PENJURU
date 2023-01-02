/* PROFIL ADMIN */
$(document).on("submit", "#profile_form", function (e) {
    e.preventDefault();
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var profile_id = $("#edit_id").val();
    let EditformData = new FormData($("#profile_form")[0]);

    $.ajax({
        type: "POST",
        url: "/profile/" + profile_id,
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
                setTimeout(function(){
                    window.location.reload();
                 }, 1000);
            }
        },
    });
});


/* PROFIL GURU */
$(document).on("submit", "#profileguru_form", function (e) {
    e.preventDefault();
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var profile_id = $("#edit_id").val();
    let EditformData = new FormData($("#profileguru_form")[0]);

    $.ajax({
        type: "POST",
        url: "/profileguru/" + profile_id,
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
                setTimeout(function(){
                    window.location.reload();
                 }, 1000);
            }
        },
    });
});