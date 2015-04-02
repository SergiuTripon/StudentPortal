	$(window).load(function() {
		$(".preloader").fadeOut("slow");
	});

    function buttonLoad () {
        $('.btn').button('Loading');
    }

    function buttonReset () {
        $('.btn').button('reset');
    }

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
