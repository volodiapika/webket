
$("#login-form" ).submit(function(event) {
  
  event.preventDefault();
  
  var $form = $(this),
    _login = $form.find("input[name='login']").val(),
    _password = $form.find("input[name='password']").val(),
    url = $form.attr("action");

  var posting = $.post(
    url,
    {
      login: _login,
      password: _password,
    }
  );
  
  posting.done(function(response) {
    var json_obj = $.parseJSON(response);
    var output = '';
    if (typeof json_obj.error !== "undefined") {
      output="";
      var inc = 0;
      for (var i in json_obj.error) {
          output+="" + json_obj.error[i] + "<br />";
          ++inc;
      }
      output+="";
      $('.msg.msg-error').css('display', 'inline');
      if (inc > 10)
        $('.msg.msg-error p strong').html(json_obj.error);
      else
        $('.msg.msg-error p strong').html(output);
      var delay = 1000;
      setTimeout(function(){$('.msg.msg-error').css('display', 'none');}, delay);
    }
    if (typeof json_obj.ok !== "undefined") {
      $('.msg.msg-ok').css('display', 'inline');
      $('.msg.msg-ok p strong').html(json_obj.ok);
      var delay = 1000;
      url = '/';
      setTimeout(function(){window.location = url;}, delay);
    }
  });
  
});

$("#register-form" ).submit(function(event) {
  
  event.preventDefault();
  
  var $form = $(this),
    _login = $form.find("input[name='login']").val(),
    _firstname = $form.find("input[name='firstname']").val(),
    _lastname = $form.find("input[name='lastname']").val(),
    _password = $form.find("input[name='password']").val(),
    url = $form.attr("action");

  var posting = $.post(
    url,
    {
      login: _login,
      firstname: _firstname,
      lastname: _lastname,
      password: _password,
    }
  );
  
  posting.done(function(response) {
    var json_obj = $.parseJSON(response);
    var output = '';
    if (typeof json_obj.error !== "undefined") {
      output="";
      var inc = 0;
      for (var i in json_obj.error) {
        output+="" + json_obj.error[i] + "<br />";
        ++inc;
      }
      output+="";
      $('.msg.msg-error').css('display', 'inline');
      if (inc > 10)
        $('.msg.msg-error p strong').html(json_obj.error);
      else
        $('.msg.msg-error p strong').html(output);
      var delay = 5000;
      setTimeout(function(){$('.msg.msg-error').css('display', 'none');}, delay);
    }
    if (typeof json_obj.ok !== "undefined") {
      $('.msg.msg-ok').css('display', 'inline');
      $('.msg.msg-ok p strong').html(json_obj.ok);
      var delay = 1000;
      url = '/auth-login';
      setTimeout(function(){window.location = url;}, delay);
    }
  });
  
});

$(".ico.edit").click(function() {
  var id = $(this).data('id'),
    firstname = $(this).data('firstname'),
    lastname = $(this).data('lastname'),
    login = $(this).data('login'),
    password = $(this).data('password'),
    role = $(this).data('role');
  $("#edit-user" ).find("input[name='id']").val(id);
  $("#edit-user" ).find("input[name='firstname']").val(firstname);
  $("#edit-user" ).find("input[name='lastname']").val(lastname);
  $("#edit-user" ).find("input[name='login']").val(login);
  $("#edit-user" ).find("input[name='password']").val('');
  $("#edit-user" ).find("input[name='role']").val(role);
  $("#box-edit-user").css('display', 'block');
  $("#edit-user").trigger("click");
});

