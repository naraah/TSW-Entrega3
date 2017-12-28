class NotaEditComponent extends Fronty.ModelComponent {
    constructor(notasModel, usuarioModel, router) {
        super(Handlebars.templates.noteedit, notasModel);
        this.notasModel = notasModel; // notes
        this.usuarioModel = usuarioModel; // global
        this.addModel('usuario', usuarioModel);
        this.router = router;

        this.notesService = new NotaService();

        this.addEventListener('click', '#savebutton', () => {
            this.notasModel.selectedNote.titulo = $('#titulo').val();
            this.notasModel.selectedNote.contenido = $('#contenido').val();
            this.notesService.saveNote(this.notasModel.selectedNote).then(() => {
              this.notasModel.set((model) => {
                model.errors = []
                });
              this.router.goToPage('notes');
            })
            .fail((xhr, errorThrown, statusText) => {
            if (xhr.status == 400) {
            this.notasModel.set((model) => {
                model.errors = xhr.responseJSON;
        });
        } else {
            alert('an error has occurred during request: ' + statusText + '.' + xhr.responseText);
        }
    });

    });
    }

    onStart() {
        var selectedId = this.router.getRouteQueryParam('idNota');
        if (selectedId != null) {
            this.notesService.getNote(selectedId)
                .then((nota) => {
                this.notasModel.setSelectedNote(nota);
        });
        }
    }
}
