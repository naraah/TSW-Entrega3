class NotaShareComponent extends Fronty.ModelComponent {
    constructor(notasModel, usuarioModel, router) {
        super(Handlebars.templates.notashare, notasModel);
        this.notasModel = notasModel; // notes
        this.usuarioModel = usuarioModel; // global
        this.addModel('usuario', usuarioModel);
        this.router = router;

        this.notesService = new NotaService();
        this.userService = new UsuarioService();

        this.addEventListener('click', '#savebutton', () => {
            var usuarios = (function() {
                var a = [];
                $("#usuarios:checked").each(function() {
                    a.push(this.value);
                });
                return a;
            })();
            var selectedId = this.router.getRouteQueryParam('idNota');
            this.notesService.shareNote(selectedId,usuarios)
            .then(() => {
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
            this.getUsuarios();
            this.notesService.getNote(selectedId)
                .then((nota) => {
                this.notasModel.setSelectedNote(nota);

        });
        }
    }

    getUsuarios() {
        var selectedId = this.router.getRouteQueryParam('id');
        this.userService.findAllUsuarios(selectedId).then((data) => {

            this.notasModel.setUsuarios(
            // create a Fronty.Model for each item retrieved from the backend
            data.map(
                (item) => new UsuariosModel(item.idUsuario, item.alias)
        ));
    });
    }
}
