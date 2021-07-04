var selectPackLabel = "";
var selectedElement = [];
var tabRel = 0;
var _totalAmount = 599;
var discountCode = 0;

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

function deleteAllCookies() {
    var cookies = document.cookie.split(";");
    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        var eqPos = cookie.indexOf("=");
        var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        if (name = "phoneNumber") {
            continue;
        }
        path = "/";
        document.cookie = name + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;path=' + path + ";";
    }
}

function TCNOKontrol(TCNO) {
    var tek = 0,
        cift = 0,
        sonuc = 0;

    if (TCNO.length != 11) return false;
    if (isNaN(TCNO)) return false;
    if (TCNO[0] == 0) return false;

    tek = parseInt(TCNO[0]) + parseInt(TCNO[2]) + parseInt(TCNO[4]) + parseInt(TCNO[6]) + parseInt(TCNO[8]);
    cift = parseInt(TCNO[1]) + parseInt(TCNO[3]) + parseInt(TCNO[5]) + parseInt(TCNO[7]);

    tek = tek * 7;
    sonuc = Math.abs(tek - cift);
    if (sonuc % 10 != TCNO[9]) return false;

    return true;
}

$(document).ready(function () {

    // $('.pagination-container').remove();

    var products = [];

    $.ajax({
        type: 'POST',
        dataType: "json",
        async: false,
        url: 'getProducts.php',
        data: { liveId: 1 }
    })
        .done(function (data) {
            if (data.result != '') {
                products = data.result;
            } else {
                console.log(data);
                return false;
            }
        })
        .fail(function (e) {
            console.log(e);
            return false;
        });

    for (let index = 0; index < products.length; index++) {
        const element = products[index];

        var d = new Date(element.endDate);
        var weekday = new Array(7);
        weekday[0] = "Pazar";
        weekday[1] = "Pazartesi";
        weekday[2] = "Salı";
        weekday[3] = "Çarşamba";
        weekday[4] = "Perşembe";
        weekday[5] = "Cuma";
        weekday[6] = "Cumartesi";

        const monthNames = ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran",
            "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"
        ];

        var n = weekday[d.getDay()];
        var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };

        var _el = '<article class="portfolio-item col-12 pf-graphics pf-uielements">' +
            '<div class="entry event col-12" style="margin-bottom: 20px;">' +
            '<div class="grid-inner row align-items-center no-gutters p-4">' +
            '<div class="entry-image col-md-4 mb-md-0">' +
            '<a>' +
            '<img src="' + element.image + '"' +
            'alt="' + element.header + '">' +
            '</a></div>' +
            '<div class="col-md-8 pl-md-4">' +
            '<div class="entry-title title-sm">' +
            '<h2><a>' + element.header + '</a></h2>' +
            '</div><div class="entry-meta">' +
            '<ul>' +
            '<li><span class="badge badge-warning px-1 py-1" style="color:white !important;padding:10px !important;background-color:' + element.tagColor + '">' + element.tagName + '</span>' +
            '</li>' +
            '<li><a><i class="icon-time"></i>' + d.toLocaleDateString("tr-TR", options) + '</a>' +
            '</li>' +
            '<li><a><i class="icon-certificate"></i>' + element.company + '</a></li>' +
            '<li style="margin-left:auto;"><h1 style="float:right;"><a>3 Ay</a></h1></li>' +
            '</ul>' +
            '</div>' +
            '<div class="entry-content">' +
            '<p>' + element.description + '</p>' +
            '<div class="row">';
        if (element.isActive === "1") {
            _el += '<div class="col-md-4"></div><div class="col-md-5"><input name="code-area" type="text" value="" class="sm-form-control" placeholder="Lütfen İndirim Kodunu giriniz..." /></div>' +
                '<div class="col-md-3"><a id="discount-button" data-payment-id="' + element.Id + '" style="background-color: #ffc107;color:white;" class="button button-3d button-black m-0" name="active-button"><i class="icon-lock3"></i>Uygula</a></div>';
        }
        else {
            _el += '<div class="col-md-12"><a name="pay-btn" data-payment-id="' + element.Id + '" class="btn btn-secondary payment-button" disabled="disabled" style="float:right;background-color:grey !important;"><i class="icon-lock3"></i>  Satışa Kapalı</a>'
        }
        _el += '</div></div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</article >';

        $("#portfolio").append(_el);
    }


    $('.portfolio-container').pajinate({
        items_per_page: 6,
        item_container_id: '#portfolio',
        nav_panel_id: '.pagination-container ul',
        show_first_last: false
    });

    $('.pagination a').click(function () {
        var t = setTimeout(function () { $('.flexslider .slide').resize(); }, 1000);
    });


    $("#userEmail").change(function (e) {
        $("span[id=privacyMail]").html(this.value);
    });

    $("#userName").change(function (e) {
        $("span[id=privacyNameSurname]").html(this.value);
    });

    $("#userAddress").change(function (e) {
        $("span[id=privacyAddress]").html(this.value);
    });

    $("#userPhone").change(function (e) {
        $("span[id=privacyPhoneNumber]").html(this.value);
    });

    // $(window).bind("beforeunload", function (event) {
    //     return "You have some unsaved changes";
    // });

    // document.addEventListener("contextmenu", function (evt) {
    //     evt.preventDefault();
    // }, false);

    $(document).keydown(function (event) {
        if (event.keyCode == 123 || (event.ctrlKey && event.shiftKey && event.keyCode == 67) || (event.ctrlKey && event.shiftKey && event.keyCode == 73) || (event.ctrlKey && event.shiftKey && event.keyCode == 80) || (event.ctrlKey && event.shiftKey && event.keyCode == 74)) { // Prevent F12
            return false;
        }
    });

    $("#userIdentificationNumber").keypress(function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });

    $.getJSON("il-bolge.json", function (sonuc) {
        $.each(sonuc, function (index, value) {
            var row = "";
            row += '<option value="' + value.il + '">' + value.il + '</option>';
            $("#userCity").append(row);
        })
    });

    $("#userCity").on("change", function () {
        var il = $(this).val();
        $("#userDistrict").attr("disabled", false).html("<option value=''>İlçe Seçiniz...</option><option value='MERKEZ'>Merkez</option>");
        $.getJSON("il-ilce.json", function (sonuc) {
            $.each(sonuc, function (index, value) {
                var row = "";
                if (value.il == il) {
                    row += '<option value="' + value.ilce + '">' + value.ilce + '</option>';
                    $("#userDistrict").append(row);
                }
            });
        });
    });

    $('a[name="active-button"]').click(function () {

        var _dataId = $(this).attr("data-payment-id");
        var _selectedEl = products.filter(x => x.Id === _dataId);

        if (_selectedEl[0].unlocked === "1") {

            selectedElement = _selectedEl;
            $('#ftco-loader').addClass('show');

            $("span[id=privacyRealAmount]").html(_selectedEl[0].amount);
            $("span[id=privacyTotalAmount]").html(_selectedEl[0].amount);

            var currentdate = new Date();
            var datetime = currentdate.getDate() + "-"
                + (currentdate.getMonth() + 1) + "-"
                + currentdate.getFullYear();

            $("span[id=privacyDate]").html(datetime);

            $("#processTabs").tabs("disable", 0);
            $("#processTabs").tabs("disable", 2);
            $("#processTabs").tabs("enable", 1);
            $("#processTabs").tabs("option", "active", 1);
            tabRel += 1;
            setTimeout(function () {
                $('#ftco-loader').removeClass('show');
            }, 500);

        } else {

            discountCode = md5($.trim($(this).parent().prev().children("input[name='code-area']:first").val().toLowerCase()));

            switch (discountCode) {
                case "d98cb03a9ec555298ef454505c59d0e5":
                    discountCode = 80;
                    break;
                case "7226d1e2a30a61beb08502abbac90ca5":
                    discountCode = 70;
                    break;
                case "5e1fa33cd59c89fc0ddcdf6a3149f5d3":
                    discountCode = 60;
                    break;
                case "20a576efb65dfcc40b6a65cd47940cfb":
                    discountCode = 50;
                    break;
                default:
                    swal("Uyarı!", "İndirim kodunuz yanlış!", "warning");
                    discountCode = 0;
                    return false;
            }

            if (discountCode != 0) {

                _selectedEl[0].unlocked = "1";
                $(this).css("background-color", "rgb(255 62 62)");
                // $(this).unbind("click");
                $(this).parent().prev().children("input[name='code-area']:first").prop('disabled', true);
                $(this).parent().prev().children("input[name='code-area']:first").remove();
                $(this).text("Satın Al");
                $(this).parent().next().children("a[name='pay-btn']:first").prop('disabled', false);

                $("#amountInfoTable").show();
                $("a[id='discount-button']").remove();
                var discountTotal = parseInt(parseFloat("599.99") * (discountCode / 100));
                $("span[id=totalReelAmount]").html("3 X 199.99 ₺ = <strong>599.99 ₺</strong>");
                $("span[id=totalDiscount]").html("<strong>" + discountTotal + ".99 ₺</strong>");
                $("span[id=totalAmount]").html("<strong>" + (598 - discountTotal) + ".99 ₺</strong>");
                _totalAmount = (598 - discountTotal);

            }

        }

    });

    function isNumericInputPhone(event) {
        var key = event.keyCode;
        return ((key >= 48 && key <= 57) || // Allow number line
            (key >= 96 && key <= 105) // Allow number pad
        );
    };

    function isModifierKey(event) {
        var key = event.keyCode;
        return (event.shiftKey === true || key === 35 || key === 36) || // Allow Shift, Home, End
            (key === 8 || key === 9 || key === 13 || key === 46) || // Allow Backspace, Tab, Enter, Delete
            (key > 36 && key < 41) || // Allow left, up, right, down
            (
                // Allow Ctrl/Command + A,C,V,X,Z
                (event.ctrlKey === true || event.metaKey === true) &&
                (key === 65 || key === 67 || key === 86 || key === 88 || key === 90)
            )
    };

    function enforceFormat(event) {
        if (!isNumericInputPhone(event) && !isModifierKey(event)) {
            event.preventDefault();
        }
    };

    function formatToPhone(event) {
        if (isModifierKey(event)) {
            return;
        }

        // I am lazy and don't like to type things more than once
        var target = event.target;
        var input = event.target.value.replace(/\D/g, '').substring(0, 10); // First ten digits of input only
        var zip = input.substring(0, 3);
        var middle = input.substring(3, 6);
        var last = input.substring(6, 10);
        if (zip.charAt(0) === "0") { target.value = ``; }
        else if (input.length > 6) { target.value = `(${zip}) ${middle} - ${last}`; }
        else if (input.length > 3) { target.value = `(${zip}) ${middle}`; }
        else if (input.length > 0) { target.value = `(${zip}`; }
    };

    $(document).on("keydown", "#userPhone", function (e) {
        enforceFormat(e);
    });

    $(document).on("keyup", "#userPhone", function (e) {
        formatToPhone(e);
    });

    deleteAllCookies();
    $('.pricing-features').hide();

    setTimeout(function () {
        $('#ftco-loader').removeClass('show');
    }, 2000);
});