$("#edit-user").submit(function(event) {
  
  event.preventDefault();
  
  var $form = $(this),
    _id = $form.find("input[name='id']").val(),
    _login = $form.find("input[name='login']").val(),
    _firstname = $form.find("input[name='firstname']").val(),
    _lastname = $form.find("input[name='lastname']").val(),
    _password = $form.find("input[name='password']").val(),
    _role = $form.find("input[name='role']").val(),
    url = $form.attr("action");

  var posting = $.post(
    url,
    {
      id: _id,
      login: _login,
      firstname: _firstname,
      lastname: _lastname,
      password: _password,
      role: _role,
    }
  );
  
  posting.done(function(response) {
    var json_obj = $.parseJSON(response);
    var output = '';
    if (typeof json_obj.error !== "undefined") {
      output="";
      var inc = 0;
      for (var i in json_obj.error) {
        output+="" + json_obj.error[i] + "<br />";
        ++inc;
      }
      output+="";
      $('.msg.msg-error').css('display', 'inline');
      if (inc > 10)
        $('.msg.msg-error p strong').html(json_obj.error);
      else
        $('.msg.msg-error p strong').html(output);
      var delay = 5000;
      setTimeout(function(){$('.msg.msg-error').css('display', 'none');}, delay);
    }
    if (typeof json_obj.ok !== "undefined") {
      $('.msg.msg-ok').css('display', 'inline');
      $('.msg.msg-ok p strong').html(json_obj.ok);
      var delay = 1000;
      url = '/list-users';
      setTimeout(function(){window.location = url;}, delay);
    }
  });
  
});

$(".ico.edit.message0").click(function() {
  var id = $(this).data('id');
  $("#send-message").find("input[name='idto']").val(id);
  $("#box-edit-messages").css('display', 'block');
  $("#send-message").trigger("click");
});

$("#send-message").submit(function(event) {
  
  event.preventDefault();
  
  var $form = $(this),
    _idto = $form.find("input[name='idto']").val(),
    _idfrom = $form.find("input[name='idfrom']").val(),
    _title = $form.find("input[name='title']").val(),
    _message = $form.find("input[name='message']").val(),
    url = $form.attr("action");

  var posting = $.post(
    url,
    {
      idto: _idto,
      idfrom: _idfrom,
      title: _title,
      message: _message,
    }
  );
  
  posting.done(function(response) {
    var json_obj = $.parseJSON(response);
    var output = '';
    if (typeof json_obj.error !== "undefined") {
      output="";
      var inc = 0;
      for (var i in json_obj.error) {
        output+="" + json_obj.error[i] + "<br />";
        ++inc;
      }
      output+="";
      $('.msg.msg-error').css('display', 'inline');
      if (inc > 10)
        $('.msg.msg-error p strong').html(json_obj.error);
      else
        $('.msg.msg-error p strong').html(output);
      var delay = 5000;
      setTimeout(function(){$('.msg.msg-error').css('display', 'none');}, delay);
    }
    if (typeof json_obj.ok !== "undefined") {
      $('.msg.msg-ok').css('display', 'inline');
      $('.msg.msg-ok p strong').html(json_obj.ok);
      var delay = 1000;
      url = '/list-users';
      setTimeout(function(){$('.msg.msg-ok').css('display', 'none');}, delay);
    }
  });
  
});

$(".ico.del").click(function() {
  var id = $(this).data('id');
  var url = '/delete-users/' + id;
  var posting = $.post(
    url,
    {}
  );
  posting.done(function(response) {
    var json_obj = $.parseJSON(response);
    var output = '';
    if (typeof json_obj.error !== "undefined") {
      output="";
      var inc = 0;
      for (var i in json_obj.error) {
        output+="" + json_obj.error[i] + "<br />";
        ++inc;
      }
      output+="";
      $('.msg.msg-error').css('display', 'inline');
      if (inc > 10)
        $('.msg.msg-error p strong').html(json_obj.error);
      else
        $('.msg.msg-error p strong').html(output);
      var delay = 1000;
      setTimeout(function(){$('.msg.msg-error').css('display', 'none');}, delay);
    }
    if (typeof json_obj.ok !== "undefined") {
      $('.msg.msg-ok').css('display', 'inline');
      $('.msg.msg-ok p strong').html(json_obj.ok);
      var delay = 1000;
      url = '/auth-login';
      $('#list_' + id).remove();
      setTimeout(function(){$('.msg.msg-ok').css('display', 'none');}, delay);
    }
  });
});
