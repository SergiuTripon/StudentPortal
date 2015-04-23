	$(window).load(function() {
		$(".preloader").fadeOut("slow");
	});

    function togglePreloader() {
        $('.preloader').toggle();
    }

    $("body").on('click', '.btn-load', function() {
        $(this).data('loading-text', 'Loading...').button('loading');
    });

    function buttonReset () {
        $('.btn-load').button('reset');
    }

    var settings = {
        "iDisplayLength": 10,
        "paging": true,
        "ordering": true,
        "info": false,
        "language": {
            "emptyTable": "There are no records to display."
        }
    };

    //Responsiveness
    $(window).resize(function(){
        var width = $(window).width();
        if(width <= 550){
            $('.modal-info .view-action .btn').addClass('btn-block');
            $('.modal-info .view-action').removeClass('pull-left');
            $('.modal-info .view-close .btn').addClass('btn-block');
            $('.modal-info .view-close').removeClass('pull-right').css('cssText', 'margin-top: 5px;');
        } else {
            $('.modal-info .view-action .btn').removeClass('btn-block');
            $('.modal-info .view-action').addClass('pull-left');
            $('.modal-info .view-close .btn').removeClass('btn-block');
            $('.modal-info .view-close').addClass('pull-right').css('cssText', 'margin-top: 0px;');
        }
    }).resize();

	// Disables the background of a cell that contains Victoria in the Station Status table
	$(".table-stationstatus td").filter(function() { return $.trim($(this).text()) === "Victoria"; }).
	closest('tr').addClass( "no-background" );

	// Adds a specific class to a row that contains a specific Tube Line name
	$('.table-custom td').filter(function() { return $.trim($(this).text()) === "Bakerloo"; }).
	closest('tr').addClass( "bakerloo" );
	
	$('.table-custom td').filter(function() { return $.trim($(this).text()) === "Central"; }).
	closest('tr').addClass( "central" ); 
	
	$('.table-custom td').filter(function() { return $.trim($(this).text()) === "Circle"; }).
	closest('tr').addClass( "circle" ); 
	
	$('.table-custom td').filter(function() { return $.trim($(this).text()) === "District"; }).
	closest('tr').addClass( "district" ); 
	
	$('.table-custom td').filter(function() { return $.trim($(this).text()) === "DLR"; }).
	closest('tr').addClass( "dlr" ); 
	
	$('.table-custom td').filter(function() { return $.trim($(this).text()) === "Hammersmith and City"; }).
	closest('tr').addClass( "hammersmith" ); 
	
	$('.table-custom td').filter(function() { return $.trim($(this).text()) === "H'smith & City"; }).
	closest('tr').addClass( "hammersmith" );
	
	$('.table-custom td').filter(function() { return $.trim($(this).text()) === "Jubilee"; }).
	closest('tr').addClass( "jubilee" );
	
	$('.table-custom td').filter(function() { return $.trim($(this).text()) === "Metropolitan"; }).
	closest('tr').addClass( "metropolitan" );
	
	$('.table-custom td').filter(function() { return $.trim($(this).text()) === "Northern"; }).
	closest('tr').addClass( "northern" ); 
	
	$('.table-custom td').filter(function() { return $.trim($(this).text()) === "Overground"; }).
	closest('tr').addClass( "overground" ); 
	
	$('.table-custom td').filter(function() { return $.trim($(this).text()) === "Piccadilly"; }).
	closest('tr').addClass( "picadilly" );
	
	$('.table-custom td').filter(function() { return $.trim($(this).text()) === "Victoria"; }).
	closest('tr').addClass( "victoria" );
	
	$('.table-custom td').filter(function() { return $.trim($(this).text()) === "Waterloo and City"; }).
	closest('tr').addClass( "waterloo" );
	
	$('.table-custom td').filter(function() { return $.trim($(this).text()) === "Waterloo & City"; }).
	closest('tr').addClass( "waterloo" );
