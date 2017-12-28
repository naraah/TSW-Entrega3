class NotasComponent extends Fronty.ModelComponent {
    constructor(notasModel, usuarioModel, router) {
        super(Handlebars.templates.notastable, notasModel, null, null);


        this.notasModel = notasModel;
        this.usuarioModel = usuarioModel;
        this.addModel('usuario', usuarioModel);
        this.router = router;

        this.notesService = new NotaService();

    }

    onStart() {
        this.updateNotes();
    }

    updateNotes() {
        this.notesService.listNotes().then((data) => {

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

class NotaRowComponent extends Fronty.ModelComponent {
    constructor(notaModel, usuarioModel, router, notasComponent) {
        super(Handlebars.templates.noterow, notaModel, null, null);

        this.notasComponent = notasComponent;

        this.usuarioModel = usuarioModel;
        this.addModel('usuario', usuarioModel); // a secondary model

        this.router = router;

        this.addEventListener('click', '.remove-button', (event) => {
            if (confirm(I18n.translate('Are you sure?'))) {
            var idNota = event.target.getAttribute('item');
            this.notasComponent.notesService.deleteNote(idNota)
                .fail(() => {
                alert('note cannot be deleted')
        })
        .always(() => {
                this.notasComponent.updateNotes();
        });
        }
    });

        this.addEventListener('click', '.unshared-button', (event) => {
            if (confirm(I18n.translate('Are you sure?'))) {
            var idNota = event.target.getAttribute('item');
            this.notasComponent.notesService.deleteShareNote(idNota)
                .fail(() => {
                alert('note cannot be unshared')
        })
        .always(() => {
                this.notasComponent.updateNotesShared();
            })
        }
    });

        this.addEventListener('click', '.share-button', (event) => {
            var idNota = event.target.getAttribute('item');
        this.router.goToPage('share-note?id=' + idNota);
    });
    }

}
