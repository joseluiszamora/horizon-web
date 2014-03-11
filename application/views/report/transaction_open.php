<form action="" id="search_transaction_open">
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
            <label>Agencia: </label>
            <?php echo form_dropdown('client', $client); ?>
        </li>
        <li>
            <a href="#" class="search">Buscar</a>
        </li>
    </ul>
    </form>
<div class="table_transactions_open_container">
	<table class="table_transactions_open">
		<thead>
			<tr>
				<th>Fecha</th>
				<th>Nro Transacción</th>
				<th>CodCliente</th>
				<th>Nombre Cliente</th>
				<th>Usuario</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($transactions_open as $transaction): ?>
				<tr>
					<td>03/04/2013</td>
					<td><?php echo $transaction->idTransaction; ?></td>
					<td><?php echo $transaction->codecustomer; ?></td>
					<td><?php echo $transaction->customer; ?></td>
					<td><?php echo $transaction->user; ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>