<?php

class PaisesParser {
    private $paises = [];
    
    public function __construct($xmlFile) {
        $xml = simplexml_load_file($xmlFile);
        foreach($xml->Item as $item) {
            $this->paises[] = [
                'id' => (string)$item->Id,
                'nombre' => (string)$item->Nombre
            ];
        }
    }
    
    public function getPaises() {
        return $this->paises;
    }
    
    public function getPaisById($id) {
        foreach($this->paises as $pais) {
            if($pais['id'] == $id) {
                return $pais;
            }
        }
        return null;
    }
    
    // Genera un select HTML con los países
    public function generarSelect($name = 'pais', $selectedId = null) {
        $html = "<select name='$name' id='$name' class='form-control'>";
        $html .= "<option value=''>Seleccione un país</option>";
        
        foreach($this->paises as $pais) {
            $selected = ($selectedId == $pais['id']) ? 'selected' : '';
            $html .= "<option value='{$pais['id']}' $selected>{$pais['nombre']}</option>";
        }
        
        $html .= "</select>";
        return $html;
    }
}//http://localhost/ProyectoFinalDS7/FrontEnd/views/admin/AdminCrud.php