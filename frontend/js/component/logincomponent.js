class LoginComponent extends Fronty.ModelComponent {
  constructor(usuarioModel, router) {
    super(Handlebars.templates.login, usuarioModel);
    this.usuarioModel = usuarioModel;
    this.userService = new UsuarioService();
    this.router = router;

    this.addEventListener('click', '#loginbutton', (event) => {
      this.userService.login($('#login').val(), $('#password').val())
        .then(() => {
          this.router.goToPage('notes');
          this.usuarioModel.setLoggeduser($('#login').val());
        })
        .catch(() => {
          this.usuarioModel.logout();
        });
    });

    this.addEventListener('click', '#registerlink', () => {
      this.usuarioModel.set(() => {
        this.usuarioModel.registerMode = true;
      });
    });

    this.addEventListener('click', '#registerbutton', () => {
      this.userService.register({
          nombre: $('#registername').val(),
          apellidos: $('#registersurname').val(),
          alias: $('#registerusername').val(),
          password: $('#registerpassword').val()
        })
        .then(() => {
          alert(I18n.translate('User registered! Please login'));
          this.usuarioModel.set((model) => {
            model.registerErrors = {};
            model.registerMode = false;
          });
        })
        .fail((xhr, errorThrown, statusText) => {
          if (xhr.status == 400) {
            this.usuarioModel.set(() => {
              this.usuarioModel.registerErrors = xhr.responseJSON;
            });
          } else {
            alert('an error has occurred during request: ' + statusText + '.' + xhr.responseText);
          }
        });
    });
  }
}
