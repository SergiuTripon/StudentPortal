	$(window).load(function() {
		$(".preloader").fadeOut("slow");
	});

    (function() {

    var width, height, largeHeader, canvas, ctx, circles, target, animateHeader = true;

    // Main
    initHeader();
    addListeners();

    function initHeader() {
        width = window.innerWidth;
        height = window.innerHeight;
        target = {x: 0, y: height};

        largeHeader = document.getElementsByClassName('container');
        largeHeader.style.height = height+'px';

        canvas = document.getElementsByClassName('container');
        canvas.width = width;
        canvas.height = height;
        ctx = canvas.getContext('2d');

        // create particles
        circles = [];
        for(var x = 0; x < width*0.5; x++) {
            var c = new Circle();
            circles.push(c);
        }
        animate();
    }

    // Event handling
    function addListeners() {
        window.addEventListener('scroll', scrollCheck);
        window.addEventListener('resize', resize);
    }

    function scrollCheck() {
        if(document.body.scrollTop > height) animateHeader = false;
        else animateHeader = true;
    }

    function resize() {
        width = window.innerWidth;
        height = window.innerHeight;
        largeHeader.style.height = height+'px';
        canvas.width = width;
        canvas.height = height;
    }

    function animate() {
        if(animateHeader) {
            ctx.clearRect(0,0,width,height);
            for(var i in circles) {
                circles[i].draw();
            }
        }
        requestAnimationFrame(animate);
    }

    // Canvas manipulation
    function Circle() {
        var _this = this;

        // constructor
        (function() {
            _this.pos = {};
            init();
            console.log(_this);
        })();

        function init() {
            _this.pos.x = Math.random()*width;
            _this.pos.y = height+Math.random()*100;
            _this.alpha = 0.1+Math.random()*0.3;
            _this.scale = 0.1+Math.random()*0.3;
            _this.velocity = Math.random();
        }

        this.draw = function() {
            if(_this.alpha <= 0) {
                init();
            }
            _this.pos.y -= _this.velocity;
            _this.alpha -= 0.0005;
            ctx.beginPath();
            ctx.arc(_this.pos.x, _this.pos.y, _this.scale*10, 0, 2 * Math.PI, false);
            ctx.fillStyle = 'rgba(0,0,0,'+ _this.alpha+')';
            ctx.fill();
        };
    }

})();

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
