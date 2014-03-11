<div class="row">
  <div class="span12 titleTop">
    <h1 class="floatLeft">Productos</h1>
  </div>
  
  <div class="container logincontainer">    
    <style type="text/css">
      .bigTransactionInfoContainer{
        border: 0 !important;
        padding-top: 0px!important;
        padding-bottom: 0px!important;
        margin-bottom: 0px!important;
      }
      .transactionInforRow{
        float: left;
        width: 100%;
      }
      .transactionInforRow .left{
        float: left;
        width: 250px;
      }
      .transactionInforRow .right{
        float: left;
      }
    </style>

    <?php
      $transaction = $this->Transaction_Model->get($idtransaction);               
      foreach ($transaction as $row){
        $user = $this->User_Model->get($row->idUser);
        $customer = $this->Client_Model->get($row->idCustomer);
        $conciliado = $row->Conciliado; 
      }
    ?>
    <div class="span10 offset1">
      <div class="block_head row">
        <h2 class="span6">Transaccion</h2>
        <?php echo anchor('transaction/finish/'.$idtransaction, 'Finalizar', array('class' => 'btnTitle btn btn-primary')); ?>
       
        <?php 
          //if($this->Account_Model->get_profile() == "1" || (isset($statuscreate) && $statuscreate = "create")){
          if(($this->Account_Model->get_profile() == "1") || ($conciliado == "1")){
            echo anchor('detailtransaction/create/'.$idtransaction, 'Añadir Productos', array('class' => 'btnTitle btn btn-primary', 'style'=>'margin-right:5px;')); 
          }
        ?>
      </div>
      <div class="block_content row">
         <div class="block_content row bigTransactionInfoContainer">
            <div class="transactionInforRow">
              <div class="left"><strong>Codigo de Transaccion:</strong></div>
              <div class="right"><?php echo $idtransaction; ?></div>
            </div>
              

              <?php foreach ($user as $rowUser) {?>
                <div class="transactionInforRow">
                  <div class="left"><strong>Transaccion Creada Por:</strong></div>
                  <div class="right"><?php echo $rowUser->Nombre." ".$rowUser->Apellido; ?></div>
                </div>
              <?php } ?>

              <?php foreach ($customer as $rowCustomer) {?>             
                <div class="transactionInforRow">
                  <div class="left"><strong>Codigo de Cliente:</strong></div>
                  <div class="right"><?php echo $rowCustomer->CodeCustomer; ?></div>
                </div>
                <div class="transactionInforRow">
                  <div class="left"><strong>Cliente:</strong></div>
                  <div class="right"><?php echo $rowCustomer->NombreTienda; ?></div>
                </div>
                <div class="transactionInforRow">
                  <div class="left"><strong>Direccion:</strong></div>
                  <div class="right"><?php echo $rowCustomer->Direccion; ?></div>
                </div>                
              <?php } ?>
                
             

              <div class="span8 transactionsLogContainer">
                <div class="block_head row">
                  <h4 class="span6">Coordenadas</h4>
                </div>
                <div class="block_content row">
                  <div class="block_content row bigTransactionInfoContainer">
                    <?php 
                    $sw = TRUE;
                    $mapEnable = FALSE;
                    $coord ="0.0;0.0";
                    foreach ($blog as $rowblog) {
                      if ($sw && isset($rowblog->CoordenadaInicio)){
                        $coord = explode(';', $rowblog->CoordenadaInicio);
                        $latitude = $coord[0];
                        $longitude = $coord[1];
                        $sw = FALSE;
                        $mapEnable = TRUE;
                      }
                    ?>
                    <h3><?php echo $rowblog->Operation; ?></h3>
                    <fieldset>
                      <div class="transactionInforRow">
                        <div class="left"><strong>Fecha y Hora de Inicio:</strong></div>
                        <div class="right"><?php echo $rowblog->FechaHoraInicio; ?></div>
                      </div>
                      <div class="transactionInforRow">
                        <div class="left"><strong>Fecha y Hora de Finalizacion:</strong></div>
                        <div class="right"><?php echo $rowblog->FechaHoraFin; ?></div>
                      </div>
                      <?php
                        if ($mapEnable && $latitude!="0.0" && $longitude!="0.0"){ // check if map exist
                      ?>
                        <div class="transactionInforRow">
                          <div class="left"><strong>Coordenada de Inicio:</strong></div>
                          <div class="right"><?php echo $rowblog->CoordenadaInicio; ?></div>
                        </div>
                        <div class="transactionInforRow">
                          <div class="left"><strong>Coordenada de Finalizacion:</strong></div>
                          <div class="right"><?php echo $rowblog->CoordenadaFin; ?></div>
                        </div>
                      <?php
                        }
                      ?>
                    </fieldset>
                  <?php } ?>
                  </div>
                </div>
              </div>
          </div>
      </div>
    </div>

    <?php
      if ($mapEnable && $latitude!="0.0" && $longitude!="0.0"){ // check if map exist
    ?>
    <div class="span10 offset1">
      <div class="block_head row">
        <h2 class="span6">Ubicacion</h2>
      </div>
      <div class="block_content row">
         <div class="block_content row bigTransactionInfoContainer">
           <iframe width="800" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.es/maps?f=q&amp;source=s_q&amp;hl=es&amp;geocode=&amp;q=+<?php echo $latitude ?>++<?php echo $longitude ?>&amp;aq=&amp;sll=-16.49901,-68.146248&amp;sspn=0.422016,0.780716&amp;ie=UTF8&amp;t=m&amp;z=14&amp;output=embed"></iframe><br /><small><a href="https://maps.google.es/maps?f=q&amp;source=embed&amp;hl=es&amp;geocode=&amp;q=+<?php echo $latitude ?>++<?php echo $longitude ?>&amp;aq=&amp;sll=-16.49901,-68.146248&amp;sspn=0.422016,0.780716&amp;ie=UTF8&amp;t=m&amp;z=14" style="color:#0000FF;text-align:left">Ver mapa más grande</a></small>
          </div>
      </div>
    </div>
    <?php
      }
    ?>
    




    <?php     
      // product list
      $transdetail = $this->Detailtransaction_Model->get($idtransaction);
      $data['category'] = 'transaction';
      $data['transdetail'] = $transdetail;     
      if (isset($conciliado) && $conciliado !="" && $conciliado =="1"){
        $data['conciliado'] = "1";
      }else{
        $data['conciliado'] = "0";
      }
      $this->load->view('transaction/tab4', $data);
    ?>  

  </div>  
</div>