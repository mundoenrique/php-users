'use strict'
$(function () {
  $.balloon.defaults.css = null;
  insertFormInput(false);

  if (lang.SETT_MAINT_NOTIF === 'ON') {
    var mesgNotif = lang.GEN_MSG_MAINT_NOTIF.replace('%s', assetUrl + 'images/' + customerUri + '/maint_notif4.png');
    modalBtn = {
      btn1: {
        text: lang.GEN_BTN_ACCEPT,
        action: 'destroy'
      },
      maxHeight: 'none',
      minWidth: 500,
      posAt: 'center top',
      posMy: 'center top+100'
    }

    appMessages(lang.GEN_SYSTEM_NAME, mesgNotif, '', modalBtn);
  }

  $('#userPass').on('keyup', function () {
    $(this).attr('type', 'password');

    if ($(this).val() == '') {
      $(this).attr('type', 'text');
    }
  });

  $('#signInBtn').on('click', function (e) {
    e.preventDefault();
    $('#userPass').attr('type', 'password');
    form = $('#signInForm');
    validateForms(form);

    if (form.valid()) {
      btnText = $(this).html();
      data = getDataForm(form);
      data.userPass = cryptography.encrypt(data.userPass);
      data.currentTime = new Date().getHours();
      $(this).html(loader);
      insertFormInput(true);

      getRecaptchaToken('SignIn', function (recaptchaToken) {
        data.token = recaptchaToken;
        getSignIn();
      });
    }
  });

  $('#system-info').on('click', '.send-otp', function () {
    form = $('#OTPcodeForm');
    validateForms(form);

    if (form.valid()) {
      $(this)
        .html(loader)
        .prop('disabled', true)
      insertFormInput(true);

      getRecaptchaToken('verifyIP', function (recaptchaToken) {
        data.token = recaptchaToken;
        data.OTPcode = $('#otpCode').val();
        data.saveIP = $('#acceptAssert').is(':checked') ? true : false;
        getSignIn();
      });
    }
  });
});

function getSignIn() {
  who = 'User';
  where = 'signin';

  callNovoCore(who, where, data, function (response) {
    switch (response.code) {
      case 0:
        $(location).attr('href', response.data);
        break;
      case 1:
        $('#userName').showBalloon({
          html: true,
          classname: response.className,
          position: response.position,
          contents: response.msg
        });
        break;
      case 2:
        response.modalBtn.minWidth = 480;
        response.modalBtn.maxHeight = 'none';
        response.modalBtn.posAt = 'center top';
        response.modalBtn.posMy = 'center top+160';

        inputModal = '<form id="OTPcodeForm" name="formVerificationOTP" class="mr-2" method="post" onsubmit="return false;">';
        inputModal += '<p class="pt-0 p-0">' + response.msg + '</p>';
        inputModal += '<div class="row">';
        inputModal += '<div class="form-group col-8">';
        inputModal += '<label for="otpCode">' + lang.GEN_OTP_LABEL_INPUT + '</label>'
        inputModal += '<input id="otpCode" class="form-control" type="text" name="otpCode" autocomplete="off" maxlength="10">';
        inputModal += '<div class="help-block"></div>'
        inputModal += '</div">';
        inputModal += '</div>';
        inputModal += '<div class="form-group custom-control custom-switch mb-0">'
        inputModal += '<input id="acceptAssert" class="custom-control-input" type="checkbox" name="acceptAssert">'
        inputModal += '<label class="custom-control-label" for="acceptAssert">' + lang.USER_IP_ASSERT + '</label>'
        inputModal += '</div">'
        inputModal += '</form>';

        $('#accept').addClass('send-otp');
        appMessages(response.title, inputModal, response.icon, response.modalBtn);
        break;
      case 3:
        response.modalBtn.minWidth = 480;
        response.modalBtn.maxHeight = 'none';
        response.modalBtn.posAt = 'center top';
        response.modalBtn.posMy = 'center top+160';
        inputModal = response.msg

        appMessages(response.title, inputModal, response.icon, response.modalBtn);
        break;

    }

    if (response.code != 0) {
      $('#userPass').val('');
      $('#signInBtn').html(btnText);
      insertFormInput(false);

      if (lang.SETT_RESTAR_USERNAME == 'ON') {
        $('#userName').val('');
      }

      setTimeout(function () {
        $("#userName").hideBalloon();
      }, 2000);
    }
  });
}
