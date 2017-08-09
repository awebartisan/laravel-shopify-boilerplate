$(document).ready(function(){

	/* Below code is mostly required in every project, so please don't remove it */
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    //Handling tabs click event
    $('ul.tabs li').click(function () {

        var tab_id = $(this).children().attr('href');

        $('ul.tabs li').removeClass('active');
        $('.tab-content').removeClass('current');

        $(this).addClass('active');
        $(tab_id).addClass('current');
    });

});