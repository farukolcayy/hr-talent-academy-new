<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTA - Sorular</title>

    <head>
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700|Poppins:300,400,500,600,700|PT+Serif:400,400i&display=swap" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="../css/bootstrap.css" type="text/css" />
        <!-- <link rel="stylesheet" href="../assets/style.css" type="text/css" /> -->
        <link rel="stylesheet" href="../css/dark.css" type="text/css" />
        <!-- <link rel="stylesheet" href="../css/font-icons.css" type="text/css" /> -->
        <link rel="stylesheet" href="../css/animate.css" type="text/css" />
        <link rel="stylesheet" href="../css/magnific-popup.css" type="text/css" />
        <!-- Bootstrap Data Table Plugin -->
        <link rel="stylesheet" href="../css/bs-datatable.css" type="text/css" />
        <link href="/assets/img/favicon_new.png" rel="icon">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
    </head>
</head>
<style>
    #ftco-loader {
    position: fixed;
    width: 96px;
    height: 96px;
    left: 50%;
    top: 50%;
    -webkit-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    background-color: rgba(255, 255, 255, 0.9);
    -webkit-box-shadow: 0px 24px 64px rgba(0, 0, 0, 0.24);
    box-shadow: 0px 24px 64px rgba(0, 0, 0, 0.24);
    border-radius: 16px;
    opacity: 0;
    visibility: hidden;
    -webkit-transition: opacity .2s ease-out, visibility 0s linear .2s;
    -o-transition: opacity .2s ease-out, visibility 0s linear .2s;
    transition: opacity .2s ease-out, visibility 0s linear .2s;
    z-index: 1000;
}

#ftco-loader.fullscreen {
    padding: 0;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    -webkit-transform: none;
    -ms-transform: none;
    transform: none;
    background-color: #fff;
    border-radius: 0;
    -webkit-box-shadow: none;
    box-shadow: none;
}

#ftco-loader.show {
    -webkit-transition: opacity .4s ease-out, visibility 0s linear 0s;
    -o-transition: opacity .4s ease-out, visibility 0s linear 0s;
    transition: opacity .4s ease-out, visibility 0s linear 0s;
    visibility: visible;
    opacity: 1;
}

#ftco-loader .circular {
    -webkit-animation: loader-rotate 2s linear infinite;
    animation: loader-rotate 2s linear infinite;
    position: absolute;
    left: calc(50% - 24px);
    top: calc(50% - 24px);
    display: block;
    -webkit-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    transform: rotate(0deg);
}

#ftco-loader .path {
    stroke-dasharray: 1, 200;
    stroke-dashoffset: 0;
    -webkit-animation: loader-dash 1.5s ease-in-out infinite;
    animation: loader-dash 1.5s ease-in-out infinite;
    stroke-linecap: round;
}

@-webkit-keyframes loader-rotate {
    100% {
        -webkit-transform: rotate(360deg);
        transform: rotate(360deg);
    }
}

@keyframes loader-rotate {
    100% {
        -webkit-transform: rotate(360deg);
        transform: rotate(360deg);
    }
}

@-webkit-keyframes loader-dash {
    0% {
        stroke-dasharray: 1, 200;
        stroke-dashoffset: 0;
    }
    50% {
        stroke-dasharray: 89, 200;
        stroke-dashoffset: -35px;
    }
    100% {
        stroke-dasharray: 89, 200;
        stroke-dashoffset: -136px;
    }
}

