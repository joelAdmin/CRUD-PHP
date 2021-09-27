<?php
class IndexController extends ControllerBase
{
    //Accion index
    Public function validarSession()
    {
        require_once 'libs/Session.class.php';
        $Session = new Session('libs/Session.class.php');

        if(!$Session->validaSession())
        { 
            $this->view->show("Vadmin.php"); 
            exit; 
        }
    }

    public function index()
    {
		$this->validarSession();
        //$vars['informacion'] = $this->getLugar();
       // $this->view->show("Vadmin.php");
        $this->view->show("VpanelAdmin.php");
       //$this->view->show("Vprincipal.php");
    }
    
    public function panelAdmin()
    {
		//$vars['informacion'] = $this->getLugar();
        $this->view->show("VpanelAdmin.php");
    }
    
    public function testView()
    {
        $vars['nombre'] = "Joel Lama";
        $vars['lugar'] = $this->getLugar();
        $this->view->show("test.php", $vars);
    }
    
    private function getLugar()
    {
        return "San Juan de los Morros, Venezuela";
    }
    
    public function nuevoContacto()
    {
		//$vars['informacion'] = $this->getLugar();
        $this->view->show("Vcontacto.php");
    }
    
    public function accesoModulo()
    {
        $this->view->show("Vpermiso.php");
    }
    
    
}
?>
