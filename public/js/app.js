$(document).ready(function() {

  var url = '';

  function redirect(url) {
    var protocol = window.location.protocol + '//';
    var host = window.location.host;
    var defaultUrl = '/';

    if (url) {
      window.location.replace(protocol + host + url);
    } else {
      window.location.replace(protocol + host + defaultUrl);
    }
  }

  $(document).on('submit', '.auth', function(e) {
    e.preventDefault();

    var form = $(this);
    var action = form.attr('action');
    var method = form.attr('method');
    var data = new FormData(form[0]);

    $.ajax({
      url: action,
      type: method,
      data: data,
      processData: false,
      cache: false,
      contentType: false,

      success: function(data) {
        var response = $.parseJSON(data);

        $('.auth p').removeClass('error').addClass('success').text(response.message).show();

        setTimeout(function(){
            redirect();
        },1000);
      },

      error: function(e) {
        var error = $.parseJSON(e.responseText);
        $('.error').text(error.message).show();
      }
    });
  });

  $('.button-buy').on('click', function() {
    $('#reserve-lead').attr('action', '/apartment/buy');
  });

  $('.button-reserve').on('click', function() {
    $('#reserve-lead').attr('action', '/apartment/reserve');

    if ($(this).hasClass('remove-reserve')) {
      $('#reserve-lead').attr('action', '/apartment/withdraw-reserve');
    }
  });

  $(document).on('submit', '#reserve-lead', function(e) {
    e.preventDefault();
    validate(this);

    var form = $(this);
    var action = form.attr('action');
    var method = form.attr('method');

    var data = new FormData(form[0]);
    if (validate(this) == true) {
      $('.buy-panel').addClass('status-success');

      $.ajax({
        url: action,
        type: method,
        data: data,
        contentType: false,
        cache: false,
        processData: false,

        success: function(data) {
            var response = $.parseJSON(data);

            document.getElementById('reserve-lead').reset();
            $('.circle-loader').toggleClass('load-complete');
            $('.checkmark').toggle();
            setTimeout(function() {
              $('body').removeClass('get-buy-panel');
            }, 2000);
            setTimeout(function() {
              $('.buy-panel').removeClass('status-success');
              $('.circle-loader').toggleClass('load-complete');
              $('.checkmark').toggle();
            }, 2200);
            setTimeout(function() {
              updateSidebar();
              changeFloor();
              $('.view-apartment.select-apartment').removeClass('select-apartment');
            }, 3000);
        },

        error: function(e) {
          document.getElementById('reserve-lead').reset();
          $('.circle-loader').toggleClass('load-complete failed');
          $('.checkmark').toggle();
          $('.buy-panel').find('.error-msg').show();
          $('.buy-panel').find('.error-msg').text(response['message']);
          setTimeout(function() {
            $('body').removeClass('get-buy-panel');
          }, 2000);
          setTimeout(function() {
            $('.buy-panel').removeClass('status-success');
            $('.circle-loader').toggleClass('load-complete failed');
            $('.checkmark').toggle();
            $('.buy-panel').find('.error-msg').hide();
          }, 2200);
        }
      });
    }
  });

  $(document).on('submit', '#actual-info', function(e) {
    e.preventDefault();

    var form = $(this);
    var action = form.attr('action');
    var method = form.attr('method');

    $('loader').addClass('loading');
    $('#boxApartments').addClass('filter-blur');

    $.ajax({
      url: action,
      type: method,
      contentType: false,
      cache: false,
      proccessData: false,

      success: function(data) {
        var response = $.parseJSON(data);

        if(window.location.toString().indexOf('/') > 0) {
          updateSidebar();
          changeFloor();
        }

        $('.circle-loader').toggleClass('load-complete');
        $('.checkmark').toggle();
        $('loader').find('.success-msg').show();
        $('loader').find('.success-msg').text(response['message']);

        setTimeout(function() {
          $('loader').removeClass('loading');
          $('.circle-loader').toggleClass('load-complete');
          $('.checkmark').toggle();
          $('loader').find('.success-msg').hide();
          $('loader').find('.success-msg').text();
          $('#boxApartments').removeClass('filter-blur');
        }, 800);
      },

      error: function(e) {
        $('.circle-loader').toggleClass('load-complete');
        $('.checkmark').toggle();
        $('loader').find('.error-msg').show();
        $('loader').find('.error-msg').text(response['message']);
        
        setTimeout(function() {
          $('loader').removeClass('loading');
          $('.circle-loader').toggleClass('load-complete failed');
          $('.checkmark').toggle();
          $('loader').find('.error-msg').hide();
          $('loader').find('.error-msg').text();
          $('#boxApartments').removeClass('filter-blur');
        }, 800);
      }
    });
  });

/********************************************************Start code by Vit********************************************************/

// Обновление сайдбара без перезагрузки
function updateSidebar() {
  var floor = $('.select-floor').find('.floor').text();
  var studio = $('.flat-item[data-flat=1]');
  var euro2x = $('.flat-item[data-flat=4]');
  var flat2x = $('.flat-item[data-flat=2]');
  var flat3x = $('.flat-item[data-flat=3]');
  $('#sidebarCount').load('/../ .flat__body, .flat-table', function () {
      $('.flat-table-row:nth-child(' + floor + ')').addClass('select-floor');
      if (studio.hasClass('select')) {
          $('.flat-item[data-flat=1]').addClass('select');
          $('.flat-table-item[data-flat=1]').addClass('select-flat');
      }

      if (euro2x.hasClass('select')) {
          $('.flat-item[data-flat=4]').addClass('select');
          $('.flat-table-item[data-flat=4]').addClass('select-flat');
      }

      if (flat2x.hasClass('select')) {
          $('.flat-item[data-flat=2]').addClass('select');
          $('.flat-table-item[data-flat=2]').addClass('select-flat');
      }

      if (flat3x.hasClass('select')) {
          $('.flat-item[data-flat=3]').addClass('select');
          $('.flat-table-item[data-flat=3]').addClass('select-flat');
      }

      selectFloor();
      flatTable();
  });

}
// Обновление сайдбара без перезагрузки

// Замена img на SVG
  $(function() {
    jQuery('img.svg').each(function() {
      var $img = jQuery(this);
      var imgID = $img.attr('id');
      var imgClass = $img.attr('class');
      var imgURL = $img.attr('src');

      jQuery.get(imgURL, function(data) {
        // Get the SVG tag, ignore the rest
        var $svg = jQuery(data).find('svg');

        // Add replaced image's ID to the new SVG
        if (typeof imgID !== 'undefined') {
          $svg = $svg.attr('id', imgID);
        }
        // Add replaced image's classes to the new SVG
        if (typeof imgClass !== 'undefined') {
          $svg = $svg.attr('class', imgClass + ' replaced-svg');
        }

        // Remove any invalid XML tags as per http://validator.w3.org
        $svg = $svg.removeAttr('xmlns:a');

        // Check if the viewport is set, else we gonna set it if we can.
        if (!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
          $svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
        }

        // Replace image with new SVG
        $img.replaceWith($svg);

      }, 'xml');

    });
  });

  // Навигация
  $('.navigation-section').on('click', function() {
    if ($(this).hasClass('active')) {
      $(this).removeClass('active');
    } else {
      $('.navigation-section').removeClass('active');
      $(this).addClass('active');
    }

    if ($('.navigation-section').hasClass('active')) {
      $('loader').addClass('active');
      $('#boxApartments').addClass('filter-blur');
    } else {
      $('loader').removeClass('active');
      $('#boxApartments').removeClass('filter-blur');
    }

    $('loader').click(function() {
      $('loader').removeClass('active');
      $('#boxApartments').removeClass('filter-blur');
      $('.navigation-section').removeClass('active');
    });
  });
  // Навигация

  // Выбор квартир по типу
  function flatTable() {
    $('.flat-item').on('click', function() {
      var selectFlat = $(this).data("flat");

      switch (selectFlat) {
        case 1:
          selectedFlat = "студия";
          break;
        case 2:
          selectedFlat = "2-х комнатная";
          break;
        case 3:
          selectedFlat = "3-х комнатная";
          break;
        case 4:
          selectedFlat = "евро 2-х комнатная";
          break;
      }

      if ($(this).hasClass('select')) {
        $(this).removeClass('select');
        $('.view-apartment[data-type="' + selectedFlat + '"]').removeClass('active-item');
        $('.flat-table-item[data-flat="' + selectFlat + '"]').removeClass('select-flat');
      } else {
        $(this).addClass('select');
        $('.view-apartment[data-type="' + selectedFlat + '"]').addClass('active-item');
        $('.flat-table-item[data-flat="' + selectFlat + '"]').addClass('select-flat');
      }

    });
  }
  // Выбор квартир по типу

  function selectedType() {

    if ($('.flat-item[data-flat=1]').hasClass('select')) {
      $('.view-apartment[data-type="студия"]').addClass('active-item');
    }

    if ($('.flat-item[data-flat=4]').hasClass('select')) {
      $('.view-apartment[data-type="евро 2-х комнатная"]').addClass('active-item');
    }

    if ($('.flat-item[data-flat=2]').hasClass('select')) {
      $('.view-apartment[data-type="2-х комнатная"]').addClass('active-item');
    }

    if ($('.flat-item[data-flat=3]').hasClass('select')) {
      $('.view-apartment[data-type="3-х комнатная"]').addClass('active-item');
    }

  }

  // Активация первого этажа
  function activeFloor() {
    $('.flat-table-row:first').addClass('select-floor');
    var floor = $('.flat-table-row:first').find('.floor').text();
    $('.floor-arrow-down').addClass('active');

    if (floor == 2) {
      $('.floor-arrow-up').removeClass('active');
    }

    changeFloor();
  }
  // Активация первого этажа

  // Смена этажа
  function changeFloor() {
    var floor = $('.select-floor').find('.floor').text();
    var condition = "operator=WHERE &field=a.floor&symbol==&floor=";
    var data = condition + floor;
    var action = '/apartments';
    var method = 'GET';

    var floorInfoText = $('.floor__number .number-text');
    var floorNumber = $('.select-floor').find('.flat-table-item:first').text();
    floorNumber = floorNumber.replace(/\D/g, '');
    floorInfoText.text(floorNumber);

    if (floor == 2) {
      $('.floor-arrow-up').removeClass('active');
    } else if (floor == 16) {
      $('.floor-arrow-down').removeClass('active');
    } else {
      $('.floor-arrow-up').addClass('active');
      $('.floor-arrow-down').addClass('active');
    }

    if (floor >= 12) {
      $('body').addClass('floor-12');
      whatFloor = '12';
      $.ajax({
        url: "/public/svg/apartments" + whatFloor + ".html",
        success: function(data) {
          $("#apartmentsLayout").html(data);
        }
      });
    } else {
      $('body').removeClass('floor-12');
      whatFloor = '2';
      $.ajax({
        url: "/public/svg/apartments" + whatFloor + ".html",
        success: function(data) {
          $("#apartmentsLayout").html(data);
        }
      });
    }

    $("#floorInfo #floorMapSchema .floor-schema").attr("src", "/../../public/image/flats/floor/walls" + whatFloor + ".png");

    $.ajax({
      url: action,
      data: data,
      type: method,
      contentType: false,
      cache: false,
      processData: false,

      success: function(data) {
        var response = $.parseJSON(data);

        $('.view-apartment').each(function(index) {
          var flatId = $('.view-apartment').attr('id');
          for (key in response) {
            $('#' + key + '.view-apartment').attr({
              'data-status': '' + response[key].status + '',
              'data-type': '' + response[key].type + '',
              'data-price': '' + parseFloat(response[key].price) + '',
              'data-windows': '' + response[key].windows + ''
            });
          }
        });

        $('.flat-number').each(function(index) {

          for (key in response) {
            $('.flat-number.' + key + '').text(response[key].num);
          }
        });

        selectedType();

        selectFlat();

        $('.view-apartment').on('click', function() {
          var status = $(this).data('status');
          var number = $(this).attr("id");
          var flatId = response[number].id;
          var flatStatus = response[number].status;
          var typeOfApartment = response[number].type;
          var flatFloor = response[number].floor;
          var flatNumber = response[number].num;
          var totalArea = response[number].total_area;
          var livingArea = response[number].factual_area;
          var flatPrice = response[number].price;

          var floor = $(".floor__number .number-text").text();
          var windows = $(this).data('windows');

          initWindowsView(floor, windows);

          if (status == '2') {
            var reservator = $('#reservator').text();
            var userRole = $('#role').text();

            var method = 'GET';
            var action = '/buyer/show';
            var data =  "apartment_id=" + parseInt(flatId);

            $.ajax({
              type: method,
              url: action,
              data: data,

              success: function(data) {
                var response = $.parseJSON(data);
                var buyerId;

                if ((response['status'] == 'success') && (userRole == 2)) {
                  var buyerId = response.id;

                  $('body').addClass('get-buy-panel');
                  $('.button-reserve.remove-reserve').removeAttr('disabled');
                  $('input[name="buyer_id"]').val('' + buyerId + '');
                  $('input[name="name"]').val('' + response.name + '');
                  $('input[name="surname"]').val('' + response.surname + '');
                  $('input[name="phone"]').val('' + response.phone + '');
                  $('input[name="email"]').val('' + response.email + '');
                } else if ((response['status'] == 'success') && (userRole == 3)) {

                  if ((response['status'] == 'success') && (reservator == response.seller_id)) {
                    var buyerId = response.id;

                    $('body').addClass('get-buy-panel');
                    $('.button-reserve.remove-reserve').removeAttr('disabled');
                    $('input[name="buyer_id"]').val('' + buyerId + '');
                    $('input[name="name"]').val('' + response.name + '');
                    $('input[name="surname"]').val('' + response.surname + '');
                    $('input[name="phone"]').val('' + response.phone + '');
                    $('input[name="email"]').val('' + response.email + '');
                  }

                } else if ((response['status'] == 'success') && (userRole == 1)) {
                  if ((response['status'] == 'success') && (reservator == response.seller_id)) {
                    var buyerId = response.id;

                    $('body').addClass('get-buy-panel');
                    $('.button-reserve.remove-reserve').removeAttr('disabled');
                    $('input[name="buyer_id"]').val('' + buyerId + '');
                    $('input[name="name"]').val('' + response.name + '');
                    $('input[name="surname"]').val('' + response.surname + '');
                    $('input[name="phone"]').val('' + response.phone + '');
                    $('input[name="email"]').val('' + response.email + '');
                  }
                } else if ((response['status'] == 'fail_amo') && (userRole == 3)) {

                  $('body').removeClass('get-buy-panel');
                  $('.button-reserve.remove-reserve').attr('disabled', 'disabled');
                  document.getElementById('reserve-lead').reset();
                  $('input[name="buyer_id"]').val('');

                  $('loader').addClass('active loading');
                  $('.circle-loader').toggleClass('load-complete failed');
                  $('#boxApartments').addClass('filter-blur');
                  
                  var statusBlock = document.querySelector('.status-block');
                  var errorMsg = document.createElement('div');
                  errorMsg.className = 'error-message';
                  errorMsg.innerHTML = response['message'];

                  $('.checkmark').toggle();
                  statusBlock.appendChild(errorMsg);
                  

                } else if ((response['status'] == 'fail')) {
                  $('body').removeClass('get-buy-panel');
                  $('.button-reserve.remove-reserve').attr('disabled', 'disabled');
                  document.getElementById('reserve-lead').reset();
                  $('input[name="buyer_id"]').val('');
                }
              },

              error: function(e) {

              }
            });

              $('#floorInfo').removeClass('get-flat-info');

              setTimeout( function() {
                $('#floorInfo').removeClass('get-flat-display');
              }, 150);

          } else if (status == '3') {
              $('body').removeClass('get-buy-panel');
              document.getElementById('reserve-lead').reset();
              $('input[name="buyer_id"]').val('');
              $('#floorInfo').removeClass('get-flat-info');

              setTimeout( function() {
                $('#floorInfo').removeClass('get-flat-display');
              }, 150);
          } else {

            document.getElementById('reserve-lead').reset();
            $('.button-reserve').removeAttr('disabled');
            $('input[name="buyer_id"]').val('');

            $('#floorInfo').addClass('get-flat-display');

            setTimeout( function() {
                $('#floorInfo').addClass('get-flat-info');
            } , 100);
          }
          // Очистка полей
          if ($('.buy-panel form div').hasClass('error')) {
            $('.buy-panel form div').removeClass('error');
            $('.buy-panel form div .error-message').remove();
          }

          switch (flatStatus) {
            case '3':
              flatStatus = "Продана";
              $('.form-panel-header').text('Квартира продана');
              $('.button-reserve').removeClass('remove-reserve');
              break;
            case '1':
              flatStatus = "Свободна";
              $('.button-reserve').text('Бронировать').removeClass('remove-reserve');
              $('.form-panel-header').text('Купить / бронировать');
              break;
            case '2':
              flatStatus = "Забронирована";
              $('.form-panel-header').text(flatStatus);
              $('.button-reserve').text('Снять бронь').addClass('remove-reserve');
              break;
          }

          $('#flatInfo .flat-header').text(typeOfApartment);
          $('#flatInfo .flat-floor span').text(flatFloor);
          $('#flatInfo .flat-number span').text(flatNumber);
          $('#flatInfo .flat-total-area span').text(totalArea);
          $('#flatInfo .flat-living-area span').text(livingArea);
          $('#flatInfo #flatCost').text(flatPrice.replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '));
          $('.select-flat-info .flat-status span').text(flatStatus);
          $('.buy-panel form #apartmentId').val(flatId);
          $('.buy-panel form #apartmentNum').val(flatNumber);
          $('#flatInfo .flat-img').attr('src', '/../../public/image/flats/' + totalArea + '/flat.svg');

          // Перенос значений в форму
          $('.select-flat-info .flat-number span').text(flatNumber);
          $('.select-flat-info .flat-type span').text(typeOfApartment);
          $('.select-flat-info .flat-floor span').text(flatFloor);
          $('.select-flat-info .flat-total-area span').text(totalArea);
          $('.select-flat-info .flat-price span').text(flatPrice.replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '));
        });

      }
    });
  }
  // Смена этажа

  $('.loader').on('click', function() {
    $('.loader').removeClass('active loading');
    $('.circle-loader').toggleClass('load-complete failed');
    $('.checkmark').toggle();
    var errorMsg = document.querySelector('.error-message');
    // errorMsg.parentNode.removeChild(errorMsg);
    
      $('#boxApartments').removeClass('filter-blur');
      $('.main__content').removeClass('filter-blur');
    
    
  });

  whatFloor = '2';
  if(document.location.pathname == '/') {
    $.ajax({
      url: "/public/svg/apartments" + window.whatFloor + ".html",
      success: function(data) {
        $("#apartmentsLayout").html(data);

        if(window.location.toString().indexOf('/') > 0) {
          activeFloor();
        }
        selectFloor();
        selectFlat();
        flatTable();
      }
    });
  }

  // Выбор первой свободной квартиры
  function firstFreeFlat() {
    $('.view-apartment[data-status=1]:first').addClass('select-apartment');
    var number = $('.select-apartment').attr("id");
    var flatId = response[number].id;
    var flatStatus = response[number].status;
    var typeOfApartment = response[number].type;
    var flatFloor = response[number].floor;
    var flatNumber = response[number].num;
    var totalArea = response[number].total_area;
    var livingArea = response[number].living_area;
    var flatPrice = response[number].price;

    // Очистка полей
    if ($('.buy-panel form div').hasClass('error')) {
      $('.buy-panel form div').removeClass('error');
      $('.buy-panel form div .error-message').remove();
    }

    switch (flatStatus) {
      case '3':
        flatStatus = "Продана";
        break;
      case '1':
        flatStatus = "Свободна";
        break;
      case '2':
        flatStatus = "Забронирована";
        break;
    }

    $('#flatInfo .flat-header').text(typeOfApartment);
    $('#flatInfo .flat-floor span').text(flatFloor);
    $('#flatInfo .flat-number span').text(flatNumber);
    $('#flatInfo .flat-total-area span').text(totalArea);
    $('#flatInfo .flat-living-area span').text(livingArea);
    $('#flatInfo #flatCost').text(flatPrice.replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '));
    $('.select-flat-info .flat-status span').text(flatStatus);
    $('.buy-panel form #apartmentId').val(flatId);
    $('#flatInfo .flat-img').attr('src', '/../../public/image/flats/' + totalArea + '/flat.svg');

    // Перенос значений в форму
    $('.select-flat-info .flat-number span').text(flatNumber);
    $('.select-flat-info .flat-type span').text(typeOfApartment);
    $('.select-flat-info .flat-floor span').text(flatFloor);
    $('.select-flat-info .flat-total-area span').text(totalArea);
    $('.select-flat-info .flat-price span').text(flatPrice.replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '));
  }

  // Выбор квартиры
  function selectFlat() {
    $('.view-apartment').on('click', function() {
      $('.view-apartment').removeClass('select-apartment');
      $(this).addClass('select-apartment');
    });
  }
  // Выбор квартиры

  // Появление названий улиц
  setTimeout(function() {
    $('.name-street').addClass('show-street');
  }, 500);
  // Появление названий улиц

  // For select floor
  function selectFloor() {
    $('.flat-table-row').on('click', function() {
      $('.flat-table-row').removeClass('select-floor');
      $(this).addClass('select-floor');

      var floor = $(this).find('.floor').text();

      if (floor == 2) {
        $('.floor-arrow-up').removeClass('active');
        $('.floor-arrow-down').addClass('active');
      } else if (floor == 16) {
        $('.floor-arrow-down').removeClass('active');
        $('.floor-arrow-up').addClass('active');
      } else {
        $('.floor-arrow-up').addClass('active');
        $('.floor-arrow-down').addClass('active');
      }

      changeFloor();
    });
  }

  // Переключение этажей на стрелках
  $('.floor-arrow-down').on('click', function(e) {
    e.preventDefault();
    nextFloor();
  });

  $('.floor-arrow-up').on('click', function(e) {
    e.preventDefault();
    prevFloor();
  });

  function nextFloor() {
    $('.flat-table-row.select-floor').next('.flat-table-row').addClass('select-floor').prev('.flat-table-row').removeClass('select-floor');
    changeFloor();
  }

  function prevFloor(e) {
    $('.flat-table-row.select-floor').prev('.flat-table-row').addClass('select-floor').next('.flat-table-row').removeClass('select-floor');
    changeFloor();
  }
  // Переключение этажей на стрелках

  // Select flat
  $('.flat-table-row').on('click', function() {
    var floorInfoText = $('.floor__number .number-text');
    var floorNumber = $(this).find('.flat-table-item:first').text();
    floorNumber = floorNumber.replace(/\D/g, '');
    floorInfoText.text(floorNumber);
  });

  // Вызов панели
  $('.btn-buy').on('click', function() {
    $('body').addClass('get-buy-panel');
  });
  // Вызов панели

  // Закрытие панели
  $('.close-panel').on('click', function() {
    $('body').removeClass('get-buy-panel');
  });
  // Закрытие панели

  // Form validation
  function showError(container, errorMessage) {
    container.className = 'error';
    var msgElem = document.createElement('span');
    msgElem.className = "error-message";
    msgElem.innerHTML = errorMessage;
    container.appendChild(msgElem);
  }

  function resetError(container) {
    container.className = '';
    if (container.lastChild.className == "error-message") {
      container.removeChild(container.lastChild);
    }
  }

  function validate(form) {
    var elems = form.elements;

    resetError(elems.name.parentNode);
    if (!elems.name.value) {
      showError(elems.name.parentNode, ' Укажите ваше имя.');
    };

    resetError(elems.surname.parentNode);
    if (!elems.surname.value) {
      showError(elems.surname.parentNode, ' Укажите вашу фамилию.');
    };

    resetError(elems.email.parentNode && elems.phone.parentNode);
    var re = /^[\w-\.]+@[\w-]+\.[a-z]{2,3}$/i;
    if (!elems.email.value && !elems.phone.value) {
      showError(elems.email.parentNode, ' Введите email.');
      showError(elems.phone.parentNode, ' Введите номер телефона.');
    } else if (!elems.email.value && elems.phone.value != '') {
      resetError(elems.email.parentNode);
    } else if (!re.test(elems.email.value)) {
      showError(elems.email.parentNode, ' Введенный email некорректный.');
    }


    if ($('.buy-panel form div').hasClass('error')) {
      return false;
    } else {
      return true;
    }
  }

  // Phone mask
  $('[name="phone"]').inputmask({
    "mask": "+7(999)999-99-99"
  });
  // Phone mask

  // Input focus
  $('.buy-panel form input').on('focus', function() {
    if ($('.buy-panel form div').hasClass('error')) {
      $('.buy-panel form div').removeClass('error');
      $('.buy-panel form div .error-message').remove();
    }
  });
  // Input focus

  // Вызов сайдбара при ширине 1200
  $(window).on('resize', function() {
    handleMedia();
  });

  function handleMedia() {
    if(window.matchMedia('(max-width: 1200px)').matches){
      $(document).on('click', '.menu-item', function() {

        if ($('.menu-item').hasClass('active-sidebar')) {
          $('.menu-item').removeClass('active-sidebar');
          $('body').removeClass('get-sidebar');
          $('.main__content').removeClass('filter-blur');
          $('loader').removeClass('active');
        } else {
          $('.menu-item').addClass('active-sidebar');
          $('body').addClass('get-sidebar');
          $('.main__content').addClass('filter-blur');
          $('loader').addClass('active');
        }

      });

      $('loader').on('click', function() {
        $('.navigation-section').removeClass('active');
        $('.loader').removeClass('active');

        $('loader').removeClass('active');
        $('.menu-item').removeClass('active-sidebar');
        $('body').removeClass('get-sidebar');
        $('#boxApartments').removeClass('filter-blur');
        $('.main__content').removeClass('filter-blur');
      });
    }
  }

  handleMedia();
  // Вызов сайдбара при ширине 1200








  // $(document).on('click', '.btn-action', function() {
  //   $(this).toggleClass('hidden');
  //   $(this).siblings('button').toggleClass('hidden');
  // });

  $(document).on('click', '.form-edit', function() {
    $(this).toggleClass('hidden');
    $(this).siblings('button').toggleClass('hidden');
    $(this).closest('tr').find('td.editable').addClass('active');
  });

  $(document).on('click', '.form-save', function() {
    var editable = $(this).closest('tr').find('td.editable');
    var action = $(this).closest('tr').data('action');
    var id = $(this).closest('tr').data('id');
    var data = {};
    data['id'] = id;

    var allowToSend = true;

    editable.each(function() {
      if(isValid($(this).find('form'))) {
        var attrName = $(this).find('input, select').attr('name');
        if($(this).find('input').length) {
          if(attrName.indexOf('[]') !== -1) {
            var span = $(this).find('span');
            span.html('');
            $(this).find('input:checked').each(function() {
              span.append('<div>' + $(this).data('name') + '</div>')
            });
          } else {
            $(this).find('span').text($(this).find('input').val());
          }
        } else {
          $(this).find('span').text($(this).find('option:selected').text());
        }
        if(attrName.indexOf('[]') !== -1) {
          data[attrName] = [];
          $(this).find('input:checked').each(function() {
            data[attrName].push($(this).val());
          });
        } else {
          data[attrName] = $(this).find('input, select').val();
        }
      } else {
        allowToSend = false;
      }
    });

    if(allowToSend) {
      editable.removeClass('active');
      $(this).toggleClass('hidden');
      $(this).siblings('button').toggleClass('hidden');
      submitData(action, data);
    }
  });

  function submitData(action, data) {
    $.ajax({
      url: action,
      type: 'POST',
      data: data,
      success: function(data) {
        console.log(data);
      }
    })
  }

  $(document).on('submit', '.common-ajax-form', function(e) {
    e.preventDefault();

    var form = $(this);

    var action = form.attr('action');
    var method = form.attr('method');
    var data = new FormData(form[0]);

    if(isValid(form)) {
      $.ajax({
        url: action,
        type: method,
        data: data,
        cache: false,
        processData: false,
        contentType: false,

        success: function(data) {
          var response = $.parseJSON(data);
          if($('#file-error').length) {
            $('#file-error').text(response.message).addClass('green');
          }
          if(form.hasClass('form-delete')) {
            form.closest('tr').remove();
          }
          if(form.hasClass('form-add')) {
            updateTable();
          }
          // console.log(response);
        },

        error: function(e) {
          var error = $.parseJSON(e.responseText);
          if(e.status === 400) {
            $('#file-error').text(error.message);
          }
          console.log(error);
        }
      });
    }
  });

  function isValid(form) {
    var clean = true;
    form.find('input[type="text"], input[type="number"]').each(function() {
      if($(this).attr('name') != 'discount') {
        if($(this).val() == '') {
          $(this).addClass('err');
          $('<span class="err-msg">Поле не может быть пустым</span>').insertBefore($(this));
          clean = false;
        }
        if($(this).val().length > 255) {
          $(this).addClass('err');
          $('<span class="err-msg">Поле должно быть меньше 255 символов</span>').insertBefore($(this));
          clean = false;
        }
        if($(this).attr('type') == 'number' && $(this).val().length > 11) {
          $(this).addClass('err');
          $('<span class="err-msg">Поле должно быть меньше 11 символов</span>').insertBefore($(this));
          clean = false;
        }
      }
    });
    return clean;
  }

  $(document).on('focus', 'input', function() {
    $(this).removeClass('err');
    $(this).prevAll('.err-msg').remove();
  });

  function updateTable() {
    $.ajax({
      url: window.location.href,
      type: 'GET',
      success: function(data) {
        $(document).find('.table').html($(data).find('.table table'));
      }
    });
  }

  if(window.location.pathname != '/') {
    $(document).find('.menu-item').addClass('hack');
  }

  /********************************************************End code by Vit********************************************************/
});