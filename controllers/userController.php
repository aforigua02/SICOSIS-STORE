<?php
require_once 'app/model/CustomerModel';

class CustomerController {
    private $model;

    /*public function __construct(){
        $this->model = new CustomerModel();
    }*/

    // Listar todos los clientes
    public function index(){
        $customers = $this->model->readAll();
        require_once 'app/views/customer/index.php';
    }

    // Mostrar formulario de creación
    public function createForm(){
        require_once 'app/views/customer/create.php';
    }

    // Crear un cliente
    public function create(){
        if(isset($_POST['name']) && isset($_POST['email'])){
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email']
            ];
            $this->model->create($data);
        }
        header("Location: /public/index.php?controller=customer&action=index");
    }

    // Eliminar cliente
    public function delete($id){
        $this->model->delete($id);
        header("Location: /public/index.php?controller=customer&action=index");
    }

    // Mostrar formulario de edición
    public function editForm($id){
        // Código para mostrar el formulario de edición
    }

    // Actualizar cliente
    public function update($id){
        if(isset($_POST['name']) && isset($_POST['email'])){
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email']
            ];
            $this->model->update($id, $data);
        }
        header("Location: /sicosis_store/public/pruebaCrud.php?userController&action=pruebaCrud");
    }
}
?>
