<?php
/************************************************************************************
* Name:				General Functions												*
* File:				Application\FramworkCore\GeneralFunctions.php 					*
* Author(s):		Vinas de Andrade, Raphael Pawlik e Leandro Menezes				*
*																					*
* Description: 		This file holds basic functions called by different files		*
*					throughout the site.											*
*																					*
* Creation Date:	13/10/2011														*
* Version:			2.12.1115														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
*************************************************************************************/

	function objectToArray ($d) {
		if (is_object($d)) {
			$d = get_object_vars($d);
		}
 		if (is_array($d)) {
			return array_map(__FUNCTION__, $d);
		} else {
			return $d;
		}
	}

	/* Função que gera uma string aleatória - randomString($comprimento=8)
	 * @integer		- Comprimento da senha
	 * @return string */
	function randomString ($comprimento = 8) {
		// $caracteres	= 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		// $caracteres	= 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789';
		$caracteres	= 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
		$limite		= strlen($caracteres) - 1;
		$pass		= '';
		for ($i = 0; $i < $comprimento; $i++) {
			$pass	.= $caracteres[rand(0, $limite)];
		}
		return $pass;
	}

	/* Função que formata a data que vai para o mysql - data_mysql($date)
	 * @param string	- Data no formato ("2011-10-17 09:40:42" ou "2011/10/17 09:40:42")
	 * @return string */
	function data_mysql ($data='now') {
		// Se data não enviada
		if ($data == 'now') {
			// Monta data com dia de hoje
			$dt_dia	= date("d");
			$dt_mes	= date("n");
			$dt_ano	= date("Y");
			$data	= $dt_ano.'-'.$dt_mes.'-'.$dt_dia;
		} else {
			$dt_dia	= substr($data, 8, 2);
			$dt_mes	= substr($data, 5, 2);
			$dt_ano	= substr($data, 0, 4);
			$data	= $dt_ano.'-'.$dt_mes.'-'.$dt_dia;
		}
		return $data;
	}

	/* Função que formata a data que vai para o mysql - data_bras_mysql($date)
	 * @param string	- Data no formato ("17-10-2011 09:40:42" ou "17/10/2011 09:40:42")
	 * @return string */
	function data_bras_mysql ($data='now') {
		// Se data não enviada
		if ($data == 'now') {
			// Monta data com dia de hoje
			$dt_dia	= date("d");
			$dt_mes	= date("n");
			$dt_ano	= date("Y");
			$data	= $dt_ano.'-'.$dt_mes.'-'.$dt_dia;
		} else {
			$dt_dia	= substr($data, 0, 2);
			$dt_mes	= substr($data, 3, 2);
			$dt_ano	= substr($data, 6, 4);
			$data	= $dt_ano.'-'.$dt_mes.'-'.$dt_dia;
		}
		return $data;
	}

	/* Função que formata a data vem do mysql e vai para o PHP - data_php($date)
	 * @param string	- Data no formato ("2011-10-17 09:40:42" ou "2011/10/17 09:40:42")
	 * @return string */
	function data_php ($data='now') {
		// Se data não enviada
		if ($data == 'now') {
			// Monta data com dia de hoje
			$dt_dia	= date("d");
			$dt_mes	= date("n");
			$dt_ano	= date("Y");
			$data	= $dt_dia.'/'.$dt_mes.'/'.$dt_ano;
		} else {
			$dt_dia	= substr($data, 8, 2);
			$dt_mes	= substr($data, 5, 2);
			$dt_ano	= substr($data, 0, 4);
			$data	= $dt_dia.'/'.$dt_mes.'/'.$dt_ano;
		}
		return $data;
	}

	/* Função que formata a data e hora que vem do mysql e vai para o PHP - datahora_php($date)
	 * @param string	- Data no formato ("2011-10-17 09:40:42" ou "2011/10/17 09:40:42")
	 * @return string */
	function datahora_php ($data='now') {
		// Se data não enviada
		if ($data == 'now') {
			// Monta data com dia de hoje
			$dt_dia		= date("d");
			$dt_mes		= date("n");
			$dt_ano		= date("Y");
			$dt_hora	= date("G");
			$dt_min		= date("i");
			$dt_seg		= date("s");
		} else {
			$dt_dia		= substr($data, 8, 2);
			$dt_mes		= substr($data, 5, 2);
			$dt_ano		= substr($data, 0, 4);
			$dt_hora	= substr($data, 11, 2);
			$dt_min		= substr($data, 14, 2);
			$dt_seg		= substr($data, 17, 2);
		}
		$data			= $dt_dia.'/'.$dt_mes.'/'.$dt_ano.' as '.$dt_hora.':'.$dt_min.':'.$dt_seg;
		return $data;
	}

	/* Função que formata a data e hora que vem do mysql e vai para o MYSQL - datahora_mysql($date)
	 * @param string	- Data no formato ("2011-10-17 09:40:42" ou "2011/10/17 09:40:42")
	 * @return string */
	function datahora_mysql ($data='now') {
		// Se data não enviada
		if ($data == 'now') {
			// Monta data com dia de hoje
			$dt_dia		= date("d");
			$dt_mes		= date("n");
			$dt_ano		= date("Y");
			$dt_hora	= date("G");
			$dt_min		= date("i");
			$dt_seg		= date("s");
		} else {
			$dt_dia		= substr($data, 8, 2);
			$dt_mes		= substr($data, 5, 2);
			$dt_ano		= substr($data, 0, 4);
			$dt_hora	= substr($data, 11, 2);
			$dt_min		= substr($data, 14, 2);
			$dt_seg		= substr($data, 17, 2);
		}
		$data			= $dt_ano.'-'.$dt_mes.'-'.$dt_dia.' '.$dt_hora.':'.$dt_min.':'.$dt_seg;
		return $data;
	}

	/* Função que tira caracteres ilegais, capazes de ocasionar cross-cript
	 * @param string	- input text
	 * @return string */
	function no_xss ($string=false) {
		if ($string) {
			// Inicializa variáveis
			$strings_xss	= $GLOBALS['strings_xss'];
			// Retira caracteres
			$string			= str_replace($strings_xss, '', $string);
		}
		// Retorna valor
		return $string;
	}