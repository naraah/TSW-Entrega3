class NotaModel extends Fronty.Model {

    constructor(idNota, titulo, contenido, fk_idUsuario) {
        super('NotaModel'); //call super

        if (idNota) {
            this.idNota = idNota;
        }

        if (titulo) {
            this.titulo = titulo;
        }

        if (contenido) {
            this.contenido = contenido;
        }

        if (fk_idUsuario) {
            this.fk_idUsuario = fk_idUsuario;
        }
    }

    setTitulo(titulo) {
        this.set((self) => {
            self.titulo = titulo;
    });
    }

    setContenido(contenido) {
        this.set((self) => {
            self.contenido = contenido;
    });
    }

    setFk_idUsuario(fk_idUsuario) {
        this.set((self) => {
            self.fk_idUsuario = fk_idUsuario;
    });
    }
}
