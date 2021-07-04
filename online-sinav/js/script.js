(function () {

  var magicFocus;

  magicFocus = class magicFocus {
    constructor(parent) {
      var i, input, len, ref;
      this.show = this.show.bind(this);
      this.hide = this.hide.bind(this);
      this.parent = parent;
      if (!this.parent) {
        return;
      }
      this.focus = document.createElement('div');
      this.focus.classList.add('magic-focus');
      this.parent.classList.add('has-magic-focus');
      this.parent.appendChild(this.focus);
      ref = this.parent.querySelectorAll('input, textarea, select');
      for (i = 0, len = ref.length; i < len; i++) {
        input = ref[i];
        input.addEventListener('focus', function () {
          return window.magicFocus.show();
        });
        input.addEventListener('blur', function () {
          return window.magicFocus.hide();
        });
      }
    }

    show() {
      var base, base1, el;
      if (!(typeof (base = ['INPUT', 'SELECT', 'TEXTAREA']).includes === "function" ? base.includes((el = document.activeElement).nodeName) : void 0)) {
        return;
      }
      clearTimeout(this.reset);
      if (typeof (base1 = ['checkbox', 'radio']).includes === "function" ? base1.includes(el.type) : void 0) {
        el = document.querySelector(`[for=${el.id}]`);
      }
      this.focus.style.top = `${el.offsetTop || 0}px`;
      this.focus.style.left = `${el.offsetLeft || 0}px`;
      this.focus.style.width = `${el.offsetWidth || 0}px`;
      return this.focus.style.height = `${el.offsetHeight || 0}px`;
    }

    hide() {
      var base, el;
      if (!(typeof (base = ['INPUT', 'SELECT', 'TEXTAREA', 'LABEL']).includes === "function" ? base.includes((el = document.activeElement).nodeName) : void 0)) {
        this.focus.style.width = 0;
      }
      return this.reset = setTimeout(function () {
        return window.magicFocus.focus.removeAttribute('style');
      }, 200);
    }

  };

  // initialize
  window.magicFocus = new magicFocus(document.querySelector('.form'));

  $(function () {
    return $('.select').customSelect();
  });

}).call(this);


var max_limit = 3; // Max Limit
var indexNum = 1;

function readCookie(name) {
  debugger;
  var nameEQ = name + "=";
  var ca = document.cookie.split(';');
  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') c = c.substring(1, c.length);
    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
  }
  return null;
}


$(document).ready(function () {

  var checkSecurity = readCookie("applySession");
  if (checkSecurity != "91cbf9ceb6dd2835215980d7397ebda5") {
    alert("Yetkisiz giriş!");
    window.location.href = 'https://birliktekariyer.com';
  }

  $(".checkbox-input:input:checkbox").each(function (index) {
    this.checked = (".checkbox-input:input:checkbox" < max_limit);
  }).change(function () {
    if ($(".checkbox-input:input:checkbox:checked").length > max_limit) {
      this.checked = false;
    }
  });

  $(":checkbox").change(function () {
    if (this.checked) {
      $("#selectArea").hide(this).append("<p style='color: white;' id='selectValue" + this.value + "'><span id='selectQueue'>" + indexNum + '.Tercihiniz :</span><span style="color:#ff2300">' + $(this).next('label').text() + "</span></p>").show('slow');
      indexNum += 1;
    } else {
      var _val = "#selectValue" + this.value;
      $(_val).fadeOut(500, function () {
        $(this).remove();
        indexNum = 1;
        $("span#selectQueue").each(function (index) {
          var $span = $(this);
          $span.text((index + 1) + '.Tercihiniz :');
          indexNum++;
        });
      });
    }
  });

  $('#average').keypress(function (event) {
    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
      event.preventDefault();
    }
  });

  setTimeout(function () {
    $('#ftco-loader').removeClass('show');
  }, 2000);

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
  // Input must be of a valid number format or a modifier key, and not longer than ten digits
  if (!isNumericInputPhone(event) && !isModifierKey(event)) {
    event.preventDefault();
  }
};

function formatToPhone(event) {
  if (isModifierKey(event)) { return; }

  // I am lazy and don't like to type things more than once
  var target = event.target;
  var input = event.target.value.replace(/\D/g, '').substring(0, 10); // First ten digits of input only
  var zip = input.substring(0, 3);
  var middle = input.substring(3, 6);
  var last = input.substring(6, 10);

  if (input.length > 6) { target.value = `(${zip}) ${middle} - ${last}`; }
  else if (input.length > 3) { target.value = `(${zip}) ${middle}`; }
  else if (input.length > 0) { target.value = `(${zip}`; }
};


$(document).on("keydown", "#phone", function (e) {
  enforceFormat(e);
});

$(document).on("keyup", "#phone", function (e) {
  formatToPhone(e);
});


$('#applyForm').submit(function () {

  var response = grecaptcha.getResponse();
  if (response.length === 0) {
    $('#msg').html("Lütfen bot olmadığınızı kanıtlayın!");
    return false;
  } else {

    // show that something is loading
    $('#msg').html("Gönderiliyor...");

    var selectedDepartments = "";
    var selectedDepartmentsCount = 0;
    $('input[type=checkbox]').each(function () {
      if (this.checked == true) {
        selectedDepartments += $(this).next('label').text() + ",";
        selectedDepartmentsCount += 1;
      }
    });

    if (selectedDepartmentsCount < 3) {
      alert("En az 3 departman seçmelisiniz!");
      $('#msg').html("");
      return false;
    }
    selectedDepartments = selectedDepartments.substring(0, selectedDepartments.length - 1)
    var averageOption = $("input[type=radio][name='optionAverage']:checked").next('label').text();

    var values = $(this).serialize();
    values += "&averageOption=" + encodeURIComponent(averageOption);
    values += "&selectedDepartments=" + encodeURIComponent(selectedDepartments);


    // Call ajax for pass data to other place
    $.ajax({
      type: 'POST',
      url: 'insert.php',
      data: values // getting filed value in serialize form
    })
      .done(function (data) { // if getting done then call.
        $('#msg').html(data);
        if (data === "Başvurunuz Kaydedildi") {
          setTimeout(function () {
            window.location.href = 'https://birliktekariyer.com';
          }, 1000);
        };

      })
      .fail(function () { // if fail then getting message

        // just in case posting your form failed
        alert("Başvuru başarısız! Lütfen tekrar deneyin.");

      });

    // to prevent refreshing the whole page page
    return false;

  }

});