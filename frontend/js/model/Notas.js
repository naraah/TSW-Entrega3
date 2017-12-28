class NotasModel extends Fronty.Model {

    constructor() {
        super('NotasModel'); //call super

        // model attributes
        this.notas = [];
        this.usuarios = [];
    }

    setSelectedNote(nota) {
        this.set((self) => {
            self.selectedNote = nota;
    });
    }

    setNotes(notas) {
        this.set((self) => {
            self.notas = notas;
    });
    }

    setUsuarios(usuarios) {
        this.set((self) => {
            self.usuarios = usuarios;
    });
    }
}
