<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'assets/meta-tags.php'; ?>

    <title>Student Portal | Overview</title>

    <?php include 'assets/css-paths/common-css-paths.php'; ?>

    <style>
    .hex-tile {
        position: relative;
        margin: 1em auto;
        width: 10em; height: 17.32em;
        border-radius: 1em/.5em;
        background: orange;
        transition: opacity .5s;
        cursor: pointer;
    }
    .hex-tile:before, .hex-tile:after {
        position: absolute;
        width: inherit; height: inherit;
        border-radius: inherit;
        background: inherit;
        content: '';
    }
    .hex-tile:before {
        transform: rotate(60deg);
    }
    .hex-tile:after {
        transform: rotate(-60deg);
    }
    </style>

</head>

<body>
	
	<div class="preloader"></div>

    <?php include 'includes/menus/menu.php'; ?>

    <div id="overview-portal" class="container">

    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
    <div class="hex-tile"></div>
    </div>

	</div> <!-- /container -->

	<?php include 'includes/footers/footer.php'; ?>

    <?php include 'assets/js-paths/common-js-paths.php'; ?>
    <?php include 'assets/js-paths/tilejs-js-path.php'; ?>

	<script>
    Ladda.bind('.ladda-button', {timeout: 2000});
	</script>

</body>
</html>
