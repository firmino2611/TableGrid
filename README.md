# TableGrid
Estrutura de grid reaproveitável, para ser usada em vários lugares da aplicação.

## Instalação
Instalando via composer. Configure o arquivo composer.json para que ele permita a instalação de pacote com estabilidade dev
```javascript
composer require firmino/tablegrid
```
Registre o ServiceProvider em config/app.php
```php
'providers' => [
      Firmino\TableGrid\Providers\TableGridServiceProvider::class,
]
```
Registre também o Facade no mesmo arquivo
```php
'aliases' => [
      'TableGrid' => Firmino\TableGrid\Facades\TableGrid::class,
]
```

Publique o arquivo de configuração
```javascript
php artisan vendor:publish --provider="Firmino\TableGrid\Providers\TableGridServiceProvider"
```

## Como utilizar
Utilize o Facade TableGrid para configurar a tabela, este possui os seguintes metódos que podem ser utilizados para criar a 
estrutura da tablea:

### Exemplo básico
```php
<?php
// código omitido ....

use Firmino\TableGrid\Facades\TableGrid;

// codigo omitido ....

public function index(){
    $table = TableGrid::model(Model::class)
        ->columns([
            [
                'label' => 'Titulo',
                'name' => 'title'
            ]
        ])
        ->search();
    return view('view')->with('table', $table);
 }
```

Para renderizar a tabela basta chamar o metodo ´render()´ da seguinte forma no html:

`{!! $table->render() !!}`

#### Metódos

##### `model(Model $model = null)`
Caso não seja `null` atribui um modelo para ser usado na criação da tabela, pode ser enviado uma instancia do `model`ou apenas o a 
string equivalente ao nome da classe.
Caso contrário será retornado o model.

---

##### `columns(Array $columns = null)`
Recupera uma matriz com as informações das colunas caso não seja enviado nenhum valor. Caso contrário recebe uma matriz
```php
[
  [
     'label' => 'Titulo',
      'name' => 'title'
  ]
]
```

Pode ser enviado ainda uma chave chamada `field` para caso o campo que se deseja mostrar seja um objeto referente a 
alguma relação do model, esta chave deve receber qual o campo desse objeto deve ser mostrado.
Exemplo:
```php
[
  [
     'label' => 'Autor',
      'name' => 'user',
      'fiedl' => 'name'
  ]
]
```

--- 

##### `rows()`
Recupera as linhas da tabela

---

##### `activeDataTable(Boolean $active)`
Configura se o plugin DataTable deverá ser usado.

---

##### `dataTable()`
Recupera o atributo dataTable, que identifica se o plugin DataTable está ativo ou não.

---

##### `actions()`
Recupera as ações que foram adicionadas na tabela

---

##### `addAction(string $label, string $route, string $template, string $class = 'btn btn-default btn-sm')`
Adiciona uma ação para ser exibida na tabela. 
- $label => Texto que aparece no link.
- $route => Nome da rota que será redirecionado ao clicar no link.
- $template => Template do link que será mostrado no front-end.
- $class => Classe do Bootstrap para personalizar os links. (success, primary, danger, warning, default)

---

##### `addEditAction(string $label, string $route, string $template, string $class = 'btn btn-primary btn-sm')`
Adiciona uma ação de edição para ser exibida na tabela. 
- $label => Texto que aparece no link.
- $route => Nome da rota que será redirecionado ao clicar no link.
- $template => Template do link que será mostrado no front-end.
- $class => Classe do Bootstrap para personalizar os links. (success, primary, danger, warning, default)

---


##### `addDeleteAction(string $label, string $route, string $template, string $class = 'danger')`
Adiciona uma ação de exclusão para ser exibida na tabela. 
- $label => Texto que aparece no link.
- $route => Nome da rota que será redirecionado ao clicar no link.
- $template => Template do link que será mostrado no front-end.
- $class => Classe do Bootstrap para personalizar os links. (success, primary, danger, warning, default)

---

##### `search()`
Faz a consulta no banco de dados na tabela referente ao `model`configurado.

---

##### `render()`
Renderiza a tabela.

---

## Templates
O pacote possui 3 tamplates básicos para renderizar os links de ações, que podem ser chamados da seguinte forma:
- Table::templates.edit-action
- Table::templates.delete-action
- Table::templates.action (Para ações adicionais)

## Configurações
O arquivo de configurações permite fazer alguns ajustes no plugin DataTable.
- translation_table (Permite que as informações da tabela sejam traduziadas para o portugues-br)
- zero_records (Texto que é mostrado quando não são encontrados registro na tabela)
- search (Texto que aparece ao lado da barra de pesquisa da tabela)


## Exemplos

### Usando ações editar e excluir
```php
<?php
// código omitido ....

use Firmino\TableGrid\Facades\TableGrid;

// codigo omitido ....

public function index(){
    $table = TableGrid::model(Model::class)
            ->columns([
                [
                    'label' => 'Titulo',
                    'name' => 'title'
                ],
                [
                    'label' => 'Autor',
                    'name' => 'user',
                    'field' => 'name'
                ]
            ])
            ->activeDataTable(true)
            ->addEditAction('Editar', 'edit', 'Table::templates.edit-action')
            ->addDeleteAction('Excluir', 'destroy', 'Table::templates.delete-action', 'danger')
            ->search();

      return view('home')->with('table', $table);
}
```

### Usando ações adicionais
```php
<?php
// código omitido ....

use Firmino\TableGrid\Facades\TableGrid;

// codigo omitido ....

public function index(){
    $table = TableGrid::model(Model::class)
              ->columns([
                  [
                      'label' => 'Descricao',
                      'name' => 'description'
                  ]
              ])
              ->addAction('acao', 'login', 'table.action', 'warning')
              ->search();

    return view('home')->with('table', $table);
 }
```





