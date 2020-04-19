'use strict';

(function () {
  function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
      "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
  }

  function setCookie(name, value, options = {}) {
    options = { path: '/',   ...options };

    if (options.expires instanceof Date) {
      options.expires = options.expires.toUTCString();
    }

    let updatedCookie = encodeURIComponent(name) + "=" + encodeURIComponent(value);

    for (let optionKey in options) {
      updatedCookie += "; " + optionKey;
      let optionValue = options[optionKey];
      if (optionValue !== true) {
        updatedCookie += "=" + optionValue;
      }
    }

    document.cookie = updatedCookie;
  }

  const clearButton = document.querySelector('.lots_clear');
  if (clearButton) {
    clearButton.addEventListener('click', function (event) {
      event.preventDefault();
      setCookie('history', '', { 'max-age': -1 });
      location.reload(false);
    })
  }
})();

(function() {
  const signupForm = document.querySelector('#signup-form');
  if (signupForm) {
    const passwordInput = signupForm.querySelector('#password');
    const passwordRepeatInput = signupForm.querySelector('#password-repeat');

    function checkPassword() {
      if (passwordInput.value === passwordRepeatInput.value && passwordInput.value.length > 0) {
        passwordRepeatInput.parentNode.classList.remove('form__item--invalid');
        passwordRepeatInput.setCustomValidity("");
        return true;
      } else {
        passwordRepeatInput.parentNode.classList.add('form__item--invalid');
        passwordRepeatInput.setCustomValidity("Пароли должны совпадать");
        return false;
      }
    }

    passwordInput.addEventListener('input', checkPassword);
    passwordRepeatInput.addEventListener('input', checkPassword);

    signupForm.addEventListener('submit', function (event) {
        if (!checkPassword()) event.preventDefault();
    });
  }
})();

(function () {
  var FILE_TYPES = ['gif', 'jpg', 'jpeg', 'png'];

  var checkFileType = function (file, fileTypes) {
    var fileName = file.name.toLowerCase();
    return fileTypes.some(function (it) {
      return fileName.endsWith(it);
    });
  };

  var loadFiles = function (input, onLoad, fileTypes) {
    var files = input.files;
    for (var i = 0; i < files.length; i++) {
      if (files[i] && checkFileType(files[i], fileTypes)) {
        var reader = new FileReader();
        reader.addEventListener('load', function (e) {
          onLoad(e, input);
        });
        reader.readAsDataURL(files[i]);
      }
    }
  };

  var onLoadImageFile = function (e, input) {
    var formItem = input.closest('.form__item');
    var preview = formItem.querySelector('.preview');
    var previewImage = preview.querySelector('.preview__img img');
    previewImage.src = e.target.result;
    formItem.classList.add('form__item--uploaded');
  };

  var onChangeFile = function (event) {
    loadFiles(event.target, onLoadImageFile, FILE_TYPES);
  };

  var imageFileInputs = document.querySelectorAll('.js-image-file-input');
  for (var i = 0; i < imageFileInputs.length; i++) {
    imageFileInputs[i].addEventListener('change', onChangeFile)
  }

  var onClosePreviewClick = function (e) {
    var formItem = e.target.closest('.form__item');
    formItem.classList.remove('form__item--uploaded');
    var input = formItem.querySelector('input');
    input.value = '';
    if(!/safari/i.test(navigator.userAgent)){
      input.type = '';
      input.type = 'file';
    }
  };

  var closePreviewButtons = document.querySelectorAll('.preview__remove');
  for (var i = 0; i < closePreviewButtons.length; i++) {
    closePreviewButtons[i].addEventListener('click', onClosePreviewClick)
  }
})();


