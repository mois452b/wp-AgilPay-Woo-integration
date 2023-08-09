jQuery('#agilpay_card_expiry')
    .keydown( function(event) {
        const regularExp = /[0-9]/
        if( regularExp.exec( event.key ) === null ) {
            event.preventDefault()
        }
    } )
    .keyup( function(event) {
        jQuery(this).val( event.target.value.replace('/','') )
        const arrayContent = jQuery(this).val().split('')
        if( arrayContent.length > 4 ) {
            arrayContent.shift()
        }
        jQuery(this).val( arrayContent.toSpliced(1,1,arrayContent[1],'/').join('') )
    } )

jQuery('#agilpay_card_cvv')
    .keydown( function(event) {
        const regularExp = /[0-9]/
        if( jQuery(this).val().length==3 && regularExp.exec( event.key ) ) {
            event.preventDefault()
        }
    })