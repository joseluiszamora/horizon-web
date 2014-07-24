<style type="text/css">
.factura {
  font-family: monospace;
}
.factura center, .factura section {
  padding: 0 10px;
}
.factura .title {
  font-weight: bold;
  margin-top: 10px;
  font-size: 1.2em;
}
.factura .subtitle {
  font-size: 1.1em;
  font-weight: bold;
  margin-top: 10px;
}
.factura .underline {
  text-decoration: underline;
}
.factura .separador {
  border-top: 1px dashed #000;
  margin: 15px 0;
}
.factura .item1 {
  margin-top: 5px;
}
.factura .item1 .almacen {
  float: right;
}
.factura table {
  border-spacing: 0;
  font-size: 0.9em;
  width: 100%;
}
.factura table .section {
  float: left;
  width: 50%;
}
.factura table .linea {
  padding-top: 7px;
  border-bottom: 1px dashed #000;
}
.factura table tr .codigo {
  padding-left: 15px;
}
.factura .fecha-hora {
  margin: 15px 0;
  font-size: 0.8em;
}
.factura .firma {
  border-top: 1px dashed #000;
  margin: 100px auto 20px;
  padding: 10px 0 0;
  text-align: center;
  width: 200px;
}
</style>

<div class="row factura">
  <div class="col-md-offset-1 col-md-9">
    <center>
      <div class="title">DISTRIBUIDORA AD</div>
      <div class="title">HORIZON</div>
      <div class="subtitle underline">SALIDA DE ALMACEN</div>
      <div class="subtitle">ORIGINAL</div>
    </center>
    <div class="separador"></div>
    <section>
      <div class="item1">
        <span class="nro">Nro. 000625</span>
        <span class="almacen">Alm. 001</span>
      </div>
      <div class="item1">
        Fecha <?php echo $liquidation[0]->fechaRegistro; ?>
      </div>
      <div class="item1">
        Usuario: <?php echo "Pepito de los Palotes" ?>
      </div>
      <div class="item1">
        Distribuidor: <?php echo $liquidation[0]->Nombre." ".$liquidation[0]->Apellido; ?>
      </div>
    </section>
    <div class="separador"></div>
    <section>
      <table>
        <thead>
          <tr>
            <td class="codigo">CODIGO</td>
            <td>PRODUCTO</td>
            <td colspan="2">TOTAL CARGADO</td>
          </tr>
        </thead>
        <tbody>
          <?php
            foreach ($lines as $rowline) {
              $totalPline = 0;
              $totalUline = 0;
          ?>
            <tr>
              <td colspan="2" class="linea nameline"><?php echo $rowline["nameLine"]; ?></td>
              <td class="pieza linea">P</td>
              <td class="pieza linea">U</td>
            </tr>
            <?php
              foreach ($rowline["products"] as $rowproducts){
                $totalchargeu = $rowproducts["previousDayU"] + $rowproducts["chargeU"]+ $rowproducts["chargeExtraU1"]+ $rowproducts["chargeExtraU2"]+ $rowproducts["chargeExtraU3"];
                $totalchargep = $rowproducts["previousDayP"] + $rowproducts["chargeP"]+ $rowproducts["chargeExtraP1"]+ $rowproducts["chargeExtraP2"]+ $rowproducts["chargeExtraP3"];
                $totalPline += $totalchargep;
                $totalUline += $totalchargeu;
            ?>
              <tr>
                <td class="codigo"><?php echo $rowproducts["idProduct"]; ?></td>
                <td class="producto"><?php echo $rowproducts["Nombre"]; ?></td>
                <td class="paquete"><?php echo $totalchargep; ?></td>
                <td class="unidad"><?php echo $totalchargeu; ?></td>
              </tr>
            <?php } ?>
          <?php } ?>
        </tbody>
      </table>
    </section>
    <div class="separador"></div>
    <section>
      <div class="fecha-hora">Fecha Hora Imp. 24/07/2014 - 11:23</div>
      <div class="revisar-verificar">Revise y verifique el detalle de los productos antes de firmar.</div>

      <div class="firma entregado">Entregado</div>
      <div class="firma recibido">Recibido</div>
    </section>
  </div>
</div>