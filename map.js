"use strict";

let map, searchManager;

// Initialize the map when the page loads
document.addEventListener("DOMContentLoaded", function () {
    getMap();
});

const searchBtn = document.querySelector(".search_btn");

searchBtn.addEventListener("click", () => {
    map.entities.clear();
    const departureInput = document.getElementById("departure");
    const destinationInput = document.getElementById("destination");

    const departure = departureInput.value.trim();
    const destination = destinationInput.value.trim();

    if (departure && destination) {
        geocodeQuery(departure, "departure");
        geocodeQuery(destination, "destination");
    } else {
        alert("Please enter both departure and destination.");
    }
});

function getMap() {
    map = new Microsoft.Maps.Map('#map', {
        credentials: 'AjyUnMwyZfHS0OUZcyOeKgZvbV0gg_nw0N0BbXPvQpUd-J6arKa7w_KEEXE3SCg8',
    });
}

function geocodeQuery(query, locationType) {
    if (!searchManager) {
        Microsoft.Maps.loadModule('Microsoft.Maps.Search', function () {
            searchManager = new Microsoft.Maps.Search.SearchManager(map);
            geocodeQuery(query, locationType);
        });
    } else {
        let searchRequest = {
            where: query,
            callback: function (r) {
                if (r && r.results && r.results.length > 0) {
                    var pin = new Microsoft.Maps.Pushpin(r.results[0].location);
                    map.entities.push(pin);

                    if (locationType === "departure") {
                        map.setView({ bounds: r.results[0].bestView });
                    }
                } else {
                    alert(`No results found for ${locationType}.`);
                }
            },
            errorCallback: function (e) {
                alert(`Error geocoding ${locationType}.`);
            }
        };
        searchManager.geocode(searchRequest);
    }
}
