class NotasShareComponent extends Fronty.ModelComponent {
    constructor(notasModel, usuarioModel, router) {
        super(Handlebars.templates.notastable, notasModel, null, null);


        this.notasModel = notasModel;
        this.usuarioModel = usuarioModel;
        this.addModel('usuario', usuarioModel);
        this.router = router;

        this.notesService = new NotaService();

    }

    onStart() {
        this.updateNotesShared();
    }

    updateNotesShared() {
        this.notesService.listNotesShare().then((data) => {
            this.notasModel.setNotes(
            // create a Fronty.Model for each item retrieved from the backend
            data.map(
                (item) => new NotaModel(item.idNota, item.titulo, item.contenido, item.fk_idUsuario)
        ));
    });
    }

    // Override
    createChildModelComponent(className, element, id, modelItem) {
        return new NotaRowComponent(modelItem, this.usuarioModel, this.router, this);
    }
}
