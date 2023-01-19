import { Injectable } from '@angular/core';
import * as $ from 'jquery';
import { SweetAlert2Module } from '@sweetalert2/ngx-sweetalert2';
import Swal from 'sweetalert2';
import { FunctionsService } from '../services/functions.service';

@Injectable({
  providedIn: 'root'
})
export class UsuariosService {

  constructor( 
    private _FunctionsService:FunctionsService
  ){ }

  public getUsers() {
    const data = this._FunctionsService.ajaxRequest( this._FunctionsService.API_URL+"/listar" );
    console.log(data);
  }

}
