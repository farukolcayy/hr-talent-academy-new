<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Talent Academy</title>
    <link rel="shortcut icon" type="image/x-icon" href="/assets/img/favicon_new.png">
    <head>
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700|Poppins:300,400,500,600,700|PT+Serif:400,400i&display=swap" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
        <link rel="stylesheet" href="css/dark.css" type="text/css" />
        <link rel="stylesheet" href="css/font-icons.css" type="text/css" />
        <link rel="stylesheet" href="css/animate.css" type="text/css" />
        <!-- Bootstrap Data Table Plugin -->
        <link rel="stylesheet" href="./css/components/bs-datatable.css" type="text/css" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
    </head>
</head>

<body>
    <!-- Content
        ============================================= -->
    <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" />
        </svg></div>
    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
                <div class="row">
                    <div class="col-md-3">
                        <a id="exportButton" class="button button-3d button-rounded button-blue"><i class="icon-book3"></i>Dışa Aktar</a>
                    </div>
                </div>
                <div class="row" style="margin: 20px;">
                    <div class="col-md-3">
                        <a id="totalApply" style="border: 2px solid red;padding:10px;"></a>
                    </div>
                    <div class="col-md-3">
                        <a id="todayTotalApply" style="border: 2px solid blue;padding:10px;margin-left:8px;">
                            <?php
                            if (!$link = mysql_connect('localhost', 'hrtalent_basvuru', '!hrt!2021!')) {
                                echo 'mysql\'e bağlanamadı';
                                exit;
                            }

                            if (!mysql_select_db('hrtalent_basvuru', $link)) {
                                echo 'Veritabanı seçilemedi';
                                exit;
                            }

                            $sql    = 'SELECT COUNT(*) as "todayApply" FROM `basvuru` where DATE(applyDate)=CURDATE()';
                            mysql_set_charset('utf8', $link);
                            $result = mysql_query($sql, $link);

                            if (!$result) {
                                echo "Veritabanı hatası, veritabanı sorgulanamıyor\n";
                                echo 'MySQL Hatası: ' . mysql_error();
                                exit;
                            }

                            while ($row = mysql_fetch_assoc($result)) {
                                echo 'Bugünkü toplam : ' . $row['todayApply'];
                            }
                            mysql_free_result($result);

                            ?>
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table style="display:none;" id="datatable2">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Ad </th>
                                <th>Soyad</th>
                                <th>Email</th>
                                <th>Telefon</th>
                                <th>Üniversite</th>
                                <th>Bölüm</th>
                                <th>Sınıf</th>
                                <th>Başvuru Tarihi</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!$link = mysql_connect('localhost', 'hrtalent_basvuru', '!hrt!2021!')) {
                                echo 'mysql\'e bağlanamadı';
                                exit;
                            }

                            if (!mysql_select_db('hrtalent_basvuru', $link)) {
                                echo 'Veritabanı seçilemedi';
                                exit;
                            }

                            $sql    = 'SELECT * FROM basvuru GROUP by emailAddress order by applyDate desc';

                            mysql_set_charset('utf8', $link);
                            $result = mysql_query($sql, $link);

                            if (!$result) {
                                echo "Veritabanı hatası, veritabanı sorgulanamıyor\n";
                                echo 'MySQL Hatası: ' . mysql_error();
                                exit;
                            }

                            while ($row = mysql_fetch_assoc($result)) {
                                echo '<tr>';
                                echo '<td>' . $row['Id'] . '</td>';
                                echo '<td>' . $row['name'] . '</td>';
                                echo '<td>' . $row['surname'] . '</td>';
                                echo '<td>' . $row['emailAddress'] . '</td>';
                                echo '<td>' . $row['phoneNumber'] . '</td>';
                                echo '<td>' . $row['university'] . '</td>';  
                                echo '<td>' . $row['department'] . '</td>';
                                echo '<td>' . $row['class'] . '</td>';    
                                echo '<td>' . substr($row['applyDate'], 0, -9) . '</td>';
                              
                                echo '</tr>';
                            }

                            mysql_free_result($result);

                            ?>
                        </tbody>
                    </table>

                    <table id="datatable1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Ad </th>
                                <th>Soyad</th>
                                <th>Email</th>
                                <th>Telefon</th>
                                <th>Üniversite</th>
                                <th>Bölüm</th>
                                <th>Sınıf</th>
                                <th>Başvuru Tarihi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!$link = mysql_connect('localhost', 'hrtalent_basvuru', '!hrt!2021!')) {
                                echo 'mysql\'e bağlanamadı';
                                exit;
                            }

                            if (!mysql_select_db('hrtalent_basvuru', $link)) {
                                echo 'Veritabanı seçilemedi';
                                exit;
                            }

                            $sql    = 'SELECT * FROM basvuru GROUP by emailAddress order by applyDate desc';
                            mysql_set_charset('utf8', $link);
                            $result = mysql_query($sql, $link);

                            if (!$result) {
                                echo "Veritabanı hatası, veritabanı sorgulanamıyor\n";
                                echo 'MySQL Hatası: ' . mysql_error();
                                exit;
                            }

                            while ($row = mysql_fetch_assoc($result)) {
                                echo '<tr>';
                                echo '<td>' . $row['Id'] . '</td>';
                                echo '<td>' . $row['name'] . '</td>';
                                echo '<td>' . $row['surname'] . '</td>';
                                echo '<td>' . $row['emailAddress'] . '</td>';
                                echo '<td>' . $row['phoneNumber'] . '</td>';
                                echo '<td>' . $row['university'] . '</td>';  
                                echo '<td>' . $row['department'] . '</td>';
                                echo '<td>' . $row['class'] . '</td>';    
                                echo '<td>' . substr($row['applyDate'], 0, -9) . '</td>';
                                echo '</tr>';
                            }

                            mysql_free_result($result);

                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section><!-- #content end -->

    <script src="js/jquery.js"></script>
    <script src="js/plugins.min.js"></script>

    <!-- Bootstrap Data Table Plugin -->
    <script src="js/components/bs-datatable.js"></script>

    <!-- Footer Scripts
	============================================= -->
    <script src="js/functions.js"></script>
    <script src="js/jquery.table2excel.js"></script>

    <script>
        $(document).ready(function() {
            $('#datatable1').dataTable({
                "ordering": false
            });

            $("#exportButton").click(function() {
                $("#datatable2").table2excel({
                    name: "basvurular",
                    filename: "YEA Basvurular", //do not include extension
                    fileext: ".xls" // file extension
                });
            });

            var textUnder = $("#datatable1_info").text();
            $("#totalApply").text("Toplam Başvuru : " + textUnder.substr(0, textUnder.indexOf(' ')));

            $('#ftco-loader').removeClass('show');
        });
    </script>
</body>

</html>