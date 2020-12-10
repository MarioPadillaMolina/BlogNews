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


    //borrado
    
    //los de ciclo for -> class="enlaceBorrar". Así le añadimos a cada link el ID
    let enlacesBorrar = document.getElementsByClassName('enlaceBorrar');
    if (enlacesBorrar) {
        for (var i = 0; i < enlacesBorrar.length; i++) {
            enlacesBorrar[i].addEventListener('click', getClassConfirmation);
        }
    }

    function getClassConfirmation() {
        let id = event.target.dataset.id;
        let name = event.target.dataset.name;
        //let retVal = confirm('¿Seguro que quieres borrar la moneda #' + id + 'de nombre ' + name + '?');
        //if (retVal) {
            var formDelete = document.getElementById('formDelete');
            formDelete.action += '/' + id;
            formDelete.submit();
//        }
    }
    
    //los de id="enlaceBorrar"
    let enlaceBorrar = document.getElementById('enlaceBorrar');
    if (enlaceBorrar) {
        enlaceBorrar.addEventListener('click', getConfirmation);
    }

    function getConfirmation() {
        let id = event.target.dataset.id; //data-id
        let name = event.target.dataset.name; //data-name
        let retVal = confirm('¿Sure to delete coin #' + id + ' ' + name + '?');
        if (retVal) {
            var formDelete = document.getElementById('formDelete');
            formDelete.submit();
        }
    }

})();
