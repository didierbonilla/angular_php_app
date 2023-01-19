﻿
// ----------------------------------- GENERAL VARIABLES ------------------------------------
const urlAPI = "https://apitotaltravel.azurewebsites.net/";

// ----------------------------------- INIZIALIZE ------------------------------------
/*
$("#loaderAnimation").hide();
$("#menu_rol_items").empty();
$("#menu_rol_groups").empty();

fillMenu(Client_Role_Id);
fillProfileImage(Client_User_ID);
*/
// ----------------------------------- FUNCTIONS ------------------------------------
/*
function fillProfileImage(User_ID) {
    const user_data = ajaxRequest(urlAPI +"/API/Users/Find?id=" + User_ID);
    $("#user_image").prop("src", user_data.data.image_URL);
}

function highlightTile() {
    var urlPart = $(location).attr('href').split("/")[3];

    if ($(`a[href='/${urlPart}/Index']`).length) {
        var tileItem = $(`a[href='/${urlPart}/Index']`);
        var tileLinkID = tileItem.parent().parent().attr("id")

        $(`#${tileLinkID.replace("_container", "")}`).click()

        tileItem.addClass("activeTile");
    } else {
        var urlPart2 = $(location).attr('href').split("/")[4];
        var tileItem = $(`a[href='/${urlPart}/${urlPart2}']`);
        var tileLinkID = tileItem.parent().parent().attr("id")

        $(`#${tileLinkID.replace("_container", "")}`).click()

        tileItem.addClass("activeTile");
    }

}


function fillMenu(rol_id){

    const RestrictionsList = ajaxRequest(urlAPI + "/API/RolePermissions/List");
    getDashboard(rol_id, RestrictionsList);

    if (RestrictionsList.code == 200) {

        const Restrictions = RestrictionsList.data.filter(x => x.iD_Rol == rol_id);

        for (var i = 0; i < Restrictions.length; i++) {

            const element = Restrictions[i];

             //si el elemento es visible
            if (element.esVisible == true) {

                //si el elemento no pertenece a un grupo
                if (element.id_grupo == null) {
                    const menu_item =
                        `<li class="sidebar-item" id="menu_item_${element.id}">
                            <a class="sidebar-link" href="/${element.controlador}/${element.accion}">
                                ${element.permiso}
                            </a>
                        </li>`;

                    $("#menu_rol_items").append(menu_item);
                }
                else {

                     //si el grupo existe lo añade 
                    if ($(`#menu_group_${element.id_grupo}`).length > 0) {
                        $(`#menu_group_${element.id_grupo}_container`).append(
                            `<li>
                                <a id="menu_item_${element.id}" class="sidebar-link" href="/${element.controlador}/${element.accion}">${element.permiso}</a>
                            </li>`
                        );
                    }
                    // si no lo crea
                    else {
                        $("#menu_rol_groups").append(
                            `<li class="sidebar-item">
                                <a class="sidebar-link" id="menu_group_${element.id_grupo}" href="#menu_group_${element.id_grupo}_container" data-bs-toggle="collapse" data-toggle="collapse">
                                    ${element.grupo}
                                </a>
                                <ul class="collapse list-unstyled" id="menu_group_${element.id_grupo}_container"></ul>
                             </li>`
                        );

                        $(`#menu_group_${element.id_grupo}_container`).append(
                            `<li>
                                <a id="menu_item_${element.id}" class="sidebar-link" href="/${element.controlador}/${element.accion}">${element.permiso}</a>
                            </li>`
                        );
                    }
                }


            }
        }
    }
}

function getDashboard(rol_id, RestrictionsList) {

    const dashboard = RestrictionsList.data.filter(x => x.iD_Rol == rol_id && x.esDashboard == true);

    if (dashboard.length > 0) {
        const item = dashboard[0];

        const menu_item =
            `<li class="sidebar-item">
                <a id="menu_item_dashboard" class="sidebar-link" href="/${item.controlador}/${item.accion}">${item.permiso}</a>
            </li>`;

        $("#menu_rol_items").append(menu_item);
    }
}
*/

// ----------------------------------- FILE FORMAT ------------------------------------
    async function createBlob(url) {
        var response = await fetch(url);
        response.headers = { type: 'image/jpeg' };
        var data = await response.blob();
        return data;
    }

    function convertImage(file) {
        return new Promise((resolve) => {
            const read = new FileReader();

            read.onload = () => resolve({
                src: read.result,
                fileName: file.name
            });

            read.readAsDataURL(file);
        });
    }

// ----------------------------------- FORM VALIDATE ------------------------------------
    // si calback retorna true, crea span en containerDiv
