// on initialise ckeditor
// Membre
BalloonEditor
    .create(document.querySelector("#editorNomMembre"))
        .then(editor => {
            document.querySelector("div#part_form form").addEventListener("submit", function (e){
                e.preventDefault();
                this.querySelector("input#membre_nom_membre").value = editor.getData();
                this.submit();
            })
        });

BalloonEditor.create(document.querySelector("#editorDescMembre"))
    .then(editor => {
        document.querySelector("div#part_form form").addEventListener("submit", function (e){
            e.preventDefault();
            this.querySelector("input#membre_desc_membre").value = editor.getData();
            this.submit();
        })
    });

BalloonEditor
    .create(document.querySelector("#editorNomMembreModif"))
    .then(editor => {
        document.querySelector("div#part_form form").addEventListener("submit", function (e){
            e.preventDefault();
            this.querySelector("input#membre_modif_nom_membre").value = editor.getData();
            this.submit();
        })
    });

BalloonEditor.create(document.querySelector("#editorDescMembreModif"))
    .then(editor => {
       document.querySelector("div#part_form form").addEventListener("submit", function (e) {
           e.preventDefault();
           this.querySelector("input#membre_modif_desc_membre").value = editor.getData();
           this.submit();
       })
    });

// Action
BalloonEditor
    .create(document.querySelector("#editorNomAction"))
    .then(editor => {
        document.querySelector("div#part_form form").addEventListener("submit", function (e){
            e.preventDefault();
            this.querySelector("input#action_nom_act").value = editor.getData();
            this.submit();
        })
    });


BalloonEditor
    .create(document.querySelector("#editorDescAction"))
    .then(editor => {
        document.querySelector("div#part_form form").addEventListener("submit", function (e){
            e.preventDefault();
            this.querySelector("input#action_desc_act").value = editor.getData();
            this.submit();
        })
    });

BalloonEditor
    .create(document.querySelector("#editorNomActionModif"))
    .then(editor => {
        document.querySelector("div#part_form form").addEventListener("submit", function (e){
            e.preventDefault();
            this.querySelector("input#action_modif_nom_act").value = editor.getData();
            this.submit();
        })
    });

BalloonEditor
    .create(document.querySelector("#editorDescActionModif"))
    .then(editor => {
        document.querySelector("div#part_form form").addEventListener("submit", function (e){
            e.preventDefault();
            this.querySelector("input#action_modif_desc_act").value = editor.getData();
            this.submit();
        })
    });

// A Propos
BalloonEditor
    .create(document.querySelector("#editorProposEmail"))
    .then(editor => {
        document.querySelector("div#part_form form").addEventListener("submit", function (e){
            e.preventDefault();
            this.querySelector("input#a_propos_email").value = editor.getData();
            this.submit();
        })
    });

BalloonEditor
    .create(document.querySelector("#editorProposDescRegle"))
    .then(editor => {
        document.querySelector("div#part_form form").addEventListener("submit", function (e){
            e.preventDefault();
            this.querySelector("input#a_propos_descReglements").value = editor.getData();
            this.submit();
        })
    });

BalloonEditor
    .create(document.querySelector("#editorProposEmailModif"))
    .then(editor => {
        document.querySelector("div#part_form form").addEventListener("submit", function (e){
            e.preventDefault();
            this.querySelector("input#a_propos_modif_email").value = editor.getData();
            this.submit();
        })
    });

BalloonEditor
    .create(document.querySelector("#editorProposDescRegleModif"))
    .then(editor => {
        document.querySelector("div#part_form form").addEventListener("submit", function (e){
            e.preventDefault();
            this.querySelector("input#a_propos_modif_descReglements").value = editor.getData();
            this.submit();
        })
    });
