var selectPackLabel = "";
var discountCode = "";
var discountCodeValue = "";

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
        path = "/online-odeme";
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

    $(".copy-button-havale").click(function () {
        var valueName = $(this).attr("data-value");
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(valueName).select();
        document.execCommand("copy");
        $temp.remove();
        $(this).text("Kopyalandı!");
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

    $(window).bind("beforeunload", function (event) {
        return "You have some unsaved changes";
    });

    document.addEventListener("contextmenu", function (evt) {
        evt.preventDefault();
    }, false);

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
        var target = event.target;
        var input = event.target.value.replace(/\D/g, '').substring(0, 10);
        var zip = input.substring(0, 3);
        var middle = input.substring(3, 6);
        var last = input.substring(6, 10);
        if (zip.charAt(0) === "0") {
            target.value = ``;
        } else if (!(zip.charAt(0) === "(" || zip.charAt(0) === "5")) {
            target.value = ``;
        } else if (input.length > 6) {
            target.value = `(${zip}) ${middle} - ${last}`;
        } else if (input.length > 3) {
            target.value = `(${zip}) ${middle}`;
        } else if (input.length > 0) {
            target.value = `(${zip}`;
        }
    };

    $(document).on("keydown", "#userPhone", function (e) {
        enforceFormat(e);
    });

    $(document).on("keyup", "#userPhone", function (e) {
        formatToPhone(e);
    });

    // var checkPrivacy = readCookie("isPrivacyRead");
    // if (checkPrivacy != "1") {
    //     window.location.href = "/online-odeme";
    // }

    deleteAllCookies();
    $('.pricing-features').hide();

    setTimeout(function () {
        $('#ftco-loader').removeClass('show');
    }, 1000);
});

