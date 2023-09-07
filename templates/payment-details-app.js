jQuery('#agilpay_card_expiry')
    .on('input', function () {
        // Obtén el valor del input
        let inputValue = jQuery(this).val();
        
        // Remueve cualquier caracter que no sea número o '/'
        inputValue = inputValue.replace(/[^0-9/]/g, '');
        
        // Formatea la fecha MM/YY
        if (inputValue.length === 2 && inputValue.indexOf('/') === -1) {
          inputValue = inputValue.substring(0, 2) + '/';
        } else if (inputValue.length > 2 && inputValue.indexOf('/') === -1) {
          inputValue = inputValue.substring(0, 2) + '/' + inputValue.substring(2);
        }
        
        // Limita el campo a un máximo de 5 caracteres (MM/YY)
        if (inputValue.length > 5) {
          inputValue = inputValue.substring(0, 5);
        }
        
        // Asigna el valor formateado al input
        jQuery(this).val(inputValue);
    } )
    .on('keydown', function (e) {
        if (e.keyCode === 8) {
            let inputValue = jQuery(this).val();
            // Verifica si el último carácter es '/'
            if (inputValue.charAt(inputValue.length - 1) === '/') {
                // Elimina el último carácter
                inputValue = inputValue.slice(0, -1);
                jQuery(this).val(inputValue);
            }
        }
    });

jQuery('#agilpay_card_cvv')
    .keydown( function(event) {
        const regularExp = /[0-9]/
        if( jQuery(this).val().length==3 && regularExp.exec( event.key ) ) {
            event.preventDefault()
        }
    })