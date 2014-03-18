<?php
  class Diary extends  CI_Controller {   
    public function __construct() {
      parent::__construct();
      
      $this->load->model('Diary_Model');
      $this->load->model('User_Model');
      $this->load->model('Client_Model');
      
      if (!($this->Account_Model->logged_in() === TRUE)) {
        redirect('account/login');
      }/* else if (!($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'diary'))) {
        show_404();
      }*/
    }

    function index() {
      $data['diaries'] = $this->Diary_Model->get_diaries();
      $data['distributor'] = $this->User_Model->get_users_by_profile(4);
      $data['clients'] = $this->Client_Model->get_clients();
      $data['category'] = 'diary';
      $data['page'] = 'index';
      $this->load->view('template/template', $data);
    }

     function create() {
      $data['distributor'] = $this->User_Model->get_users_by_profile(4);
      $data['clients'] = $this->Client_Model->get_clients();
      $data['category'] = 'diary';
      $data['action'] = 'new';
      $data['page'] = 'form';     
      $this->load->view('template/template', $data);
    }

    function saveblock() {
      $transdate = explode("***", $this->input->post('date'));
      $transvoucher = explode("***", $this->input->post('voucher'));
      $transclient = explode("***", $this->input->post('client'));
      $transammount = explode("***", $this->input->post('ammount'));
      $transdetail = explode("***", $this->input->post('detail'));

      for ($i=0; $i < count($transdate)-1; $i++) { 
        $data_in['FechaRegistro'] = date("y-m-d");
        $data_in['FechaTransaction'] = $transdate[$i];
        $data_in['idUser'] = "1";
        $data_in['idUserSupervisor'] = "1";
        $data_in['idTransaction'] = "1";
        $data_in['NumVoucher'] = $transvoucher[$i];
        $data_in['idCustomer'] = $transclient[$i];
        $data_in['Type'] = "P";
        $data_in['Monto'] = $transammount[$i];
        $data_in['Estado'] = "activo";
        $data_in['Detalle'] = $transdetail[$i];

        $this->Diary_Model->create($data_in);
      }
      redirect("diary");
    }

    function addpay() {
      $this->form_validation->set_rules('ammount', 'Cantidad', 'xss_clean|required');

      $this->form_validation->set_message('required', '%s es obligatorio.');
      
      $data_in['FechaRegistro'] = date("y-m-d");
      $data_in['FechaTransaction'] = date("y-m-d");
      $data_in['idUser'] = "1";
      $data_in['idUserSupervisor'] = "1";
      $data_in['idTransaction'] = "1";
      $data_in['NumVoucher'] = $this->input->post('voucher');
      $data_in['idCustomer'] = "123";
      $data_in['Type'] = "C";
      $data_in['Monto'] = $this->input->post('ammount');
      $data_in['Estado'] = '1';
      $data_in['Detalle'] = "pago";

      if ($this->Diary_Model->create($data_in) == TRUE) {
        redirect("diary");
      }
    }

    function getpays(){
      $data_in['voucher'] = $this->input->post('voucher');
      $data['pays'] = $this->Diary_Model->getpays($data_in);

      $res = '<tbody>';
      $total = 0;
      foreach ($data['pays'] as $r) {
        $res .= '<tr><td class="center">'.$r->FechaRegistro.'</td><td class="center">'.$r->Monto.'</td><td class="center">'.$r->Detalle.'</td></tr>';
        $total = $total + $r->Monto;
      }

      $res .= '</tbody>';
      $res .= '<tfoot>';  
      $res .= '<tr><td class="center"><b>Total:</b></td><td class="center">'.$total.'</td><td class="center">&nbsp;</td></tr>';
      $res .= '</tfoot>';
      echo $res;
    }




/*
    public function edit($id = "") {
      if ($id != "") {
        $data['idCity'] = $id;
        $city = $this->City_Model->get($id);
        if (empty($city)) {
            show_404();
        }
        $data['city'] = $city[0];
        $data['category'] = 'city';
        $data['action'] = 'edit';
        $data['page'] = 'form';
        $this->load->view('template/template', $data);
      }
      else
        redirect('city');
    }

    

    function delete($id) {
      $this->City_Model->delete($id);
      redirect('district');
    } 
*/

  }
?>