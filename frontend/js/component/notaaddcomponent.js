class NotaAddComponent extends Fronty.ModelComponent {
    constructor(notasModel, usuarioModel, router) {
        super(Handlebars.templates.noteedit, notasModel);
        this.notasModel = notasModel; // notes

        this.usuarioModel = usuarioModel; // global
        this.addModel('usuario', usuarioModel);
        this.router = router;

        this.notesService = new NotaService();

        this.addEventListener('click', '#savebutton', () => {
            var newNote = {};
        newNote.titulo = $('#titulo').val();
        newNote.contenido = $('#content').val();
        newNote.fk_idUsuario = this.usuarioModel.currentUser;
        this.notesService.addNote(newNote)
            .then(() => {
            this.router.goToPage('notes');
    })
    .fail((xhr, errorThrown, statusText) => {
            if (xhr.status == 400) {
            this.notasModel.set(() => {
                this.notasModel.errors = xhr.responseJSON;
        });
        } else {
            alert('an error has occurred during request: ' + statusText + '.' + xhr.responseText);
        }
    });
    });
    }
}