jQuery(window).on('pluginTabsReady', function () {

    var optionPayment = "kredi-karti";

    $('input[type=radio][name=radio-group-1]').change(function () {

        if (this.value == 'kredi-karti') {
            optionPayment = "kredi-karti";
            $("#card-option-form").show(function () {
                $("#havale-option-form").hide();
            });
        } else if (this.value == 'havale-eft') {
            optionPayment = "havale-eft";
            $("#havale-option-form").show(function () {
                $("#havaleToplamTutarText").text(parseInt(totalAmountPrice) + ".99 ₺");
            });
        }
    });

    function MailKontrol(email) {
        var kontrol = new RegExp(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
        return kontrol.test(email);
    };

    var emailAddress = "";
    var userName = "";
    var userPhone = "";
    var userAddress = "";
    var totalAmountPrice = "";
    var selectProgramLabel = "HR Talent Academy 2 Aylık Paket";
    var userIdentificationNumber = "";
    var userCity = "";
    var userDistrict = "";


    $("#havaleSubmit").click(function () {
        $(this).off('click');
        $('#ftco-loader').addClass('show');

        var ttAmount = parseInt(parseFloat(totalAmountPrice));
        ttAmount = Number(ttAmount.toFixed(2));

        $.ajax({
            type: 'POST',
            url: '/online-odeme/payment-eft.php',
            dataType: "json",
            data: {
                'email': emailAddress,
                'totalAmountPrice': ttAmount + ".99",
                'discountCode': discountCode,
                'discountCodeValue': discountCodeValue,
                'basketContent': selectProgramLabel,
                'userName': userName.replace(/'/g, "`"),
                'userPhone': "+90" + userPhone,
                'userAddress': userAddress.replace(/'/g, "`"),
                'userIdentificationNumber': userIdentificationNumber,
                'userCity': userCity,
                'userDistrict': userDistrict
            }
        })
            .done(function (data) {
                $("#havale-option-form").hide();
                $("#processTabs").tabs("option", "active", 4);
                $("#havale-success-form").show();
            })
            .fail(function (xhr, textStatus, errorThrown) {
                swal("Uyarı!", "Havale Talebiniz Kaydedilemedi!", "error");
                console.log(xhr.responseText);
                console.log(textStatus);
                console.log(errorThrown);
            });

        setTimeout(function () {
            $('#ftco-loader').removeClass('show');
            $(this).on('click');
        }, 1000);

    });

    $("#processTabs").tabs({ show: { effect: "fade", duration: 400 } });
    var tabRel = 2;

    $(".tab-linker").click(function () {

        if (tabRel == 2) {

            emailAddress = $('#userEmail').val();

            if (emailAddress != "" && emailAddress != null && MailKontrol(emailAddress) != false) {

                discountCodeValue = $.trim($('#discountCode').val().toLowerCase());
                discountCode = md5($.trim($('#discountCode').val().toLowerCase()));

                switch (discountCode) {
                    case "d41d8cd98f00b204e9800998ecf8427e":
                        discountCode = 0;
                        break;
                    case "39f3ea0e2ab06a70a9fd93c7421df8eb":
                        discountCode = 60;
                        break;
                    default:
                        swal("Uyarı!", "İndirim kodunuz yanlış!", "warning");

                        return false;
                        break;
                }
                if (discountCode != 0) {
                    swal("Başarılı", "İndiriminiz uygulandı.", "success");

                }

                $("span[id=privacyMail]").html(emailAddress);
                $("span[id=privacyDiscount]").html("%" + discountCode);

                var hash = md5(emailAddress);
                document.cookie = "applySession=" + hash;
                document.cookie = "applyEmail=" + emailAddress;
                document.cookie = "discountCode=" + discountCode;
                tabRel++;

                var amountOrder = [649];
                totalAmountPrice=parseInt(649-(((649)*discountCode)/100));

                if (discountCode != 0) {
                    var discountTotal = parseInt((649 *discountCode)/100) +".99 ₺";
                    $("#totalDiscountMessage").text(discountTotal);

                    var totalAmount = parseInt(649-(((649)*discountCode)/100))+".99₺";
                    $("#totalAmountMessage").text(totalAmount);
                }

                $('#ftco-loader').addClass('show');
                $("#processTabs").tabs("option", "active", 1);
                setTimeout(function () {
                    $('#ftco-loader').removeClass('show');
                }, 1000);

            }
            else {
                swal("Uyarı!", "Lütfen uygun bir e-mail adresi giriniz!", "warning");

                return false;
            }
        }
        else if (tabRel == 3) {

            var ttAmount = 649.99;

            var privacyTotal = totalAmountPrice + ".99";
            $("span[id=privacyRealAmount]").html(ttAmount);
            $("span[id=privacyTotalAmount]").html(privacyTotal);

            if (discountCode == 0) {
                $("span[id=privacyDiscountTotal]").html(0);
            } else {
                $("span[id=privacyDiscountTotal]").html(ttAmount-totalAmountPrice);
            }

            var currentdate = new Date();
            var datetime = currentdate.getDate() + "-"
                + (currentdate.getMonth() + 1) + "-"
                + currentdate.getFullYear();

            $("span[id=privacyDate]").html(datetime);

            $('#ftco-loader').addClass('show');
            $("#processTabs").tabs("option", "active", 2);
            tabRel++;

            setTimeout(function () {
                $('#ftco-loader').removeClass('show');
            }, 1000);

        }
        else if (tabRel == 4) {

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
            if ($('#checkbox-1')[0].checked === false || $('#checkbox-2')[0].checked === false || $('#checkbox-3')[0].checked === false) {
                swal("Uyarı!", "Gizlilik metinlerini işaretlemelisiniz!", "warning");
                return false;
            };

            if (optionPayment == "kredi-karti") {
                if (userName != "" && userName != null && userPhone != "" && userPhone != null) {

                    $('#ftco-loader').addClass('show');
                    tabRel++;
                    $("#processTabs").tabs("option", "active", 3);
                    var ttAmount = parseInt(parseFloat(totalAmountPrice));

                    ttAmount = Number(ttAmount.toFixed(2));
                    $("#ptab4Content").load('/online-odeme/payment.php', {
                        'email': emailAddress,
                        'totalAmountPrice': ttAmount + "99",
                        'discountCode': discountCode,
                        'discountCodeValue': discountCodeValue,
                        'basketContent': selectProgramLabel,
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
                    }, 1000);

                } else {
                    swal("Uyarı!", "Kişisel bilgilerin tamamı doldurulmalı!", "warning");
                    return false;
                }
            } else {

                if (userName != "" && userName != null && userPhone != "" && userPhone != null) {

                    $('#ftco-loader').addClass('show');
                    tabRel++;
                    $("#processTabs").tabs("option", "active", 3);

                    var ttAmount = parseInt(parseFloat(totalAmountPrice));
                    ttAmount = Number(ttAmount.toFixed(2));

                    $("#havaleToplamTutarText").text(ttAmount + ".99 ₺");

                    document.cookie = "phoneNumber=" + userPhone;


                    setTimeout(function () {
                        $('#ftco-loader').removeClass('show');
                    }, 1000);

                } else {
                    swal("Uyarı!", "Kişisel bilgilerin tamamı doldurulmalı!", "warning");
                    return false;
                }

            }
            deleteAllCookies();
        }
        return false;
    });
});