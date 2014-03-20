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
      $data['balance'] = $this->Diary_Model->get_balance();
      $data['distributor'] = $this->User_Model->get_users_by_profile_id_mail(4);
      $data['clients'] = $this->Client_Model->get_clients();
      $data['category'] = 'diary';
      $data['page'] = 'index';
      $this->load->view('template/template', $data);
    }

    function create() {
      $data['distributor'] = $this->User_Model->get_users_by_profile_id_mail(4);
      $data['clients'] = $this->Client_Model->get_clients();
      $data['category'] = 'diary';
      $data['action'] = 'new';
      $data['page'] = 'form';     
      $this->load->view('template/template', $data);
    }

    function saveblock() {
      $transdistributor = explode("***", $this->input->post('distributor'));
      $transdate = explode("***", $this->input->post('date'));
      $transvoucher = explode("***", $this->input->post('voucher'));
      $transclient = explode("***", $this->input->post('client'));
      $transammount = explode("***", $this->input->post('ammount'));
      $transdetail = explode("***", $this->input->post('detail'));

      for ($i=0; $i < count($transdate)-1; $i++) { 
        $data_in['FechaRegistro'] = date("y-m-d");
        $data_in['FechaTransaction'] = $transdate[$i];
        $data_in['idUser'] = $transdistributor[$i];
        $data_in['idUserSupervisor'] = "1";
        $data_in['idTransaction'] = "1";
        $data_in['NumVoucher'] = $transvoucher[$i];
        $data_in['idCustomer'] = $transclient[$i];
        $data_in['Type'] = "P";
        $data_in['Monto'] = $transammount[$i];
        $data_in['Estado'] = "1";
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
      $data_in['Detalle'] = $this->input->post('detail');

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
        $res .= '<tr><td class="center">'.$r->FechaRegistro.'</td><td class="center">'.$this->Diary_Model->roundnumber($r->Monto, 2).'</td><td class="center">'.$r->Detalle.'</td></tr>';
        $total = $total + $r->Monto;
      }

      $res .= '</tbody>';
      $res .= '<tfoot>';  
      $res .= '<tr><td class="center"><b>Total:</b></td><td class="center">'.$this->Diary_Model->roundnumber($total, 2).'</td><td class="center">&nbsp;</td></tr>';
      $res .= '</tfoot>';
      echo $res;
    }

    function search(){
      $this->form_validation->set_rules('distributor', 'distributor', 'xss_clean');
      $this->form_validation->set_message('xss_clean', 'security: danger value.');

      $data_in['distributor'] = $this->input->post('distributor');
      $data_in['dateStart'] = $this->input->post('dateStart');
      $data_in['dateFinish'] = $this->input->post('dateFinish');
      $data_in['status'] = $this->input->post('status');

      $data['diaries'] = $this->Diary_Model->search($data_in);
      $data['balance'] = $this->Diary_Model->get_balance();

      $data['distributor'] = $this->User_Model->get_users_by_profile_id_mail(4);
      $data['clients'] = $this->Client_Model->get_clients();
      $data['category'] = 'diary';
      $data['page'] = 'index';
      $this->load->view('template/template', $data);
    }

     // desactivar
    function deactive($id) {
      $this->Diary_Model->set_status($id, '3');
      // Save log for this action
      $data['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
      $data['idAction'] = '18';
      $data['idReferencia'] = $id;
      $data['FechaHora'] = date("y-m-d, g:i");
      $this->Log_Model->create($data);
      redirect('product');
    }

  }
?>