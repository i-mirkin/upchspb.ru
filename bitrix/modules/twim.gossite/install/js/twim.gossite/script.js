/* global ymaps, BX */

;"use strict";

var AppOptionTwimGossite = (function(){

    var forEach = Array.prototype.forEach;

    function _init(){
        _toggleVoiceType();
        _initYaMap();
    }

    document.addEventListener("DOMContentLoaded", function(event){
        _init();
    }, false);

    function _loadScript( url, callback ) {
        var script = document.createElement("script");
        script.type = "text/javascript";
        if(script.readyState) {  // only required for IE <9
            script.onreadystatechange = function() {
            if ( script.readyState === "loaded" || script.readyState === "complete" ) {
                script.onreadystatechange = null;
                callback();
            }
            };
        } else {  //Others
            script.onload = function() {
            callback();
            };
        }
        script.src = url;
        document.getElementsByTagName("head")[0].appendChild( script );
    }

    function _toggleVoiceType(){
        var type_voice = document.querySelectorAll('[name^="type_voice_"]');
        forEach.call(type_voice, function(input){
            input.addEventListener("change", function(e){
                var type_item = document.querySelectorAll('.type-item-voice');
                forEach.call(type_item, function(item){item.style.display = "none";});
                var type_item_select = document.querySelectorAll('.type-item-voice__'+this.value);
                forEach.call(type_item_select, function(item){item.style.display = "";});
            }, false);
        });
    }

    function _initYaMap(){
        var elMaps = document.querySelectorAll(".s-gossite-ya-map");
        var loadScript = false;
        var maps = [];
        var coordsDef = [51.667400, 39.202329];

        //получаем параметры для карт сайтов
        forEach.call(elMaps, function(el, index){
            var site_id = "",
            dataMap,
            data;

            if(!el.hasAttribute("data-map")){
                console.warn(BX.message["twim.gossit_not_set_params"]);
                return false;
            }
            
            try{
                dataMap = el.getAttribute("data-map");
                data = JSON.parse(dataMap);
            } catch(e){
                console.warn(BX.message["twim.gossit_json_parse"] + " " + e);
                return false;
            }

            if(("key" in data) && (data.key.length > 1)){
                if(!loadScript){
                    _loadScript("https://api-maps.yandex.ru/2.1/?apikey="+data.key+"&lang=ru_RU", initMap);
                    loadScript = true;
                }   
                maps.push({"el": el, "site_id":data.site_id}); 
            } else {
                if(("site_id" in data)){
                    site_id = data.site_id;
                }
                console.warn(BX.message["twim.gossit_not_set_api_key"] + " " + site_id);
                return false;
            }  
            
        });

        // строим карты и управления для них, 
        function initMap(){
            ymaps.ready(function(){
                maps.forEach( function(element, index){
                    var myPlacemark,
                    myMap,
                    inputCoord,
                    mySearchControl,
                    coordsMap = coordsDef,
                    coords = "";
                    
                    inputCoord = document.querySelector("input[name='coord_ya_"+element.site_id+"']");
                    if(inputCoord && inputCoord.value.length > 4){
                        coords = coordsToArray(inputCoord.value);
                        coordsMap = coords;
                    }

                    myMap = new ymaps.Map(element.el, {
                        center: coordsMap,
                        zoom: 12,
                        controls:["searchControl", "zoomControl"]
                    },{
                        suppressMapOpenBlock: true
                    }),
                    myMap.behaviors.disable('dblClickZoom');

                    mySearchControl = myMap.controls.get("searchControl");  
                    mySearchControl.options.set('noPlacemark', true);

                    if(coords){
                        myPlacemark = createPlacemark(coords);
                        myMap.geoObjects.add(myPlacemark);
                        myPlacemark.events.add('dragend', function () {
                            inputCoord.value = strCoordsFormat(myPlacemark.geometry.getCoordinates());
                        });
                    }

                    myMap.events.add('dblclick', function (e) {
                        var coords = e.get('coords');
                        if (myPlacemark) {
                            myPlacemark.geometry.setCoordinates(coords);
                        }
                        else {
                            myPlacemark = createPlacemark(coords);
                            myMap.geoObjects.add(myPlacemark);
                            myPlacemark.events.add('dragend', function () {
                                inputCoord.value = strCoordsFormat(myPlacemark.geometry.getCoordinates());
                            });
                        }

                        inputCoord.value = strCoordsFormat(coords);
                    });
        
                });

                /**
                 * преобразует строку в массив координат
                 * @param {array} coordsStr 
                 */
                function coordsToArray(coordsStr){
                    var arCoords = coordsStr.split(",");
                    for (var index = 0; index < arCoords.length; index++) {
                        arCoords[index] = arCoords[index].trim();
                    }
                    return arCoords;

                }
                /**
                 * Форматирует массив координать в строку для записи в бд
                 * @param {string} coords 
                 */
                function strCoordsFormat(coords){
                    for (var index = 0; index < coords.length; index++) {
                        coords[index] = coords[index].toFixed(8);
                    }
                    return coords.join(", ");
                }
                /**
                 * create Placemark
                 * @param {type} coords
                 * @returns {ymaps.Placemark}
                 */
                function createPlacemark(coords) {
                    return new ymaps.Placemark(coords, {}, {
                        preset: 'islands#violetDotIconWithCaption',
                        draggable: true
                    });
                }
            });
        };
    }

    return {
        //loadScript: loadScript
    };
})();
