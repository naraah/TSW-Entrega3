class UsuarioModel extends Fronty.Model {
  constructor() {
    super('UsuarioModel');
    this.isLogged = false;
      this.usuarios = [];
  }

  setLoggeduser(loggedUser) {
    this.set((self) => {
      self.currentUser = loggedUser;
      self.isLogged = true;
    });
  }

  logout() {
    this.set((self) => {
      delete self.currentUser;
      self.isLogged = false;
    });
  }

    setUsuarios(usuarios) {
        this.set((self) => {
            self.usuarios = usuarios;
    });
    }
}
