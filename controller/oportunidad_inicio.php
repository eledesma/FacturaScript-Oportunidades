<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_model('cuenta.php');
require_model('direccion_cliente.php');
require_model('subcuenta.php');
require_model('subcuenta_cliente.php');
require_model('opciones.php');
/**
 * Description of oportunidad_inicio
 *
 * @author Administrador
 */
class oportunidad_inicio extends fs_controller
{
    public $listado;
    public $editar;
    public $opciones;
    public $base;



    public function __construct() {
        parent::__construct(__CLASS__, 'Oportunidades', 'Negocios');
    }

    protected function private_core() {

        $this->base = $this->db->select("SELECT * FROM clientes;");
        $this->opciones = new opciones();
        $completado = FALSE;
        $this->editar= FALSE;
        $this->listado= $this->opciones->all();




        if (isset($_POST['modificar'])) /// Editar Oportunidad
        {
         $this->opciones->id = $_POST['modificar'];
         $this->editar = $this->opciones->get($_POST['modificar']);
         if ($this->editar)
         {
          $this->opciones->fecha= $_POST['fecha'].' '.$_POST['hora'];
          $this->opciones->completado = isset($_POST['completado']);
          $this->opciones->cliente= $_POST['cliente'];
          $this->opciones->empresa= $_POST['empresa'];
          $this->opciones->oportunidad= $_POST['oportunidad'];
          $this->opciones->venta= $_POST['venta'];
          $this->opciones->valor= $_POST['valor'];

            if ($this->opciones->save())
                {
                    $this->new_message('Datos Modificados Correctamante');

                }
                else
                {
                    $this->new_error_msg('Error al Modificar');
                }
         }
        }
        else if (isset($_POST['fecha'])) ///Nueva Oportunidad
            {
            $this->opciones->fecha = $_POST['fecha'].' '.$_POST['hora'];
            $this->opciones->cliente= $_POST['cliente'];
            $this->opciones->empresa= $_POST['empresa'];
            $this->opciones->oportunidad= $_POST['oportunidad'];
            $this->opciones->venta= $_POST['venta'];
            $this->opciones->valor= $_POST['valor'];

            if($this->opciones->save())

                {
                    $this->new_message('Datos Guardados Correctamante');

                }
                else
                {
                    $this->new_error_msg('Error al Guardar');
                }
            }
        else if (isset ($_GET['id'])) ///Mostrar Oportunidad
            {
             $this->editar = $this->opciones->get($_GET['id']);
            }
            else if (isset ($_GET['delete'])) ///Eliminar Oportunidad
            {
             $aux = $this->opciones->get($_GET['delete']);
             if ($aux)
             {
             if ($aux->delete())
                {
                $this->new_message('Datos Eliminados Correctamante');
                }
                else
                {
                $this->new_error_msg('Error al Eliminar');
                }
             }
            else
            {
            $this->new_error_msg('Tarea NO Encontrada');
            }


            }
    }


}
