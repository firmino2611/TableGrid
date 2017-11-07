<a class="btn btn-{{ $action['class'] }} btn-sm" href="{{ route($action['route'], $row->getKey()) }}" 
onclick="
			event.preventDefault();
			if (confirm('Deseja excluir este item?')) {
				document.getElementById('form-edit-{{ $row->getKey() }}').submit();
			}
"> {{ $action['label'] }} </a>

<form id="form-edit-{{ $row->getKey() }}" action="{{ route($action['route'], $row->getKey()) }}" method="POST" style="display: none;">
    {{ csrf_field() }}
    {{ method_field('delete') }}
</form>