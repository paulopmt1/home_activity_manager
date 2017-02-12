HomeActivityManager = (function (pub) {

    pub.visibleCards = {};
    pub.cardTemplate = document.querySelector('.cardTemplate');
    pub.container = document.querySelector('.main');
    pub.isLoading = true;
    pub.spinner = document.querySelector('.loader');
    
    var allUserActivities = [];
    
    /*
     * Fake weather data that is presented when the user first uses the app,
     * or when the user has not saved any cities. See startup code for more
     * discussion.
     */
    var initialActivity = {
        id: '2459115',
        name: 'Lavar Banheiro',
        created: '2016-07-22T01:00:00Z',
        punctuation: 10
    };

    pub.renderAllActivities = function () {
        
        if (localStorage.allUserActivities) {
            allUserActivities = JSON.parse(localStorage.allUserActivities);
            allUserActivities.forEach(function (activity) {
                pub.renderUserActivity(activity);
            });
        } else {
            
            pub.renderUserActivity(initialActivity);
        }
    };
    
    
    pub.saveActivitiesLocal = function () {
        var allActivities = JSON.stringify(allUserActivities);
        localStorage.allUserActivities = allActivities;
    };
    
    pub.getUserActivities = function () {
        
        $.get('getActivities', function(activities){
            allUserActivities = activities;
            pub.saveActivitiesLocal();
            pub.renderAllActivities();
        }).fail(function(){
            alert('o que vamos apresentar se o usuário não conseguiu nada?');
        }); 
    };
    
    
    // Updates a weather card with the latest weather forecast. If the card
    // doesn't already exist, it's cloned from the template.
    pub.renderUserActivity = function (activity) {
        var dataLastUpdated = new Date(activity.created);

        var card = pub.visibleCards[activity.id];

        if (!card) {
            card = pub.cardTemplate.cloneNode(true);
            card.classList.remove('cardTemplate');
            card.querySelector('.activityName').textContent = activity.name;
            card.querySelector('.points').textContent = activity.punctuation + ' pontos';
            card.removeAttribute('hidden');
            pub.container.appendChild(card);
            pub.visibleCards[activity.id] = card;
        }

        if (pub.isLoading) {
            pub.spinner.setAttribute('hidden', true);
            pub.container.removeAttribute('hidden');
            pub.isLoading = false;
        }
    };
    
    
    
    
//    pub.renderUserActivity(initialActivity);
    //    localStorage.selectedCities = "";
//    pub.selectedCities = localStorage.selectedCities;
    pub.renderAllActivities();
    pub.getUserActivities();

    return pub;
})(HomeActivityManager || {});