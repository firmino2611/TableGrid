<?php

namespace Firmino\TableGrid\Traits;

trait TableGridTrait
{
	/**
	*	Renderiza a tabela
	*	@return View
	*/
	public function render(){
		return view('Table::table')->with('table', $this);
	}
}