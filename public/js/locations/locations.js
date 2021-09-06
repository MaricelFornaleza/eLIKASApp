var my_handlers = {
    fill_provinces:  function(){
        var region_code = $(this).val();
        $('#province').ph_locations('fetch_list', [{"region_code": region_code}]);

        },
        fill_cities: function(){
            var province_code = $(this).val();
            $('#branch').ph_locations( 'fetch_list', [{"province_code": province_code}]);
        },
        fill_barangays: function(){
            var city_code = $(this).val();
            console.log(city_code);
            $('#barangay_1').ph_locations('fetch_list', [{"city_code": city_code}]);
    }
};

$(function(){
    $('#region').on('change', my_handlers.fill_provinces);
    $('#province').on('change', my_handlers.fill_cities);
    $('#branch').on('change', my_handlers.fill_barangays);

    $('#region').ph_locations({'location_type': 'regions'});
    $('#province').ph_locations({'location_type': 'provinces'});
    $('#branch').ph_locations({'location_type': 'cities'});
    $('#barangay_1').ph_locations({'location_type': 'barangays'});

    $('#region').ph_locations('fetch_list');
    // $('#province').ph_locations('fetch_list', [{"region_code": '01'}]);

});