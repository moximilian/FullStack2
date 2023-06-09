$(function() {
  // Обработка отправки формы
  $('#login-form').submit(function(e) {
    e.preventDefault(); // Отменить стандартную отправку формы

    $.ajax({
      type: 'POST',
      url: 'login.php',
      data: $('#login-form').serialize(),
      dataType: 'html',
      success: function(data) {
        $('#user-info').html(data);
        $('#error-message').text('');
      },
      error: function(jqxhr, status, error) {
        if (jqxhr.status === 401) {
          $('#error-message').text('Неверный логин или пароль');
        } else if (jqxhr.status === 429) {
          $('#error-message').text('Слишком много неудачных попыток входа. Попробуйте снова через 5 минут.');
        } else {
          $('#error-message').text('Ошибка сервера: ' + error);
        }
        $('#user-info').html('');
      }
    });
  });
});s