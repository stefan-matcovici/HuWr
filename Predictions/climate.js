
//Source: http://download.geonames.org/export/
// Countries
var climate_arr = new Array("Tropical wet","Tropical wet and dry","Semiarid","Arid","Mediterranean","Humid subtropical","Marine west coast","Humid continental","Subarctic","Tundra","Ice cap","Highland");
function populateClimates(climateElementId) {
    // given the id of the <select> tag as function argument, it inserts <option> tags
    var climateElement = document.getElementById(climateElementId);
    climateElement.length = 0;
    climateElement.options[0] = new Option('Select Climate', '-1' );
    climateElement.selectedIndex = 0;
    for (var i = 0; i < climate_arr.length; i++) {
        climateElement.options[climateElement.length] = new Option(climate_arr[i], climate_arr[i]);
    }
}