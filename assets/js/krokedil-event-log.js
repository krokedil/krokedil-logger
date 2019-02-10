jQuery( function( $ ) {
    var krokedil_event_log = { 
        renderJson: function() {
            $(".krokedil_json").each(function(){
                var string = $( this ).html();
                var json = JSON.parse( string );
                renderjson;
                $( this ).html( renderjson.set_show_to_level( '2' )( json ) )
            });
        },
        toggleJson: function( event_nr ){
            var event_id = '#krokedil_event_nr_' + event_nr;
            $(event_id).slideToggle('slow');
        },
        changeTab: function( event_nr, type ) {
            var request_tab_data = $('.krokedil_event_request[data-event-nr=' + event_nr + ']');
            var response_tab_data = $('.krokedil_event_response[data-event-nr=' + event_nr + ']');
            var request_tab = $('.krokedil_request_tab[data-event-nr=' + event_nr + ']');
            var response_tab = $('.krokedil_response_tab[data-event-nr=' + event_nr + ']');
            var button = $('.krokedil_copy_json[data-event-nr=' + event_nr + ']');

            // Handle tab data change
            if( 'request' === type ) {
                request_tab_data.addClass('krokedil_active_data_tab');
                response_tab_data.removeClass('krokedil_active_data_tab');
                request_tab.addClass('krokedil_active_tab');
                response_tab.removeClass('krokedil_active_tab');
                button.data('event-type', 'request');
            } else {
                response_tab_data.addClass('krokedil_active_data_tab');
                request_tab_data.removeClass('krokedil_active_data_tab');
                response_tab.addClass('krokedil_active_tab');
                request_tab.removeClass('krokedil_active_tab');
                button.data('event-type', 'response');
            }            
        },
        copyJson: function( event_nr, type ) {
            if( type === 'request' ) {
                var json = $('.krokedil_event_request_raw[data-event-nr=' + event_nr + ']');
            } else if( type === 'response' ) {
                var json = $('.krokedil_event_response_raw[data-event-nr=' + event_nr + ']');
            }
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(json).text()).select();
            document.execCommand("copy");
            $temp.remove();
        }
    }
    $( document ).ready(function() {
        krokedil_event_log.renderJson();
    });
    $('body').on('click', '.krokedil_timestamp', function() {
        var event_nr = $(this).data('event-nr');
        krokedil_event_log.toggleJson( event_nr );
    });
    $('body').on('click', '.krokedil_tab', function() {
        var event_nr = $(this).data('event-nr');
        var_type = '';
        if( $(this).hasClass( 'krokedil_request_tab' ) ) {
            type = 'request';
        } else {
            type = 'response';
        }
        krokedil_event_log.changeTab( event_nr, type );
    });
    $('body').on('click', '.krokedil_copy_json', function() {
        var event_nr = $(this).data('event-nr');
        var type = $(this).data('event-type');
        krokedil_event_log.copyJson( event_nr, type );
    });
});