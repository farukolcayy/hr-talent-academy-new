<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR 2021-2022 Soru Paneli</title>
    <link rel="shortcut icon" href="/assets/img/favicon_new.png">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

    <head>
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700|Poppins:300,400,500,600,700|PT+Serif:400,400i&display=swap" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="./css/bootstrap.css" type="text/css" />
        <link rel='stylesheet' href='https://rawcdn.githack.com/SochavaAG/example-mycode/master/_common/css/reset.css'>
        <link rel="stylesheet" href="./css/dark.css" type="text/css" />
        <link rel="stylesheet" href="./css/font-icons.css" type="text/css" />
        <link rel="stylesheet" href="./css/animate.css" type="text/css" />
        <!-- Bootstrap Data Table Plugin -->
        <link rel="stylesheet" href="./css/components/bs-datatable.css" type="text/css" />
        <link rel="stylesheet" href="./css/style-payment.css?v=1.4" type="text/css" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
    </head>
</head>

<body>

    <div id="loader_form">
        <div data-loader="circle-side-2"></div>
    </div><!-- /loader_form -->



    <div class="ag-tabs-block">
        <div class="ag-format-container">
            <div class="ag-tabs_title">
                HR Sorular
            </div>
            <div class="ag-tabs_box">
                <ul class="ag-tabs_list">
                    <li class="js-tabs_item ag-tabs_item js-ag-tabs_item__active">
                        <a href="#service-1" class="ag-tabs_link" aria-expanded="true">HR-2</a>
                    </li>
                    <li class="js-tabs_item ag-tabs_item">
                        <a href="#service-2" class="ag-tabs_link" aria-expanded="false">HR-1</a>
                    </li>
                </ul>

                <div class="ag-tab_box">

                    <div id="service-1" class="js-tab_pane ag-tab_pane js-ag-tab_pane__active">
                        <section id="content">
                            <div class="content-wrap">

                                <div class="container clearfix">


                                    <div class="row counter-responsive" style="margin: 20px;">

                                        <div class="col-md-3 col-6">
                                            <a class="total-style-1" id="totalApply1" style="border: 2px solid red;padding:10px;"></a>
                                        </div>

                                        <div class="col-md-2 col-12">
                                            <a class="export-style" id="exportButton1" class="button button-3d button-rounded button-blue"><i class="icon-book3"></i>Dışa Aktar</a>
                                        </div>

                                    </div>



                                    <div class="table-responsive">

                                        <table id="datatable1" class="table table-striped table-bordered" cellspacing="0" width="100%">

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

                                                $conn = new PDO('mysql:host=localhost;dbname=hrtalent_live;charset=utf8;port=3306', 'hrtalent_basvuru', '!hrt!2021!');

                                                $query = $conn->query("SELECT * FROM canli_yayin_sorular ORDER BY `canli_yayin_sorular`.`dateTime` DESC", PDO::FETCH_ASSOC);

                                                if ($query->rowCount()) {
                                                    foreach ($query as $row) {
                                                        echo '<tr>';
                                                        echo '<td>' . $row['Id'] . '</td>';
                                                        echo '<td>' . $row['nameSurname'] . '</td>';
                                                        echo '<td>' . $row['question'] . '</td>';
                                                        echo '<td>' . $row['dateTime'] . '</td>';
                                                        echo '</tr>';
                                                    }
                                                }

                                                ?>

                                            </tbody>

                                        </table>

                                    </div>



                                </div>

                            </div>

                        </section><!-- #content end -->

                    </div>

                    <div id="service-2" class="js-tab_pane ag-tab_pane">
                        <section id="content2">

                            <div class="content-wrap">

                                <div class="container clearfix">


                                    <div class="row counter-responsive" style="margin: 20px;">

                                        <div class="col-md-4 col-6">
                                            <a class="total-style-1" id="totalApply2" style="border: 2px solid red;padding:10px;"></a>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <a class="export-style" id="exportButton2" class="button button-3d button-rounded button-blue"><i class="icon-book3"></i>Dışa Aktar</a>
                                        </div>
                                    </div>



                                    <div class="table-responsive">


                                        <table id="datatable2" class="table table-striped table-bordered" cellspacing="0" width="100%">

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

                                                $conn = new PDO('mysql:host=localhost;dbname=hrtalent_live;charset=utf8;port=3306', 'hrtalent_basvuru', '!hrt!2021!');

                                                $query = $conn->query("SELECT * FROM canli_yayin_sorular_old ORDER BY `canli_yayin_sorular_old`.`dateTime` DESC", PDO::FETCH_ASSOC);

                                                if ($query->rowCount()) {
                                                    foreach ($query as $row) {
                                                        echo '<tr>';
                                                        echo '<td>' . $row['Id'] . '</td>';
                                                        echo '<td>' . $row['nameSurname'] . '</td>';
                                                        echo '<td>' . $row['question'] . '</td>';
                                                        echo '<td>' . $row['dateTime'] . '</td>';
                                                        echo '</tr>';
                                                    }
                                                }

                                                ?>

                                            </tbody>


                                        </table>

                                    </div>



                                </div>

                            </div>

                        </section><!-- #content end -->

                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="./js/jquery.js"></script>
    <script src="./js/plugins.min.js"></script>

    <!-- Bootstrap Data Table Plugin -->
    <script src="./js/components/bs-datatable.js"></script>

    <!-- Footer Scripts
	============================================= -->
    <script src="./js/functions.js"></script>
    <script src="./js/script-payment.js?v=1.4"></script>
    <!-- <script src="./js/jquery.table2excel.js"></script> -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/amcharts/3.21.15/plugins/export/libs/FileSaver.js/FileSaver.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/6.26.0/polyfill.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.js"></script>
    <script src="./js/excelExport.js?v=1.2"></script>

    <script>
        $(document).ready(function() {

            var array1, array2, array3, array4, array5;

            $.ajax({
                    type: 'get',
                    dataType: "json",
                    url: 'all-data.php'
                    // data: { liveId: 2 }
                })
                .done(function(dataResult) {

                    if (dataResult.data1 != '') {

                        array1 = dataResult.data1;
                        array2 = dataResult.data2;

                    } else {
                        console.log(data);
                        return false;
                    }
                })
                .fail(function(e) {
                    console.log(e);
                    return false;
                });


            $('#datatable1').dataTable({
                "ordering": false
            });

            $('#datatable2').dataTable({
                "ordering": false
            });


            $("#exportButton1").click(function() {
                const header = ["Id", "Ad-Soyad", "Soru", "Tarih"];
                const worksheet = "Sorular";
                const filename = "HR-2 Sorular";
                exportExcel(header, worksheet, filename, array1);
            });

            $("#exportButton2").click(function() {
                const header = ["Id", "Ad-Soyad", "Soru", "Tarih"];
                const worksheet = "Sorular";
                const filename = "HR-1 Sorular";
                exportExcel(header, worksheet, filename, array2);
            });


            var textUnder = $("#datatable1_info").text();
            if (textUnder === "" || textUnder === null || textUnder === undefined) {
                $("#totalApply1").html("Toplam Soru : <strong>0</strong>");
            } else {
                $("#totalApply1").html("Toplam Soru : <strong>" + textUnder.substr(0, textUnder.indexOf(' ')) + "</strong>");
            }

            var textUnder2 = $("#datatable2_info").text();
            if (textUnder2 === "" || textUnder2 === null || textUnder2 === undefined) {
                $("#totalApply2").html("Toplam Soru : <strong>0</strong>");
            } else {
                $("#totalApply2").html("Toplam Soru : <strong>" + textUnder2.substr(0, textUnder2.indexOf(' ')) + "</strong>");
            }
            
            $("#loader_form").fadeOut();
        });
    </script>
</body>

</html>