/*
    function ManualValidateForm(callback = () => { return true; }, containerDiv, validateMessage = "Rellene este campo") {
        //crea span item
        var labelvalidator = document.createElement("span");
        labelvalidator.className = "labelvalidator";
        labelvalidator.innerText = validateMessage;

        if (callback) {
            if ($(containerDiv).find("span.labelvalidator").length == 0) {
                $(containerDiv).append(labelvalidator);
            }
            $(containerDiv).addClass("error");

            return true;
        } else {
            $(containerDiv).find("span.labelvalidator").remove();
            $(containerDiv).removeClass("error");

            //añade item de status sobre el input actual
            return false;
        }

    }

    function ValidateForm(inputArray = [], reset = false) {
        var Validate = [];

        if (reset) {
            const parent = $(item.Jqueryinput).parents(".field")[0];
            $.each(inputArray, function (i, item) {

                $(parent).find("span.labelvalidator").remove();
                $(parent).removeClass("error");
                $(item.Jqueryinput).val("");

            });

            return true;
        } else {
            //recorre cada input en array
            $.each(inputArray, function (i, item) {

                var parent = $(item.Jqueryinput).parents(".field")[0];
                var empty = false;
                //crea span item
                var labelvalidator = document.createElement("span");
                labelvalidator.className = "labelvalidator";
                labelvalidator.innerText = item.validateMessage;

                //valida tipo de inpur y si esta vacio 
                if (item.check == true) { //check box o radio button
                    parent = $(item.Jqueryinput).parents(".checkButton_container")[0];

                    if ($(item.Jqueryinput).find(":checked").length == 0) {
                        empty = true;
                    }
                }
                else if (item.file == true) { //input file
                    if ($(item.Jqueryinput).prop("files")[0] == undefined || $(item.Jqueryinput).prop("files")[0] == null) {
                        empty = true;
                    }
                }
                else { //inputs(text,number...), selects
                    if ($(item.Jqueryinput).val() == 0 || $(item.Jqueryinput).val() == null) {
                        empty = true;
                    }
                }

                //ajecuta funcionalidad de label
                if (empty) {
                    if ($(parent).find("span.labelvalidator").length == 0) {
                        $(parent).append(labelvalidator);
                    }

                    $(parent).addClass("error");

                    //añade item de status sobre el input actual
                    Validate.push(
                        { item: item.Jqueryinput, status: false }
                    );

                } else {
                    //si valor de input esta llena remueve spam de error
                    $(parent).find("span.labelvalidator").remove();
                    $(parent).removeClass("error");

                    //añade item de status sobre el input actual
                    Validate.push(
                        { item: item.Jqueryinput, status: true }
                    );
                }

            });

            //filtra status items en false
            var statusFilter = jQuery.grep(Validate, function (item, i) {
                return item.status == false;
            });

            if (statusFilter.length == 0) {
                return true;
            }

            return false;
        }

    }
*/

// ----------------------------------- ALERTS ------------------------------------
    //se utiliza para alertas de campos vacios
    function iziToastAlert(title = "An error ocurred", message = "", type = "error") {
        const colors = {
            success: 'green',
            error: 'red',
            warning: 'yellow',
            info: 'blue'
        };

        iziToast.show({
            color: colors[type],
            icon: `ico-${type}`,
            title: title,
            message: message,
        });
    }

    // se utiliza para alertas de completado o error
    function sweetAlert(title = "An error ocurred", message = "", type = "error") {
        Swal.fire(
            title,
            message,
            type
        )
    }

    /*
        se utiliza para dar alertas de confirmacion de usuario, ejemplo al eliminar un registro,
        el parametro successfunction: es la funcion que se ejecutara al dar confirm en la alerta,
        ejemplo de formar parametro:
            const successfunction = () => { 
                 ** contenido de la funcion **
            };
    */
    function sweetAlertconfirm(title = "An error ocurred", message = "", type = "error", successfunction = () => { alert("prueba"); }) {

        Swal.fire({
            title: title,
            text: message,
            icon: type,
            showCancelButton: true,
            confirmButtonColor: '#A97BC4',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                successfunction();
            }
        })
    }

