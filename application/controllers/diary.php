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
      $data_in['status'] = "1";
      $data_in['type'] = "P";
      $data['total'] = $this->Diary_Model->ammounts_search($data_in);
      $data_in['type'] = "C";
      $data['saldo'] = $this->Diary_Model->ammounts_search($data_in);
      $data['diaries'] = $this->Diary_Model->get_diaries();
      $data['balance'] = $this->Diary_Model->get_balance();
      $data['distributor'] = $this->User_Model->get_users_by_profile_no_admin();
      $data['clients'] = $this->Client_Model->get_clients();
      $data['category'] = 'diary';
      $data['page'] = 'index';

      $data_index['order'] = "customer.NombreTienda";
      $search_parameters = http_build_query($data_index);
      $data['search_parameters'] = $search_parameters;

      $this->load->view('template/template', $data);
    }

    function charts(){
      $data['category'] = 'diary';
      $data['page'] = 'charts';
      $this->load->view('template/template', $data);
    }

    function create() {
      $data['distributor'] = $this->User_Model->get_users_by_profile_no_admin();
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
        print_r("MMMMMMMMMMMM");
        print_r($transdate);
        
        if ( $transdate[$i] != "" & $transdistributor[$i] != "0" & $transvoucher[$i] != "" & $transclient[$i] != "0" & $transammount[$i] != "" & $transammount[$i] != "" ) {

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
      }
      redirect("diary");
    }

    function addpay() {
      $this->form_validation->set_rules('ammount', 'Cantidad', 'xss_clean|required');
      $this->form_validation->set_message('required', '%s es obligatorio.');
      
      $data_in['FechaRegistro'] = date("y-m-d");
      $data_in['FechaTransaction'] = date("y-m-d");
      $data_in['idUser'] = $this->input->post('client');
      $data_in['idUserSupervisor'] = "1";
      $data_in['idTransaction'] = "1";
      $data_in['NumVoucher'] = $this->input->post('voucher');
      $data_in['idCustomer'] = $this->input->post('distributor');
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

      $data['parameters'] = $data_in;
      $data_in['type'] = "P";
      $data['total'] = $this->Diary_Model->ammounts_search($data_in);
      $data_in['type'] = "C";
      $data['saldo'] = $this->Diary_Model->ammounts_search($data_in);
      $data['distributor'] = $this->User_Model->get_users_by_profile_no_admin();
      $data['clients'] = $this->Client_Model->get_clients();
      $data['category'] = 'diary';
      $data['page'] = 'index';

      $data_index['order'] = "customer.NombreTienda";
      $search_parameters = http_build_query($data_in);
      $data['search_parameters'] = $search_parameters;

      $this->load->view('template/template', $data);
    }

    function deactive($id) {
      $this->Diary_Model->set_status($id, '3');
      $diary = $this->Diary_Model->get($id);
      $diaries_list = $this->Diary_Model->get_diaries_by_params($diary[0]->NumVoucher, $diary[0]->idCustomer, "C");

      foreach ($diaries_list as $dl) {
        $this->Diary_Model->set_status($dl->iddiario, '3');
      }
      // Save log for this action
      $data['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
      $data['idAction'] = '18';
      $data['idReferencia'] = $id;
      $data['FechaHora'] = date("y-m-d, g:i");
      $this->Log_Model->create($data);
      redirect("diary");
    }


    function get_clients_for_distributor($idDistrib=-1) {
      $areas = $this->User_Model->get_area_by_id($idDistrib);
      echo(json_encode($this->Client_Model->get_customers_by_area($areas)));
    }

    function get_loan_limit($id_client=-1) {
      $limit = $this->Client_Model->get_credit_limit($id_client);
      //$ammount = $this->Diary_Model->get_loan_limit($id_client);
      //echo(json_encode($ammount));
      echo(json_encode($this->Diary_Model->roundnumber( $limit, 2 )));
    }

    function pdf() {
      $this->load->helper('pdfexport_helper.php');
      $parameters_string = $this->input->post('parameters');

      parse_str(html_entity_decode($parameters_string), $parameters);
      $diaries = $this->Diary_Model->search($parameters);

      $user_email = $this->Account_Model->get_email();
      $user = $this->Account_Model->get_user_by_email($user_email);

      if (isset($parameters['customer']) && ($parameters['customer']!="") && ($parameters['customer']!="0")) {
        $parameters['customer'] = $parameters['customer'];
      }
      $data['user_name'] = $user->Nombre . ' ' . $user->Apellido;
      $data['parameters'] = $parameters;
      $data['title'] = 'REPORTE DE CREDITOS';
      $data['diaries'] = $diaries;
      $data['category'] = 'diary';
      $data['page'] = 'pdf';
      $data['base_url']=$_SERVER["DOCUMENT_ROOT"].'/systems/horizon/';
      $data['base_url']=$_SERVER["DOCUMENT_ROOT"].'/horizon/';
      //$this->load->view('template/template_pdf', $data);
      //print_r($diaries);
      $templateView = $this->load->view('template/template_pdf', $data, TRUE);
      exportMeAsDOMPDF($templateView, "report");
    }

  }
?>