


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


    function handleAjax(results, form, errorContainer, isClient) { // в result данные которые вернет php - скрипт
        
        if (results[0] === true && !isClient) {
            clearValidationMessages(form, errorContainer);
        } else {
            showValidationMessages(form, errorContainer, results[1]);
        }
    }

    function showValidationMessages(form, errorContainer, errors) {
        
        clearValidationMessages(form, errorContainer);
        $.each(errors, function (inputKey, errorMessages) {
            if (errorMessages && errorMessages.length > 0) {
                form.find("[name=" + inputKey + "]").siblings(errorContainer)
                    .html("<p class='text-danger'>" + errorMessages[0] + "</p>");
            }
        });
    }

     function clearValidationMessages(form, errorContainer) {
        form.find(errorContainer).html('');
    }

     function validateOnClient(values, rules) {
         if (values instanceof Object) {
             if (rules instanceof Object) {
                 errors = {};
                 valid = true;
                 for (var formKey in rules) {
                     console.log((rules[formKey]));
                     splitRules = explode("|", rules[formKey]);
                     errors[formKey] = [];
                     for (var splitRule in splitRules) {

                         splitRuleWithOptions = explode(":", splitRules[splitRule]);
                         switch (splitRuleWithOptions[0]) {
                             case 'required':
                                 if (!values[formKey] ||
                                     values[formKey].length == 0
                                 ) {
                                     errors[formKey].push(formKey + " is required");
                                 }
                                 break;
                             case 'positive':
                                 values[formKey] = Number(values[formKey]);

                                 if (!Number.isInteger(values[formKey]) || values[formKey] < 0) {
                                     errors[formKey].push(formKey + " must be a number biger than 0");
                                 }
                                 break;
                         }
                     }
                 }
                     for (var key in errors) {
                         console.log("key: " + key + "  errors[key]: " + errors[key]);
                         if (errors[key].length > 0) {
                             valid = false;
                         }
                     }
                     return [valid, errors];

             } else {
                 alert("Отсутствуют правила валидации");
             }
         } else {
             alert("Отсутствуют данные формы");
         }
     }




    function explode( delimiter, string ) {	// Split a string by string
        //
        // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
        // +   improved by: kenneth
        // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)

        var emptyArray = { 0: '' };

        if ( arguments.length != 2
            || typeof arguments[0] == 'undefined'
            || typeof arguments[1] == 'undefined' )
        {
            return null;
        }

        if ( delimiter === ''
            || delimiter === false
            || delimiter === null )
        {
            return false;
        }

        if ( typeof delimiter == 'function'
            || typeof delimiter == 'object'
            || typeof string == 'function'
            || typeof string == 'object' )
        {
            return emptyArray;
        }

        if ( delimiter === true ) {
            delimiter = '1';
        }

        return string.toString().split ( delimiter.toString() );
    }
