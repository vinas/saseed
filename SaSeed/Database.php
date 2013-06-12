<?php
/************************************************************************************
* Name:				Database Functions												*
* File:				Application\FramworkCore\Database.php 							*
* Author(s):		Vinas de Andrade												*
*																					*
* Description: 		This file holds basic Database functions for the whole			*
*					web-site. It also contains Database connection and query		*
*					functions.														*
*																					*
* Creation Date:	22/09/2011														*
* Version:			2.13.0219														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
*************************************************************************************/

	namespace SaSeed;

	class Database {

		// ** Declaração de variáveis **
		// @var string
		private $connection;					// Link de conexão
		// @var string
		private $last_connection	= null;		// Contém as informações da última conexão usada
		// @var string
		private $last_query			= '';		// Contém as informações da última query sql usada
		// @var string
		private $error				= '';		// Retorna o texto da mensagem de erro da última operação sql
		// @var string
		private $display_errors		= '';		// Erro a ser exibido
		// @var integer
		private $errno				= '';		// Retorna o valor numérico da mensagem de erro da última operação sql
		// @var boolean
		private $is_locked			= false;	// Existe alguma tabela travada agora?


		// ** CONEXãO ** \\
		// ************* \\

		/* Função de conexão - DBConnection($db_host, $db_user, $db_pass, $db_name)
		 * @var(s) string
		 * @return boolean */
		public function DBConnection($db_host = false, $db_user = false, $db_pass = '', $db_name = false) {
			// Se valores foram enviados
			if (($db_host) && ($db_user) && ($db_name)) {
				$this->connection = mysql_connect($db_host, $db_user, $db_pass);
				// Se conexão foi feita
				if ($this->connection) {
					// Se base de dado pôde ser selecionada
					if (mysql_select_db($db_name, $this->connection)) {
						$this->last_connection=&$this->connection;
						// Retorna conexão
						return $this->connection;
					// Se não foi possível selecionar um banco de dados
					} else {
						// Retorna erro
						$this->display_errors('- N&atilde;o foi poss&iacute;vel selecionar o Banco de Dados: '.$db_name.'<br>Erro: '.mysql_error());
						return false;
					}
				// Se não foi possível conectar-se ao banco
				} else { 
					$this->display_errors('- N&atilde;o foi poss&iacute;vel conectar-se o Banco de Dados: '.$db_name.'<br>Erro: '.mysql_error());
					return false;
				}
			// Se valores não foram enviados
			} else { 
				$this->display_errors('- Valores de conex&atilde;o n&atilde;o foram enviados!');
				return false;
			}
		}

		/* Fecha a conexão MySQL - close()
		 * @param  none
		 * @return boolean */
		public function close() {
			$this->msql = '';
			return mysql_close($this->connection);
		}

		// ** CRUD ** \\
		// ********** \\

		/* Roda uma Query - rq($query)
		 * @param  string  - A query
		 * @return mixed */
		public function rq($query) {
			// Atualiza conexão
			$this->last_connection=&$this->connection;
			// Roda a query
			$this->msql=&$query;
			$result = mysql_query($query, $this->connection);
			// Se a query rodou
			if ($result) {
				$this->queries_count++;
				return $result;
			// Caso não tenha rodado
			} else {
				$this->display_errors();
				return false;
			}
		}

		/* Pega linha de resultado como um array associativo - fetch($query)
		 * @param  string  - A query
		 * @return array */
		public function fetch($query) {
			return mysql_fetch_assoc($query);
		}

		/* Pega linha de resultado como array numérico, associatvo ou ambos - afetch($query)
		 * @param  string - A query
		 * @return array */
		public function afetch($query) {
			return mysql_fetch_array($query);
		}

		/* Pega linha de resultado como um objeto - ofetch($query)
		 * @param  string - A query
		 * @return array */
		public function ofetch($query) {
			return mysql_fetch_object($query);
		}

		/* Retorna a última ID PK (campo auto_increment) da última linha inserida. - last_id()
		 * @return  integer*/
		public function last_id() {
			return mysql_insert_id($this->connection);
		}

		// *** Funções CRUD pré-preparadas ***
		
		/* Pega vários registros de uma tabela podendo-se usar condições, selecionar campos,
		   e definir a paginação - getAllRows($table, $limit, $max, $select_what, $conditions)
		 *
		 * @param string	- Tabela alvo
		 * @param string	- Condições
		 * @param string	- Que campos pegar (mto útil ao se usar JOINs)
		 * @param integer	- Regsitro de início (paginação)
		 * @param integer	- Máximo de registros (paginação)
		 *
		 * @return mixed */
		public function getAllRows($table, $limit=0, $max=0, $select_what='*', $conditions='1') {
			$query = 'SELECT '.$select_what.' FROM '.$table.' WHERE '.$conditions;
			// Adiciona paginação, se enviada
			if ($max != 0) {
				$query .= ' LIMIT '.$limit.', '.$max;
			}
			// Executa a pesquisa
			//echo $query;
			$res = $this->rq($query);
			return $res;
		}
		
		/* Pega vários registros de uma tabela podendo-se usar condições, selecionar campos,
		   e definir a paginação. Retorna um array. - getAllRows_Arr($table, $limit, $max, $select_what, $conditions)
		 *
		 * @param string	- Tabela origem dos dados
		 * @param string	- Condições
		 * @param string	- Que campos pegar (mto útil ao se usar JOINs)
		 * @param integer	- Regsitro de início (paginação)
		 * @param integer	- Máximo de registros (paginação)
		 *
		 * @return array 	- $rows[contador][campo] */
		public function getAllRows_Arr($table, $select_what='*', $conditions='1', $limit=0, $max=0) {
			// Inicializa variáveis
			$rows = '';
			$query = 'SELECT '.$select_what.' FROM '.$table.' WHERE '.$conditions;
			
			// Adiciona paginação, se enviada
			if ($max != 0) {
				$query .= ' LIMIT '.$limit.', '.$max;
			}
			//echo $query.'<br><br>';
			//die;
			// Executa a pesquisa
			$res = $this->rq($query);
			$contador = 0;
			while ($row = $this->fetch($res)) {
				// Pega nomes dos campos
				$tot_fields = count($row);
				for ($i = 0; $i < $tot_fields; $i++) {
					$key[] = key($row);
					next($row);
				}
				// Pega valores do registro
				foreach ($key as $value) {
					$rows[$contador][$value] = $row[$value];
				}
				$contador++;
			}
			// Retorna registros
			return $rows;
		}

		/* Pega um único registro podendo-se utilizar condições e selecionar os campos
		    - getRow($table, $conditions, $select_what)
		 *
		 * @param string	- Tabela alvo
		 * @param string	- quais as condições
		 * @param string	- Que campos pegar. (mto útil ao se usar JOINs)
		 *
		 * @return mixed */
		public function getRow($table, $conditions='1', $select_what='*') {
			$query = 'SELECT '.$select_what.' FROM '.$table.' WHERE '.$conditions;
			$res = $this->rq($query);
			$row = $this->fetch($res);
			return $row;
		}

		/* Atualiza ou mais registros (apenas uma condição) - updateRow($table, $fields, $values, $condition)
		 *
		 * @param string	- Tabela alvo
		 * @param string	- Condições
		 * @param string	- Que campos pegar. (mto útil ao se usar JOINs)
		 *
		 * @return boolean */
		public function updateRow($table, $fields, $values, $condition) {
			// Inicializa variáveis
			$i = 0;
			$query = '';
			// Confere se campos e valores batem
			if (count($fields) == count($values)) {
				// Monta query
				$query = 'UPDATE '.$table.' SET ';
				// Coloca na query os campos
				foreach ($fields as $campo) {
					if ($i != 0) {
						$query .= ', ';
					}
					$query .= $campo.' = ';
					// Coloca na query os calores
					if (is_int($values[$i])) { // numérico
						$query .= $values[$i];
					} else if (gettype($values[$i]) == 'object') { // data/objeto
						foreach ($values[$i] as $variavel) {
								$valor = $variavel;
								break;
						}
						$query .= "'".$valor."'";
					} else { // string
						$query .= "'".$values[$i]."'";
					}
					$i++;
				}
				// Coloca na query a(s) condição(ões)
				$query .= ' WHERE '.$condition;
			}
			// Executa query
			$res = $this->rq($query);
			return $res;
		}

		/* Deleta um ou mais registros (apenas uma condição) - deleteRow($table, $condition)
		 * @param  string - A tabela em questão
		 * @param  string - Condições da query
		 * @return boolean */
		public function deleteRow($table, $condition) {
			$query = 'DELETE FROM '.$table.' WHERE '.$condition;
			$res = $this->rq($query);
			return $res;
		}

		/* Insere um novo registro - insertRow($table, $values)
		 * @param  string - A tabela em questão
		 * @param  array  - Valores a seres inseridos
		 * @param  array  - Campos que receberão valores
		 * @return boolean */
		public function insertRow($table, $values, $fields='') {
			// Monta query
			$query = 'INSERT INTO '.$table.' (';
			// Pega campos da tabela destino
			if ($fields == '') {
				$fields = $this->listFields_noid($table);
				// Coloca campos na query (ID IGNORADO***)
				for ($i = 0; $i < count($fields); $i++) {
					if ($i > 0) {
						$query .= ', ';
					}
					$query .= $fields[$i];
				}
			} else {
				// Coloca campos na query (TODOS OS CAMPOS)
				for ($i = 0; $i < count($fields); $i++) {
					if ($i > 0) {
						$query .= ', ';
					}
					$query .= $fields[$i];
				}
			}
			// Coloca os valores na query
			$query .= ') VALUES (';
			for ($i = 0; $i < count($values); $i++) {
				if ($i != 0) {
					$query .= ', ';
				}

				// Se o valor for numérico
				if (is_int($values[$i])) {
					$query .= $values[$i];
				// Se o valor for objeto (data)
				} else if (gettype($values[$i]) == 'object') {
					foreach ($values[$i] as $variavel) {
							$valor = $variavel;
							break;
					}
					$query .= "'".$valor."'";
				// Se for String ou money/decimal
				} else {
					$query .= "'".$this->string_escape($values[$i])."'";
				}
			}
			$query .= ')';
			// Executa a query
			$res = $this->rq($query);
			return $res;
		}

		// ** FUNÇÕES AUXILIARES ** \\
		// ************************ \\

		/* Retorna os nomes dos campos de uma tabela - listFields($table)
		 * @param  string  - A tabela
		 * @return array */
		public function listFields($table) {
			$query = 'SHOW COLUMNS FROM '.$table;
			$res = $this->rq($query);
			while ($row = $this->fetch($res)) {
				$fields[] = $row['Field'];
			}
			return $fields;
		}

		/* Retorna os nomes dos campos de uma tabela (menos campo ID) - listFields_noid($table)
		 * @param  string  - A tabela
		 * @return array */
		public function listFields_noid($table) {
			$contador = 0;
			$query = 'SHOW COLUMNS FROM '.$table;
			$res = $this->rq($query);
			while ($row = $this->fetch($res)) {
				if ($contador != 0) {
					$fields[] = $row['Field'];
				}
				$contador++;
			}
			return $fields;
		}

		/* Retorna número de campos de uma tabela - numFields($table)
		 * @param  string  - A tabela
		 * @return integer */
		public function numFields($table) {
			$query = 'DESCRIBE '.$table;
			$res = $this->rq($query);
			$value = mysql_num_rows($res);
			return $res;
		}

		/* Retorna o número de linhas de uma query já executada - num_rows($result)
		 * @param  string - O resultado da query.
		 * @return integer */
		public function num_rows($result) {
			return mysql_num_rows($result);
		}

		/* Retorna o número de linhas afetadas pela última query - affected_rows()
		 * @return integer */
		public function affected_rows() {
			return mysql_affected_rows($this->last_connection);
		}

		/* Retorna o número total de queries executadas. (Vai geralmente no fim do script) - num_queries()
		 * @return integer */
		public function num_queries() {
			return $this->queries_count;
		}

		/* Trava uma(s) tabela(s) - lock_tables($tables)
		 * @param   array  - Array das tabelas => Tipo de trava
		 * @return  void */
		public function lock_tables($tables) {	
			// Confere se existem tabelas a serem travadas
			if ((is_array($tables)) && (count($tables) > 0)) {
				// Trava a(s) tabela(s)
				$msql = '';
				foreach ($tables as $name=>$type){
					$msql .= (!empty($msql)?', ':'').''.$name.' '.$type.'';
				}
				$this->rq('LOCK TABLES '.$msql.'');
				$this->is_locked = true;
			}
		}

		/* Destrava tabela(s) do banco - unlock_tables() */ 
		public function unlock_tables() {
			if ($this->is_locked){
				$this->rq('UNLOCK TABLES');
				$this->is_locked = false;
			}
		}

		/* Trata um valor para ser usado com segurança em queries - string_escape($string, $full_escape = false)
		 * @param  string  - String a ser tratada
		 * @param  bool    - Caso tratar '%' e '_' seja preciso
		 * @return string */
		public function string_escape($string, $full_escape = false) {
			// Trata precisa tratar '%' e '_'
			if ($full_escape) $string = str_replace(array('%', '_'), array('\%', '\_'), $string);
			// Trata e retorna a string
			$string = stripslashes($string);
			if (function_exists('mysql_real_escape_string')) {
				return mysql_real_escape_string($string, $this->connection);
			} else{
				return mysql_escape_string($string);
			}
		}

		/* Limpa o resultado ($result) - free_result($result)
		 * @param  string  - O resultado a ser limpo ($result)
		 * @return boolean */
		public function free_result($result) {
			return mysql_free_result($result);
		}

		/* Retorna a mensagem de erro do MySQL - error()
		 * @return string */
		public function error() {
			$this->error = (is_null($this->last_connection))?'':mysql_error($this->last_connection);
			return $this->error;
		}

		/* Retorna o número do erro MySQL - errno()
		 * @return string */
		public function errno() {
			$this->errno=(is_null($this->last_connection))?0:mysql_errno($this->last_connection);
			return $this->errno;
		}

		/* Se um erro de BD acontecer, o script vai ser parado e uma mensagem de erro exibida - display_errors($error_message)
		 * @param  string  - A mensagem de erro. Se vazia, será criada como $this->sql.
		 * @return string */
		public function display_errors($error_message='') {
			// Pega mensagem e número da mensagem de erro da última conexão
			if ($this->last_connection) {
				$this->error=$this->error($this->last_connection);
				$this->errno=$this->errno($this->last_connection);
			}
			// Confere $_SERVER para adicionar mais detalhes
			if (!$error_message) {
				$error_message = '- Erro na query: '.$this->msql;
			}
			$message = ''.$error_message.'<br />
			'.(($this->errno!='')?'- Error: '.$this->error.' (Error #'.$this->errno.')<br />':'').'
			- File: '.$_SERVER['SCRIPT_FILENAME'].'<br />';
			die('Erro de Banco de Dados, favor tentar novamente mais tarde.<br />'.$message.'');
			//die('Erro de Banco de Dados:<br /><br />Um erro ocorreu na pesquisa, a mesma estava vazia ou era invalida.<br />Favor tentar novamente mais tarde.<br /><br />- debug: dbfc.display_errors');
		}
	}
?>