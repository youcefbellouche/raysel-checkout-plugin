(function ($) {
    // SELECT CITIES INIT
    const selectCities = document.createElement("select");
    selectCities.setAttribute("name", "rwc-city");
    selectCities.setAttribute("required", "required");
    selectCities.classList.add("rwc-city-select");
    var cities = wpData.cities;
    
    
    // SELECT SHIPPING METHOD
    const selectShipping = document.createElement("select")
    selectShipping.setAttribute("name","rwc-shipping")
    selectShipping.setAttribute("required","required")
    selectShipping.classList.add("rwc-shipping-select")
    var shipping = wpData.shipping
    

    // WILAYA ON CHANGE
    $(document).on("change", ".rwc-wilaya-select", function (e) {
      const selectedState = e.target.value;
      const option = document.createElement("option");
      option.setAttribute("value", "");
      option.setAttribute("selected", "selected");
      option.setAttribute("disabled", "true");
      option.classList.add("rwc-city-option");
      option.append("اختر بلدية *");
      selectCities.innerHTML = "";
      selectCities.appendChild(option);
      const linkedCities = cities.filter(
        (city) =>
          city.wilaya_name_ascii.replace("'", "") ===
          selectedState.replace("'", "")
      );
      linkedCities.forEach((city) => {
      const option = document.createElement("option");
      option.setAttribute("value", city.commune_name_ascii);
      option.classList.add("rwc-city-option");
      option.append(city.commune_name);
      selectCities.appendChild(option);
      });
      $(".rwc-states").append(selectCities);

      const optionShipping = document.createElement("option");
      optionShipping.setAttribute("value", "");
      optionShipping.setAttribute("selected", "selected");
      optionShipping.setAttribute("disabled", "true");
      optionShipping.classList.add("rwc-shipping-option");
      optionShipping.append("اختر طريقة النفل *");
      selectShipping.innerHTML = "";
      selectShipping.appendChild(optionShipping);
      
      
      if(shipping[selectedState]['selling_point']){
        const optionShipping = document.createElement("option");
        optionShipping.setAttribute("value", 'selling_point');
        optionShipping.classList.add("rwc-shipping-option");
        optionShipping.append("استلام من مكتب النقل");
        selectShipping.appendChild(optionShipping);
      }
      if(shipping[selectedState]['seller'] == "on"){
        const optionShipping = document.createElement("option");
        optionShipping.setAttribute("value", "seller");
        optionShipping.classList.add("rwc-shipping-option");
        optionShipping.append("استلام من المحل");
        selectShipping.appendChild(optionShipping);
      }
      const optionShippingLiv = document.createElement("option");
      optionShippingLiv.setAttribute("value", 'regulare');
      optionShippingLiv.classList.add("rwc-shipping-option");
      optionShippingLiv.append("التوصيل للمنزل");
      selectShipping.appendChild(optionShippingLiv);
      $(".rwc-states").append(selectShipping);
    });
  })(jQuery);
  