<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Talent Academy Başvurular</title>
    <link rel="shortcut icon" type="image/x-icon" href="/assets/images/favicon.png">
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
    </div>

    <div class="ag-tabs-block">
        <div class="ag-format-container">
            <div class="ag-tabs_title">
                Başvurular
            </div>
            <div class="ag-tabs_box">
                <ul class="ag-tabs_list">
                    <li class="js-tabs_item ag-tabs_item js-ag-tabs_item__active">
                        <a href="#service-1" class="ag-tabs_link" aria-expanded="true">Başvurular-2021</a>
                    </li>
                </ul>

                <div class="ag-tab_box">

                    <div id="service-1" class="js-tab_pane ag-tab_pane js-ag-tab_pane__active">
                        <section id="content">


                            <div class="content-wrap">

                                <div class="container clearfix">


                                    <div class="row counter-responsive" style="margin: 20px;">

                                        <div class="col-md-3 col-6">

                                            <a class="total-style-1" id="totalApply" style="border: 2px solid red;padding:10px;"></a>

                                        </div>

                                        <div class="col-md-3 col-6">

                                            <a class="total-style-2" id="todayTotalApply" style="border: 2px solid blue;padding:10px;">

                                            </a>

                                        </div>

                                        <div class="col-md-2 col-12">

                                            <a class="export-style" id="exportButton" class="button button-3d button-rounded button-blue"><i class="icon-book3"></i>Dışa Aktar</a>

                                        </div>

                                    </div>



                                    <div class="table-responsive">

                                        <table id="datatable1" class="table table-striped table-bordered" cellspacing="0" width="100%">

                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Ad-Soyad</th>
                                                    <th>Email</th>
                                                    <th>Telefon</th>
                                                    <th>Üniversite</th>
                                                    <th>Bölüm</th>
                                                    <th>Sınıf</th>
                                                    <th>Sınava girdi mi?</th>
                                                    <th>Başvuru Tarihi</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php

                                                $conn = new PDO('mysql:host=localhost;dbname=hrtalent_basvuru_2021;charset=utf8;port=3306', 'hrtalent_basvuru', '!hrt!2021!');

                                                $query = $conn->query('SELECT Id,name,surname,emailAddress,phoneNumber,university,department,class,
                                                case 
                                                    when  isStartQuiz =0 then "Hayır"
                                                    when  isStartQuiz= 1 then "Evet"
                                                    end as isStartQuiz,applyDate
                                                FROM basvuru GROUP by emailAddress order by applyDate desc', PDO::FETCH_ASSOC);

                                                if ($query->rowCount()) {
                                                    foreach ($query as $row) {
                                                        echo '<tr>';
                                                        echo '<td>' . $row['Id'] . '</td>';
                                                        echo '<td>' . $row['name'] . ' ' . $row['surname'] . '</td>';
                                                        echo '<td>' . $row['emailAddress'] . '</td>';
                                                        echo '<td>' . $row['phoneNumber'] . '</td>';
                                                        echo '<td>' . $row['university'] . '</td>';
                                                        echo '<td>' . $row['department'] . '</td>';
                                                        echo '<td>' . $row['class'] . '</td>';
                                                        echo '<td>' . $row['isStartQuiz'] . '</td>';
                                                        echo '<td>' . $row['applyDate'] . '</td>';
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

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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

            var array1;

            $.ajax({
                    type: 'get',
                    dataType: "json",
                    url: 'all-data.php'
                })
                .done(function(dataResult) {

                    if (dataResult.data1 != '') {

                        array1 = dataResult.data1;
                        $("#todayTotalApply").html("Bugünkü toplam: <strong>" + dataResult.total1 + "</strong>");

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

            $("#exportButton").click(function() {
                const header = ["Id", "Ad-Soyad", "Email", "Telefon", "Üniversite", "Bölüm", "Sınıf", "Sınava girdi mi?", "Başvuru Tarihi"];
                const worksheet = "Başvurular";
                const filename = "HR 2021 Başvurular";
                exportExcel(header, worksheet, filename, array1);
            });


            var textUnder = $("#datatable1_info").text();
            if (textUnder === "" || textUnder === null || textUnder === undefined) {
                $("#totalApply").html("Toplam Başvuru : <strong>0</strong>");
            } else {
                $("#totalApply").html("Toplam Başvuru : <strong>" + textUnder.substr(0, textUnder.indexOf(' ')) + "</strong>");
            }


            $("#loader_form").fadeOut();
        });
    </script>
</body>

</html>