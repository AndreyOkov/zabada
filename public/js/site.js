


    function formDataToArray(form) {
        var formData = form.serializeArray(),   //возвращает массив объектов JavaScropt, который можно передавать в формате JSON.
            formDataObject = {},
            selects = [],                          //для успешной сериализации элемент формы должен содержать атрибут name
            regexp = /[\[][\]]/;

        // создаем ассоциативный массив из объкетов содержащихся в formData
        $.each(formData, function (key, value) {
            if (value.name.search(regexp) > 0) {
                value.name = value.name.substr(0, value.name.length - 2);
                if (!selects[value.name]) {
                    selects[value.name] = [];
                }
                selects[value.name].push(value.value);
            }
            formDataObject[value.name] = value.value;
        });
        for (var i in selects) {
            formDataObject[i] = selects[i];
        }
        return formDataObject;
    }


    function handleAjax(results, form, errorContainer) { // в result данные которые вернет php - скрипт
        
        if (results[0] === true) {
            clearValidationMessages(form, errorContainer);
        } else {
            showValidationMessages(form, errorContainer, results[1]);
        }
    }

    function showValidationMessages(form, errorContainer, errors) {
        
        clearValidationMessages(form, errorContainer);
        $.each(errors, function (inputKey, errorMessages) {
            if (errorMessages && errorMessages.length > 0) {
                console.log("inputKey: "+inputKey+"  errorMessages: " + errorMessages);
                console.log(form.find(errorContainer));
                form.find("[name=" + inputKey + "]").siblings(errorContainer)
                    .html("<p class='text-danger'>" + errorMessages[0] + "</p>");
            }
        });
    }

     function clearValidationMessages(form, errorContainer) {
        form.find(errorContainer).html('');
    }


