function split( val ) {
	return val.split( /,\s*/ );
}

function extractLast( term ) {
	return split( term ).pop();
}

$( document ).ready(function() {
    if ($('.tokenfield').length) {
        var groups = $('.tokenfield').attr('data-groups').split(',');
        $('.tokenfield').tokenfield({
            autocomplete: {
                source: function( request, response ) {
                    // delegate back to autocomplete, but extract the last term
                    response( $.ui.autocomplete.filter(
                        groups, extractLast( request.term )));
                },
                focus: function() {
                    // prevent value inserted on focus
                    return false;
                },
                select: function( event, ui ) {
                    var terms = split( this.value );
                    // remove the current input
                    terms.pop();
                    // add the selected item
                    terms.push( ui.item.value );
                    // add placeholder to get the comma-and-space at the end
                    terms.push( "" );
                    this.value = terms.join( ", " );
                    return false;
                },
                delay: 100
            },
            showAutocompleteOnFocus: true
        });
    }
});
