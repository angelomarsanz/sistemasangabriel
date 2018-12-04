<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <h1>Transacciones corregidas</h2>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">Nro.</th>
                        <th scope="col">Alumno</th>
						<th scope="col">Id Transaction</th>
						<th scope="col">Descripción</th>
						<th scope="col">Monto transacción</th>
						<th scope="col">Abonado</th>
						<th scope="col">Pagado</th>
						<th scope="col">Actualizado</th>
                    </tr>
                </thead>
                <tbody>
					<?php $accountTransactions = 1; ?>
                    <?php foreach ($studentTransactions as $studentTransaction): ?>
						<tr>
							<td><?= $accountTransactions ?></td>
							<td><?= $studentTransaction->student->full_name ?></td>
							<td><?= $studentTransaction->id ?></td>
							<td><?= $studentTransaction->transaction_description ?></td>
							<td><?= number_format($studentTransaction->original_amount, 2, ",", ".") ?></td>
							<td><?= number_format($studentTransaction->amount, 2, ",", ".") ?></td>
							<td><?= $studentTransaction->paid_out ?></td>
							<td><?= $studentTransaction->modified->format('d-m-Y')   ?></td>
						</tr>
						<?php $accountTransactions++ ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>