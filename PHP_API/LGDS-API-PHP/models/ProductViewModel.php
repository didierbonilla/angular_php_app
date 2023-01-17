<?php

class product{
    
    public int $prod_id;
    public ?string $prod_nombre;
    public float $prod_precioCompra;
    public float $prod_precioVenta;
    public int $prod_stock;
    public int $usua_id;
    public int $cate_id;
    public ?string $cate_descripcion;
    public ?string $prod_fechaCreacion;
    public int $prod_usuarioModifica;
    public ?string $prod_fechaModifica;
    public int $prod_estado;

    function __construct($product){
        $this->prod_id = !isset($product["prod_id"]) ? 0 : $product["prod_id"];
        $this->prod_nombre = !isset($product["prod_nombre"]) ? null : $product["prod_nombre"];
        $this->prod_precioCompra = !isset($product["prod_precioCompra"]) ? 0 : $product["prod_precioCompra"];
        $this->prod_precioVenta = !isset($product["prod_precioVenta"]) ? 0 : $product["prod_precioVenta"];
        $this->prod_stock = !isset($product["prod_stock"]) ? 0 : $product["prod_stock"];
        $this->usua_id = !isset($product["usua_id"]) ? 0 : $product["usua_id"];
        $this->cate_id = !isset($product["cate_id"]) ? 0 : $product["cate_id"];
        $this->cate_descripcion = !isset($product["cate_descripcion"]) ? null : $product["cate_descripcion"];
        $this->prod_fechaCreacion = !isset($product["prod_fechaCreacion"]) ? null : $product["prod_fechaCreacion"];
        $this->prod_usuarioModifica = !isset($product["prod_usuarioModifica"]) ? 0 : $product["prod_usuarioModifica"];
        $this->prod_fechaModifica = !isset($product["prod_fechaModifica"]) ? null : $product["prod_fechaModifica"];
        $this->prod_estado = !isset($product["prod_estado"]) ? 0 : $product["prod_estado"];
    }
}
