(function() {

    //validación...
    let createMonedaForm = document.getElementById('createMonedaForm');
    
    //incompleto, falta validación
    if (createMonedaForm) {
        createMonedaForm.addEventListener('submit', function(event) {
            if (1 == 1) {
                //submit
            }
            else {
                alert("error validating");
                event.preventDefault();
            }
        })
    }


    //borrado en posts index y en comments
    let launchModal = document.getElementsByClassName('launchModal');
    if (launchModal) {
        for (var i = 0; i < launchModal.length; i++) {
            launchModal[i].addEventListener('click', sendModal);
        }
    }
    
    function sendModal(event){
        let id = event.target.dataset.id;
        let content = event.target.dataset.content;
        document.getElementById("objId").innerText = id;
        document.getElementById("objContent").innerText = content.substring(0, 50);
        document.getElementById("modalConfirmation").setAttribute("data-id", id);
    }
    
    
    let modalConfirmation = document.getElementById("modalConfirmation");
    if(modalConfirmation) {
        modalConfirmation.addEventListener('click', getModalConfirmation);        
    }
    
    function getModalConfirmation(event) {
        let id = event.target.dataset.id; //data-id
            var formDelete = document.getElementById('formDelete');
            formDelete.action += '/' + id;
            formDelete.submit();
    }

})();
