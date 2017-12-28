class NotaService {
    constructor() {}

    listNotes() {
        return $.get(AppConfig.backendServer+'/rest/nota');
    }

    listNotesShare() {
        return $.get(AppConfig.backendServer+'/rest/nota/share');
    }

    getNote(idNota) {
        return $.get(AppConfig.backendServer+'/rest/nota/' + idNota);
    }

    deleteNote(idNota) {
        return $.ajax({
            url: AppConfig.backendServer+'/rest/nota/' + idNota,
            method: 'DELETE'
        });
    }

    deleteShareNote(idNota){
        return $.ajax({
            url: AppConfig.backendServer+'/rest/nota/share/' + idNota,
            method: 'DELETE'
        });
    }

    saveNote(nota) {
        return $.ajax({
            url: AppConfig.backendServer+'/rest/note/' + nota.idNota,
            method: 'PUT',
            data: JSON.stringify(nota),
            contentType: 'application/json'
        });
    }

    addNote(nota) {
        return $.ajax({
            url: AppConfig.backendServer+'/rest/nota',
            method: 'POST',
            data: JSON.stringify(nota),
            contentType: 'application/json'
        });
    }

    shareNote(idNota, usuarios){
        return $.ajax({
            url: AppConfig.backendServer+ '/rest/nota/' + idNota + '/share',
            method: 'POST',
            data: JSON.stringify(usuarios),
            contentType:'application/json'
        });
    }
}
