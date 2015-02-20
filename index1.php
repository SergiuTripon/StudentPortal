<!DOCTYPE html>
<html lang="en">
<head>

    <?php include 'assets/meta-tags.php'; ?>

    <title>jQuery UI Bootstrap</title>

    <?php include 'assets/css-paths/common-css-paths.php'; ?>

    <?php include 'assets/css-paths/datetimepicker-css-path.php'; ?>

</head>

<body>

    <div class="container">

    <!-- Datepicker -->
    <section id="calendar">
    <div class="page-header">
        <h1>Datepicker</h1>
    </div>
    <div id="datepicker"></div>

    </section>
    <!--end datepicker-->

    </div>

    <?php include 'assets/js-paths/common-js-paths.php'; ?>
    <?php include 'assets/js-paths/datetimepicker-js-path.php'; ?>

    <script>
    // Datepicker
    $('#datepicker').datepicker({
        inline: true
    });
    </script>

</body>
</html>