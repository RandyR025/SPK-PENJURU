fetchkriteria();
function fetchkriteria() {
  $.ajax({
    type: "GET",
    url: "/fetch-kriteria",
    dataType: "json",
    success: function(response){
      // console.log(response.user);
      $('tbody').html("");
      $.each(response.kriteria, function(key, item){
        $('tbody').append('<tr>\
          <td>'+(key+1)+'</td>\
          <td>'+item.kode_kriteria+'</td>\
          <td>'+item.nama_kriteria+'</td>\
          <td>\
            <a href="/show-subkriteria/'+item.kode_kriteria +'" value="'+item.kode_kriteria +'" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1 view_kriteria" data-bs-toggle="tooltip" data-bs-placement="top" titte data-bs-original-title="View">\
            <i class="fa-regular fa-eye"></i>\
            </a>\
            <a href="/show-perbandingansubkriteria/'+item.kode_kriteria +'" value="'+item.kode_kriteria +'" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1 view_kriteria" data-bs-toggle="tooltip" data-bs-placement="top" titte data-bs-original-title="View">\
            <i class="fa-solid fa-table-cells"></i>\
            </a>\
          </td>\
        </tr>'
        );
      });
    }
    
  });      
}
