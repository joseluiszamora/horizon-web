<?php
  class Report extends  CI_Controller {
    public function __construct() {
      parent::__construct();
      $this->load->model('Account_Model');
      $this->load->model('Transaction_Model');
      $this->load->model('Detailtransaction_Model');
      $this->load->model('Profile_Model');
      $this->load->model('Permission_Model');
      $this->load->model('Client_Model');
      $this->load->model('Product_Model');
      $this->load->model('Blog_Model');
      $this->load->model('City_Model');
      $this->load->model('Area_Model');
      $this->load->model('Commerce_Model');
    }

    function index() {
      //if ($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'permisos_de_acceso')){
        if ($this->Account_Model->logged_in() === TRUE) {
          $data['client'] = $this->Client_Model->get_clients();
          $data['transactions'] = $this->Transaction_Model->report_finish();
          $data['transactions_open'] = $this->Transaction_Model->report_open();
          $data['clients'] = $this->Client_Model->report();
          $data['ciudad'] = $this->City_Model->get_cities(0);
          $data['zona'] = $this->Area_Model->get_area();
          $data['barrio'] = $this->District_Model->get_disctricts();
          $data['comercio'] = $this->Commerce_Model->get_commerce();
          $data['category'] = 'report';
          $data['page'] = 'index';
          $this->load->view('template/template', $data);
        } else {
          redirect('account/login');
        }
      //}else{
      //  show_404();
      //}
    }

    function get_transactions() {
      //print_r ($_POST);
      $date_from = $this->input->post('date_from');
      $date_to = $this->input->post('date_to');
      $client = $this->input->post('client');
      $transactions = $this->Transaction_Model->report_filter($date_from, $date_to, $client);

        echo '<table class="table_transactions">
    <thead>
      <tr>
        <th>Fecha</th>
        <th>Nro Transacción</th>
        <th>CodCliente</th>
        <th>Nombre Cliente</th>
        <th>Usuario</th>
      </tr>
    </thead>';
      foreach ($transactions as $transaction) {
        echo '<tr>'.
            '<td>03/04/2013</td>'.
            '<td>'. $transaction->idTransaction. '</td>'.
            '<td>'. $transaction->codecustomer. '</td>'.
            '<td>'. $transaction->customer. '</td>'.
            '<td>'. $transaction->user. '</td>'.
          '</tr>';
      }
      echo '</tbody>
  </table>';

    }

    function get_clients() {
      //print_r ($_POST);
      $date_from = $this->input->post('date_from');
      $date_to = $this->input->post('date_to');
      $zona = $this->input->post('zona');
      $ciudad = $this->input->post('ciudad');
      $barrio = $this->input->post('barrio');
      $comercio = $this->input->post('comercio');
      $clients = $this->Client_Model->report_filter($date_from, $date_to, $ciudad, $zona, $barrio, $comercio);

        echo '<table class="table_clients">
    <thead>
      <tr>
        <th>Fecha de Alta</th>
        <th>CodCliente</th>
        <th>Nombre Tienda</th>
        <th>Comercio</th>
        <th>Dirección</th>
      </tr>
    </thead>';
      foreach ($clients as $client) {
        echo '<tr>'.
            '<td>' . $client->FechaAlta . '</td>'.
            '<td>' . $client->CodeCustomer . '</td>'.
            '<td>' . $client->NombreTienda . '</td>'.
            '<td>' . $client->comercio . '</td>'.
            '<td>' . $client->Direccion . '</td>'.
          '</tr>';
      }
      echo '</tbody>
  </table>';

    }

    function transaction() {
      //if ($this->Permission_Model->check_if_access($this->Account_Model->get_profile(), 'permisos_de_acceso')){
        if ($this->Account_Model->logged_in() === TRUE) {
          $this->load->helper('pdfexport_helper.php');
          $data['transactions'] = $this->Transaction_Model->report();
          $data['category'] = 'report';
          $data['page'] = 'index';
          $templateView = $this->load->view('template/template_pdf', $data, TRUE);
          exportMeAsDOMPDF($templateView, "report");
        } else {
          redirect('account/login');
        }
      //}else{
      //  show_404();
      //}
    }

    function create() {
      $data['category'] = 'transaction';
      $data['client'] = $this->Client_Model->get_clients();
      $data['action'] = 'new';
      $data['page'] = 'form';
      $this->load->view('template/template', $data);
    }

    public function edit($id = "") {
      if ($this->Account_Model->logged_in() === TRUE) {
     if ($id != "") {
         // $data['idpermission'] = $id;
          $transaction = $this->Transaction_Model->get($id);
          //$transactionTitle = $this->transaction_Model->get_name($id);

          if (empty($transaction)) {
            show_404();
          }
          $data['transaction'] = $transaction;
          //$data['modules'] = $this->Permission_Model->report_modules();
          //$data['transaction'] = $this->transaction_Model->report();

          $data['category'] = 'transaction';
          $data['action'] = 'edit';
          $data['page'] = 'form';
          $data['client'] = $this->Client_Model->get_clients();
          $this->load->view('template/template', $data);
        }
        else
          redirect('transaction');
      } else {
        redirect('account/login');
      }
    }

    function save() {
      if ($this->Account_Model->logged_in() === TRUE) {
        $this->form_validation->set_rules('custom', 'Cliente', 'xss_clean|required');

        $this->form_validation->set_message('required', '%s es obligatorio.');
        $this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');

        if ($this->form_validation->run() == FALSE) {
          if($this->input->post('form_action') == "save") {
            $data['action'] = 'new';
          }else {
            $data['action'] = 'edit';
          }
          $data['client'] = $this->Client_Model->get_clients();
          $data['category'] = 'transaction';
          $data['page'] = 'form';
          $this->load->view('template/template', $data);
        } else {
          $data_in['idCustomer'] = $this->input->post('custom');
          $data_in['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
          $data_in['Observacion'] = $this->input->post('obs');

          // Check if Save or Edit
          if($this->input->post('form_action') == "save") {

            $insertcode = $this->Transaction_Model->create($data_in);  // get new transaction code

            if ( $insertcode === FALSE) {
              $data['category'] = 'transaction';
              $data['action'] = 'new';
              $data['page'] = 'form';
              $data['client'] = $this->Client_Model->get_clients();
              $this->load->view('template/template', $data);
            } else {
              $data_blog['idTransaction'] = $insertcode;
              $data_blog['idUser'] = $this->Account_Model->get_user_id($this->session->userdata('email'));
              $data_blog['Operation'] = 'creacion';
              $data_blog['FechaHoraInicio'] = date("y-m-d, g:i");
              $data_blog['FechaHoraFin'] = date("y-m-d, g:i");
              $data_blog['CoordenadaInicio'] = '0.0';
              $data_blog['CoordenadaFin'] = '0.0';

              if ($this->Blog_Model->create($data_blog) === TRUE) {
                redirect('transaction');
              } else {
                $data['category'] = 'transaction';
                $data['action'] = 'new';
                $data['page'] = 'form';
                $data['client'] = $this->Client_Model->get_clients();
                $this->load->view('template/template', $data);
              }
            }
          }else{
            if ($this->Transaction_Model->update($data_in, $idtransaction) === TRUE) {
              redirect('transaction');
            } else {
              $data['category'] = 'transaction';
              $data['action'] = 'edit';
              $data['page'] = 'form';
              $data['client'] = $this->Client_Model->get_clients();
              $this->load->view('template/template', $data);
            }
          }
        }
      } else {
        redirect('account/login');
      }
    }

     public function products($id = "") {
      if ($this->Account_Model->logged_in() === TRUE) {
     if ($id != "") {
          $products = $this->Product_Model->get_all();
          $transaction = $this->Transaction_Model->get($id);

          if (empty($transaction)) {
            show_404();
          }

            $data['transaction'] = $this->Transaction_Model->get_info($id);
            $data['blog'] = $this->Blog_Model->get_by_transaction($id);
            $data['idtransaction'] = $id;
            $data['category'] = 'transaction';
            $data['page'] = 'products';
            $this->load->view('template/template', $data);
        }
        else
          redirect('transaction');
      } else {
        redirect('account/login');
      }
    }

    public function product_save() {
      if ($this->Account_Model->logged_in() === TRUE) {
        $this->form_validation->set_rules('product', 'Producto', 'xss_clean|required');
        $this->form_validation->set_rules('cantidad', 'Cantidad', 'xss_clean|required');
        //$this->form_validation->set_rules('obs', 'O', 'xss_clean|required');

        $this->form_validation->set_message('required', '%s es obligatorio.');
        $this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');

        if ($this->form_validation->run() == FALSE) {
          $data['transaction'] = $transaction;
          $data['products'] = $products;
          $data['transdetail'] = $transdetail;
          $data['idtransaction'] = $this->input->post();
          $data['category'] = 'transaction';
          $data['page'] = 'products';
          $data['action'] = 'new';
          $data['page'] = 'form';
          $this->load->view('template/template', $data);

        } else {
          /*$data_in['idCustomer'] = $this->input->post('product');
          $data_in['idCustomer'] = $this->input->post('cantidad');
          $data_in['Observacion'] = $this->input->post('obs');


          if ($this->Detailtransaction_Model->create($data_in) === TRUE) {
            redirect('transaction');
          } else {
            $data['transaction'] = $transaction;
            $data['products'] = $products;
            $data['category'] = 'transaction';
            $data['page'] = 'products';
            $this->load->view('template/template', $data);
          }*/
        }
      } else {
        redirect('account/login');
      }
    }


    // activate permission
    public function activate() {
      $transaction = $this->input->post('transaction');
      $module = $this->input->post('module');
      $this->Transaction_Model->activate($transaction, $module);
    }

    // deactivate permission
    public function deactivate() {
      $transaction = $this->input->post('transaction');
      $module = $this->input->post('module');
      $this->Transaction_Model->deactivate($transaction, $module);
    }


    /*function create() {
      $data['category'] = 'permission';
      $data['action'] = 'new';
      $data['page'] = 'form';
      $this->load->view('template/template', $data);
    }

    function save() {
      if ($this->Account_Model->logged_in() === TRUE) {
        $this->form_validation->set_rules('desc', 'Tipo de Comercio', 'xss_clean|required');

        $this->form_validation->set_message('required', '%s es obligatorio.');
        $this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');

        if ($this->form_validation->run() == FALSE) {
          if($this->input->post('form_action') == "save") {
            $data['action'] = 'new';
          }else {
            $data['action'] = 'edit';
          }
          $data['category'] = 'permission';
          $data['page'] = 'form';
          $this->load->view('template/template', $data);
        } else {
          $data_in['Descripcion'] = $this->input->post('desc');
          $idpermission = $this->input->post('idpermission');

          // Check if Save or Edit
          if($this->input->post('form_action') == "save") {
            if ($this->Permission_Model->create($data_in) === TRUE) {
              redirect('permission');
            } else {
              $data['category'] = 'permission';
              $data['action'] = 'new';
              $data['page'] = 'form';
              $this->load->view('template/template', $data);
            }
          }else{
            if ($this->Permission_Model->update($data_in, $idpermission) === TRUE) {
              redirect('permission');
            } else {
              $data['category'] = 'permission';
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
      $this->Permission_Model->delete($id);
      redirect('permission');
    } */

  }
?>