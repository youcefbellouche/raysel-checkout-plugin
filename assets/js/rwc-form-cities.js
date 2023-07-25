(function ($) {
    var cities = [];
    // SELECT STATES INIT
    const selectWilaya = document.createElement("select");
    selectWilaya.setAttribute("required", "required");
    selectWilaya.setAttribute("name", "rwc-state");
    selectWilaya.classList.add("rwc-wilaya-select");
  
    // SELECT CITIES INIT
    const selectCities = document.createElement("select");
    selectCities.setAttribute("name", "rwc-city");
    selectCities.setAttribute("required", "required");
    selectCities.classList.add("rwc-city-select");
  
    $(".rwc-product-wrapper").hide();
    Promise.all([
      $.getJSON(wpData.mainFileUrl + "/assets/algeria_cities.json"),
      $.getJSON(wpData.mainFileUrl + "/assets/algeria_states_lotfi.json"),
    ]).then((data) => {
      cities = data[0];
      $(".rwc-product-wrapper").show();
      const option = document.createElement("option");
      option.setAttribute("value", "");
      option.setAttribute("selected", "selected");
      option.setAttribute("disabled", "true");
      option.classList.add("rwc-wilaya-option");
      option.append("اختر الولاية *");
      selectWilaya.appendChild(option);
      // SET SELECT INPUT STATES
      data[1].forEach((wilaya) => {
        const option = document.createElement("option");
        option.setAttribute("value", wilaya.fr_name.replace("'", ""));
        option.classList.add("rwc-wilaya-option");
        option.append(wilaya.ar_name);
        selectWilaya.appendChild(option);
      });
  
      $(".rwc-states").append(selectWilaya);
    });
  
    $(document).on("change", ".rwc-wilaya-select", function (e) {
      const selectedState = e.target.value;
      const linkedCities = cities.filter(
        (city) =>
          city.wilaya_name_ascii.replace("'", "") ===
          selectedState.replace("'", "")
      );
      const option = document.createElement("option");
      option.setAttribute("value", "");
      option.setAttribute("selected", "selected");
      option.setAttribute("disabled", "true");
      option.classList.add("rwc-city-option");
      option.append("اختر بلدية *");
      selectCities.innerHTML = "";
      selectCities.appendChild(option);
      linkedCities.forEach((city) => {
        const option = document.createElement("option");
        option.setAttribute("value", city.commune_name_ascii);
        option.classList.add("rwc-city-option");
        option.append(city.commune_name);
        selectCities.appendChild(option);
      });
      $(".rwc-states").append(selectCities);
    });
  })(jQuery);
  