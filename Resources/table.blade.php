{{-- Datatables css --}}
@if($table->dataTable())
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
@endif

@if($table->rows())
<table id="tablegrid" class="table">
	<thead>
		<tr>
			@foreach($table->columns() as $column)
				<th>{{ $column['label'] }}</th>
			@endforeach
			@if(count($table->actions()))
				<th>Acoes</th>
			@endif
		</tr>
	</thead>
	<tbody>
		@foreach($table->rows() as $row)
			<tr>
				@foreach($table->columns() as $column)
					<td>
						@if(is_object($row->{$column['name']}))
							@if(isset($column['field']) )
								@if(isset($row->{$column['name']}->{$column['field']}) )
									{{ $row->{$column['name']}->{$column['field']} }}
								@endif
							@else
								{{ $row->{$column['name']} }}
							@endif
						@else
							{{ $row->{$column['name']} }}
						@endif
					</td>
				@endforeach
				@if(count($table->actions()))
					<td>
						@foreach($table->actions() as $action)
							 @include($action['template'], [
												'row' => $row,
												'action' => $action
											]) 
						@endforeach
					</td>
				@endif
			</tr>
		@endforeach
	</tbody>
</table>

@else
	<table>
		<tr>
			<td>Nenhum registro foi encontrado</td>
		</tr>
	</table>
@endif

{{-- Datables js --}}
@if($table->dataTable())
	<script src="//code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>

	@if(config('table.translation_table'))
		<script>
			$(function() {
	            $('#tablegrid').DataTable({
		              "columnDefs": [
		                  {"orderable": true }
		              ],
		              "language": {
		                  "zeroRecords": "{{ config('table.zero_records') }}",
		                  "infoEmpty": "Mostrando 0 resultados encontrados",
		                  "infoFiltered":   "(filtro aplicado nas _MAX_ entradas)",
		                  "info":  "Mostrando _START_ a _END_ do total de _TOTAL_ encontradas",
		                  "search": "{{ config('table.search') }}",
		                  "lengthMenu":     "Mostrar _MENU_ resultados",
		                  "paginate": {
		                      "first":      "First",
		                      "last":       "Last",
		                      "next":       "Próximo",
		                      "previous":   "Anterior"
		                  },
		              }
		          });
	        });
			
		</script>
	@else
		<script>
			$(function() {
	            $('#tablegrid').DataTable();
	        });
		</script>
	@endif
@endif

