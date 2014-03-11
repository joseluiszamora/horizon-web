<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of usuario
 *
 * @author Zenlabs
 */

class Play extends CI_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model(array('User_model', 'Ticket_model', 'Question_model', 'Code_model', 'Userquestion_model'));
    if ($this->Account_model->logged_in() !== TRUE) {
      redirect('account');
    }
  }

  public function index() {
    $data['category'] = 'play';
    $data['page'] = 'index';
    $this->load->view('template/template', $data);
  }

  public function new_game() {
    if ($this->Account_model->logged_in() === TRUE) {
      //$this->form_validation->set_rules('code', 'Numero de Codigo', 'xss_clean|required|is_unique[tickets.code]');
      $this->form_validation->set_rules('code', 'Numero de Codigo', 'xss_clean|required|callback_code_check');

      $this->form_validation->set_message('required', 'El %s es obligatorio.');
      $this->form_validation->set_message('is_unique', 'Este ticket ya fue utilizado.');
      $this->form_validation->set_message('code_check', 'Codigo no valido');
      $code = $this->input->post('code');

      if ($this->form_validation->run() == FALSE) {
        $data['category'] = 'play';
        $data['page'] = 'index';
        $this->load->view('template/template', $data);
      } else {
        $user_id = $this->session->userdata('userid');
        //$ticket_id = $this->Ticket_model->create($code, $user_id);
        //$this->question();

        // update ticket status
        $data_update['cStatus']= 1;
        $data_update['cDateUsed']= date("y-m-d H:m:s");
        $this->Code_model->update_code($code, $data_update);
        
        $questions = $this->Question_model->get_random_6($user_id);
        $questions_ids = Array();
        foreach ($questions as $key => $question) {
          $questions_ids[$key] = $question->question_id;

          // associate code with user
          $this->Userquestion_model->create($user_id, $question->question_id);
        }
        $ticket_id = $this->Ticket_model->create($code, $user_id, $questions_ids);
        $data['ticket'] = $ticket_id;
        $data['questions'] = $questions_ids;
        $data['category'] = 'play';
        $data['page'] = 'answer';
        $this->load->view('template/template', $data);
      }
    } else {
      redirect("account");
    }
  }

  function code_check(){
    $code = $this->input->post('code');

    if($this->Code_model->code_check($code) === TRUE){
      //if($this->Ticket_model->code_unique($code) === TRUE){
      //  return TRUE;
      //}else{
      //  $this->form_validation->set_message('code', 'Este codigo ya fue utilizado anteriormente');
      //  return FALSE;
      //}
      return TRUE;
    }else{
      $this->form_validation->set_message('code', 'Codigo no valido');
      return FALSE;
    }
  }

  function ticket_check() { 
    $code = $this->input->post('code');

    if($this->Ticket_model->code_unique($code) === TRUE){
      return TRUE;
    }else{
      $this->form_validation->set_message('code', 'Este codigo ya fue utilizado anteriormente');
      return FALSE;
    }
  }

  public function question() {
    $data['category'] = 'play';
    $data['page'] = 'answer';
    $this->load->view('template/template', $data);
  }

  public function finished($win, $total, $ticket) {

    $data['category'] = 'play';
    $data['win'] = $win;
    $data['total'] = $total;
    $data['page'] = 'finished';
    $this->load->view('template/template', $data);

    $this->send_points_mail($win, $total, $ticket);
  }

  function get_questions($idTicket=-1) {
    echo(json_encode($this->Question_model->get_questions($idTicket)));
  }

  function save_questions(){
    $pointsValue = 10;  // valor por defecto de cada respuesta contestada
    $pointsWin = 0;
    $pointsTotal = 0;
    $oldPoints = 0;

    $questions = explode(',', $this->input->post('questions'));
    $answers = explode(',', $this->input->post('answers'));
    $ticket = explode(',', $this->input->post('ticket'));

    for ($i=0; $i <= 2; $i++) { 
      if(isset($questions[$i]) && isset($answers[$i]) && $questions[$i] != "" && $answers[$i] != ""){
        if($this->Question_model->check_question($questions[$i], $answers[$i])){
          $pointsWin += $pointsValue;
        }
      }
    }
    $oldPoints += $this->User_model->get_points($this->Account_model->get_user_id());

    // sumar puntos ganados
    $pointsTotal =  $oldPoints + $pointsWin;  // puntos ganados
    $this->User_model->update_points($pointsTotal, $this->Account_model->get_user_id());
    $this->finished($pointsWin, $pointsTotal, $ticket);
  }


  function update_question(){
    $pointsValue = 10;  // valor por defecto de cada prespuesta contestada
    $oldPoints = 0;  // vpuntos del ticket
    $totalPoints = 0;  // puntos totales

    $question = $this->input->post('questionId');
    $response = $this->input->post('response');
    $ticket = $this->input->post('ticket');
    $status = $this->input->post('status');

    // extraer el valor almacenado de los puntos de este ticket hasta ahora
    $oldPoints = $this->Ticket_model->get_points($ticket);


    if(isset($question) && isset($response) && $question != "" && $response != ""){
      if($this->Question_model->check_question($question, $response)){
        
        $totalPoints = $oldPoints + $pointsValue;

        $this->update_ticket($ticket, $status, $totalPoints);
      }
    }
  }

  //funcion para actualizar el ticket
  function update_ticket($ticket, $status, $points) {
    $data = array(
      'ticket_id' => $ticket,
      'cStatus' => $status,
      'nPoints' => $points
    );

    if ($this->Ticket_model->update_ticket($ticket, $data)) {
      return true;
    } else {
      return false;
    }
  }

  function send_points_mail($win, $total, $ticket){
    // calculando el tiempo utilizado
    $ticket = $this->Ticket_model->get($ticket);      
    $time = $this->dateDiff($ticket->dDateStart, $ticket->dDateFinish);

    $data_points['ganados'] = $win;
    $data_points['total'] = $total;
    $data_points['time'] = $time;


    $user = $this->Account_model->get_by_id($this->Account_model->get_user_id());
    
    $this->load->library('email');

    $config['mailtype'] = 'html';
    $this->email->initialize($config);

    $this->email->from('admin@derbymundial.com', 'DERBY');
    $this->email->to($user->cUserEmail);
    $this->email->cc('jzamora@zenlabs.net');
    $this->email->bcc('jzamora@zenlabs.net');
    $this->email->subject('Sumaste Nuevos puntos');

    $msg = $this->load->view('template/template_new_points', $data_points, true);
    $this->email->message($msg);

    $this->email->send();
  }

  function update_question_date(){
    $ticket = $this->input->post('ticket');
    $action = $this->input->post('action');
    if ($action == "create") {
      $data['dDateStart'] = date("y-m-d H:m:s");
    }else{
      $data['dDateFinish'] = date("y-m-d H:m:s");
    }
    print_r($data);
    if($this->Ticket_model->update_ticket($ticket, $data))
      echo true
    else
      return false

  }

  // caclcula la diferencia entre 2 fechas
    function dateDiff($time1, $time2, $precision = 6) {
      // Time format is UNIX timestamp or
      // PHP strtotime compatible strings
      // Set timezone
      date_default_timezone_set("UTC");
      // If not numeric then convert texts to unix timestamps
      if (!is_int($time1)) {
        $time1 = strtotime($time1);
      }
      if (!is_int($time2)) {
        $time2 = strtotime($time2);
      }
   
      // If time1 is bigger than time2
      // Then swap time1 and time2
      if ($time1 > $time2) {
        $ttime = $time1;
        $time1 = $time2;
        $time2 = $ttime;
      }
   
      // Set up intervals and diffs arrays
      $intervals = array('year','month','day','hour','minute','second');
      $diffs = array();
   
      // Loop thru all intervals
      foreach ($intervals as $interval) {
        // Set default diff to 0
        $diffs[$interval] = 0;
        // Create temp time from time1 and interval
        $ttime = strtotime("+1 " . $interval, $time1);
        // Loop until temp time is smaller than time2
        while ($time2 >= $ttime) {
          $time1 = $ttime;
          $diffs[$interval]++;
          // Create new temp time from time1 and interval
          $ttime = strtotime("+1 " . $interval, $time1);
        }
      }
   
      $count = 0;
      $times = array();
      // Loop thru all diffs
      foreach ($diffs as $interval => $value) {
        // Break if we have needed precission
        if ($count >= $precision) {
          break;
        }
        // Add value and interval 
        // if value is bigger than 0
        if ($value > 0) {
          // Add s if value is not 1
          if ($value != 1) {
            $interval .= "s";
          }
          // Add value and interval to times array
          $times[] = $value . " " . $interval;
          $count++;
        }
      }
   
      // Return string with times
      return implode(", ", $times);
    }
}