class NotaViewComponent extends Fronty.ModelComponent {
    constructor(notasModel, usuarioModel, router) {
        super(Handlebars.templates.notaview, notasModel);

        this.notasModel = notasModel; // notes
        this.usuarioModel = usuarioModel; // global
        this.addModel('usuario', usuarioModel);
        this.router = router;

        this.notesService = new NotaService();
    }

    onStart() {
        var selectedId = this.router.getRouteQueryParam('idNota');
        this.loadNote(selectedId);
    }

    loadNote(idNota) {
        if (idNota != null) {
            this.notesService.getNote(idNota)
                .then((nota) => {
                this.notasModel.setSelectedNote(nota);
        });
        }
    }
}