jQuery(window).on('pluginTabsReady', function () {

    function MailKontrol(email) {
        var kontrol = new RegExp(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
        return kontrol.test(email);
    };

    var emailAddress = "";
    var userName = "";
    var userPhone = "";
    var userAddress = "";
    var userIdentificationNumber = "";
    var userCity = "";
    var userDistrict = "";

    $("#processTabs").tabs({ show: { effect: "fade", duration: 400 }, disabled: [0, 1, 2] });

    $(".tab-linker-previous").click(function () {
        tabRel -= 1;
        $("#processTabs").tabs("disable", tabRel - 1);
        $("#processTabs").tabs("disable", tabRel + 1);
        $("#processTabs").tabs("enable", tabRel);
        $("#processTabs").tabs("option", "active", tabRel);
    });

    $(".tab-linker").click(function () {

        if (tabRel == 1) {


            if ($('#checkbox-1')[0].checked === false || $('#checkbox-2')[0].checked === false || $('#checkbox-3')[0].checked === false) {
                swal("Uyarı!", "Gizlilik metinlerini işaretlemelisiniz!", "warning");
                return false;
            };


            emailAddress = $('#userEmail').val();

            if (emailAddress === "" && emailAddress === null && MailKontrol(emailAddress) === false) {

                swal("Uyarı!", "Lütfen uygun bir e-mail adresi giriniz!", "warning");
                return false;

            }

            $("span[id=privacyMail]").html(emailAddress);

            var hash = md5(emailAddress);
            document.cookie = "applySession=" + hash;
            document.cookie = "applyEmail=" + emailAddress;


            userName = $('#userName').val();
            userPhone = $('#userPhone').val().replace(' ', '').replace('(', '').replace(')', '').replace('-', '').replace('  ', '');
            userAddress = $('#userAddress').val();
            userIdentificationNumber = $("#userIdentificationNumber").val();
            userCity = $("#userCity option:selected").text();
            userDistrict = $("#userDistrict option:selected").text();

            if (TCNOKontrol(userIdentificationNumber) != true) {
                swal("Hata", "TC No Geçersiz!", "error");
                return false;
            }

            if (userAddress === "" || userAddress === null || userCity === "İl Seçiniz..." || userCity === null || userDistrict === "İlçe Seçiniz..." || userDistrict === null) {
                swal("Uyarı!", "Adres bilgilerinin tamamı doldurulmalı!", "warning");
                return false;
            }

            if (userName != "" && userName != null && userPhone != "" && userPhone != null) {

                $('#ftco-loader').addClass('show');
                tabRel++;

                $("#processTabs").tabs("disable", 0);
                $("#processTabs").tabs("disable", 1);
                $("#processTabs").tabs("enable", 2);
                $("#processTabs").tabs("option", "active", 2);

                $("#ptab4Content").load('payment.php', {
                    'email': emailAddress,
                    'totalAmountPrice': _totalAmount + "99",
                    'discountCode': discountCode,
                    'basketContent': selectedElement[0].header,
                    'userName': userName.replace(/'/g, "`"),
                    'userPhone': "+90" + userPhone,
                    'userAddress': userAddress.replace(/'/g, "`"),
                    'userIdentificationNumber': userIdentificationNumber,
                    'userCity': userCity,
                    'userDistrict': userDistrict
                });

                document.cookie = "phoneNumber=" + userPhone;

                setTimeout(function () {
                    $('#ftco-loader').removeClass('show');
                }, 2000);

            } else {
                swal("Uyarı!", "Kişisel bilgilerin tamamı doldurulmalı!", "warning");
                return false;
            }
            deleteAllCookies();
        }

        return false;
    });
});