/**
 * Created by sami on 21-Apr-15.
 */
var Observer = (function() {
    var myEvents = {};

    // based on the excellent article: http://addyosmani.com/blog/jquery-1-7s-callbacks-feature-demystified/
    function Topic( id ) {
        var callbacks,
            method,
            topic = id && myEvents[ id ];
        if ( !topic ) {
            callbacks = jQuery.Callbacks();
            topic = {
                publish: callbacks.fire,
                subscribe: callbacks.add,
                unsubscribe: callbacks.remove
            };
            if ( id ) {
                myEvents[ id ] = topic;
            }
        }
        return topic;
    };

    return {
        event: Topic
    };
});

