	// Replaces empty text with "No Extra Information"
    $('td').each(function () {
    if ($(this).html().trim().length === 0) 
    $(this).append("No Extra Information");
    });
	
	// Disables the background of a cell that contains Victoria in the Station Status table
	$(".table-custom td").filter(function(index) { return $.trim($(this).text()) === "Victoria"; }).
	closest('tr').addClass( "no-background" );

	// Adds a specific class to a row that contains a specific Tube Line name
	$('td').filter(function(index) { return $.trim($(this).text()) === "Bakerloo"; }).
	closest('tr').addClass( "bakerloo" );
	
	$('td').filter(function(index) { return $.trim($(this).text()) === "Central"; }).
	closest('tr').addClass( "central" ); 
	
	$('td').filter(function(index) { return $.trim($(this).text()) === "Circle"; }).
	closest('tr').addClass( "circle" ); 
	
	$('td').filter(function(index) { return $.trim($(this).text()) === "District"; }).
	closest('tr').addClass( "district" ); 
	
	$('td').filter(function(index) { return $.trim($(this).text()) === "DLR"; }).
	closest('tr').addClass( "dlr" ); 
	
	$('td').filter(function(index) { return $.trim($(this).text()) === "Hammersmith and City"; }).
	closest('tr').addClass( "hammersmith" ); 
	
	$('td').filter(function(index) { return $.trim($(this).text()) === "H'smith & City"; }).
	closest('tr').addClass( "hammersmith" );  
	
	$('td').filter(function(index) { return $.trim($(this).text()) === "Jubilee"; }).
	closest('tr').addClass( "jubilee" );
	
	$('td').filter(function(index) { return $.trim($(this).text()) === "Metropolitan"; }).
	closest('tr').addClass( "metropolitan" );
	
	$('td').filter(function(index) { return $.trim($(this).text()) === "Northern"; }).
	closest('tr').addClass( "northern" ); 
	
	$('td').filter(function(index) { return $.trim($(this).text()) === "Overground"; }).
	closest('tr').addClass( "overground" ); 
	
	$('td').filter(function(index) { return $.trim($(this).text()) === "Piccadilly"; }).
	closest('tr').addClass( "picadilly" );
	
	$('td').filter(function(index) { return $.trim($(this).text()) === "Victoria"; }).
	closest('tr').addClass( "victoria" );
	
	$('td').filter(function(index) { return $.trim($(this).text()) === "Waterloo and City"; }).
	closest('tr').addClass( "waterloo" );
	
	$('td').filter(function(index) { return $.trim($(this).text()) === "Waterloo & City"; }).
	closest('tr').addClass( "waterloo" );
	
	//If a table cell contains "Information" it replaces it with "No Extra Information"
	$('td').filter(function(index) { return $.trim($(this).text()) === "Information"; }).empty().
	append("No Extra Information");
	
	//If a table cell contains "True" it replaces it with "Yes"
	$('td').filter(function(index) { return $.trim($(this).text()) === "true"; }).empty().
	append("Yes");
	
	//If a table cell contains "True" it replaces it with "Yes"
	$('td').filter(function(index) { return $.trim($(this).text()) === "false"; }).empty().
	append("No");
	
