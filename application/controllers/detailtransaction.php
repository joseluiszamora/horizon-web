<?php
  class Detailtransaction extends  CI_Controller {
    public function __construct() {
      parent::__construct();
      $this->load->model('Product_Model');
      $this->load->model('Detailtransaction_Model');
      $this->load->model('Linevolume_Model');
      $this->load->model('Diary_Model');
    }

    function index() {
    }
     function create($idtransac) {
      //$products = $this->Product_Model->get_all();
      $products = array($dropdown[""] = 'Seleccione Producto');
      $transdetail = $this->Detailtransaction_Model->get($idtransac);
      $data['linea'] = $this->Linevolume_Model->get_lines();
      $data['volumen'] = $this->Linevolume_Model->get_linesvolumes();
      $data['category'] = 'detailtransaction';
      $data['action'] = 'new';
      $data['page'] = 'form';
      $data['transdetail'] = $transdetail;
      $data['idtransaction'] = $idtransac;
      $data['products'] = $products;
      $this->load->view('template/template', $data);
    }

    public function edit($id = "") {
     /* if ($this->Account_Model->logged_in() === TRUE) {
        if ($id != "") {
          $data['iddistrict'] = $id;
          $detailtrans = $this->Detailtransaction_Model->get($id);
          if (empty($district)) {
              show_404();
          }
          $data['detailtrans'] = $detailtrans[0];
          $products = $this->Product_Model->get_all();
          $transdetail = $this->Detailtransaction_Model->get($id);
          $data['category'] = 'detailtransaction';
          $data['action'] = 'edit';
          $data['page'] = 'form';
          $data['transdetail'] = $transdetail;
          $data['idtransaction'] = $id;
          $data['products'] = $products;
          $this->load->view('template/template', $data);
        }
        else
          redirect('district');
      } else {
        redirect('account/login');
      }*/
    }

    function save() {
      if ($this->Account_Model->logged_in() === TRUE) {
        $this->form_validation->set_rules('line', 'line', 'xss_clean|required|greater_than[0]');
        $this->form_validation->set_rules('volume', 'volume', 'xss_clean|required|greater_than[0]');
        $this->form_validation->set_rules('product', 'product', 'xss_clean|required|greater_than[0]');
        $this->form_validation->set_rules('cantidad', 'cantidad', 'xss_clean|required|numeric');
        //line   volume  product  cantidad
        //$this->form_validation->set_rules('obs', 'O', 'xss_clean|required');

        $this->form_validation->set_message('greater_than', '%s es obligatorio.');
        $this->form_validation->set_message('required', '%s es obligatorio.');
        $this->form_validation->set_message('numeric', 'Introduzca un numero valido.');
        $this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');

        if ($this->form_validation->run() == FALSE) {
          $products = $this->Product_Model->get_all();
          $transdetail = $this->Detailtransaction_Model->get($this->input->post('idtransaction'));
          $data['linea'] = $this->Linevolume_Model->get_lines();
          $data['volumen'] = $this->Linevolume_Model->get_volumes();
          $data['category'] = 'detailtransaction';
          $data['action'] = 'new';
          $data['page'] = 'form';
          $data['transdetail'] = $transdetail;
          $data['idtransaction'] = $this->input->post('idtransaction');
          $data['products'] = $products;
          $this->load->view('template/template', $data);
        } else {

          $data_in['idTransaction'] = $this->input->post('idtransaction');
          $data_in['idProduct'] = $this->input->post('product');
          $data_in['Cantidad'] = $this->input->post('cantidad');
          $data_in['Observacion'] = $this->input->post('obs');

          $trans = $this->Transaction_Model->get($this->input->post('idtransaction'));

          //echo $trans[0]->Estado;
          if($trans[0]->Estado == '6')
            $data_in['Estado'] = '3';
          if($trans[0]->Estado == '1')
            $data_in['Estado'] = '1';


          if ($this->input->post('obs') == ""){
            $data_in['Observacion'] = "Web";
          }else{
            $data_in['Observacion'] = $this->input->post('obs');
          }


          /** SAVE DAILY **/
          if ($this->Diary_Model->check_if_exist_by_transaction($data_in['idTransaction'])) {
            // update diary ammount
            $diary = $this->Diary_Model->get_by_transaction($data_in['idTransaction']);
            $newAmmount = ($diary[0]->Monto + ($this->Product_Model->get_price($data_in['idProduct']) * $data_in['Cantidad']));
            //print_r($newAmmount);
            //new ammount
            $data_diary['Monto'] = $newAmmount;
            
            print_r($this->Diary_Model->update($data_diary, $diary[0]->iddiario));
          }
          /** SAVE DAILY **/


          if ($this->Detailtransaction_Model->check_if_exist_product($this->input->post('idtransaction'), $this->input->post('product')) === TRUE) {

            $objtrans = $this->Detailtransaction_Model->get_by_trans_prod($this->input->post('idtransaction'), $this->input->post('product'));
            $data_in['Cantidad'] = $objtrans[0]->Cantidad + $this->input->post('cantidad');  
            $result = $this->Detailtransaction_Model->update($data_in, $objtrans[0]->idDetailTransaction);

          }else{
            $result = $this->Detailtransaction_Model->create($data_in);
          }
          if ($result) {
            redirect('transaction/products/'.$data_in['idTransaction']);
          } else {
            $products = $this->Product_Model->get_all();
            $transdetail = $this->Detailtransaction_Model->get($data_in['idTransaction']);
            $data['category'] = 'detailtransaction';
            $data['action'] = 'new';
            $data['page'] = 'form';
            $data['transdetail'] = $transdetail;
            $data['idtransaction'] = $data_in['idTransaction'];
            $data['products'] = $products;
            $this->load->view('template/template', $data);
          }
        }
      } else {
        redirect('account/login');
      }
    }
/*
    function create() {
      $data['category'] = 'district';
      $data['action'] = 'new';
      $data['page'] = 'form';
      $data['area'] = $this->Area_Model->get_area();
      $this->load->view('template/template', $data);
    }

    public function edit($id = "") {
      if ($this->Account_Model->logged_in() === TRUE) {
        if ($id != "") {
          $data['iddistrict'] = $id;
          $district = $this->District_Model->get($id);
          if (empty($district)) {
              show_404();
          }
          $data['district'] = $district[0];
          $data['category'] = 'district';
          $data['action'] = 'edit';
          $data['page'] = 'form';
          $data['area'] = $this->Area_Model->get_area();
          $this->load->view('template/template', $data);
        }
        else
          redirect('district');
      } else {
        redirect('account/login');
      }
    }

    function save() {
      if ($this->Account_Model->logged_in() === TRUE) {
        $this->form_validation->set_rules('desc', 'Descripcion', 'xss_clean|required');
        $this->form_validation->set_rules('area', 'Zona', 'xss_clean|required');

        $this->form_validation->set_message('required', '%s es obligatorio.');
        $this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');

        if ($this->form_validation->run() == FALSE) {
          if($this->input->post('form_action') == "save") {
            $data['action'] = 'new';
          }else {
            $data['action'] = 'edit';
          }

					$data['category'] = 'district';
					$data['page'] = 'form';
					$data['area'] = $this->Area_Model->get_area();
					$this->load->view('template/template', $data);
        } else {
          $data_in['idBarrio'] = $this->input->post('iddistrict');
          $data_in['Descripcion'] = $this->input->post('desc');
          $data_in['idZona'] = $this->input->post('area');

          // Check if Save or Edit
          if($this->input->post('form_action') == "save") {
            if ($this->District_Model->create($data_in) === TRUE) {
              redirect('district');
            } else {
              $data['category'] = 'district';
              $data['action'] = 'new';
              $data['page'] = 'form';
              $this->load->view('template/template', $data);
            }
          }else{
            if ($this->District_Model->update($data_in, $data_in['idBarrio']) === TRUE) {
              redirect('district');
            } else {
              $data['category'] = 'district';
              $data['action'] = 'edit';
              $data['page'] = 'form';
              $this->load->view('template/template', $data);
            }
          }
        }
      } else {
        redirect('account/login');
      }
    }

    function delete($id) {
      $this->District_Model->delete($id);
      redirect('district');
    }
*/
    function delete($id_transaction=0, $id_product=0) {
      $this->Detailtransaction_Model->delete($id_transaction, $id_product);
      redirect('transaction/products/'.$id_transaction);
    }
  }
?>