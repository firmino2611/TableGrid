<?php 

namespace Firmino\TableGrid\Facades;

use Illuminate\Support\Facades\Facade;

class TableGrid extends Facade
{
	protected static function getFacadeAccessor(){
		return 'Table.table';
	}
}