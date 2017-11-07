<?php 

namespace Firmino\TableGrid;

use Firmino\TableGrid\Traits\TableGridTrait;

class Table
{
	use TableGridTrait;

	/**
	*	Representa as linhas da tabela
	*	@var Array 
	*/
	private $rows = [];

	/**
	*	Representa as colunas da tabela	
	*	@var Array 
	*/
	private $columns = [];

	/**
	*	Representa as acoes que podem ser colocadas na tabela
	*	@var Array 
	*/
	private $actions = [];

	/**
	*	Modelo ao qual a tabela devera buscar os dados
	*	@var Builder
	*/
	private $model = null;

	/**
	*	Copia do modelo
	*	@var Builder
	*/
	private $modelOriginal = null;

	/**
	*	Determina se o plugin DataTable esta ativo ou desativado
	*	@var Boolean
	*/
	private $dataTable = false;


	/**
	*	Retorna as linhas da tabela
	*	@return Array
	*/
	public function rows(){
		return $this->rows;
	}

	/**
	*	Retorna ou configura o modelo para ser usado na busca
	*	@param Model $model
	*	@return Array ou Table
	*/
	public function model($model = null){
		if (!$model) {
			return $this->model;
		}

		$this->model = !is_object($model) ? new $model : $model;
		$this->modelOriginal = $this->model;
		return $this;
	}

	/**
	*	Se enviado o parametro $columns retorna a instancia de Table, caso contrario retonra um array com as colunas que     *	 devem ser mostradas na table
	*	@var Array $columns
	*	@return Table ou Array
	*/
	public function columns($columns = null){
		if (!$columns) {
			return $this->columns;
		}

		$this->columns = $columns;
		return $this;
	}

	/**
	*	Ativa ou desativa o plugin DataTable
	*	@param Boolean $active
	*	@return Table
	*/
	public function activeDataTable($active){
		$this->dataTable = $active;
		return $this;
	}

	/**
	*	Ativa ou desativa o plugin DataTable
	*	@return Boolean
	*/
	public function dataTable(){
		return $this->dataTable;
	}

	/**
	*	Retorna as acoes configuradas na tabela
	*	@return Array
	*/
	public function actions(){
		return $this->actions;
	}

	/**
	*	Adiciona acoes para tabela.
	*
	*	Label que aparecera no link da acao
	*	@param String $label
	*	Route para qual se deve direcionar a acao quando for clicada
	*	@param String $route
	*	Template que renderiza os links das acoes
	*	@param String $template
	* 	Class usada para estilizar cada links de uma acao
	*	@param String $class
	*
	*	@return Table
	*/
	public function addAction($label, $route, $template, $class){
		$this->actions[] = [
				'label' => $label,
				'route' => $route,
				'template' => $template,
				'class' => $class
		];

		return $this;
	}

	/**
	*	Adiciona uma acao de edicao
	*	Label que aparecera no link da acao
	*	@param String $label
	*	Route para qual se deve direcionar a acao quando for clicada
	*	@param String $route
	*	Template que renderiza os links das acoes
	*	@param String $template
	* 	Class usada para estilizar cada links de uma acao
	*	@param String $class
	*
	*	@return Table
	*/
	public function addEditAction($label, $route, $template, $class = 'default'){
		$this->addAction($label, $route, $template,$class);
		return $this;
	}

	/**
	*	Adiciona uma acao de exclusao
	*	Label que aparecera no link da acao
	*	@param String $label
	*	Route para qual se deve direcionar a acao quando for clicada
	*	@param String $route
	*	Template que renderiza os links das acoes
	*	@param String $template
	* 	Class usada para estilizar cada links de uma acao
	*	@param String $class
	*
	*	@return Table
	*/
	public function addDeleteAction($label, $route, $template, $class = 'default'){
		$this->addAction($label, $route, $template,$class);
		return $this;
	}
	
	/**
	*	Faz a consulta na tabela do modelo
	*
	*	@return Table
	*/
	public function search(){
		$keyName = $this->modelOriginal->getKeyName();
		$columns = collect($this->columns())->pluck('name')->toArray();
		array_unshift($columns, $keyName);
		$this->rows = $this->getRelations($this->model); 
		return $this;
	}

	/**
	*	Pega todas as relacoes do modelo
	*
	*	@return Array
	*/
	public function getRelations($model){
		return $model::with([])->get();
	}
}