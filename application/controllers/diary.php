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
      $data['diaries'] = $this->Diary_Model->search($data_in);
      $data_in['type'] = "C";
      $data['saldo'] = $this->Diary_Model->ammounts_search($data_in);
      //$data['diaries'] = $this->Diary_Model->get_diaries();
      $data['balance'] = $this->Diary_Model->get_balance();
      $data['distributor'] = $this->User_Model->get_users_by_profile_no_admin();
      $data['clients'] = $this->Client_Model->get_clients();
      $data['category'] = 'diary';
      $data['page'] = 'index';

      $data_index['order'] = "customer.NombreTienda";
      $data_index['status'] = "1";
      $search_parameters = http_build_query($data_index);
      $data['search_parameters'] = $search_parameters;

      $this->load->view('template/template', $data);
    }

    function chartsAmmount(){
      $data['category'] = 'diary';
      $data['page'] = 'chartsammount';
      $this->load->view('template/template', $data);
    }

    function chartsDistrib(){
      $data['category'] = 'diary';
      $data['page'] = 'chartsdistrib';
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

    function get_user_no_admin() {
      echo(json_encode($this->User_Model->get_users_by_profile_no_admin()));
    } 

    function saveblock() {
      $transdistributor = explode("***", $this->input->post('distributor'));
      $transdate = explode("***", $this->input->post('date'));
      $transvoucher = explode("***", $this->input->post('voucher'));
      $transclient = explode("***", $this->input->post('client'));
      $transammount = explode("***", $this->input->post('ammount'));
      $transdetail = explode("***", $this->input->post('detail'));

      for ($i=0; $i < count($transdate)-1; $i++) {
        if ( $transdate[$i] != "" & $transdistributor[$i] != "0" & $transvoucher[$i] != "" & $transclient[$i] != "0" & $transammount[$i] != "" & $transammount[$i] != "" ) {

          $data_in['FechaRegistro'] = date("y-m-d");
          $data_in['FechaTransaction'] = $transdate[$i];
          $data_in['idUser'] = $transdistributor[$i];
          $data_in['idUserSupervisor'] = $this->Account_Model->get_user_id($this->session->userdata('email'));;
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
      $data_in['FechaTransaction'] = $this->input->post('date');
      $data_in['idUser'] = $this->input->post('client');
      $data_in['idUserSupervisor'] = $this->Account_Model->get_user_id($this->session->userdata('email'));;
      $data_in['idTransaction'] = "1";
      $data_in['NumVoucher'] = $this->input->post('voucher');
      $data_in['idCustomer'] = $this->input->post('distributor');
      $data_in['Type'] = "C";
      $data_in['Monto'] = $this->input->post('ammount');
      $data_in['Estado'] = '1'; 
      $data_in['Detalle'] = $this->input->post('detail');

      $id = $this->Diary_Model->create($data_in);
      if ($id != null) {
        $allpays = $this->Diary_Model->get_all_pay_for($data_in);
        $balance = $this->Diary_Model->get_ammount($data_in);

        if ($allpays >= $balance[0]->Monto ){
          $this->Diary_Model->set_status($balance[0]->iddiario, 2);
          $diaries_list = $this->Diary_Model->get_diaries_by_params($balance[0]->NumVoucher, $balance[0]->idCustomer, "C");

          foreach ($diaries_list as $dl) {
            $this->Diary_Model->set_status($dl->iddiario, 2);
          }
        }

        redirect("diary");
      }
    }



    function getpays(){
      $data_in['voucher'] = $this->input->post('voucher');
      $data_in['distributor'] = $this->input->post('distributor');
      //$data_in['customer'] = $this->input->post('customer');
      $data['pays'] = $this->Diary_Model->getpays($data_in);

      $res = '<tbody>';
      $total = 0; 
      foreach ($data['pays'] as $r) {
        $res .= '<tr>';
        $res .= '<td class="center">'.$r->FechaTransaction.'</td>';
        $res .= '<td class="center">'.$this->Diary_Model->roundnumber($r->Monto, 2).'</td>';
        $res .= '<td class="center">'.$r->Detalle.'</td>';
        $res .= '<td class="center">';
        $res .= '   <a href="#modal-delete-'.$r->iddiario.'" role="button" class="btn btn-primary" data-toggle="modal">X</a>';
        $res .= '<div id="modal-delete-'.$r->iddiario.'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Eliminar</h3>
  </div>
  <div class="modal-body">
    <p>Esta seguro que desea Eliminar este pago ?</p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    '.anchor("diary/removepay/".$r->iddiario, "Desactivar", array("class" => "btn btn-primary")).'
  </div>
</div>';
        $res .= '</td>';
        $res .= '</tr>';





        $total = $total + $r->Monto;
      }

      $res .= '</tbody>';
      $res .= '<tfoot>';  
      $res .= '<tr><td class="center"><b>Total:</b></td><td class="center">'.$this->Diary_Model->roundnumber($total, 2).'</td><td class="center">&nbsp;</td><td>&nbsp;</td></tr>';
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
      $data['idAction'] = '47';
      $data['idReferencia'] = $id;
      $data['FechaHora'] = date("y-m-d, g:i");
      $this->Log_Model->create($data);
      redirect("diary");
    }

    function removepay($id) {
      $this->Diary_Model->delete($id);
      //save logs
      $data_log['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
      $data_log['idReferencia'] = $id;
      $data_log['idAction'] = '49';
      $data_log['FechaHora'] = date("y-m-d, g:i");
      $this->Log_Model->create($data_log);
      redirect("diary");
    }


    function get_clients_for_distributor($idDistrib=-1) {
      $areas = $this->User_Model->get_area_by_id($idDistrib);
      echo(json_encode($this->Client_Model->get_customers_by_area($areas)));
    }

    function get_loan_limit($id_client=-1) {
      $limit = $this->Client_Model->get_credit_limit($id_client);
      //print_r($limit);
      if ($limit == 0 || $limit == "0" || $limit == null){
        $limit = 50000;
      }
      $debe = $this->Diary_Model->get_all_loan($id_client);
      $pago = $this->Diary_Model->get_all_pay($id_client);
      $ammount = ($debe - $pago);
      //$ammount = $this->Diary_Model->get_loan_limit($id_client);

      echo(json_encode($this->Diary_Model->roundnumber( $limit - $ammount, 2 )));
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