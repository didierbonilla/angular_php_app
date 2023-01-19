import { Injectable } from '@angular/core';
import * as $ from 'jquery';

@Injectable({
  providedIn: 'root'
})
export class FunctionsService {

  API_URL:string = "localhost/angular_php_app/PHP_API/LGDS-API-PHP";
  constructor() { }

  /*GetCookie(value) {
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
  }*/

  public ajaxRequest(url: string, data: any = {}, method: string = "GET", SendToken: boolean = true) {

    var HTTPError = {
      message: '',
      code: 0,
      success: false,
      data: {}
    };

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
        HTTPError = response;
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
        console.log(HTTPError);
      }
    });

    return HTTPError;
  }

  public ajaxRequestFormData(url: string, data: FormData = new FormData(), method: string = "GET", SendToken: boolean = true) {

    var dataResponse = null;
    var Token = null;
    var HTTPError = {
      message: "",
      code: 0,
      success: false,
      data: {}
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
      }
    });

    return dataResponse;
  }

  public findGetValue(Get_KeyName = "") {
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
}
