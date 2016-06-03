<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tarea_agenda
 *
 * @author Administrador
 */
class opciones extends fs_model
{
   public $id;
   public $fecha;
   public $cliente;
   public $empresa;
   public $oportunidad;
   public $venta;
   public $valor;
   public $completado;
   public $exists;


public function __construct($t = FALSE)
    {
        parent::__construct('oportunidades', '/plugins/oportunidades/');

        if ($t)
        {
            $this->id =$t['id'];
            $this->fecha =Date('d-m-Y H:i',  strtotime($t['fecha']));
            $this->cliente = $t['cliente'];
            $this->empresa = $t['empresa'];
            $this->oportunidad = $t['oportunidad'];
            $this->venta = $t['venta'];
            $this->valor = $t['valor'];
            $this->completado = $this->str2bool($t['completado']);
        }
        else
        {
            $this->id = NULL;
            $this->fecha= Date('d-m-Y H:i');
            $this->cliente = NULL;
            $this->empresa = NULL;
            $this->oportunidad = NULL;
            $this->venta = NULL;
            $this->valor = NULL;
            $this->completado = NULL;
        }
    }

    protected function install() {
        return '';
    }
     public function get($id) {

         $data = $this->db->select("SELECT * FROM oportunidades WHERE id= ".$this->var2str($id).";");

         if ($data)

         {
             return new opciones($data[0]);
         }
         else
         {
             return FALSE;
         }

     }

  public function exists() {
       if (is_null($this->id)) {
           return FALSE;
       } else
           return $this->db->select("SELECT * FROM oportunidades WHERE id = ".$this->var2str($this->id).';');
   }



     public function save() {

         if ($this->exists()){

             $this->fecha =Date ('Y-m-d H:i', strtotime($this->fecha));

         $sql ="UPDATE oportunidades SET fecha = ".$this->var2str($this->fecha).
               ", cliente = ".$this->var2str($this->cliente).
               ", empresa = ".$this->var2str($this->empresa).
               ", oportunidad = ".$this->var2str($this->oportunidad).
               ", venta = ".$this->var2str($this->venta).
               ", valor = ".$this->var2str($this->valor).
               ", completado = ".$this->var2str($this->completado).
               " WHERE id = ".$this->var2str($this->id).";";

       return $this->db->exec($sql);

         }
         else
         {

    $sql ="INSERT INTO oportunidades (fecha,cliente,empresa,oportunidad,venta,valor) VALUES
                     (".$this->var2str($this->fecha).
                     ",".$this->var2str($this->cliente).
                      ",".$this->var2str($this->empresa).
                     ",".$this->var2str($this->oportunidad).
                      ",".$this->var2str($this->venta).
                     ",".$this->var2str($this->valor).");";

    if ($this->db->exec($sql))

    {
        /// $this->id = $this->db->lastval();
         return TRUE;
    }
 else
    {
        return FALSE;
    }

         }
      }

     public function delete() {
         return $this->db->exec("DELETE FROM oportunidades WHERE id = "
                 .$this->var2str($this->id).";");
     }

     public function all() {

         $lista = array();

         $data= $this->db->select("SELECT * FROM oportunidades ORDER BY fecha DESC;");

         if ($data)
         {
             foreach ($data as $d)

                 $lista[] = new opciones ($d);

         return $lista;
         }
     }

    
      public function separa_fecha()
    {
        $data = explode(' ', $this->fecha);
        return $data=Date('d-m-Y', strtotime($data[0]));
    }

     public function separa_hora()
    {
        $data = explode(' ',$this->fecha);
        return $data[1];
    }

}
