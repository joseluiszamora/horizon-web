<form action="" id="search_client">
    <ul>
        <li>
            <label>Fecha de: </label>
            <input type="text" name="date_from" class="datePicker" />
        </li>
        <li>
            <label>Fecha a: </label>
            <input type="text" name="date_from" class="datePicker" />
        </li>
        <li>
            <label>Ciudad: </label>
            <?php echo form_dropdown('ciudad', $ciudad); ?>
        </li>
        <li>
            <label>Zona: </label>
            <?php echo form_dropdown('zona', $zona); ?>
        </li>
        <li>
            <label>Barrio: </label>
            <?php echo form_dropdown('barrio', $barrio); ?>
        </li>
        <li>
            <label>Tipo de Comercio: </label>
            <?php echo form_dropdown('comercio', $comercio); ?>
        </li>
        <li>
            <a href="#" class="search">Buscar</a>
        </li>
    </ul>
    </form>
<div class="table_clients_container">
	<table class="table_clients">
		<thead>
			<tr>
				<th>Fecha de Alta</th>
				<th>CodCliente</th>
				<th>Nombre Tienda</th>
				<th>Comercio</th>
				<th>Dirección</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($clients as $client): ?>
				<tr>
					<td><?php echo $client->FechaAlta; ?></td>
					<td><?php echo $client->CodeCustomer; ?></td>
					<td><?php echo $client->NombreTienda; ?></td>
					<td><?php echo $client->comercio; ?></td>
					<td><?php echo $client->Direccion; ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>