//----------------------------- PETICIONES AJAX ----------------------------------------

    function GetCookie(value) {
        var key = null;
        $.ajax({
            url: urlAPI +"/read-claims?key=" + value,
            data: {},
            method: "GET",
            dataType: "json",
            headers: {
                'Content-Type': 'application/json'
            },
            async: false,
            success: function (response) {
                key = response.data;
            }
        });

        return key;
    }

    function ajaxRequest(url, data = {}, method = "GET", SendToken = true) {

        var dataResponse = null;
        var Token = null;
        var HTTPError = {
            message: '',
            code: 0,
            success: false,
            data: null
        }

        $.ajax({
            url: url,
            data: JSON.stringify(data),
            method: method,
            dataType: "json",
            headers: {
                'Content-Type': 'application/json',
            },
            async: false,
            success: function (response) {
                dataResponse = response;
            },
            error: function (jqXHR, exception) {
                HTTPError.code = jqXHR.status;
                HTTPError.data = jqXHR;
                HTTPError.message += "Request http Error: " + url + ", Exception: ";

                // http errors 
                if (jqXHR.status === 0) {
                    HTTPError.message += 'Not connect.\n Verify Network.';
                } else if (jqXHR.status == 404) {
                    HTTPError.message += 'Requested page not found. [404]';
                } else if (jqXHR.status == 500) {
                    HTTPError.message += 'Internal Server Error [500].';
                } else if (jqXHR.status == 401) {
                    HTTPError.message += 'Unauthorized Server Action [401].';
                }

                // exception errors
                else if (exception === 'parsererror') {
                    HTTPError.message += 'Requested JSON parse failed.';
                } else if (exception === 'timeout') {
                    HTTPError.message += 'Time out error.';
                } else if (exception === 'abort') {
                    HTTPError.message += 'Ajax request aborted.';
                } else {
                    HTTPError.message += jqXHR.responseText;
                }
                dataResponse = HTTPError;
                console.log(HTTPError);
            }
        });

        return dataResponse;
    }

    function ajaxRequestFormData(url, data = new FormData(), method = "GET", SendToken = true) {

        var dataResponse = null;
        var Token = null;
        var HTTPError = {
            message: "",
            code: 0,
            success: false,
            data: null
        }

        $.ajax({
            url: url,
            data: data,
            mimeType: "multipart/form-data",
            headers: {
                'Authorization': `Bearer ${Token}`
            },
            async: false,
            processData: false,
            contentType: false,
            type: method,
            success: function (httpResponse) {
                dataResponse = httpResponse;
            },
            error: function (jqXHR, exception) {
                /*jqXHR = JSON.parse(jqXHR);*/

                HTTPError.code = jqXHR.status;
                HTTPError.data = jqXHR;
                HTTPError.message += "Request http Error: " + url + ", Exception: ";

                // http errors 
                if (jqXHR.status === 0) {
                    HTTPError.message += 'Not connect.\n Verify Network.';
                } else if (jqXHR.status == 404) {
                    HTTPError.message += 'Requested page not found. [404]';
                } else if (jqXHR.status == 500) {
                    HTTPError.message += 'Internal Server Error [500].';
                } else if (jqXHR.status == 401) {
                    HTTPError.message += 'Unauthorized Server Action [401].';
                }

                // exception errors
                else if (exception === 'parsererror') {
                    HTTPError.message += 'Requested JSON parse failed.';
                } else if (exception === 'timeout') {
                    HTTPError.message += 'Time out error.';
                } else if (exception === 'abort') {
                    HTTPError.message += 'Ajax request aborted.';
                } else {
                    HTTPError.message += jqXHR.responseText;
                }
                dataResponse = HTTPError;
                console.log(HTTPError);
            }
        });

        return dataResponse;
    }

    function FindGetValue(Get_KeyName="") {
        var Get_KeyValue = null;

        // get url search content after "?" 
        //example: www.url?get_var=5
        //return : get_var=5
        var url_query = location.search.substring(1);

        //split vars and get in array
        var gets_vars = url_query.split("&");

        for (var i = 0; i < gets_vars.length; i++) {
            //divide la key from the value in item
            var var_key = gets_vars[i].split("=");

            // if key is equal to query key return value key
            if (var_key[0] == Get_KeyName) {
                //get value key
                Get_KeyValue = var_key[1];
                break;
            }
        }

        //return value key
        return Get_KeyValue;
    }

