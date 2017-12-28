class MainComponent extends Fronty.RouterComponent {
  constructor() {
    super('frontyapp', Handlebars.templates.main, 'maincontent');

    // models instantiation
    // we can instantiate models at any place
    var userModel = new UsuarioModel();
    var notesModel = new NotasModel();

    super.setRouterConfig({
      notes: {
        component: new NotasComponent(notesModel, userModel, this),
        title: 'Notes'
      },
      'view-note': {
        component: new NotaViewComponent(notesModel, userModel, this),
        title: 'Note'
      },
      'edit-note': {
        component: new NotaEditComponent(notesModel, userModel, this),
        title: 'Edit Note'
      },
      'add-note': {
        component: new NotaAddComponent(notesModel, userModel, this),
        title: 'Add Note'
      },
      login: {
        component: new LoginComponent(userModel, this),
        title: 'Login'
      },
        'share-note': {
            component: new NotaShareComponent(notesModel, userModel, this),
            title: 'Share Note'
        },
        share: {
          component: new NotasShareComponent(notesModel, userModel, this),
            title: 'Share'
        },
      defaultRoute: 'login'
    });

    Handlebars.registerHelper('currentPage', () => {
          return super.getCurrentPage();
    });

    var userService = new UsuarioService();
    this.addChildComponent(this._createUserBarComponent(userModel, userService));
    this.addChildComponent(this._createLanguageComponent());

  }

  _createUserBarComponent(userModel, userService) {
    var userbar = new Fronty.ModelComponent(Handlebars.templates.user, userModel, 'userbar');

    userbar.addEventListener('click', '#logoutbutton', () => {
      userModel.logout();
      userService.logout();
    });

    // do relogin
    userService.loginWithSessionData()
      .then(function(logged) {
        if (logged != null) {
          userModel.setLoggeduser(logged);
        }
      });

    return userbar;
  }

  _createLanguageComponent() {
    var languageComponent = new Fronty.ModelComponent(Handlebars.templates.language, this.routerModel, 'languagecontrol');
    // language change links
    languageComponent.addEventListener('click', '#englishlink', () => {
      I18n.changeLanguage('default');
      document.location.reload();
    });

    languageComponent.addEventListener('click', '#spanishlink', () => {
      I18n.changeLanguage('es');
      document.location.reload();
    });

    return languageComponent;
  }
}
