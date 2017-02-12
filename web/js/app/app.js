HomeActivityManager = (function (pub) {
    'use strict';

    pub.addDialog = document.querySelector('.dialog-container');
    pub.daysOfWeek = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    
    /*****************************************************************************
     *
     * Event listeners for UI elements
     *
     ****************************************************************************/
    $('#butRefresh').click(function () {
        pub.updateForecasts();
    });
    $('#butAdd').click(function () {
        pub.toggleAddDialog(true);
    });

    $('#butAddCity').click(function () {
        // Add the newly selected city
        var select = document.getElementById('selectTaskToAdd');
        var selected = select.options[select.selectedIndex];
        var key = selected.value;
        var label = selected.textContent;
        
        addActivity(key);
        
        pub.saveActivitiesLocal();
        pub.renderAllActivities();
        pub.toggleAddDialog(false);
    });

    $('#butAddCancel').click(function () {
        // Close the add new city dialog
        pub.toggleAddDialog(false);
    });


    var addActivity = function(activityId){
        $.post('addActivity/' + activityId, function(){
            pub.getUserActivities();
        });
    };

    /*****************************************************************************
     *
     * Methods to update/refresh the UI
     *
     ****************************************************************************/

    // Toggles the visibility of the add new city dialog.
    pub.toggleAddDialog = function (visible) {
        if (visible) {
            pub.addDialog.classList.add('dialog-container--visible');
        } else {
            pub.addDialog.classList.remove('dialog-container--visible');
        }
    };

    


    /*****************************************************************************
     *
     * Methods for dealing with the model
     *
     ****************************************************************************/

    

    if ('serviceWorker' in navigator) {
//        window.addEventListener('load', function () {
//            navigator.serviceWorker.register('/sw.js').then(function (registration) {
//                // Registration was successful
//                console.log('ServiceWorker registration successful with scope: ', registration.scope);
//            }).catch(function (err) {
//                // registration failed :(
//                console.log('ServiceWorker registration failed: ', err);
//            });
//        });
    }


    return pub;
})(HomeActivityManager || {});