@keyframes loader-dash {
    0% {
        stroke-dasharray: 1, 200;
        stroke-dashoffset: 0;
    }
    50% {
        stroke-dasharray: 89, 200;
        stroke-dashoffset: -35px;
    }
    100% {
        stroke-dasharray: 89, 200;
        stroke-dashoffset: -136px;
    }
}
#exportButton {
    cursor: pointer;
    border: 3px solid black;
    color: white;
    padding: 10px;
    background-color: #007bff;
    border-radius: 8px;
}
#exportButton:active {
    transform: scale(1.1);
    box-shadow: 3px 2px 22px 1px rgb(0 0 0 / 60%);
}
    .copy-button {
    border: 2px solid #2121af;
    background: #f0ff0a;
    color: black;
    border-radius: 4px;
    padding: 7px;
    cursor: pointer;
}
.copy-button:active {
        transform: scale(0.99);
        /* Scaling button to 0.98 to its original size */
        box-shadow: 3px 2px 22px 1px rgba(0, 0, 0, 0.60);
        /* Lowering the shadow */
    }
</style>

<body>
    <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" />
        </svg></div>
    <!-- Content
		============================================= -->
    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix" style="padding-top: 100px;">
                <a id="exportButton" class="button button-3d button-rounded button-blue"><i class="icon-book3"></i>Dışa Aktar</a>
                <div class="table-responsive" style="margin-top: 100px;">
                    <table style="display:none;" id="datatable2">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Ad Soyad</th>
                                <th>Soru</th>
                                <th>Tarih</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!$link = mysql_connect('localhost', 'hrtalent_live', '!hrt!2021!')) {
                                echo 'mysql\'e bağlanamadı';
                                exit;
                            }

                            if (!mysql_select_db('hrtalent_live', $link)) {
                                echo 'Veritabanı seçilemedi';
                                exit;
                            }

                            $sql    = 'SELECT * FROM canli_yayin_sorular group by question ORDER BY `canli_yayin_sorular`.`dateTime` DESC';
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
                                echo '<td>' . $row['nameSurname'] . '</td>';
                                echo '<td>' . $row['question'] . '</td>';
                                echo '<td>' . $row['dateTime'] . '</td>';
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
                                <th>Ad Soyad</th>
                                <th>Soru</th>
                                <th>Tarih</th>
                                <th>İşlem</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                             if (!$link = mysql_connect('localhost', 'hrtalent_live', '!hrt!2021!')) {
                                echo 'mysql\'e bağlanamadı';
                                exit;
                            }

                            if (!mysql_select_db('hrtalent_live', $link)) {
                                echo 'Veritabanı seçilemedi';
                                exit;
                            }

                            $sql    = 'SELECT * FROM canli_yayin_sorular group by question ORDER BY `canli_yayin_sorular`.`dateTime` DESC';
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
                                echo '<td>' . $row['nameSurname'] . '</td>';
                                echo '<td>' . $row['question'] . '</td>';
                                echo '<td>' . $row['dateTime'] . '</td>';
                                echo '<td><button class="copy-button" data-name="' . $row['nameSurname'] . '" data-question="' . $row['question'] . '">Kopyala</button></td>';
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

    <script src="../js/jquery.js"></script>
    <script src="../js/plugins.min.js"></script>

    <!-- Bootstrap Data Table Plugin -->
    <script src="../js/bs-datatable.js"></script>

    <!-- Footer Scripts
	============================================= -->
    <script src="../js/jquery.table2excel.js"></script>

    <script>
        $(document).ready(function() {
            // $('#datatable1').dataTable();
            $('#datatable1').dataTable({
                "ordering": false
            });

            $("#exportButton").click(function() {
                $("#datatable2").table2excel({
                    name: "sorular",
                    filename: "HR Canlı Yayın Soruları", //do not include extension
                    fileext: ".xls" // file extension
                });
            });

            $('#ftco-loader').removeClass('show');

            $('#datatable1').on('click', 'button', function(event) {
                event.stopPropagation();
                event.stopImmediatePropagation();

                var valueName = $(this).attr("data-name");
                var valueQuestion = $(this).attr("data-question");

                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val(valueName + " - " + valueQuestion).select();
                document.execCommand("copy");
                $temp.remove();

            });

            // setInterval(function() {
            //     location.reload();
            // }, 10000);
        });
    </script>
</body>

</html>