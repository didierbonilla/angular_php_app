<?php

class product{
    
    public int $prod_id;
    public ?string $prod_nombre;
    public float $prod_precioCompra;
    public float $prod_precioVenta;
    public int $prod_stock;
    public int $usua_id;
    public int $cate_id;
    public ?string $prod_fechaCreacion;
    public int $prod_usuarioModifica;
    public ?string $prod_fechaModifica;
    public int $prod_estado;

    function __construct($state){
        $this->prod_id = !isset($state["prod_id"]) ? 0 : $state["prod_id"];
        $this->prod_nombre = !isset($state["prod_nombre"]) ? null : $state["prod_nombre"];
        $this->prod_precioCompra = !isset($state["prod_precioCompra"]) ? 0 : $state["prod_precioCompra"];
        $this->prod_precioVenta = !isset($state["prod_precioVenta"]) ? 0 : $state["prod_precioVenta"];
        $this->prod_stock = !isset($state["prod_stock"]) ? 0 : $state["prod_stock"];
        $this->usua_id = !isset($state["usua_id"]) ? 0 : $state["usua_id"];
        $this->cate_id = !isset($state["cate_id"]) ? 0 : $state["cate_id"];
        $this->prod_fechaCreacion = !isset($state["prod_fechaCreacion"]) ? null : $state["prod_fechaCreacion"];
        $this->prod_usuarioModifica = !isset($state["prod_usuarioModifica"]) ? 0 : $state["prod_usuarioModifica"];
        $this->prod_fechaModifica = !isset($state["prod_fechaModifica"]) ? null : $state["prod_fechaModifica"];
        $this->prod_estado = !isset($state["prod_estado"]) ? 0 : $state["prod_estado"];
    }
}
