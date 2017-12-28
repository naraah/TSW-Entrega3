class UsuarioService {
  constructor() {}

  loginWithSessionData() {
    var self = this;
    return new Promise((resolve, reject) => {
      if (window.sessionStorage.getItem('login') &&
        window.sessionStorage.getItem('pass')) {
        self.login(window.sessionStorage.getItem('login'), window.sessionStorage.getItem('pass'))
          .then(() => {
            resolve(window.sessionStorage.getItem('login'));
          })
          .catch(() => {
            reject();
          });
      } else {
        resolve(null);
      }
    });
  }

  login(login, pass) {
    return new Promise((resolve, reject) => {

      $.get({
          url: AppConfig.backendServer+'/rest/usuario/' + login,
          beforeSend: function(xhr) {
            xhr.setRequestHeader("Authorization", "Basic " + btoa(login + ":" + pass));
          }
        })
        .then(() => {
          //keep this authentication forever
          window.sessionStorage.setItem('login', login);
          window.sessionStorage.setItem('pass', pass);
          $.ajaxSetup({
            beforeSend: (xhr) => {
              xhr.setRequestHeader("Authorization", "Basic " + btoa(login + ":" + pass));
            }
          });
          resolve();
        })
        .fail(() => {
          window.sessionStorage.removeItem('login');
          window.sessionStorage.removeItem('pass');
          $.ajaxSetup({
            beforeSend: (xhr) => {}
          });
          reject();
        });
    });
  }

  logout() {
    window.sessionStorage.removeItem('login');
    window.sessionStorage.removeItem('pass');
    $.ajaxSetup({
      beforeSend: (xhr) => {}
    });
  }

  register(usuario) {
    return $.ajax({
      url: AppConfig.backendServer+'/rest/usuario',
      method: 'POST',
      data: JSON.stringify(usuario),
      contentType: 'application/json'
    });
  }

    findAllUsuarios(idNota) {
        return $.get(AppConfig.backendServer+'/rest/usuarios/'+idNota);
    }
}
