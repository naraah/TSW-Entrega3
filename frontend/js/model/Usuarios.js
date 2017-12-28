class UsuariosModel extends Fronty.Model {

    constructor(idUsuario, alias) {
        super('UsuariosModel'); //call super

        if (idUsuario) {
            this.idUsuario = idUsuario;
        }

        if (alias) {
            this.alias = alias;
        }
    }

    setAlias(alias) {
        this.set((self) => {
            self.alias = alias;
    });
    }
}