//----------------------------- SEMANTIC FUNCTIONS HELPERS ----------------------------------------
/*
    function AddDropDownItem(DropDown, item = { value: 0, text: "" }) {

        $(DropDown).parent().find(".menu").append(
            `<div class="item" data-value="${item.value}" data-text="${item.text}">${item.text}</div>`
        );
        $(DropDown).append(
            `<option value="${item.value}">${item.text}</option>`
        );
    }

    function ClearDropDownItem(DropDown) {
        $(DropDown).parent().find(".menu").empty();
        $(DropDown).empty();
    }

    function SetDropDownValue(DropDown, defaultValue = "") {

        $(DropDown).find(`option[value = "${defaultValue}"]`).prop("selected", true);

        const parent = $(DropDown).parent();

        //remueve item selected actual
        parent.find(`.menu div.item`).removeClass("active selected");

        //encuentra default
        const item = parent.find(`.menu div.item[data-value="${defaultValue}"]`);
        $(item[0]).addClass(["active", "selected"]);

        //setea texto
        $(parent).find(".text").removeClass("default");
        $(parent).find(".text").html(
            $(item[0]).attr("data-text")
        );

    }

    function SetDropDownPlaceholder(DropDown) {
        $(DropDown).dropdown('restore defaults');

    }

    function getCalendarDate(stringDate) {
        var date = new Date(stringDate);
        var year = date.getFullYear();
        var month = date.getMonth() + 1;
        var day = date.getDate();
        if (month < 10) {
            month = '0' + month;
        }
        if (day < 10) {
            day = '0' + day;
        }

        return `${year}-${month}-${day}T${date.getHours()}:${date.getMinutes()}`;
    }

    function FillDropDown(
        dropdownData = {
            dropdown: $(),
            items: {
                list: [],
                valueData: "",
                textData: ""
            },
            placeholder: {
                empty: "No se encontraron opciones",
                default: "Seleccione una opcion",
            },
            semantic: true
        }
    ){

        // get dropdpwn atributes
        const dropDown = $(dropdownData.dropdown);
        const dropdownClass = dropDown.attr('class');
        const id = dropDown.attr('id');
        const name = dropDown.attr('name');

        //create and set dropdown atributes
        var newDropdown = document.createElement("select");
        $(newDropdown).attr('class', dropdownClass);
        $(newDropdown).attr('id', id);
        $(newDropdown).attr('name', name);


        if (dropdownData.items.list.length > 0) {

            var placeholder = document.createElement("option");
            placeholder.value = "";
            placeholder.innerText = dropdownData.placeholder.default;
            //set placeholder
            newDropdown.append(placeholder);

            for (let i = 0; i < dropdownData.items.list.length; i++) {
                const item = dropdownData.items.list[i];
                const value = item[dropdownData.items.valueData];
                const text = item[dropdownData.items.textData];

                //create option
                var option = document.createElement("option");
                option.value = value;
                option.innerText = text;

                newDropdown.append(option);
            }

        }
        else {
            var placeholder = document.createElement("option");
            placeholder.value = "";
            placeholder.innerText = dropdownData.placeholder.empty;
            //set placeholder
            newDropdown.append(placeholder);
        }

        if (dropdownData.semantic) {
            $(newDropdown).addClass(["ui", "dropdown", "search"]);
        }
        if (dropdownData.items.list.length > 10) {
            $(newDropdown).addClass("search");
        }

        const actualDropDown = $($(dropDown).parents(".field")[0]).find("div.ui.dropdown");
        $(actualDropDown).replaceWith(newDropdown);
    
    }
*/
//----------------------------- DATE FORMAT ----------------------------------------
    function GetDateFormat(dateConfig = { string_date: "", hour_format: 12, date_format: "short"}) {
        const months = [
            "enero", "febrero", "marzo", "abril",
            "mayo", "junio", "julio", "agosto",
            "septiembre","octubre","noviembre","diciembre"
        ]
        var datetime = {
            year: "",
            month: "",
            day: "",
            hour: "",
            minute: "",
            format: 12
        }

        const datetimeArray = dateConfig.string_date.split("T");
        const dateArray = datetimeArray[0].split("-");
        const timeArray = datetimeArray[1].split(":");

        // get date
        datetime.year = dateArray[0];
        datetime.month = dateArray[1];
        datetime.day = dateArray[2];

        // get time
        datetime.hour = timeArray[0];
        datetime.minute = timeArray[1];

        // create time format
        dateConfig.time = `${datetime.hour}:${datetime.minute}`;
        if (dateConfig.hour_format == 12) {

            datetime.hour = parseInt(datetime.hour);
            dateConfig.time =
                datetime.hour > 12
                    ? `${datetime.hour - 12}:${datetime.minute} PM`
                    : `${datetime.hour}:${datetime.minute} AM`;
        }

        // create date format
        dateConfig.date = datetimeArray[0];
        if (dateConfig.date_format.toLowerCase() == "large") {
            datetime.month_name = months[datetime.month-1];
            dateConfig.date = `${datetime.day} de ${months[datetime.month-1]}, ${datetime.year}`;
        }
        else if (dateConfig.date_format.toLowerCase() == "short") {

            const month_name = months[datetime.month-1].substring(0, 3);
            datetime.month_name = month_name;
            dateConfig.date = `${datetime.day} de ${month_name}, ${datetime.year}`;
        }

        //construct response datetime
        dateConfig.datetime = `${dateConfig.date} a las ${dateConfig.time}`
        dateConfig.datetime_data = datetime;

        return dateConfig;
}

    function getDaysBetweenTwoDates(date_1, date_2) {

        var fechaInicio = new Date(date_1.split("T")[0]).getTime();
        var fechaFin = new Date(date_2.split("T")[0]).getTime();

        var diff = fechaFin - fechaInicio;

        return diff / (1000 * 60 * 60 * 24);
    }
